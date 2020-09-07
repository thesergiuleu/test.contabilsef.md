<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstruireRegisterRequest;
use App\Notifications\InstruireRegister;
use App\Post;
use App\PostRegister;
use App\Subscription;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class InstruireController extends Controller
{
    public function register(StoreInstruireRegisterRequest $request, Post $post)
    {
        $data = $request->validated();
        $subscriptionService = \App\SubscriptionService::query()->where('name', 'like', "%Revista electronică „Contabilsef.md”%")->first();
        /** @var User $user */
        $user = Auth::user();

        /** @var Subscription $subscription */
        if ($subscriptionService) {
            if ($user && !$subscription = $user->activeSubscription($subscriptionService->id)) {
                if (isset($data['subscribe']) && (bool)$data['subscribe']) {
                    $subscription = $user->subscriptions()->create([
                        'user_id' => $user->id,
                        'service_id' => $subscriptionService->id,
                        'message' => 'Mesaj din sistem: Abonatul este creat in urma inregistrarii la seminar-ul ' . $post->title,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'company' => $user->company,
                        'price' => apply_discount($subscriptionService->price, $subscriptionService->discount()),
                    ]);
                }
            }
        }
        /** @var PostRegister $postRegister */
        $postRegister = $post->postRegisters()->create($data);

        if (isset($subscription)) {
            Notification::send($user, new InstruireRegister($postRegister, $subscription));
        } else {
            $user = new User();
            $user->email = $data['email'];
            #send email for seminar without any discounts
            Notification::send($user, new InstruireRegister($postRegister));
        }

        return response()->json([
            'message' => setting('raspunsuri.instruire_register', 'Va-ti inregistrat cu success. Verificati email-ul pentru mai multe detalii.'),
            'status' => 'success',
            'redirect_url' => session()->get('_previous')['url']
        ]);
    }
}
