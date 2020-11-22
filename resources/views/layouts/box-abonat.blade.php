<div class="box-abounat">
    @if($check)
        <p style="font-weight: bold; font-size: 20px">Această informație este destinată pentru abonații: <a
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
        @if($item->subscriptionServices()->exists())
            <p>Versiunea completă a acestui articol este disponibilă doar pentru abonații la</p>
            <p><a
                    href="{{ route('profile') }}"
                    style="font-weight: bold; font-size: 20px;text-decoration: underline; color: black !important;">{{ $item->getPostSubscriptionServices() }}</a>
            </p>
        @else
            <p>Această informație este protejata</p>
            <p>Pentru a vizualiza vă rugăm să vă autentificați</p>
        @endif
        <div class="post-item">
            <a style="color: black !important;" href="#" class="first inregistrare_cont">Inregistrare</a>
            <a style="color: #FFFFFF !important;" href="#" class="autentific">Autentificare</a>
        </div>

    @endif
</div>
