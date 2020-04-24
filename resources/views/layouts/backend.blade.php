<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ITEST.UZ :: ADMIN PANEL</title>
        <link href="{{ asset('backend/less/font-awesome.min.css') }}" rel="stylesheet">
        @yield('styles')
        <link href="{{ asset('backend/less/styles.css') }}" rel="stylesheet">
    </head>
    <body class="">
        <div class="overlay"></div>
        
        <div class="wrapper">
            <nav class="navbar">
                <a href="{{ url('/') }}" class="navbar__brand" style="background-image: url({{ asset('backend/img/logo.svg')}})"></a>

                <button class="navbar__toggle">
                    <span></span>
                </button>

                <ul class="navbar__nav">
                    {{-- <li class="navbar__list navbar__list--end">
                        <a href="{{ action('Backend\UserController@profile') }}" class="navbar__link navbar__logout">
                            <i class="fa fa-envelope"></i>
                            <span class="tag tag-danger navbar__tag">2</span>
                        </a>
                    </li> --}}
                    <li class="navbar__list navbar__list--end">
                        <a href="{{ action('Backend\UserController@profile') }}" class="navbar__link navbar__logout">
                            <i class="fa fa-cogs"></i>
                        </a>
                    </li>
                    <!-- Logout button -->
                    <li class="navbar__list navbar__list--end">
                        <a href="{{ action('Auth\LoginController@logout') }}" class="navbar__link navbar__logout">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </li>
                </ul>
            </nav>

            <aside class="sidebar">
                
                <div href="#" class="sidebar__info">
                    <i class="fa fa-user sidebar__icon"></i> {{ auth()->user()->name }}<br/>
                </div> 
               
                <p class="sidebar__label">MAIN</p>
                <ul class="sidebar__nav">
                    @if(auth()->user()->hasRole(['admin', 'main_teacher', 'teacher', 'moderator']))
                        <li class="sidebar__list {{ (!request()->is('admin') ?: 'sidebar__list--active') }}">
                            <a href="{{ route('backend.dashboard') }}" class="sidebar__link">
                                <i class="fa fa-bar-chart sidebar__icon"></i>
                                <span class="sidebar__text">Статистика</span>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->hasRole(['admin', 'main_teacher', 'teacher']))
                        <li class="sidebar__list {{ (!request()->is('admin/question') ?: 'sidebar__list--active') }}">
                            <a href="{{ action('Backend\QuestionController@index') }}" class="sidebar__link">
                                <i class="fa fa-question-circle sidebar__icon"></i>
                                <span class="sidebar__text">Вопросы</span>
                            </a>
                        </li>
                    @endif
                    
                    @if(auth()->user()->hasRole(['admin', 'main_teacher']))
                        <li class="sidebar__list {{ (!request()->is('admin/category') ?: 'sidebar__list--active') }}">
                            <a href="{{ action('Backend\CategoryController@index') }}" class="sidebar__link">
                                <i class="fa fa-folder sidebar__icon"></i>
                                <span class="sidebar__text">Категории</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasRole(['admin']))
                        <li class="sidebar__list sidebar__list--drop-toggle">
                            <a href="#" class="sidebar__link">
                                <i class="fa fa-user sidebar__icon"></i>
                                <span class="sidebar__text">Управление пользователями</span>
                                <i class="fa fa-angle-right sidebar__caret"></i>
                            </a>
                            <ul class="sidebar__dropdown">
                                <li class="sidebar__list {{ (request()->is('admin/user/list') ? ' sidebar__list--active' : '') }}">
                                    <a href="{{ action('Backend\UserController@index') }}" class="sidebar__link sidebar__link--dropdown">
                                        <span class="sidebar__text">Сотрудники</span>
                                    </a>
                                </li>
                                <li class="sidebar__list {{ (request()->is('admin/user/student') ? ' sidebar__list--active' : '') }}">
                                    <a href="{{ action('Backend\UserController@student') }}" class="sidebar__link sidebar__link--dropdown">
                                        <span class="sidebar__text">Студенты</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    
                        <li class="sidebar__list sidebar__list--drop-toggle">
                            <a href="#" class="sidebar__link">
                                <i class="fa fa-database sidebar__icon"></i>
                                <span class="sidebar__text">Админ</span>
                                <i class="fa fa-angle-right sidebar__caret"></i>
                            </a>
                            <ul class="sidebar__dropdown">
                                <li class="sidebar__list {{ (request()->is('admin/price') ? ' sidebar__list--active' : '') }}">
                                    <a href="{{ action('Backend\PriceController@index') }}" class="sidebar__link sidebar__link--dropdown">
                                        <span class="sidebar__text">Цены</span>
                                    </a>
                                </li>
                                <li class="sidebar__list {{ (request()->is('admin/referal-stat') ? ' sidebar__list--active' : '') }}">
                                    <a href="{{ action('Backend\PageController@referalStat') }}" class="sidebar__link sidebar__link--dropdown">
                                        <span class="sidebar__text">Рефералы</span>
                                    </a>
                                </li>
                                <li class="sidebar__list {{ (request()->is('admin/payment') ? ' sidebar__list--active' : '') }}">
                                    <a href="{{ action('Backend\PaymentController@index') }}" class="sidebar__link sidebar__link--dropdown">
                                        <span class="sidebar__text">Платежи</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar__list {{ (request()->is('admin/university') ? 'sidebar__list--active' : '') }}">
                            <a href="{{ action('Backend\UniversityController@index') }}" class="sidebar__link">
                                <i class="fa fa-university sidebar__icon"></i>
                                <span class="sidebar__text">ВУЗы</span>
                            </a>
                        </li>
                        
                    @endif

                    @if(auth()->user()->hasRole(['admin', 'moderator']))
                    <li class="sidebar__list sidebar__list--drop-toggle">
                        <a href="#" class="sidebar__link">
                            <i class="fa fa-file-o sidebar__icon"></i>
                            <span class="sidebar__text">Блог</span>
                            <i class="fa fa-angle-right sidebar__caret"></i>
                        </a>
                        <ul class="sidebar__dropdown">
                            <li class="sidebar__list {{ (request()->is('admin/blog') ? ' sidebar__list--active' : '') }}">
                                <a href="{{ action('Backend\BlogController@index') }}" class="sidebar__link sidebar__link--dropdown">
                                    <span class="sidebar__text">Посты</span>
                                </a>
                            </li>
                            <li class="sidebar__list {{ (request()->is('admin/blog-category') ? ' sidebar__list--active' : '') }}">
                                <a href="{{ action('Backend\BlogCategoryController@index') }}" class="sidebar__link sidebar__link--dropdown">
                                    <span class="sidebar__text">Категории</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar__list {{ (!request()->is('admin/video') ?: 'sidebar__list--active') }}">
                        <a href="{{ action('Backend\VideoController@index') }}" class="sidebar__link">
                            <i class="fa fa-video-camera sidebar__icon"></i>
                            <span class="sidebar__text">Видеоуроки</span>
                        </a>
                    </li>
                    <li class="sidebar__list {{ (!request()->is('admin/review') ?: 'sidebar__list--active') }}">
                        <a href="{{ action('Backend\ReviewController@index') }}" class="sidebar__link">
                            <i class="fa fa-comments-o sidebar__icon"></i>
                            <span class="sidebar__text">Отзывы</span>
                        </a>
                    </li>
                    <li class="sidebar__list {{ (!request()->is('admin/ticket') ?: 'sidebar__list--active') }}">
                        <a href="{{ action('Backend\TicketController@index') }}" class="sidebar__link">
                            <i class="fa fa-comments-o sidebar__icon"></i>
                            <span class="sidebar__text">Тикет-система</span>
                            {{-- <span class="tag tag-danger navbar__tag">2</span> --}}
                        </a>
                    </li>
                    @endif
                </ul>
            </aside>

            <main class="content">
                {{-- Flash Messages --}}
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                        <p>{!! Session::get('success') !!}</p>
                    </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissable">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                        <p>{!! Session::get('error') !!}</p>
                    </div>
                @endif

                @foreach($errors->all() as $message)
                    <div class="alert alert-danger alert-dismissable">
                        <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                        <p>{{$message}}</p>
                    </div>
                @endforeach
                @yield('content')
            </main>
        </div>

        <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('backend/js/tinymce.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.tinymce.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.cookie.js') }}"></script>
        <script src="{{ asset('backend/js/admin.js') }}"></script>

        @yield('scripts')

    </body>
</html>