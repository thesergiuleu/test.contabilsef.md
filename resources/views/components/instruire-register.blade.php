<div class="position-post">

    <div class="post-info seminar-subscribe-container">
        <div class="boxt-title">
            <span>Înregistrare de seminar</span>
        </div>
        <div role="form" lang="ro-RO" dir="ltr">
            <div class="screen-reader-response"></div>
            <form id="instruire-register-form" action="{{ route('instruire.register', $component['data']->id) }}"
                  method="post">
                @csrf
                <p>
                    <span>
                        <input @if($errors->has('name')) class="has-error" @endif type="text" name="name"
                               value="{{ auth()->user() ? auth()->user()->name : old('name') }}" size="40"
                               aria-required="true" aria-invalid="false" placeholder="Nume, Prenume"
                               style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    </span>
                </p>
                <p>
                    <span>
                        <input @if($errors->has('email')) class="has-error" @endif type="email" name="email"
                               value="{{ auth()->user() ? auth()->user()->email : old('email') }}" size="40"
                               aria-required="true" aria-invalid="false" placeholder="Email">
                    </span>
                </p>
                <p>
                    <span>
                        <input @if($errors->has('phone')) class="has-error" @endif type="text" name="phone"
                               value="{{ auth()->user() ? auth()->user()->phone : old('phone') }}" size="40"
                               aria-required="true" aria-invalid="false" placeholder="Telefon">
                    </span>
                </p>
                <p>
                    <span>
                        <input @if($errors->has('cod_fiscal')) class="has-error" @endif type="text" name="cod_fiscal"
                               value="{{ old('cod_fiscal') }}" size="40" aria-invalid="false"
                               placeholder="IDNO (opțional)">
                    </span>
                </p>
                <p>
                    <span>
                        <input @if($errors->has('company_name')) class="has-error" @endif type="text"
                               name="company_name"
                               value="{{ auth()->user() ? auth()->user()->company : old('company_name') }}" size="40"
                               aria-invalid="false" placeholder="Numele companiei (opțional)">
                    </span>
                </p>
                <p>
                    <span>
                        <select @if($errors->has('payment_method')) class="has-error" @endif name="payment_method"
                                aria-invalid="false">
                            <option value="Alege">Alege</option>
                            @foreach(\App\Post::PAYMENT_METHODS as $key => $value)
                                <option @if(old('payment_method') == $key) selected
                                        @endif value="{{ $key }}"> {{ $value }}</option>
                            @endforeach
                        </select>
                    </span>
                </p>
                <p>
                    <span>
                        <textarea @if($errors->has('message')) class="has-error" @endif name="message" cols="40"
                                  rows="10" aria-invalid="false" placeholder="Mesaj">{{ old('message') }}</textarea>
                    </span>
                </p>

                <p style="text-align:left;">
                    <label style="font-weight: unset">
                        <input style="width: auto;" type="checkbox" name="terms" value="1">
                        <span>
                            Sînt de acord cu <a id="terms-link" target="_blank" href="{{ route('page.view', \App\Page::TERMS_AND_CONDITIONS_INSTRUIRE) }}">termeni și condiții</a>
                        </span>
                    </label>
                </p>
                @php
                    $subscriptionService = \App\SubscriptionService::query()->where('name', 'like', "%Revista electronică „Contabilsef.md”%")->first()
                @endphp
                @if(auth()->user())
                    @if ($subscriptionService && !auth()->user()->activeSubscription($subscriptionService->id))
                        <p style="text-align:left;">
                            <label style="font-weight: unset">
                                <input style="width: auto;" type="checkbox" name="subscribe" value="1">
                                <span>
                                    Benificiaza de reducere daca va abonati la revista electronica.
                                </span>
                            </label>
                        </p>
                    @endif
                @endif


                @include('components.reCaptcha')
                <input type="hidden" name="ip_address" value="{{ $_SERVER['REMOTE_ADDR'] }}">
                <p>
                    <button type="submit">Trimite</button>
                    @if(!auth()->user())
                        <a title="Autentifică-te pentru a primi reducere la inregistrare la seminar" href="#" class="autentific">Autentifică-te</a>
                    @endif
                </p>
                <div class="wpcf7-response-output wpcf7-display-none"></div>
            </form>
        </div>
    </div>
</div>
