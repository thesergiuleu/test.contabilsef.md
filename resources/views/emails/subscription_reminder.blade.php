@component('mail::message')
Bună ziua. <br>

Pe data {{ format_date($subscription->created_at) }} ati facut solicitarea pentru serviciul {{ $subscription->display_type }} dar nu ati achitat.

Atașat găsiți contul de plată pentru serviciul solicitat. <br>

Vă mulțumim pentru alegere! <br>

IMPORTANT! Vă rugăm în destinația plății să indicați ID personal {{ $subscription->user_id }}. <br>

După efectuarea plății abonamentului va fi activat serviciul ales și veți primi o scrisoare de înștiințare pe e-mail.
<br>

Pentru orice întrebări sau detalii suplimentare, ne puteți contacta prin intermediul e-mailului {{ env('OFFICE_EMAIL') }} sau la numărul de telefon (022) 22-49-37.
<br>

Cu respect,<br>
Echipa {{ config('app.name') }},<br>
<a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
@endcomponent

