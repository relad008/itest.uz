@extends('layouts.frontend')

@section('content')
	<section class="profi">

		<div class="profi-content profi-content--sm">

			<div class="container relative z-index-1">
				<div class="profi__nav-wrap">
					<ul class="profi__nav">
						<li class="profi__nav-item">
							<a href="/profieducation-about" class="profi__nav-link">@lang('profiedu_site.about_us')</a>
						</li>
						<li class="profi__nav-item">
							<a href="/profieducation-teachers" class="profi__nav-link">@lang('profiedu_site.teachers')</a>
						</li>
						<li class="profi__nav-item">
							<a href="#" class="profi__nav-link">@lang('profiedu_site.contacts')</a>
						</li>
						<li class="profi__nav-item">
							<a href="#" class="profi__nav-link">@lang('profiedu_site.campaign')</a>
						</li>
					</ul>	<!-- .profi__nav -->
				</div>	<!-- /.profi__nav-wrap -->

				<img src="{{ asset('assets/images/profi-education/logo.png') }}" alt="Profi Education" class="profi__logo">

				<h3 class="title pb-layout-xs py-layout-sm">@lang('profiedu_site.teachers')</h3>
				
				<div class="row mb-lg">
					@foreach([0,1,2,3,4] as $teacher)
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="profile__teacher js-teacher-modal-toggler">
							<div class="profi__teacher-card">
								<div class="profi__teacher-card-avatar js-teacher-source-avatar" style="background-image: url({{ asset('assets/images/teacher1.png') }})"></div>
								<p class="profi__teacher-card-name js-teacher-source-name">Хуршид Тухтаназаров</p>
								<p class="profi__teacher-card-subject js-teacher-source-subject">Английский язык</p>
							</div>
						</div>	<!-- /.profi__teacher -->
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="profile__teacher js-teacher-modal-toggler">
							<div class="profi__teacher-card">
								<div class="profi__teacher-card-avatar js-teacher-source-avatar" style="background-image: url({{ asset('assets/images/teacher2.png') }})"></div>
								<p class="profi__teacher-card-name js-teacher-source-name">Дилдора Хатамова</p>
								<p class="profi__teacher-card-subject js-teacher-source-subject">Английский язык</p>
							</div>
						</div>	<!-- /.profi__teacher -->
					</div>
					@endforeach
				</div>	<!-- /.row -->

			</div>	<!-- /.container -->

			<div class="bg-img-group bg-img-group--profi">
	            <div class="bg-img-group__item profi__bg-img-left1"></div>
	            <div class="bg-img-group__item profi__bg-img-left2"></div>
	        </div>  <!-- /.bg-img-group" -->

		</div>	<!-- /.profi-content.bg-img-group--profi -->

		<div class="modal js-teacher-modal">
			<div class="modal__content profi-modal">
				<button class="modal__dismisser js-teacher-modal-dismisser">
					<i class="icon-cancel"></i>
				</button>
				<div class="profi-modal__wrap">
					<div class="profi-modal__teacher profile__teacher">
						<div class="profi__teacher-card-avatar js-teacher-input-avatar" style="background-image: url({{ asset('assets/images/teacher2.png') }})"></div>
						<p class="profi__teacher-card-name js-teacher-input-name">Дилдора Хатамова</p>
						<p class="profi__teacher-card-subject js-teacher-input-subject">Английский язык</p>
					</div>	<!-- /.profi-modal__wrap-teacher.profi__teacher -->
					<div class="profi-modal__info">
						<p class="profi-modal__info-title">
							<i class="icon-person"></i>
							<span>@lang('profiedu_site.teacher_info')</span>
						</p>
						<p class="pb-xs">Уроженка города Ташкента.</p>
						<p class="lh">
							- 2002-2003 обучалась по программе международного английского языка в Нью-Йорском университете;<br>
							- 2003-2003 повысила квалификацию в Конкордской школе английского языка в Калифорнии;<br>
							- 2006-2010 бакалавр МВУТ;<br>
							- С 2011 года преподаватель «Profi Education» по предмету английский язык;
						</p>
					</div>
				</div>

			</div>
		</div>	<!-- /.modal -->
	    
	</section>	<!-- /.profi -->
@endsection

@section('scripts')
	<script>
		var sourceAva,
			sourceName,
			sourceSubject;

		$('.js-teacher-modal-toggler').on('click', function() {
			var _this = $(this);
			sourceAva = _this.find('.js-teacher-source-avatar').attr('style');
			sourceName = _this.find('.js-teacher-source-name').text();
			sourceSubject = _this.find('.js-teacher-source-subject').text();

			$('.js-teacher-input-avatar').attr('style', sourceAva);
			$('.js-teacher-input-name').text(sourceName);
			$('.js-teacher-input-subject').text(sourceSubject);
		});
	</script>
@endsection