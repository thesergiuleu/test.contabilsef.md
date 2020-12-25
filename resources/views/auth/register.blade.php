@extends('auth.master')
@section('title')
    {{ 'Înregistrare - ' . setting('site.name', 'Contabil Șef') }}
@endsection
<style>
    .register-container {
        position: absolute;
        z-index: 10;
        width: 100%;
        padding: 30px;
        top: 50%;
        margin-top: -345px;
    }
</style>
@section('content')
    <div class="register-container">

        <p>{!!  __('<b>Înregistrați-vă mai jos</b>')  !!}</p>

        <form action="{{ route('register') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group form-group-default" id="nameGroup">
                <label>{{ __('Nume, Prenume') }}</label>
                <div class="controls">
                    <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ __('Nume, Prenume') }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group form-group-default" id="emailGroup">
                <label>{{ __('voyager::generic.email') }}</label>
                <div class="controls">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group form-group-default" id="phoneGroup">
                <label>{{ __('Telefon') }}</label>
                <div class="controls">
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="{{ __('+373 783 12 123') }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group form-group-default" id="companyGroup">
                <label>{{ __('Compania') }}</label>
                <div class="controls">
                    <input type="text" name="company" id="company" value="{{ old('company') }}" placeholder="{{ __('Compania') }}" class="form-control">
                </div>
            </div>

            <div class="form-group form-group-default" id="positionGroup">
                <label>{{ __('Funcția') }}</label>
                <div class="controls">
                    <input type="text" name="position" id="position" value="{{ old('position') }}" placeholder="{{ __('Funcția') }}" class="form-control">
                </div>
            </div>

            <div class="form-group form-group-default" id="passwordGroup">
                <label>{{ __('voyager::generic.password') }}</label>
                <div class="controls">
                    <input type="password" name="password" placeholder="{{ __('voyager::generic.password') }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group form-group-default" id="password_confirmationGroup">
                <label>{{ __('Confirmă parola') }}</label>
                <div class="controls">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Confirmă parola') }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group" id="termsMeGroup">
                <div class="controls">
                    <input type="checkbox" name="terms" id="terms" value="1"><label for="terms" class="remember-me-text">Sunt de acord cu <a href="" target="_blank">termeni și condiții</a></label>
                </div>
            </div>

            <div class="form-group" id="newsletterMeGroup">
                <div class="controls">
                    <input type="checkbox" name="newsletter" id="newsletter" value="1"><label for="newsletter" class="remember-me-text">Doresc să primesc noutăți</label>
                </div>
            </div>

            <input type="hidden" value="{{ session()->get('_previous')['url'] }}" name="redirect_to">

            <input type="hidden" name="is_bot">

            <button type="submit" class="btn btn-block login-button">
                <span class="signingin hidden"><span class="voyager-refresh"></span> {{ __('voyager::login.loggingin') }}...</span>
                <span class="signin">{{ __('Înregistrare') }}</span>
            </button>

            <a class="btn" href="{{ route('login') }}"> Autentifică-te </a>

        </form>

        <div style="clear:both"></div>

        @if(!$errors->isEmpty())
            <div class="alert alert-red">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div> <!-- .login-container -->
@endsection

@section('post_js')
    <script>
        var btn = document.querySelector('button[type="submit"]');
        var form = document.forms[0];
        var email = document.querySelector('[name="email"]');
        btn.addEventListener('click', function(ev){
            if (form.checkValidity()) {
                btn.querySelector('.signingin').className = 'signingin';
                btn.querySelector('.signin').className = 'signin hidden';
            } else {
                ev.preventDefault();
            }
        });
        email.focus();
        document.getElementById('emailGroup').classList.add("focused");

        addFocusInAndOut('email');
        addFocusInAndOut('name');
        addFocusInAndOut('phone');
        addFocusInAndOut('company');
        addFocusInAndOut('position');
        addFocusInAndOut('password');
        addFocusInAndOut('password_confirmation');


        function addFocusInAndOut(field) {
            var input = document.querySelector(`[name=${field}]`)
            // Focus events for email and password fields
            input.addEventListener('focusin', function(e){
                document.getElementById(field + 'Group').classList.add("focused");
            });
            input.addEventListener('focusout', function(e){
                document.getElementById(field + 'Group').classList.remove("focused");
            });
        }

    </script>
@endsection
