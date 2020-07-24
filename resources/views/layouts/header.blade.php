<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta charset="UTF-8">
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' rel='stylesheet'/>
    <link href="{{ asset('css/styles.css') . '?v=' . env('STATIC_FILES_VERSION') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/main.css') . '?v=' . env('STATIC_FILES_VERSION') }}" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="{{ asset('js/vendor.js') . '?v=' . env('STATIC_FILES_VERSION') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bundle.js') . '?v=' . env('STATIC_FILES_VERSION') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') . '?v=' . env('STATIC_FILES_VERSION') }}"></script>

    <nav class="nav">
        <div class="fluide-nav">
            <div class="kat-container">
                <div class="content-nav">
                    <div class="post__nav">
                        <div class="post-nav">
                            <a href="tel:">
                                <img src="{{ asset('assets/imgs/call-answer.png') }}" alt="">
                                +373 22 22 49 37
                            </a>
                        </div>
                        <div class="post-nav">
                            <a href="mailto:">
                                <img src="{{ asset('assets/imgs/envelope.png') }}" alt="">
                                office@contabilsef.md
                            </a>
                        </div>
                    </div>

                    <div class="post-nav icons-mobile">
                        |<a href="#" class="autentific">Autentificare</a>|<a href="#" class="inregistrare_cont">Înregistrare</a>|
                    </div>
                </div>
            </div>
        </div>

        <div class="kat-container">
            <div class="menu-this">
                <div class="sub-general-menu">
                    <a href="{{ env('APP_URL') }}" class="logo"><img
                            src="{{ asset('storage/' . setting('site.logo')) }}" alt=""></a>
                </div>

                <div class="sub-general-menu">
                    <div class="menu-meniu-container">
                        {!! menu('site', 'layouts.navbar') !!}
                    </div>

                    <a href="#" class="clikc_burger">
                        <div class="navbar-mobile-menu">
                            <div class="lines-open">
                                <div class="line line-1"></div>
                                <div class="line line-2"></div>
                                <div class="line line-3"></div>
                            </div>
                        </div>
                    </a>

                </div>

            </div>
        </div>
    </nav>
    <div class="search-mobile">
        <form action="{{ env('APP_URL') }}" method="get">
            <div class="close">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                     viewBox="0 0 22.88 22.88" style="enable-background:new 0 0 22.88 22.88;" xml:space="preserve">
				<path style="fill:#1E201D;" d="M0.324,1.909c-0.429-0.429-0.429-1.143,0-1.587c0.444-0.429,1.143-0.429,1.587,0l9.523,9.539
				 l9.539-9.539c0.429-0.429,1.143-0.429,1.571,0c0.444,0.444,0.444,1.159,0,1.587l-9.523,9.524l9.523,9.539
				 c0.444,0.429,0.444,1.143,0,1.587c-0.429,0.429-1.143,0.429-1.571,0l-9.539-9.539l-9.523,9.539c-0.444,0.429-1.143,0.429-1.587,0
				 c-0.429-0.444-0.429-1.159,0-1.587l9.523-9.539L0.324,1.909z" />
                    <g>
                    </g>
			</svg>
            </div>
            <input type="text"  name="s"  placeholder="Cauta produs" >
            <button type="submit">

                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"viewBox="0 0 451 451" style="enable-background:new 0 0 451 451;" xml:space="preserve"><g><path d="M447.05,428l-109.6-109.6c29.4-33.8,47.2-77.9,47.2-126.1C384.65,86.2,298.35,0,192.35,0C86.25,0,0.05,86.3,0.05,192.3											s86.3,192.3,192.3,192.3c48.2,0,92.3-17.8,126.1-47.2L428.05,447c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4											C452.25,441.8,452.25,433.2,447.05,428z M26.95,192.3c0-91.2,74.2-165.3,165.3-165.3c91.2,0,165.3,74.2,165.3,165.3											s-74.1,165.4-165.3,165.4C101.15,357.7,26.95,283.5,26.95,192.3z" /></g></svg>
            </button>
        </form>
    </div>
    <title>{{ setting('site.title') }}</title>
</head>
