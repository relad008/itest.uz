@extends('layouts.frontend')

@section('content')
	<div class="university">
		<div class="container">

			<h2 class="title">@lang('university.unis')</h2>
			<p class="text mb-xl text-blured">@lang('university.choose_cities')</p>

			<div class="row">
				<div class="col-md-3 col-sm-4 mb-xl">
					<div class="university__list university__list--nav">
						@foreach($cities as $city)
						<a href="{{ action('Frontend\UniversityController@list', [
							'city_id' => $city->id
						]) }}" class="university__list-link{{ request()->input('city_id', 0) == $city->id ? ' active' : '' }}">{{ $city->name() }}</a>
						@endforeach
					</div>	<!-- /.university__list -->
				</div>
				<div class="col-md-9 col-sm-8">
					<div class="form-group form-group--search mb-xl">
						<input type="text" class="input input--no-inner-box-shadow" placeholder="Поиск по ВУЗам">
					</div>
					<div class="university__list">
						@foreach($univers as $univer)
							<a href="{{ action('Frontend\UniversityController@show', $univer->id) }}" class="university__list-link">{{ $univer->name() }}</a>
						@endforeach
					</div>	<!-- /.university__list -->
				</div>
			</div>	<!-- /.row -->
			
		</div>	<!-- /.container -->
	</div>	<!-- /.university -->
@endsection