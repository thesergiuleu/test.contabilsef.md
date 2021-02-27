<?php

namespace App\Http\Controllers;

use App\Package;
use App\Payment;
use App\Subscription;
use App\SubscriptionService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends SiteBaseController
{
    public function getCheckoutPage(SubscriptionService $service, Package $package)
    {
        $this->viewData['breadCrumbs'] = [
            route('service-landing', [$service]) => $service->name,
            route('checkout', [$service, $package]) => $package->name,
        ];
        $this->viewData['paymentMethods'] = [
            'card' => 'Card',
            'transfer' => 'Transfer'
        ];

        $this->viewData['service'] = $service;
        $this->viewData['package'] = $package;

        return view('checkout', $this->viewData);
    }

    public function postCheckout(Request $request, ?SubscriptionService $service, ?Package $package)
    {
        $data = $request->all();
        if ($service && $package) {

            if ($data['payment_method'] == 'card') {
                $data['payed_at'] = Carbon::now();
                $data['subscription']['started_at'] = Carbon::now();
                $data['subscription']['expired_at'] = Carbon::now()->addYear();
            }

            if (!($user = Auth::user())) {
                User::validateUser($data)->validate();
                $user = User::createUser($data);
                auth()->login($user);
            }

            $payment = new Payment($data + ['user_id' => $user->id]);
            $payment->save();

            $subscription = new Subscription($data['subscription'] + [
                    'user_id' => $user->id,
                    'package_id' => $package->id,
                    'service_id' => $service->id,
                    'payment_id' => $payment->id
                ]);
            $subscription->save();

            return redirect('/');
        }
    }

    public function checkEmail(): JsonResponse
    {
        $email = request()->input('email');
        $user = User::whereEmail($email)->first();
        return response()->json([
            'form' => view('layouts.new-user-form', ['isUser' => (bool)$user])->render()
        ]);
    }
}
