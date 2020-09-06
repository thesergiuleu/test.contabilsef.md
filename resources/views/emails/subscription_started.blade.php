@component('mail::message')
Bună ziua. <br>
<p>Data de inceput a abonamentului : {{ format_date($subscription->start_date) }}.<br>
Data de sfirsit a abonamentului : {{ format_date($subscription->end_date) }}.</p>

Cu respect,<br>
Echipa {{ config('app.name') }},<br>
<a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
@endcomponent

