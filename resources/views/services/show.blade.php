<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--  Styles  -->
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <link href="{{ asset('styles/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/hamburger.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <title>Revista online "Contabilsef.md"</title>
</head>
<body>
<header>
    <div class="nav-desktop">
        <div class="logo">
            <img src="{{ asset("images/Logo_contabilsef.png") }}" alt="logo">
        </div>
        <div class="menu-desktop"></div>
        <div class="right-list">
            <a class="phone" href="tel: +373 22 22 49 47">+373 22 22 49 47</a>
            <a class="icon" href="#"><img src="{{ asset("images/fb.svg" )}}" alt="fb"></a>
            <a class="icon" href="#"><img src="{{ asset("images/tw.svg" )}}" alt="tw"></a>
        </div>
    </div>
    <div class="nav-mobile" id="nav_mobile">
        <div id="hamburger" class="hamburger hamburger--spring">
            <div class="hamburger-box">
                <div class="hamburger-inner"></div>
            </div>
        </div>
        <div id="mob_nav" class="mob-nav">
            <div class="logo">
                <img src="{{ asset("images/Logo_contabilsef.png") }}" alt="logo">
            </div>
            <div class="menu-mobile"></div>
            <a class="phone" href="tel: +373 22 22 49 47">+373 22 22 49 47</a>
            <div class="icons-list">
                <a href="#"><img src="{{ asset("images/fb.svg" )}}" alt="fb"></a>
                <a href="#"><img src="{{ asset("images/tw.svg" )}}" alt="tw"></a>
            </div>
        </div>
    </div>
    <div class="banner" style="background: url({{ asset('images/banner-bg.jpg') }}); background-size: cover;">
        <div class="content">
            <h1>{{ $service->name }}</h1>
            <p>Contabilitatea și fiscalitatea este în permanentă schimbare și dezvoltare. Noi vă asigurăm la timp cu informații utile și soluții practice care vă simplifică activitatea dvs. și vă salvează timpul necesar pentru studierea de volume mari de documente și acte normative.</p>
            <a href="#subscription" class="banner-button">Abonare la Revistă</a>
            <a href="#ofer" class="link-down">
					<span class="arrow-down">
						<svg class="t-cover__arrow-svg" style="fill:#ffffff;" x="0px" y="0px" width="38.417px" height="18.592px" viewBox="0 0 38.417 18.592"><g><path d="M19.208,18.592c-0.241,0-0.483-0.087-0.673-0.261L0.327,1.74c-0.408-0.372-0.438-1.004-0.066-1.413c0.372-0.409,1.004-0.439,1.413-0.066L19.208,16.24L36.743,0.261c0.411-0.372,1.042-0.342,1.413,0.066c0.372,0.408,0.343,1.041-0.065,1.413L19.881,18.332C19.691,18.505,19.449,18.592,19.208,18.592z"></path></g></svg>
					</span>
            </a>
        </div>
    </div>
</header>
<main>
    @include('services.sections.offer')
    @include('services.sections.benefit')
    @include('services.sections.get-access')
    @include('services.sections.why-we')
    @include('services.sections.reviews')
    @include('services.sections.subscription')
    @include('services.sections.guaranty')
    @include('services.sections.articles')
    @include('services.sections.how-subscribe')
    @include('services.sections.contacts')

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="content">
        <div class="srl-desktop">© 2021 Totul pentru contabil SRL</div>
        <ul>
            <li><a href="#ofer">Despre proiect</a></li>
            <li><a href="#why-we">Beneficii</a></li>
            <li><a href="#subscription">Abonamente</a></li>
            <li><a href="#contacts">Contacte</a></li>
        </ul>
        <div class="srl-mobile">© 2021 Totul pentru contabil SRL</div>
        <a class="back-to-top-desktop" href="#">
            Sus
            <svg width="5" height="17" viewBox="0 0 6 20">
                <path fill="#ffffff" d="M5.78 3.85L3.12.28c-.14-.14-.3-.14-.43 0L.03 3.85c-.14.13-.08.27.13.27h1.72V20h2.06V4.12h1.72c.15 0 .22-.07.19-.17a.26.26 0 00-.07-.1z" fill-rule="evenodd"></path>
            </svg>
        </a>
    </div>
    <a class="back-to-top-mobile" href="#">
        Sus
        <svg width="5" height="17" viewBox="0 0 6 20">
            <path fill="#ffffff" d="M5.78 3.85L3.12.28c-.14-.14-.3-.14-.43 0L.03 3.85c-.14.13-.08.27.13.27h1.72V20h2.06V4.12h1.72c.15 0 .22-.07.19-.17a.26.26 0 00-.07-.1z" fill-rule="evenodd"></path>
        </svg>
    </a>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="{{ asset('js/landing.js') }}"></script>

</body>
</html>
