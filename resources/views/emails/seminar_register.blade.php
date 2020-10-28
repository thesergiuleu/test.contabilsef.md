@component('mail::message')
Bună ziua. <br>

Prin intermediu paginii contabilsef.md sa efectuat o înregistrare la seminarul organizat de dvs. <br>

Nume: {{$data['name']}}<br>
Email: {{$data['email']}}<br>
Telefon: {{$data['phone']}}<br>
Idno: {{$data['cod_fiscal']}}<br>
Denumirea companiei: {{$data['company_name']}}<br>
Metoda de plată: {{$data['payment_method']}}<br>
Mesaj:{{$data['message']}}<br>
Seminar: {{$post->name}}<br>

Cu respect,<br>
Echipa {{ config('app.name') }},<br>
<a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
@endcomponent

