@extends('layouts.frontend')

@section('content')
	<section class="main">
            
        <div class="container relative z-index-1">
            <div class="row">
                <div class="col-md-6 main__info">
                    <h1 class="title pt-xl pb-xs">@lang('main.study_remotely')</h1>
                    <p class="text-brand text-lg font-medium pb-xl">@lang('main.no_exit_home')</p>
                    <p class="main__info-item">
                        @lang('main.get_test_block')
                    </p>
                    <a href="{{ route('cabinet') }}/#/demo-select" class="btn btn--brand">@lang('main.free_test')</a>
                </div>  <!-- /.col-md-6 -->
                <div class="col-md-6">
                    <div class="main__video-wrap">
                        <iframe class="main__video js-main-video hide" src="https://mover.uz/video/embed/IZqvPgrm/" frameborder="0" allowfullscreen autoplay></iframe>
                    </div>
                </div>  <!-- /.col-md-6 -->
            </div>  <!-- /.row -->
        </div>  <!-- /.container -->

        <div class="bg-img-group">
            <div class="bg-img-group__item main__bg-img-left1"></div>
            <div class="bg-img-group__item main__bg-img-left2"></div>
            <div class="bg-img-group__item main__bg-img-left3"></div>
            <div class="bg-img-group__item main__bg-img-right"></div>
        </div>  <!-- /.bg-img-group" -->

    </section>  <!-- /.main -->

    <section class="guide">
        <div class="container">

            <h2 class="title text-center pb-layout-xs">@lang('main.how_to_use.title')</h2>
            <div class="guide__wrap">
                <div class="row">
                    <div class="col-md-3 col-sm-6 guide__item">
                        <div class="guide__icon">
                            <img src="{{ asset('assets/images/guide/card.svg') }}">
                        </div>
                        <p>{!! __('main.how_to_use.reg_on_site') !!}</p>
                    </div>
                    <div class="col-md-3 col-sm-6 guide__item">
                        <div class="guide__icon">
                            <img src="{{ asset('assets/images/guide/wallet.svg') }}">
                        </div>
                        <p>{!! __('main.how_to_use.buy_subscription') !!}</p>
                    </div>
                    <div class="col-md-3 col-sm-6 guide__item">
                        <div class="guide__icon">
                            <img src="{{ asset('assets/images/guide/folder.svg') }}">
                        </div>
                        <p>{!! __('main.how_to_use.select') !!}</p>
                    </div>
                    <div class="col-md-3 col-sm-6 guide__item">
                        <div class="guide__icon">
                            <img src="{{ asset('assets/images/guide/list.svg') }}">
                        </div>
                        <p>{!! __('main.how_to_use.answer_questions') !!}</p>
                    </div>
                </div>  <!-- /.row -->
            </div>  <!-- /.guide__wrap -->

        </div>  <!-- /.container -->
    </section>  <!-- /.guide -->

    <section class="about" id="aboutSection">

        <div class="container relative z-index-1">
            <div class="row">
                <div class="col-md-6 col-md-push-6">
                    <h2 class="title pb-xl">@lang('main.about_us')</h2>
                    <p class="lh-lg">@lang('main.about.info')</p>
                </div>
                <div class="col-md-5 col-md-pull-6">
                    <div class="about__block">
                        <ul class="about__nav">
                            <li class="about__nav-item about__nav-item--sm">@lang('main.about.state1')</li>
                            <li class="about__nav-item about__nav-item--sm">@lang('main.about.state2')</li>
                            <li class="about__nav-item">@lang('main.about.state3')</li>
                            <li class="about__nav-item">@lang('main.about.state4')</li>
                            <li class="about__nav-item">@lang('main.about.state5')</li>
                        </ul>
                    </div>
                </div>
            </div>  <!-- /.row -->
        </div>  <!-- /.container -->

        <div class="bg-img-group bg-img-group--transparent">
            <div class="bg-img-group__item about__bg-img-left1"></div>
            <div class="bg-img-group__item about__bg-img-left2"></div>
        </div>  <!-- /.bg-img-group" -->

    </section>  <!-- /.about -->

    <section class="subjects">
        <div class="container">
            
            <h2 class="title text-center pb-layout-xs mb-md">@lang('new_main.you_can_test_by_subjects')</h2>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/math.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">Математика</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/english.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">English</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/french.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">French</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/biology.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">Биология</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/native-language.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">Родной язык</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/history.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">История</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/physics.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">Физика</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/chemistry.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">Химия</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/german.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">Немецкий язык</p>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6 col-md-push-4">
                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
                        <img src="{{ asset('assets/images/subjects/russian.svg') }}" class="subjects__card-img" alt="math">
                        <p class="subjects__card-info">Русский язык</p>
                    </a>
                </div>
            </div>  <!-- /.row -->

        </div>  <!-- /.container -->
    </section>  <!-- /.subjects -->

    <section class="tariff bg-white">
        <div class="container">

            <h2 class="title text-center pb-layout-xs">@lang('pay.tariff_plans')</h2>
            <div class="row">
                @foreach($prices as $key => $price)
                <div class="col-md-4 col-sm-6{!! $key == 2 ? ' col-md-push-0 col-sm-push-3' : '' !!}">
                    <div class="tariff__card{!! $key == 1 ? ' tariff__card--super' : '' !!}">
                        @if ($key == 1)
                            <div class="tariff__card-super-title">@lang('pay.recommended')</div>
                        @endif
                        <div class="tariff__card-header">
                            <h3 class="title-sm font-regular text-normal text-center">{{ $price->name }}</h3>
                        </div>  <!-- /.tariff__card-header -->
                        <div class="tariff__card-body">
                            <div class="tariff__card-price-wrap">
                                <p class="tariff__card-price">{{ $price->price_format }} <span>@lang('pay.soum_month')</span></p>
                            </div>
                            <div class="tariff__card-item">
                                <i class="icon-check"></i>
                                <p>
                                    <span class="font-semibold">{{ $price->thematic_count }}</span>
                                    @lang('pay.thematic_tests')
                                </p>
                            </div>
                            <div class="tariff__card-item">
                                <i class="icon-check"></i>
                                <p>
                                    <span class="font-semibold">{{ $price->direction_count }}</span>
                                    @lang('pay.direction_tests')
                                </p>
                            </div>
                            <div class="tariff__card-item tariff__card-item--last">
                                <i class="{{ $price->has_chat ? 'icon-check' : 'icon-close' }}"></i>
                                <p>
                                    @lang('pay.free_consultation') 
                                    <span class="font-semibold">Profi Education</span>
                                </p>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('cabinet') }}/#/pay/{{ $price->id }}" class="btn btn--blue">@lang('pay.buy_subscription')</a>
                            </div>
                        </div>  <!-- /.tariff__card-body -->
                    </div>  <!-- /.tariff__card -->
                </div>
                @endforeach

            </div>  <!-- /.row -->

        </div>  <!-- /.container -->
    </section>  <!-- /.tariff -->

    <section class="callback">
        <div class="container">
            
            <div class="text-center">
                <h2 class="title text-upper pb-md">@lang('callback.left_questions')</h2>
                <p class="text-lg pb-md mb-lg">{!! __('callback.fill_form') !!}</p>
            </div>
            <div class="row">
                <div class="col-lg-6 col-lg-push-3 col-md-8 col-md-push-2 col-sm-10 col-sm-push-1">
                    <div class="callback__form">
                        <div class="callback__form-sent">
                            <i class="icon-check callback__form-icon"></i>
                            <h2 class="text-lg mb-sm">@lang('callback.success_title')</h2>
                            <p>@lang('callback.success_info')</p>
                        </div>
                        {!! Form::open(['action' => 'Frontend\PageController@sendEmail', 'class' => 'js-contact-form callback__form-inner']) !!}
                            <div class="form-group">
                                <input type="text" class="input js-input-name" name="name" required>
                                <label class="label">@lang('callback.name')</label>
                            </div>
                            <div class="form-group">
                                <input type="email" class="input js-input-email" name="email" required>
                                <label class="label">@lang('callback.email')</label>
                            </div>
                            <div class="form-group">
                                <textarea class="input input--textarea js-input-message"></textarea>
                                <label class="label">@lang('callback.message')</label>
                            </div>
                            <div class="clr-block">
                                <div class="callback__recaptcha">
                                    {!! NoCaptcha::display() !!}
                                </div>
                                <div class="callback__floated-right">
                                    <div class="callback__btn-wrap">
                                        <button type="submit" class="btn btn--brand callback__btn">@lang('callback.send')</button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>  <!-- /.callback__form -->
                </div>
            </div>  <!-- /.row -->

        </div>  <!-- /.container -->
    </section>  <!-- /.callback -->
