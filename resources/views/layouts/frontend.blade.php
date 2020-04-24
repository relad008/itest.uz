<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon" />
        <link rel="apple-touch-icon" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/images/favicon/apple-touch-icon-57x57.png') }}" />
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images/favicon/apple-touch-icon-72x72.png') }}" />
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/favicon/apple-touch-icon-76x76.png') }}" />
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images/favicon/apple-touch-icon-114x114.png') }}" />
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/favicon/apple-touch-icon-120x120.png') }}" />
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/images/favicon/apple-touch-icon-144x144.png') }}" />
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/favicon/apple-touch-icon-152x152.png') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-touch-icon-180x180.png') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css?=v1.3') }}">
        @yield('styles')

        <title>iTest - Оцените свой уровень знаний, и узнайте в какие ВУЗы вы можете поступить</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <header class="header">

            <div class="container">
                <div class="header__wrap">

                    <div class="header__logo-wrap">
                        <a href="{{ route('home') }}" class="logo"></a>
                        <div class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="header__menu">
                        <div class="header__menu-wrap">
                            <a href="{{ route('cabinet') }}/#/demo-select" class="btn btn--brand">@lang('main.free_test')</a>
                        </div>  <!-- /.header__menu-wrap -->
                        @if (auth()->check())
                            <div class="header__menu-wrap">
                                <a href="{{ route('cabinet') }}/#/profile" class="header__menu-item header__menu-item--spaced-left">
                                    <i class="icon-person header__menu-icon-person"></i>
                                    @lang('main.my_profile')
                                </a>
                            </div>  <!-- /.header__menu-wrap -->
                            <div class="header__menu-wrap">
                                <a href="{{ action('Auth\LoginController@logout') }}" class="header__menu-item">
                                    @lang('auth.logout')
                                </a>
                            </div>  <!-- /.header__menu-wrap -->
                        @else
                            <div class="header__menu-wrap">
                                <a href="{{ route('login') }}" class="header__menu-item b-l">
                                    @lang('auth.login')
                                </a>
                            </div>  <!-- /.header__menu-wrap -->
                            <div class="header__menu-wrap">
                                <a href="{{ route('register') }}" class="header__menu-item">
                                    @lang('auth.signup')
                                </a>
                            </div>  <!-- /.header__menu-wrap -->
                        @endif
                        <div class="header__menu-wrap dropdown">
                            <a href="{{ LaravelLocalization::getLocalizedURL() }}" class="header__menu-item">
                                {{ LaravelLocalization::getSupportedLocales()[App::getLocale()]['native'] }}
                                <i class="icon-dropdown-arrow dropdown__icon"></i>
                            </a>
                            <div class="dropdown__wrap header__dropdown-wrap">
                                @foreach(LaravelLocalization::getSupportedLocales() as $code => $lang)
                                    @if (Lang::getLocale() != $code)
                                    <a href="{{ LaravelLocalization::getLocalizedURL($code) }}" class="dropdown__item">
                                        {{ $lang['native'] }}
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>  <!-- /.header__menu-wrap -->
                    </div>  <!-- /.header__menu -->

                </div>  <!-- /.header__wrap -->
            </div>  <!-- /.container -->

            <div class="navbar">
                <div class="container">

                    <div class="navbar__wrap">
                        <div class="header__menu">
                            <div class="header__menu-wrap">
                                <a href="{{ route('cabinet') }}/#/demo-select" class="btn btn--brand">@lang('main.free_test')</a>
                            </div>  <!-- /.header__menu-wrap -->
                            @if (auth()->check())
                                <div class="header__menu-wrap">
                                    <a href="{{ route('cabinet') }}/#/profile" class="header__menu-item header__menu-item--spaced-left">
                                        <i class="icon-person header__menu-icon-person"></i>
                                        @lang('main.my_profile')
                                    </a>
                                </div>  <!-- /.header__menu-wrap -->
                                <div class="header__menu-wrap">
                                    <a href="{{ action('Auth\LoginController@logout') }}" class="header__menu-item">
                                        @lang('auth.logout')
                                    </a>
                                </div>  <!-- /.header__menu-wrap -->
                            @else
                                <div class="header__menu-wrap">
                                    <a href="{{ route('login') }}" class="header__menu-item b-l">
                                        @lang('auth.login')
                                    </a>
                                </div>  <!-- /.header__menu-wrap -->
                                <div class="header__menu-wrap">
                                    <a href="{{ route('register') }}" class="header__menu-item">
                                        @lang('auth.signup')
                                    </a>
                                </div>  <!-- /.header__menu-wrap -->
                            @endif
                            <div class="header__menu-wrap dropdown">
                                <a href="{{ LaravelLocalization::getLocalizedURL() }}" class="header__menu-item">
                                    {{ LaravelLocalization::getSupportedLocales()[App::getLocale()]['native'] }}
                                    <i class="icon-dropdown-arrow dropdown__icon"></i>
                                </a>
                                <div class="dropdown__wrap header__dropdown-wrap">
                                    @foreach(LaravelLocalization::getSupportedLanguagesKeys() as $lang)
                                        @if (Lang::getLocale() != $lang)
                                        <a href="{{ LaravelLocalization::getLocalizedURL($lang) }}" class="dropdown__item">
                                            {{ $lang }}
                                        </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>  <!-- /.header__menu-wrap -->
                        </div>  <!-- /.header__menu -->
                        <div class="navbar__nav clr-block">
                            <div class="navbar__nav-left">
                                <a href="{{ route('home') }}/#aboutSection" class="navbar__link js-scroll-to-about">@lang('main.about_us')</a>
                                <a href="{{ action('Frontend\UniversityController@index') }}" class="navbar__link">@lang('main.universities')</a>
                                <a href="{{ action('Frontend\ProfiController@index') }}" class="navbar__link">Profi Education</a>
                                <a href="http://blog.itest.uz/" class="navbar__link">@lang('main.blog')</a>
                                <a href="{{ route('video.index') }}" class="navbar__link">@lang('main.video_lessons')</a>
                            </div>  <!-- /.navbar__nav-left -->
                            <div class="navbar__nav-right dropdown">
                                <a href="#" class="navbar__link navbar__link--hidden-sm">
                                    @lang('main.tests')
                                    <i class="icon-dropdown-arrow dropdown__icon"></i>
                                </a>
                                <div class="dropdown__wrap navbar__dropdown-wrap">
                                    <a href="{{ route('cabinet') }}/#/payment" class="dropdown__item">
                                    @lang('main.pay_tests')</a>
                                    <a href="{{ route('cabinet') }}/#/direction-select" class="dropdown__item">
                                    @lang('main.direction_test')</a>
                                    <a href="{{ route('cabinet') }}/#/thematic" class="dropdown__item">@lang('main.thematic_test')</a>
                                </div>
                            </div>  <!-- /.navbar__nav-right -->
                        </div>  <!-- /.navbar__nav -->
                    </div> <!-- /.navbar__wrap -->

                </div>  <!-- /.container -->
            </div>  <!-- /.navbar -->

        </header>   <!-- /.header -->
        
        <div class="wrapper">
            @yield('content')
        </div>  <!-- /.wrapper -->
        
        <footer class="footer">
            <div class="container py-xl">
                <ul class="footer__wrap">
                    <li class="footer__wrap-item"><a href="{{ route('home') }}">@lang('main.main')</a></li>
                    <li class="footer__wrap-item"><a href="{{ route('home') }}/#aboutSection" class="js-scroll-to-about">@lang('main.about_us')</a></li>
                </ul>
                <ul class="footer__wrap">
                    <li class="footer__wrap-item"><a href="{{ action('Frontend\UniversityController@index') }}">@lang('main.universities')</a></li>
                    <li class="footer__wrap-item"><a href="{{ action('Frontend\ProfiController@index') }}">Profi Education</a></li>
                    <li class="footer__wrap-item"><a href="http://blog.itest.uz/">@lang('main.blog')</a></li>
                </ul>
                <ul class="footer__wrap">
                    <li class="footer__wrap-item"><a href="{{ route('cabinet') }}/#/direction-select">@lang('main.direction_test')</a></li>
                    <li class="footer__wrap-item"><a href="{{ route('cabinet') }}/#/thematic">@lang('main.thematic_test')</a></li>
                </ul>
                <div class="footer__wrap-right font-medium">
                    <p class="footer__info-color text text-upper pb-xs">@lang('main.have_questions')</p>
                    <p class="title-sm font-medium pb-sm">0 (371) 244-66-06</p>
                    <p class="footer__info-color text pb-xs">@lang('main.write_email')</p>
                    <a href="mailto:info@itest.uz">info@itest.uz</a>
                    <div class="socials">
                        <a href="https://t.me/profieducation_group" target="_blank" class="socials__link">
                            <img src="{{ asset('assets/images/socials/telegram.svg') }}" alt="telegram">
                        </a>
                        <a href="#" target="_blank" class="socials__link">
                            <img src="{{ asset('assets/images/socials/instagram.svg') }}" alt="instagram">
                        </a>
                        <a href="#" target="_blank" class="socials__link">
                            <img src="{{ asset('assets/images/socials/facebook.svg') }}" alt="facebook">
                        </a>
                    </div>
                </div>
            </div>  <!-- /.container -->
            <div class="footer__copy">
                <div class="container">

                    <div class="row">
                        <p class="col-md-4 footer__copy-item">
                            @lang('main.joint_product') 
                            <a href="{{ action('Frontend\ProfiController@index') }}" target="_blank"><img src="{{ asset('assets/images/profi-education.png') }}" class="footer__copy-profi" alt="Profi Education"></a>
                        </p>
                        <p class="col-md-4 footer__copy-item">© 2016 “iTest”. @lang('main.all_rights_guarded')</p>
                        <p class="col-md-4 footer__copy-item">
                            {!! trans('main.developed_by', ['logo' => '<a href="http://pronumero.uz/" target="_blank"><img src="'.asset('assets/images/numero.svg').'" alt="Numero"></a>']) !!}
                        </p>
                    </div>  <!-- /.row -->

                </div>  <!-- /.container -->
            </div>  <!-- /.footer__copy -->

        </footer>   <!-- /.footer -->

        <div class="overlay"></div>

        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script type="text/javascript">

            $('.main__video-wrap').on('click', function() {
                $(this).addClass('play');
                $('.js-main-video').removeClass('hide');
            })
        </script>
        
        <!-- <script src="{{ asset('assets/tmp/js/jquery-3.3.1.slim.min.js') }}"></script> -->
        <script src="{{ asset('assets/tmp/js/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('assets/tmp/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/tmp/js/axios.min.js') }}"></script>
        <script src="{{ asset('assets/tmp/js/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('assets/js/slick.min.js') }}"></script>
        <script>
            var doc = document;

            var is_animating = false,
                hamburger = doc.getElementsByClassName('hamburger')[0],
                navbar = doc.getElementsByClassName('navbar')[0],
                body = doc.getElementsByTagName('body')[0],
                overlay = doc.getElementsByClassName('overlay')[0];

            hamburger.addEventListener('click', function() {
                if (!is_animating) {
                    is_animating = true;
                    this.classList.toggle('open');
                    navbar.classList.toggle('open');
                    body.classList.toggle('o-hidden');
                    overlay.classList.toggle('open');
                    overlay.addEventListener('transitionend', endAnimating, false);
                }
            });

            function endAnimating() {
                is_animating = false;
            }

            // hide certain elements on body click
            ['touchend','click','change'].forEach( function(evt) {
                body.addEventListener(evt, bodyClick, false);
            });

            function bodyClick(e) {
                if ((e.type == 'touchend' || e.type == 'click') && !$(e.target)
                    .closest('.header, .js-teacher-modal-toggler').length) {

                    hamburger.classList.remove('open');
                    navbar.classList.remove('open');
                    body.classList.remove('o-hidden');
                    overlay.classList.remove('open');
                    overlay.addEventListener('transitionend', endAnimating, false);
                }
            }
        </script>
        @yield('scripts')
    </body>
</html>
