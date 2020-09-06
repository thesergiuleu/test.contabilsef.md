<form id="contact-form" action="{{ $formData['route'] }}" method="post" class="wpcf7-form" novalidate="novalidate">
    @csrf
    <div  class="inputs">
        <p style="width: 48%">
            <input type="text" name="name"  placeholder="Nume Prenume">
        </p>
        <p style="width: 48%">
            <input type="text" name="email" placeholder="Introduceti posta">
        </p>
    </div>
    <div class="text-area">
        <textarea required name="message" cols="40" rows="10" class="" id="textareaAddQuestion" aria-required="true" aria-invalid="false" placeholder="Mesaj"></textarea>
    </div>
    <div class="text-area">
        @if(!auth()->user())
            @include('components.reCaptcha')
        @endif
        <input type="hidden" name="ip_address" value="{{ $_SERVER['REMOTE_ADDR'] }}">
        <input type="hidden" name="page" value="{{ \App\Contact::CONTACT_FORM }}">
        <p>
            <button type="submit"><img src="{{ asset('assets/imgs/air.png') }}" alt=""></button>
        </p>
    </div>
</form>
