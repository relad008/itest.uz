@extends('layouts.frontend')

@section('styles')
	<link href="{{ asset('assets/css/jsmaps.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<section class="profi">

		<div class="profi-content">

			<div class="container relative z-index-1">
				<div class="profi__nav-wrap">
					<ul class="profi__nav">
						<li class="profi__nav-item">
							<a href="{{ action('Frontend\ProfiController@about') }}" class="profi__nav-link">@lang('profiedu_site.about_us')</a>
						</li>
						<li class="profi__nav-item">
							<a href="{{ action('Frontend\ProfiController@teachers') }}" class="profi__nav-link">@lang('profiedu_site.teachers')</a>
						</li>
						<li class="profi__nav-item">
							<a href="#" class="profi__nav-link js-to-contact">@lang('profiedu_site.contacts')</a>
						</li>
						<li class="profi__nav-item">
							<a href="#" class="profi__nav-link">@lang('profiedu_site.campaign')</a>
						</li>
					</ul>	<!-- .profi__nav -->
				</div>	<!-- /.profi__nav-wrap -->

				<img src="{{ asset('assets/images/profi-education/logo.png') }}" alt="Profi Education" class="profi__logo">
			
				<div class="row">
					<div class="col-md-8 col-md-push-2">
						<div class="profi-content__card">
							<div class="profi-content__card-wrap">
								<img src="{{ asset('assets/images/profi-education/level-complete.svg') }}" class="profi-content__card-thumb" alt="graduates amount">
								<p class="profi-content__card-title">2353</p>
								<p class="profi-content__card-info">{!! __('profiedu_site.total_students') !!}</p>
							</div>
							<div class="profi-content__card-wrap">
								<img src="{{ asset('assets/images/profi-education/student.svg') }}" class="profi-content__card-thumb" alt="Entered">
								<p class="profi-content__card-title">1762</p>
								<p class="profi-content__card-info">{!! __('profiedu_site.in_university') !!}</p>
							</div>
							<div class="profi-content__card-wrap">
								<img src="{{ asset('assets/images/profi-education/books.svg') }}" class="profi-content__card-thumb" alt="Came back">
								<p class="profi-content__card-title">168</p>
								<p class="profi-content__card-info">{!! __('profiedu_site.return_back') !!}</p>
							</div>
						</div>	<!-- /.profi-content__card -->
					</div>
				</div>	<!-- /.row -->
			</div>	<!-- /.container -->

			<div class="bg-img-group bg-img-group--profi">
	            <div class="bg-img-group__item profi__bg-img-left1"></div>
	            <div class="bg-img-group__item profi__bg-img-left2"></div>
	        </div>  <!-- /.bg-img-group" -->

		</div>	<!-- /.profi-content.bg-img-group--profi -->
		
		<div class="profi-about">
			<div class="container">

				<div class="row">
					<div class="col-md-6">
						<div class="profi-about__wrap">
							<img src="{{ asset('assets/images/profi-education/graph.svg') }}" class="profi-about__wrap-thumb" alt="graph">
							<p class="profi-about__wrap-info">@lang('profiedu_site.stats.1')</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="profi-about__wrap">
							<img src="{{ asset('assets/images/profi-education/ielts.svg') }}" class="profi-about__wrap-thumb" alt="ielts">
							<p class="profi-about__wrap-info">@lang('profiedu_site.stats.2')</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="profi-about__wrap">
							<img src="{{ asset('assets/images/profi-education/building.svg') }}" class="profi-about__wrap-thumb" alt="building">
							<p class="profi-about__wrap-info">@lang('profiedu_site.stats.3')</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="profi-about__wrap">
							<img src="{{ asset('assets/images/profi-education/time.svg') }}" class="profi-about__wrap-thumb" alt="time">
							<p class="profi-about__wrap-info">@lang('profiedu_site.stats.3')</p>
						</div>
					</div>
				</div>	<!-- /.row -->

			</div>	<!-- /.container -->
		</div>	<!-- /.profi-about -->

	    <section class="subjects">
	        <div class="container">
	            
	            <h2 class="title text-center pb-layout-xs mb-md">@lang('profiedu_site.for_students')</h2>
	            <div class="row">
	                <div class="col-md-4 col-sm-6">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/math-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">Математика</p>
	                    </a>
	                </div>
	                <div class="col-md-4 col-sm-6">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/english-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">English</p>
	                    </a>
	                </div>
	                <div class="col-md-4 col-sm-6">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/french-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">French</p>
	                    </a>
	                </div>
	                <div class="col-md-4 col-sm-6">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/biology-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">Биология</p>
	                    </a>
	                </div>
	                <div class="col-md-4 col-sm-6">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/native-language-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">Родной язык</p>
	                    </a>
	                </div>
	                <div class="col-md-4 col-sm-6">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/history-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">История</p>
	                    </a>
	                </div>
	                <div class="col-md-4 col-sm-6">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/physics-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">Физика</p>
	                    </a>
	                </div>
	                <div class="col-md-4 col-sm-6">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/chemistry-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">Химия</p>
	                    </a>
	                </div>
	                <div class="col-md-4 col-sm-6">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/german-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">Германия</p>
	                    </a>
	                </div>
	                <div class="col-md-4 col-sm-6 col-md-push-4">
	                    <a href="{{ route('cabinet') }}/#/thematic" class="subjects__card">
	                        <img src="{{ asset('assets/images/subjects/russian-profi.svg') }}" class="subjects__card-img" alt="math">
	                        <p class="subjects__card-info">Русский язык</p>
	                    </a>
	                </div>
	            </div>  <!-- /.row -->

	        </div>  <!-- /.container -->
	    </section>  <!-- /.subjects -->

		<section class="profi-feedback">
			<div class="container">
				<h3 class="title pb-layout-sm text-center">@lang('profiedu_site.reviews')</h3>
				<div class="row">
					<div class="col-md-7">
						<div class="profi-feedback__map-wrap">
							<div class="jsmaps-wrapper" id="uzbekistan-map"></div>
						</div>
					</div>
					<div class="col-md-5">

						<div class="profi-feedback__slider js-feedback-slider">
							@foreach($reviews as $review)
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset(Upload::getThumbFile('review', $review->id, '300x300')) }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">{{ $review->name }}</p>
											<p class="profi-feedback__card-city">{{ $review->region->name_ru }}</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">{{ $review->university->name_ru }}</p>
									<p class="profi-feedback__card-num">{{ $review->ball }}</p>
									<p>{{ $review->comment }}</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							@endforeach
							{{-- <div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Бухарская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Джизакская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Кашкадарьинская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Наманганская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Навоийская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Самаркандская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Сурхандарьинская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Сырдарьинская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Ташкентская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Ферганская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Хорезмская область</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/teacher1.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Республика Каракалпакстан</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div>
							<div>
								<div class="profi-feedback__card">
									<div class="profi-feedback__card-wrap">
										<div class="profi-feedback__card-avatar" 
											style="background-image: url({{ asset('assets/images/student.png') }})">
										</div>
										<div class="profi-feedback__card-info">
											<p class="profi-feedback__card-name">Исматуллаев Шахзод</p>
											<p class="profi-feedback__card-city">Ташкент</p>
										</div>
									</div>	<!-- /.profi-feedback__card-wrap -->
									<p class="profi-feedback__card-uni">ТАШКЕНТСКИЙ ФИНАНСОВЫЙ ИНСТИТУТ</p>
									<p class="profi-feedback__card-num">145,6</p>
									<p>Скажу спасибо Вам, учителя, за все, что дали в жизни мне: за помощь, знания, поддержку</p>
								</div>	<!-- /.profi-feedback__card -->
							</div> --}}
						</div>	<!-- /.profi-feedback-slider -->

						<div class="profi-feedback__slider-arrows">
							<button class="profi-feedback__slider-arrow profi-feedback__slider-arrow--prev js-slider-prev">
								<i class="icon-arrow-full-left"></i>
							</button>
							<button class="profi-feedback__slider-arrow profi-feedback__slider-arrow--next js-slider-next">
								<i class="icon-arrow-full-right"></i>
							</button>
						</div>	<!-- /.profi-feedback__slider-arrows -->

					</div>
				</div>	<!-- /.row -->

			</div>	<!-- /.container -->
		</section>	<!-- /.feedback -->

		<section class="callback callback--profi js-contact-section">
		    <div class="container">
				<p class="title text-center pb-layout-sm">@lang('profiedu_site.address')</p>

		    	<div class="row mb-layout-xs">
		    		<div class="col-md-6">
		    			<div class="callback__contacts">
		    				<img src="{{ asset('assets/images/profi-education/building.svg') }}" alt="contacts" class="callback__contacts-thumb">
		    				<div class="callback__contacts-info">
			    				<p class="pb-xs">
			    					г.Ташкент, ул.А.Навои, 7<br>
			    					(ориентир, бывшие торговые ряды)<br>
				    				@lang('profiedu_site.tel'): 71 249-20-01
				    			</p>
								<a href="https://goo.gl/maps/MoUBrqwAywx" class="profi__link" target="_blank">
									<i class="icon-location-filled text-profi"></i>
									@lang('profiedu_site.show_on_map')
								</a>
							</div>
		    			</div>
		    		</div>
		    		<div class="col-md-6">
		    			<div class="callback__contacts">
		    				<img src="{{ asset('assets/images/profi-education/building.svg') }}" alt="contacts" class="callback__contacts-thumb">
		    				<div class="callback__contacts-info">
			    				<p class="pb-xs">
			    					г.Ташкент, Карасу 1,  дом 18,<br>
			    					(ориентир ресторан ДУНЕ)<br>
			    					@lang('profiedu_site.tel'): 71 266 30 66
			    				</p>
								<a href="https://goo.gl/maps/Geg4ZGtKfH82" class="profi__link" target="_blank">
									<i class="icon-location-filled text-profi"></i>
									@lang('profiedu_site.show_on_map')
								</a>
							</div>
		    			</div>
		    		</div>
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
		                	<div class="text-center">
					            <h2 class="title text-upper pb-md">@lang('callback.left_questions')</h2>
					            <p class="text-lg pb-md mb-lg">{!! __('callback.fill_form') !!}</p>
					        </div>
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
	    
	</section>	<!-- /.profi -->
