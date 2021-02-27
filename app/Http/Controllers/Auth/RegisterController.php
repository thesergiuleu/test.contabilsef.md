<?php

namespace App\Http\Controllers\Auth;

use App\EmailValidation;
use App\Http\Controllers\Controller;
use App\Newsletter;
use App\Notifications\EmailVerificationNotification;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return Application|JsonResponse|RedirectResponse|Response|Redirector
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->after(function ($validator) use ($request) {
            if (!(bool)$request->get('terms')) {
                $validator->errors()->add('terms', __('Accept terms and conditions.'));
            }
            if ($request->get('is_bot')) {
                $validator->errors()->add('is_bot', __('You are bot!'));
            }
        })->validate();

        event(new Registered($user = $this->create($request->all())));

        if ($request->has('newsletter')) {
            Newsletter::create([
                'email' => $user->email,
                'name' => $user->name,
            ]);
        }
        $user->sendConfirmEmail();

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? \response()->json([
                'status' => 'success',
                'data' => $user,
                'redirect_url' => route('home')
            ])
            : redirect($this->redirectPath());
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($user) {
            return redirect($request->toArray()['redirect_to'] ?? route('home'));
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return User::validateUser($data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::createUser($data);
    }

}
