@component('mail::message')
<p>Stimate utilizator,</p>
<p>Va mulțumim că va-ți înregistrat pe pagina {{ config('app.name') }}, Pentru a confirma email-ul dvs. și a finaliza înregistrarea contului va rugăm să apăsați pe butonul de mai jos</p>
@component('mail::button', ['url' => route('confirm', $validation->token ?: '')])
Confirmă
@endcomponent
Cu respect,<br>
Echipa {{ config('app.name') }},<br>
<a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
@endcomponent
