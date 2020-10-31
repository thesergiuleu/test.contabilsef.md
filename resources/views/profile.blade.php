@extends('layouts.app')
<style>

    .last-button-style:hover,
    .post-web .box-textsss form .last-button a:hover{
        background-color: #b42a30 !important;
        opacity: 0.9 !important;
        cursor: pointer;
    }
    .post-web .box-textsss form .last-button .delete{
        font-size: 18px;
        font-weight: 600;
        font-style: normal;
        font-stretch: normal;
        line-height: normal;
        letter-spacing: normal;
        text-align: left;
        color: #fff;
        box-shadow: 0 1px 10px 0 hsla(0,0%,45%,.03);
        padding: 10px 50px;
        text-decoration: none;
        border-radius: 5px;
        transition: all .2s linear;
        background: #b42a30;
        margin: 0;
    }
    .post-web .box-textsss form .last-button .delete:hover{
        background-color: #adadad !important;
    }

    a.simple-btn-2 {
        font-size: 18px;
        font-weight: 600;
        font-style: normal;
        text-align: left;
        color: #fff;
        background-color: #3c5a98;
        padding: 22px 50px;
        text-decoration: none;
        border-radius: 5px;
        transition: all .2s linear;
        margin-bottom: 20px;
        width: auto;
    }
    a.simple-btn-2:hover{
        opacity: 0.7;
    }
</style>