@endsection

@section('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>

        function sendEmail(options) {
            var _t = {};
            _t.form = $('.js-contact-form');
            _t.name = $('.js-input-name');
            _t.email = $('.js-input-email');
            _t.message = $('.js-input-message');

            _t.onAuth = function()
            {
                _t.form.on('submit', function(e) {
                        this.getAttribute('action');
                    if (_t.form.valid()) {
                        e.preventDefault();
                        axios.post(this.getAttribute('action'), {
                            name: _t.name.val(),
                            email: _t.email.val(),
                            message: _t.message.val(),
                            "g-recaptcha-response": $("#g-recaptcha-response").val()
                        }).then(function(response) {
                            if (response.data.errors) {
                                // Signup.showError(data);
                            } else {
                                $('.callback__form-inner').addClass('hidden');
                                $('.callback__form-sent').fadeIn(400);
                            }
                        })
                    }
                    e.preventDefault();
                })
            }
            _t.init = function()
            {
                _t.options = options;
                _t.onAuth();

                _t.form.validate({
                    highlight: function(element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('is-invalid');
                    },
                    errorPlacement: function(error, element) {
                        if(element.parent('.input-group').length) {
                            error.addClass('invalid-feedback').insertAfter(element.parent());
                        } else {
                            error.addClass('invalid-feedback').insertAfter(element);
                        }
                    }
                });
            }

            return _t;
        }
                
        document.addEventListener('DOMContentLoaded', function(){
            var toAbout = document.getElementsByClassName('js-scroll-to-about'),
                aboutSection = document.getElementById('aboutSection');

            for (var i=0; i < toAbout.length; i++) { // relitere 
                toAbout[i].addEventListener('click', function(e) {
                    var hashval = this.getAttribute('href');
                    hashval = hashval.substr(-13, 13);
                    var target = document.querySelector(hashval);
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                    history.pushState(null, null, hashval);
                    e.preventDefault();
                });
            }



            new sendEmail({
                auth_url: "{{ action('Frontend\PageController@sendEmail') }}"
            }).init();

        });
    </script>
@endsection