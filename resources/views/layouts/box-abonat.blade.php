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

    .red-btn-aboneazate {
        height: 40px;
        border-radius: 5px;
        border: 1px solid #b42a30;
        background-color: #b42a30;
        box-shadow: 0 1px 10px 0 hsla(0, 0%, 45%, .03);
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        color: #fff;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        margin-top: 20px;
        transition: all .15s linear;
    }

    .container {
        margin-right: auto;
        margin-left: auto;
        padding-left: 15px;
        padding-right: 15px
    }

    @media (min-width: 768px) {
        .container {
            width: 100% !important;
        }
    }

    @media (min-width: 992px) {
        .container {
            width: 100% !important;
        }
    }

    @media (min-width: 1200px) {
        .container {
            width: 100% !important;
        }
    }
</style>
<div class="box-abounat">
    @if($item->subscriptionServices()->exists())
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p style="font-weight: bold; font-size: 20px; text-align: center !important;">Această informație
                        este destinată pentru abonații: <a
                            href="{{ route('profile') }}"
                            style="font-weight: bold; font-size: 20px;text-decoration: underline; color: black !important;">{{ $item->getPostSubscriptionServices() }}</a>
                    </p>
                </div>
                <div style="margin-top: 20px" class="col-md-3">
                    <span style="text-align: center; display: block">@include('layouts.svg')</span>
                    <div class="red-btn-aboneazate">
                        <a style="color: #FFFFFF !important;" href="{{ route('profile') }}">Abonează-te</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <ul style="margin-top: 20px">
                        <li style="font-weight: 500">Alegeți abonamentul dorit și completați comanda</li>
                        <li style="font-weight: 500">Achitați imediat cu cardul bancar sau prin transfer factura de
                            plată
                            primită pe poșta electronică
                        </li>
                        <li style="font-weight: 500">Odată cu încasarea plății primiți acces la conținutul revistei și
                            beneficiile oferite
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div style="text-align: center" class="col-md-12">
                    Această informație este protejata <br>
                    Pentru a vizualiza vă rugăm să vă autentificați
                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-4">
                    <div style="border: 1px solid black; background-color: #FFFFFF;" class="red-btn-aboneazate">
                        <a style="color: black !important;" href="{{ route('register') }}"
                           class="first">Inregistrare</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="red-btn-aboneazate">
                        <a style="color: #FFFFFF !important;" href="{{ route('login') }}" class="">Autentificare</a>
                    </div>
                </div>
                <div class="col-md-2">

                </div>
            </div>
        </div>
    @endif
</div>
@guest
    @if($item->subscriptionServices()->exists())
        <div class="boxt-title">
            <span>Dacă ești deja abonat <a style="color: #ffffff !important; font-weight: bold"
                                           href="{{ route('login') }}">Autentifică-te</a></span>
        </div>
    @endif
@endguest
