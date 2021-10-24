<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstruireRegisterRequest;
use App\Notifications\InstruireRegister;
use App\Notifications\NotifyExternalUsersAboutNewSeminarRegister;
use App\Post;
use App\PostRegister;
use App\Subscription;
use App\SubscriptionService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SeminarsController extends Controller
{
    public function register(StoreInstruireRegisterRequest $request, Post $post): JsonResponse
    {
        /** @var User $user */
        $user = getAuthUser();

        $data = $request->validated();
        $subscriptionService = SubscriptionService::query()->where('name', 'like', "%Revista%")->first();

        if (!$post->is_own) {
            if ($post->emails) {
                $post->postRegisters()->create($data);
                //notify emails
                foreach (explode(',', $post->emails) as $email) {
                    $receiver = new User();
                    $receiver->email = trim($email);
                    Notification::send($receiver, new NotifyExternalUsersAboutNewSeminarRegister($data, $post));
                }

                return responseSuccess($post, setting('raspunsuri.instruire_register', 'Va-ti inregistrat cu success. Verificati email-ul pentru mai multe detalii.'));
            }
        }


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
                        'price' => apply_discount($subscriptionService->price, $subscriptionService->getDiscount()),
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

        return responseSuccess($post, setting('raspunsuri.instruire_register', 'Va-ti inregistrat cu success. Verificati email-ul pentru mai multe detalii.'));
    }
}
