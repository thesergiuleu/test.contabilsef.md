<style>
    .input {
        width: 100%;
        border-radius: 5px;
        background-color: #ebebeb;
        box-shadow: -0.1px 3px 3px 0 rgba(0, 0, 0, .03);
        border: none;
        outline: 0;
        padding: 7px 10px;
        font-weight: 500;
        margin-top: 5px;
    }

    .input-btn {
        display: initial;
        padding: 5px 15px;
        color: #fff;
        border-radius: 3px;
        cursor: pointer;
        margin-right: 10px;
        background: #3c5a98;
        height: 36px;
    }

    .select {
        width: 100%;
        border-radius: 5px;
        background-color: #ebebeb;
        box-shadow: -0.1px 3px 3px 0 rgba(0, 0, 0, .03);
        border: none;
        outline: 0;
        padding: 7px 10px;
        font-weight: 500;
        margin-top: 5px;
        height: 36px;
    }

    .div {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 100%;
        font-size: 14px;
        font-weight: 600;
        font-style: normal;
        font-stretch: normal;
        line-height: 1.43;
        letter-spacing: normal;
        color: #252525;
        text-transform: uppercase;
        margin-bottom: 20px;
        margin: 10px;
    }

    .textarea {
        min-height: 176px;
        border-radius: 5px;
        background-color: #ebebeb;
        outline: 0;
        padding: 10px;
        border: none;
        box-shadow: -0.1px 3px 3px 0 rgba(0, 0, 0, .03);
        max-width: 100%;
        width: 100%;
        font-weight: 500;
        margin-top: 10px;
    }
</style>
<div class="conecteazane">
    <p>Contactează-ne</p>
    <form id="contact-form" action="{{ route('contact-post') }}" method="post">
        @csrf
        <div class="div">
            <input placeholder="Nume Prenume" type="text" class="@if($errors->has('name')) wpcf7-not-valid @endif" value="{{ old('name') }}" name="name">
        </div>
        <div class="div">
            <input placeholder="Email" type="text" class="@if($errors->has('email')) has-error @endif" value="{{ old('email') }}" name="email">
        </div>
        <div class="div">
            <input placeholder="Telefon" type="text" class="@if($errors->has('phone')) has-error @endif" value="{{ old('phone') }}" name="phone">
        </div>
        <div class="div">
            <textarea placeholder="Mesaj" class="@if($errors->has('message')) has-error @endif" name="message">{{ old('message') }}</textarea>
        </div>
        <input type="hidden" name="page" value="{{ \App\Contact::PAGE_CONTACT }}">
        <input type="hidden" name="ip_address" value="{{ $_SERVER['REMOTE_ADDR'] }}">

        @if(!auth()->user())
            <div class="div">
                @include('components.reCaptcha')
            </div>
        @endif

        <div style="text-align: center">
            <button class="input-btn" type="submit" style="margin-left: 15px;margin-top: 25px;padding: 8px;height: auto;left: 0;">Trimite <i id="subscription-submit-i"></i>
            </button>
        </div>
        @include('layouts.response-message')

    </form>
</div>
<div class="contactele">
    <p>{{ $component['title'] }}</p>
    <div class="box-contacte">
        <div class="content-contacte">
            <img src="{{ asset('assets/imgs/local.png') }}" alt="">
            <span>{{ setting('site.address_footer_widget') }}</span>
        </div>
        <div class="content-contacte">
            <img src="{{ asset('assets/imgs/mes.png') }}" alt="">
            <a href="mailto:{{ setting('site.email_footer_widget') }}">{{ setting('site.email_footer_widget') }}</a>
        </div>
        <div class="content-contacte">
            <img src="{{ asset('assets/imgs/tel.png') }}" alt="">
            <a href="tel:{{ setting('site.phone_footer_widget') }}">Tel: {{ setting('site.phone_footer_widget') }}</a>
            <a href="tel:{{ setting('site.fax_footer_widget') }}">Fax: {{ setting('site.fax_footer_widget') }}</a>
        </div>
    </div>
    <div class="link_s">
        <h1>Urmărește-ne</h1>
        <div class="post-link">
            <a href="{{ setting('site.twitter_widget') }}" class="icon-div"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="{{ setting('site.facebook_widget') }}" class="icon-div"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="{{ setting('site.linkedin_widget') }}" class="icon-div"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            <a href="{{ setting('site.google_widget') }}" class="icon-div"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
