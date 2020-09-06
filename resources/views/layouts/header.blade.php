<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta charset="UTF-8">
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet'/>
    <link href="{{ asset('css/styles.css') . '?v=' . env('STATIC_FILES_VERSION') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/main.css') . '?v=' . env('STATIC_FILES_VERSION') }}" rel="stylesheet" type="text/css"/>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey={{env('YANDEX_MAP_KEY')}}"></script>
    <script type="text/javascript" src="{{ asset('js/vendor.js') . '?v=' . env('STATIC_FILES_VERSION') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bundle.js') . '?v=' . env('STATIC_FILES_VERSION') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') . '?v=' . env('STATIC_FILES_VERSION') }}"></script>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
    </script>
{{--    <script type="text/javascript" src='https://www.google.com/recaptcha/api.js' async defer ></script>--}}

    <title>{{ setting('site.title') }}</title>
</head>