@section('content')
    <section id='main_content' class='main_route_section'>
        <section class="{{ isset($classes) ? $classes : 'lista-de-articole' }}">
            <section class="post-web">
                <div class="kat-container">
                    @if (isset($breadCrumbs) && $breadCrumbs)
                        @include('components.bread-crumbs', ['breadCrumbs' => $breadCrumbs])
                    @endif
                </div>
                <div class="box-personal-account">
                    <div class="kat-container">
                        <div class="cont-pers">
                            <div class="tabs">
                                <div class="li-tab ba">Cabinet personal<span class="bnts  span-bg"></span></div>
                                <div class="li-tab">Date personale<span class="bnts"></span></div>
                                <div class="li-tab">Trimite mesaj<span class="bnts "></span></div>
                                <div class="li-tab has-sub-menu"><i class="fa fa-caret-down down-icon"></i>Servicii
                                    Contabil Sef<span class="bnts"></span></div>
                                @foreach(\App\SubscriptionService::all() as $service)
                                    <div class="li-tab-sub "> {{ $service->name }} <span class="bnts"></span></div>
                                @endforeach

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="bnts" type="submit" style="top:20px; font-size: 18px; font-weight: 600; color: #252525; padding: 16px 28px; position: relative; cursor: pointer; background: none;  border: none; outline: inherit;">
                                        <span> Deconectare </span>
                                    </button>
                                </form>
                            </div>
                            <div class="tabs-content">
                                <div class="item-tab display-block-tabs general__styles">
                                    <form class="box-sub-tab"
                                          action="{{ route('user.delete') }}"
                                          id="deleteProfile">
                                        <div class="post-images"
                                             style="background-image: url('{{ asset('assets/imgs/contabile__personal.png') }}')">
                                            <p class="information" style="text-align: center">Cabinet personal</p>
                                        </div>
                                        <br><span
                                            style="font-size: 16px;  position: absolute;  margin-top: -15px; font-weight: 700;color: #3c5a98;">ID Personal: {{ auth()->id() }}</span>
                                        <br>
                                        <span style="color: #333333;"><span style="font-family: Arial, serif;"><span
                                                    lang="ro-RO">Prin înregistrarea la serviciul respectiv dvs. primiți acces general gratuit la diferite informații și materiale pregătite și publicate de echipa paginii </span></span></span><span
                                            style="color: #0000ff;"><u><a href="http://www.contabilsef.md/"><span
                                                        style="font-family: Arial, serif;"><span lang="ro-RO">www.contabilsef.md</span></span></a></u></span><span
                                            style="color: #333333;"><span style="font-family: Arial, serif;"><span
                                                    lang="ro-RO">. </span></span></span><br>
                                        <br>
                                        <span style="color: #333333;"><span style="font-family: Arial, serif;"><span
                                                    lang="ro-RO">Pentru orice întrebări sau detalii suplimentare, ne puteți contacta prin intermediul e-mailului office@contabilsef.md sau la numărul de telefon (022) 22-49-37.</span></span></span>

                                        <div class="take-decizion" style="display: none">
                                            <a onclick="$('#deleteProfile').submit()">Închide contul</a>
                                        </div>
                                        <p class="message"></p>
                                    </form>
                                </div>
                                <div class="item-tab">
                                    <div class="box-textsss">
                                        <form id="editProfileForm" class="ajax-form"
                                              action="{{ route('user.update') }}" method="post">
                                            @csrf
                                            <div class="first-post"
                                                 style="background-image: url('{{ asset('assets/imgs/a4-1238603_1920.png') }}')">
                                                <span>ID Personal <span>{{ auth()->id()  }}</span> </span>

                                                <p class="p-item">* Atenție acest ID Personal va fi folosit pentru achitarea serviciilor</p>
                                            </div>

                                            <p>Nume, Prenume</p>
                                            <input type="text" class="required" value="{{ auth()->user()->name }} " name="name">

                                            <p>Email</p>
                                            <input type="text" class="required" value="{{ auth()->user()->email }}"
                                                   name="email">

                                            <p>Telefon</p>
                                            <input type="text" class="white required" value="{{ auth()->user()->phone }}"
                                                   name="phone" placeholder="+37378930437">

                                            <p>Compania / Organizatia</p>
                                            <input type="text" class="white required" value="{{ auth()->user()->company }}"
                                                   name="company" placeholder="Led Zeppelin Inc.">

                                            <p>Functia</p>
                                            <input type="text" value="{{ auth()->user()->position  }}" name="position"
                                                   class="white required">

                                            <p>Parola veche</p>
                                            <input type="text" class="white required" name="old_password">

                                            <p>Parola noua</p>
                                            <input type="text" class="white" name="password">

                                            <p>Repetă parola noua</p>
                                            <input type="text" class="white" name="password_confirmation">


                                            <div class="last-button" style="    padding-top: 15px;">
                                                <br>
                                                <a onclick="$('#editProfileForm').submit()">Salvare <i
                                                        class="loader-icon" aria-hidden="true"></i></a>
                                            </div>
                                            @include('layouts.response-message')
                                        </form>
                                    </div>
                                </div>
                                <div class="item-tab ">
                                    <div class="box-textsss">
                                        <div role="form" class="wpcf7" id="wpcf7-f43565-o1" lang="ro-RO" dir="ltr">
                                            <div class="screen-reader-response"></div>
                                            <form id="contact-form" action="{{ route('contact-post') }}" method="post" novalidate="novalidate">
                                                @csrf
                                                <p>
                                                    <label> Nume, Prenume<br>
                                                        <span class="wpcf7-form-control-wrap your-name">
                                                            <input type="text" name="name" value="{{ auth()->user()->name }}" size="40">
                                                        </span>
                                                    </label>
                                                </p>
                                                <p>
                                                    <label> Email<br>
                                                        <span class="wpcf7-form-control-wrap your-email">
                                                            <input type="email" name="email" value="{{ auth()->user()->email }}" size="40">
                                                        </span>
                                                    </label>
                                                </p>
                                                <p>
                                                    <label> Mesaj<br>
                                                        <span class="wpcf7-form-control-wrap your-message">
                                                            <textarea name="message" cols="40" rows="10"></textarea>
                                                        </span>
                                                    </label>
                                                </p>
                                                <input type="hidden" name="ip_address" value="{{ $_SERVER['REMOTE_ADDR'] }}">
                                                <input type="hidden" name="page" value="{{ \App\Contact::PAGE_PROFILE }}">

                                                <div class="last-button">
{{--                                                    <input type="reset" class="delete" value="Anulează">--}}
{{--                                                    <p></p>--}}
                                                    <p>
                                                        <button type="submit" class="last-button-style">Trimite</button>
                                                    </p>
                                                </div>
                                                @include('layouts.response-message')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-tab-sub">
                                    <form class="box-sub-tab" id="deleteProfile">
                                        <input type="hidden" name="action" value="delete_user">

                                        <div class="post-images"
                                             style="background-image: url('{{ asset('assets/imgs/contabile__personal.png') }}')">
                                            <p class="information">Cabinet personal</p>
                                        </div>
                                        <h1>Prin înregistrarea la serviciul respectiv dvs. primiți acces general la
                                            diferite
                                            informații și materiale pregătite și publicate de colectivul website-ului
                                            www.contabilsef.md</h1>
                                        <span class="conditions">Termeni si conditii</span>

                                        <p class="for_info">Pentru a vă abona la acest serviciu vă rugăm să vă
                                            înregistrați ca
                                            utilizator. După înregistrare, veți primi un mesaj pe e-mail-ul indicat la
                                            înregistrare privind activarea utilizatorului si primirea accesului la
                                            serviciul
                                            respectiv. Pentru orice întrebări sau detalii suplimentare, ne puteți
                                            contacta prin
                                            intermediul e-mailului office@contabilsef.md sau la numărul de telefon (022)
                                            22-49-37.</p>

                                        <div class="take-decizion">
                                            <a onclick="$('#deleteProfile').submit()">Închide contul</a>
                                        </div>
                                        <p class="message"></p>
                                    </form>
                                </div>
                                @foreach(\App\SubscriptionService::all() as $service)
                                    <div class="item-tab-sub">
                                        <div class="box-sub-tab">
                                            <div class="post-images"
                                                 style="background-image: url('{{ asset('assets/imgs/contabile__personal.png') }}')">
                                                <p class="information">{{ $service->name }}</p>
                                            </div>

                                            {!! replace_price($service->description, $service) !!}


                                            <p><a href="{{ route('page.view', $service->pageId->slug) }}">Termeni și
                                                    condiții</a></p>
                                            @php
                                                $subscription = auth()->user()->activeSubscription($service->id);
                                            @endphp
                                            @if($subscription)
                                                <p class="for_info">Data de sfirsit a abonamentului : {{ format_date($subscription->end_date) }}.</p>
                                            @endif
                                            <div style="padding-top: 0; padding-bottom: 30px" class="take-decizion">
                                                <div class="div-button">
                                                    <a href="#" onclick="openSubscribeModal('{{ route("page.view", $service->pageId->slug) }}', '{{ $service->name }}', '{{ $service->id }}', '{{  apply_discount($service->price, $service->getDiscount()) }}')" class="red-btn">{{ $subscription && \Carbon\Carbon::parse($subscription->end_date)->format('Y-m-d') < \Carbon\Carbon::now()->format('Y-m-d') ? 'Prelungiți Abonamentul' : 'Abonează-te'}}</a>
                                                </div>
                                            </div>
                                            <p>La efectuarea plății, vă rugăm să indicați ID-ul personal din
                                                cabinetul personal sau din contul de plată. După achitarea
                                                abonamentului, va fi activat serviciul ales și veți primi o
                                                scrisoare de înștiințare pe e-mail. Ulterior, trimiteți întrebările
                                                Dvs. pe poșta electronică <b>consultant@contabilsef.md</b>, după
                                                care specialiștii noștri vor pregăti răspunsurile și le vor remite
                                                prin poșta electronică indicată la înregistrare. </p>
                                            <p>Pentru orice întrebări sau detalii puteți să ne contactați la
                                                e-mailul office@contabilsef.md sau la numărul de telefon 022
                                                22-49-37.</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>
@endsection
<script>
    function openSubscribeModal(termsUrl, name, type, price) {
        $('.popUp_contPersonal').css('display','block');
        $('.service-popup-label').html(name);
        $('#terms-link').attr('href', termsUrl);
        $('[name=\'service_id\']').val(type);
        $('[name=\'price\']').val(price);
    }
</script>
