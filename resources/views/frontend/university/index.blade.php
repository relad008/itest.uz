@extends('layouts.frontend')

@section('content')
	<div class="university bg-white pt-layout-sm">

		<div class="container relative z-index-1">
			<div class="text-center pb-layout-xs mb-lg">
				<h2 class="title mb-xl">@lang('university.choose_uni')</h2>
				<p class="text-lg text-blured">@lang('university.info')</p>
			</div>

			<div class="university__card">
				<form action="{{ action('Frontend\UniversityController@list') }}" method="GET">
					<div class="form-group form-group--select">
						<select name="city_id" class="input">
							@foreach($cities as $city)
							<option value="{{ $city->id }}">{{ $city->name() }}</option>
							@endforeach
						</select>
					
						<label class="label open">@lang('university.choose_city')</label>
					</div>
					<button type="submit" class="btn btn--brand">@lang('university.next')</button>
				</form>
			</div>	<!-- /.university__card -->

			<div class="row">
				<div class="col-md-3 col-sm-6">
					<div class="university__advantages">
						<img src="{{ asset('assets/images/university/university.svg') }}" alt="university">
						<p class="font-medium text-lg pt-lg pb-md">{{ $univers_count }} @lang('university.stats.title_1')</p>
						<p class="text">@lang('university.stats.info_1')</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="university__advantages">
						<img src="{{ asset('assets/images/university/cities.svg') }}" alt="cities">
						<p class="font-medium text-lg pt-lg pb-md">{{ $cities->count() }} @lang('university.stats.title_2')</p>
						<p class="text">@lang('university.stats.info_2')</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="university__advantages">
						<img src="{{ asset('assets/images/university/direction.svg') }}" alt="direction">
						<p class="font-medium text-lg pt-lg pb-md">@lang('university.stats.title_3')</p>
						<p class="text">@lang('university.stats.info_3')</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="university__advantages">
						<img src="{{ asset('assets/images/university/bars.svg') }}" alt="bars">
						<p class="font-medium text-lg pt-lg pb-md">@lang('university.stats.title_4')</p>
						<p class="text">@lang('university.stats.info_4')</p>
					</div>
				</div>
			</div>
		</div>	<!-- /.container -->

		<div class="bg-img-group">
            <div class="bg-img-group__item main__bg-img-left1"></div>
            <div class="bg-img-group__item main__bg-img-left2"></div>
            <div class="bg-img-group__item main__bg-img-right"></div>
        </div>  <!-- /.bg-img-group" -->

	</div>		<!-- /.university -->
@endsection