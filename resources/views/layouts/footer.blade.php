<footer class="footer">
    <div class="kat-container">
        <div class="links-footer">
            <div class="post">
                <img src="{{ asset('assets/imgs/local.png') }}" alt="">

                <p>{{ setting('site.address_footer_widget') }}</p>
            </div>
            <div class="post">
                <img src="{{ asset('assets/imgs/mes.png') }}" alt="">

                <div class="limks">
                    <a href="mailto:{{ setting('site.email_footer_widget') }}">{{ setting('site.email_footer_widget') }}</a>
                </div>
            </div>
            <div class="post">
                <img src="{{ asset('assets/imgs/tel.png') }}" alt="">

                <div class="limks">

                    <a href="tel:{{ setting('site.phone_footer_widget') }}">Tel: {{ setting('site.phone_footer_widget') }}</a>

                    <a href="tel:{{ setting('site.fax_footer_widget') }}">Fax: {{ setting('site.fax_footer_widget') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="kat-container">
        <div class="con-categori">
            @include('layouts.footer-navbar')

            <div class="categori-footer">
                <a href="{{ setting('site.twitter_widget') }}" class="icon-div"><i class="fa fa-twitter"
                                                                                   aria-hidden="true"></i></a>
                <a href="{{ setting('site.facebook_widget') }}" class="icon-div"><i class="fa fa-facebook"
                                                                                    aria-hidden="true"></i></a>
                <a href="{{ setting('site.linkedin_widget') }}" class="icon-div"><i class="fa fa-linkedin"
                                                                                    aria-hidden="true"></i></a>
                <a href="{{ setting('site.google_widget') }}" class="icon-div"><i class="fa fa-google-plus"
                                                                                  aria-hidden="true"></i></a>
                <a href="{{ setting('site.rss_widget') }}" class="icon-div"><i class="fa fa-rss" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <div class="kat-container">
        <div class="loc">
        </div>
    </div>
</footer>

<style>

    #containerInput .wpcf7-not-valid-tip {
        display: none;
    }

    #containerInput .wpcf7-not-valid {
        border: 1px solid red;
    }

    #containerInput span.wpcf7-not-valid-tip {
        display: none;
    }

    #containerInput p, #containerInput label, #containerInput span, #containerInput select, #containerInput input {
        width: 100%;
    }

    #containerInput select {
        border-radius: 3px;
        height: 35px;
        border: 1px solid whitesmoke;
        color: #807c7c;
        font-weight: 500;
        padding-left: 17px;
        margin-bottom: 20px;
    }

    #containerInput .popUp_contPersonal .general-item .tab-content form .selectoption, .popUp_contPersonal .general-item .tab-content form input {
        height: 35px;
        border-radius: 5px;
        box-shadow: 0 1px 10px 0 hsla(0, 0%, 45%, .03);
        border: 1px solid #ebebeb;
        font-size: 16px;
        color: #6e6a6a;
        margin-bottom: 19px;
    }

    .popUp_contPersonal .general-item .tab-content form {
        margin-bottom: 10px;
    }

    #containerInput label {
        margin-bottom: 0px;
    }

    .popUp_contPersonal .general-item .tab-content form button {
        margin-top: 0;
    }

    .popUp_contPersonal .wpcf7-response-output {
        display: block !important;
        font-size: 14px !important;
        margin: 0 !important;

    }
    .error_response {
        display: block !important;
        font-size: 14px !important;
        margin: 0 !important;
        border: 2px solid #f7e700;
        padding: 0.2em 1em
    }
    .error_response_terms {
        display: block !important;
        font-size: 14px !important;
        margin: 0 !important;
        border: 2px solid #ff0000;
        padding: 0.2em 1em
    }

</style>
@auth
<div class="popUp_contPersonal">
    <div class="general-item" id="containerInput">
        <span class="close" style="    width: 20px;  margin-right: -30px; margin-top: -20px;">
            <i class="fa fa-times"></i>
        </span>
        <p class="service-title-label">Abonare la serviciul: <span class="service-popup-label"></span></p>
        <div class="tab-content myTabContent formOne  add-display-activee">
            <div role="form">
                <div class="screen-reader-response"></div>
                <form id="subscribe-form" action="{{ route('subscribe.store') }}" method="post">
                    @csrf
                    <p>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" placeholder="Nume Prenume" size="40">
                    </p>
                    <p>
                        <input type="text" name="company" value="{{ auth()->user()->company }}" placeholder="Nume Companie" size="40">
                    </p>
                    <p>
                        <input type="text" name="phone" value="{{ auth()->user()->phone }}" placeholder="Telefon" size="40">
                    </p>
                    <p>
                        <input readonly type="email" name="email" value="{{ auth()->user()->email }}" placeholder="Email" size="40">
                    </p>
                    <p>
                        <input style="width: 48%;" type="text" name="cod_fiscal" size="40" placeholder="Codul Fiscal al platitorului">

                        <select style="width: 48%; margin-left: 15px;" name="payment_method">
                            <option value="Alege">Alege</option>
                            @foreach(\App\Post::PAYMENT_METHODS as $key => $value)
                                <option @if(old('payment_method') == $key) selected @endif value="{{ $key }}"> {{ $value }}</option>
                            @endforeach
                        </select>
                    </p>
                    <p>
                        <textarea name="message" cols="40" rows="10" placeholder="Mesaj"></textarea>
                    </p>
                    <p>
                        <span>
                            <input type="checkbox" name="terms" value="1">
                        </span>
                        <span>
                            Sînt de acord cu <a id="terms-link" target="_blank">termeni și condiții</a>
                        </span>

                    </p>
                    <input type="hidden" name="service_id" value="">
                    <input type="hidden" name="price" value="">

                    <p> <button type="submit">Solicită factura <i id="subscription-submit-i"></i></button></p>
                    <div id="error-id"  style="display: none;" role="alert"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth
<div class="myPopupRemove" style="position: fixed; top: 0; left: 0; right: 0; display: none;  overflow: auto; bottom: 0; background: rgba(0,0,0,.55); z-index: 1111;-webkit-box-align: start;-ms-flex-align: start;align-items: flex-start;">
    <div class="general-item" id="containerInput" style="background:  #fff;padding:  10px;width: 500px;padding: 73px 20px;border-radius: 10px;background-color: #f5f5f5;margin: 0 auto; -ms-flex-wrap: wrap;flex-wrap: wrap;display: -webkit-box;display: -ms-flexbox;display: flex;margin-top: 100px;position: relative;"><span class="close" onclick="$('.myPopupRemove').removeClass('add-display-activee');location.href = window.redirect_url" style="float:  right;right: -20px;position:  absolute;top: -20px;text-align:  right;"><i class="fa fa-times"></i>
        </span>
        <p class="myTabContent" style="font-size:  20px;text-align:  center;">

        </p>
    </div>
</div>
