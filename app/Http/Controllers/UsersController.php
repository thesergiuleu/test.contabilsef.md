<?php

namespace App\Http\Controllers;

use App\EmailValidation;
use App\Http\Requests\UpdateUserRequest;
use App\SubscriptionService;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function destroy()
    {
        return 'ehe';
    }

    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        $data = array_filter($data);
        if (isset($data['password'])) $data['password'] = Hash::make($data['password']);

        /** @var User $user */
        $user = Auth::user();
        $user->fill($data);
        $user->save();

        return response()->json([
            'message' => setting('raspunsuri.user_update', 'Datele dumneavoastra personale au fost salvate cu success'),
            'status' => 'success',
            'redirect_url' => session()->get('_previous')['url']
        ]);
    }

    public function confirm($hash)
    {
        /** @var EmailValidation $validation */
        if ($validation = EmailValidation::query()->where('token', $hash)->first()) {
            Auth::login($validation->user);
            $validation->user->email_verified_at = Carbon::now();
            $validation->user->save();
            $validation->forceDelete();
        }

        return redirect()->to(config('app.url'));
    }

    /**
     * @param User $user
     * @return Application|RedirectResponse|Redirector
     */
    public function loginAs(User $user)
    {
        auth()->logout();
        auth()->login($user);
        return redirect(url('/'));
    }

    public function posts()
    {
        $type = request()->input('type', 'seen');
        /** @var User $user */
        $user = \auth()->user();
        $posts = new Collection();
        foreach ($user->subscriptions as $subscription) {
            $posts->merge($subscription->service->posts()->get());
        }
        return response()->json($posts);
    }
}
