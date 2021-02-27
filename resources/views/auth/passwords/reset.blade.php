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
    <div class="login-container">

        <p>{!!  __('Introduce-ti parola pentru a o reseta')  !!}</p>

        <form action="{{ route('password.update') }}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="email" value="{{ request()->get('email') }}">
            <input type="hidden" name="token" value="{{ substr(request()->getPathInfo(), strrpos(request()->getPathInfo(), '/') + 1) }}">
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

            <button type="submit" class="btn btn-block login-button">
                <span class="signingin hidden"><span class="voyager-refresh"></span> {{ __('voyager::login.loggingin') }}...</span>
                <span class="signin">{{ __('Resetează') }}</span>
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
