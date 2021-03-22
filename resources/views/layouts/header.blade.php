<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta charset="UTF-8">
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">--}}
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet'/>
    <link href="{{ asset('css/styles.css') . '?v=' . env('STATIC_FILES_VERSION') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/main.css') . '?v=' . env('STATIC_FILES_VERSION') }}" rel="stylesheet" type="text/css"/>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey={{env('YANDEX_MAP_KEY')}}"></script>
    <script type="text/javascript" src="{{ asset('js/vendor.js') . '?v=' . env('STATIC_FILES_VERSION') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bundle.js') . '?v=' . env('STATIC_FILES_VERSION') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') . '?v=' . env('STATIC_FILES_VERSION') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>


    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
    </script>
{{--    <script type="text/javascript" src='https://www.google.com/recaptcha/api.js' async defer ></script>--}}

    <title>{{ setting('site.title') }}</title>

    <style>
        .response-message {
            background: #398f14;
            margin-top: 0px;
            color: #fff;
            border: 2px solid #398f14;
        }
    </style>
</head>
