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
        <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
    </head>
    <body>
        <div class="p-404">
            <div class="p-404-wrap">
                <div class="logo p-404-logo"></div>
                <h1 class="p-404-title">Ошибка 404</h1>
                <p class="p-404-info">Ой! Страница не найдена<br>или её не существует</p>
                <a href="{{ route('home') }}" class="btn btn--brand">Вернуться на главную</a>
            </div>
            <img src="{{ asset('assets/images/404.svg') }}" class="p-404-img" alt="404">
        </div>
    </body>
</html>