<?php

namespace App\Http\Controllers;

use App\Package;
use App\SubscriptionService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function postCheckout(Request $request)
    {
        dd($request->all());
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
