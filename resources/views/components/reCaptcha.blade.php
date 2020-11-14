@if(!auth()->user())
    <div class="wpcf7-form-control-wrap">
        <div id="g-recaptcha" class="g-recaptcha"
             data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
        </div>
        <div class="recaptcha-error">

        </div>
    </div>
@endif