@endsection

@section('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="{{ asset('assets/js/jsmaps/jsmaps-libs.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/jsmaps/jsmaps.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/jsmaps/uzbekistan.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/slick.min.js') }}" type="text/javascript"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
    	$(document).ready(function() {

    		// feedbacks slider
			var feedbackSlider = $('.js-feedback-slider');
			feedbackSlider.slick({
				arrows: true,
				dots: false,
				fade: true,
				prevArrow: '.js-slider-prev',
				nextArrow: '.js-slider-next',
			});

			// map
    		var uzMap = $('#uzbekistan-map'),
    			regionsList = [{!! $regions->map(function($item){ 
					return "'".$item."'";
				})->implode(', ') !!}];

			uzMap.JSMaps({
				map: 'uzbekistan',
				onReady: function() {
					uzMap.trigger('stateClick', '{{ $regions->first() }}');
				},
				onStateClick: function(data) {
					if (data.name == '{{ $regions->first() }}') {
						feedbackSlider.slick('slickGoTo', 13);
					}
					else {
						feedbackSlider.slick('slickGoTo', parseInt(data.id));
					}
				},
			});

			feedbackSlider.on('beforeChange', function(event, slick, currentSlide, nextSlide){
				uzMap.trigger('stateClick', regionsList[nextSlide]);
			});

		});

		$('.js-to-contact').on('touchend click', function(e) {
			e.preventDefault();
			var dist = $('.js-contact-section').offset().top;
			
			$('html, body').animate({
				scrollTop: dist
			}, 500);
		});

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