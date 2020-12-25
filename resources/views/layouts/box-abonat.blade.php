<style>
    .boxt-title {
        background-color: #a5a2a2;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-box-align: center;
        align-items: center;
        padding: 10px 40px;
        text-align: center;
    }
</style>
<div class="box-abounat">
    @if($item->subscriptionServices()->exists())
        <p style="font-weight: bold; font-size: 20px; text-align: center !important;">Această informație este destinată pentru abonații: <a
                href="{{ route('profile') }}"
                style="font-weight: bold; font-size: 20px;text-decoration: underline; color: black !important;">{{ $item->getPostSubscriptionServices() }}</a>
        </p>
        <div style="display: flex;align-items: center;justify-content: center;">
            <div style="width: 28%;">
                <span style="text-align: center; display: block">@include('layouts.svg')</span>
                <div style="height: 78px;" class="post-item">
                    <a style="color: #FFFFFF !important;" href="{{ route('profile') }}">Abonează-te</a>
                </div>
            </div>
            <ul style="width: 60%;">
                <li style="font-weight: 500">Alegeți abonamentul dorit și completați comanda</li>
                <li style="font-weight: 500">Achitați imediat cu cardul bancar sau prin transfer factura de plată
                    primită pe poșta electronică
                </li>
                <li style="font-weight: 500">Odată cu încasarea plății primiți acces la conținutul revistei și
                    beneficiile oferite
                </li>
            </ul>
        </div>
    @else
        <p>Această informație este protejata</p>
        <p>Pentru a vizualiza vă rugăm să vă autentificați</p>
        <div class="post-item">
            <a style="color: black !important;" href="{{ route('register') }}" class="first">Inregistrare</a>
            <a style="color: #FFFFFF !important;" href="{{ route('login') }}" class="">Autentificare</a>
        </div>
    @endif
</div>
@guest
    @if($item->subscriptionServices()->exists())
        <div class="boxt-title">
            <span>Dacă ești deja abonat <a style="color: #ffffff" href="{{ route('login') }}">Autentifică-te</a></span>
        </div>
    @endif
@endguest
