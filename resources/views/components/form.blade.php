<form action="{{ $formData['route'] }}" method="post" class="wpcf7-form" novalidate="novalidate">
    @csrf
    <div class="inputs">
        <input type="text" name="name" value="" size="40" class="" aria-required="true" aria-invalid="false" placeholder="Nume Prenume"><br>
        <input type="text" name="email" value="" size="40" class="" aria-required="true" aria-invalid="false" placeholder="Introduceti posta"><br>
    </div>
    <div class="text-area">
        <textarea name="message" cols="40" rows="10" class="" id="textareaAddQuestion" aria-required="true" aria-invalid="false" placeholder="Mesaj"></textarea>
    </div>
    <div class="text-area">
        <div class="wpcf7-form-control-wrap">
{{--            todo captcha--}}
        </div>
        <input type="hidden" name="ip-address" value="{{ $_SERVER['REMOTE_ADDR'] }}">
        <p>
            <button type="submit"><img src="{{ asset('assets/imgs/air.png') }}" alt=""></button>
        </p>
    </div>
</form>
