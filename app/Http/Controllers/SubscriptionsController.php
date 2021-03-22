<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Notifications\SubscriptionNotification;
use App\Subscription;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SubscriptionsController extends SiteBaseController
{
    public function view()
    {
        if (\auth()->user() && \auth()->user()->role_id == 1) return redirect(config('app.admin_url'));
        $this->viewData['breadCrumbs'] = [
            route('profile') => "Profil"
        ];

        return view('profile', $this->viewData);
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $data = $request->validated();

        /** @var User $user */
        $user = Auth::user();

        /** @var Subscription $subscription */
        $subscription = $user->subscriptions()->create($data);

        Notification::send($user, new SubscriptionNotification($subscription));

        return response()->json([
            'message' => setting('raspunsuri.subscription_store', 'Vă mulțumim pentru abonare, solicitarea Dvs. a fost recepționată. În scurt timp veți primi nota de plată. Vă rugăm să verificati email-ul'),
            'status' => 'success',
            'redirect_url' => session()->get('_previous')['url']
        ]);
    }

    public function send(Subscription $subscription)
    {
        Notification::send($subscription->user, new SubscriptionNotification($subscription));
        return redirect()->back();
    }

    public function documents(Subscription $subscription)
    {
        $pdf = PDF::loadView('invoices.subscription_pdf', compact('subscription')); #this works
        return $pdf->stream();
    }
}
