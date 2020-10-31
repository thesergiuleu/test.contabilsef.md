<div class="aboneazate" style="background-image: url({{ asset('assets/imgs/newsletter.png') }})">
    <div class="cont-subscribe">
        <div class="context">
            <h1> Abonează-te la newsletter</h1>
            <div role="form"  lang="ro-RO">
                <form id="newsletter-form" action="{{ $component['route'] }}" method="post">
                    @csrf
                    <p><span class=""><input type="text" name="name" value="" size="40" class="" aria-invalid="false"
                                             placeholder="Nume Prenume"></span></p>
                    <p><span class=""><input type="email" name="email" value="" size="40" class="" aria-required="true"
                                             aria-invalid="false" placeholder="Adresa de email"></span></p>
                    <input type="hidden" name="ip_address" value="{{ $_SERVER['REMOTE_ADDR'] }}">
                    <p>
                        <button type="submit">Abonează-te</button>
                    </p>

                    @include('layouts.response-message')

                </form>
            </div>
        </div>
    </div>
</div>
