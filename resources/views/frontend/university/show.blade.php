@extends('layouts.frontend')

@section('content')
	<div class="university">
		<div class="container">

			<h2 class="title pb-xs">{{ $univer->name() }}</h2>
			<a href="{{ action('Frontend\UniversityController@list', [
				'city_id' => $univer->city_id
			]) }}" class="link text"><i class="icon-arrow-left text-sm mr-sm"></i>@lang('university.unis_list')</a>

			<div class="university__wrap">
				@if(Upload::hasFile('university', $univer->id))
					{!! Upload::getImage('university', $univer->id, 'university__wrap-thumb') !!}
				@else
					<img src="{{ asset('assets/images/university.jpg') }}" class="university__wrap-thumb" alt="uni">
				@endif
				<div class="university__wrap-inner">
					<div class="pb-xl">
						<div class="university__wrap-item pb-sm">
							<i class="icon-location"></i>
							<span>@lang('university.address'): {{ $univer->address }}</span>
						</div>
						<div class="university__wrap-item">
							<i class="icon-phone"></i>
							<span>@lang('university.tel'): {{ $univer->phone }}</span>
						</div>
					</div>	<!-- /.pb-xl -->
					<div class="university__info">
						<div class="university__info-item">
							<p>@lang('university.dormitory'):</p>
							<p>{{ $univer->hostel ? __('university.have') : __('university.no')}}</p>
						</div>
						<?php
							$ball = $univer->faculties()
										   ->selectRaw('(total_students/(grant_count+contract_count)) as t_s,
												avg_grant_ball,
												avg_contract_ball')
										   ->get();
						?>
						<div class="university__info-item">
							<p>@lang('university.budget'):</p>
							<p>{{ number_format($ball->avg('avg_grant_ball'), 1, '.', '') }}</p>
						</div>
						<div class="university__info-item">
							<p>@lang('university.enter_ball'):</p>
							<p>{{ number_format($ball->avg('avg_contract_ball'), 1, '.', '') }}</p>
						</div>
						<div class="university__info-item">
							<p>@lang('university.people_number'):</p>
							<p>{{ number_format($ball->avg('t_s'), 1, '.', '') }} @lang('university.people_on_place')</p>
						</div>
					</div>	<!-- /.university__info -->
				</div>	<!-- /.university__wrap-inner -->
			</div>	<!-- /.university__wrap -->

			<div class="university__controls">
				<?php
					// TO DO lang
					$languages = [
						'uz' => 'Узбекский',
						'ru' => 'Русский',
						'qr' => 'Kаракалпакский',
						'kg' => 'Киргизский',
						'kz' => 'Казахский',
						'tj' => 'Таджикский'
					];
				?>
				<span class="text text-v-bottom">@lang('university.study_lang'):</span>
				@foreach($faculties as $lang => $fs)
					<a class="btn btn--brand-outline university__controls-btn" href="#tab-{{ $lang }}" data-toggle="tab">{{ $languages[$lang] }}</a>
				@endforeach
			</div>
			@foreach($faculties as $lang => $fs)
			<div class="university__table-wrap tab-pane" id="tab-{{ $lang }}">
				<table class="table university__table">
					<thead class="thead">
					    <tr>
					    	<td>Факультет</td>
					    	<td class="university__table-col-code">Код</td>
					    	<td class="text-center">План <br>приёма	</td>
					    	<td class="text-center">Конкурс</td>
					    	<td class="text-center">Проходной балл</td>
					    	<td class="text-center">Грант</td>
					    </tr>
					</thead>
					<tbody>
						@foreach($fs as $f)
						<?php
							$total_count = $f->grant_count + $f->contract_count;
						?>
							<tr>
								<td>
									<p>{{ $f->name() }}</p>
									<a href="#">
										@if(isset($subjects[$f->subject_1_id]))
											{{ $subjects[$f->subject_1_id] }} /
										@endif
										@if(isset($subjects[$f->subject_2_id]))
											{{ $subjects[$f->subject_2_id] }} /
										@endif
										@if($f->subject_3_id > 0)
											@if(isset($subjects[$f->subject_3_id]))
												{{ $subjects[$f->subject_3_id] }} 
											@endif
										@elseif($f->native_subject > 0)
											Родной язык
										@elseif($f->foreign_subject > 0)
											Иностранный язык
										@endif</a>
								</td>
								<td class="university__table-col-code">{{ $f->code }}</td>
								<td class="university__table-col">
									{{ $total_count }}
									<p class="text-lightgray">
										{{ $f->grant_count }} / {{ $f->contract_count }}
									</p>
								</td>
								<td class="university__table-col">
									{{ $total_count != 0 ? number_format($f->total_students / $total_count, 1) : 0 }}
									<p class="text-lightgray">{{ $f->total_students }}</p>
								</td>
								<td class="university__table-col">
									{{ number_format($f->contract_ball, 1) }}
									<p class="text-lightgray">{{ number_format($f->avg_contract_ball, 1) }}</p>
								</td>
								<td class="university__table-col">
									{{ number_format($f->grant_ball, 1) }}
									<p class="text-lightgray">{{ number_format($f->avg_grant_ball, 1) }}</p>
								</td>
							</tr>
					    @endforeach
					</tbody>
				</table>
			</div>
			@endforeach

		</div>	<!-- /.container -->
	</div>	<!-- /.university -->
		
	<!-- <div class="bg-info py-5">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<img src="{{ asset('assets/images/university.png') }}" style="width: 100%">
				</div>
				<div class="col-md-9 text-white">
					<p class="mb-0"><span class="oi oi-map-marker"></span> Адрес: Яккасарайский район, ул. Юсуфа хос Ходжиба, 31 </p>
					<p class="mb-3"><span class="oi oi-phone"></span> Телефон: +998 71 256 24 36</p>

					<div class="row">
						<div class="col-md-6">
							<p class="mb-2 pb-1">Общежитие</p>
							<p class="mb-2 pb-1">Средний балл для поступления:</p>
							<p class="mb-2 pb-1">Средний балл на бюджет:</p>
							<p class="mb-2 pb-1">Среднее количество людей на место:</p>
						</div>
						<div class="col-md-6">
							<p class="mb-2 pb-1">есть</p>
							<p class="mb-2 pb-1">131.3</p>
							<p class="mb-2 pb-1">116.1</p>
							<p class="mb-2 pb-1">3.5 человек на место</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> -->

	<!-- <div class="container mb-5">
		<ul class="nav nav-pills align-items-center my-3" id="myTab" role="tablist">
			<li>
				Язык обучения:
			</li>
			<li class="nav-item btn-sm">
				<a class="nav-link active" id="ru-tab" data-toggle="tab" href="#ru" role="tab" aria-controls="ru" aria-selected="true">Русский</a>
			</li>
			<li class="nav-item btn-sm">
				<a class="nav-link" id="uzb-tab" data-toggle="tab" href="#uzb" role="tab" aria-controls="uzb" aria-selected="false">Узбекский</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="ru" role="tabpanel" aria-labelledby="ru-tab">
				<table class="table table-striped table-td-v-align-middle">
					<thead class="thead">
					    <tr>
					    	<th scope="col">Факультет</th>
					    	<th scope="col">Код</th>
					    	<th scope="col">План приёма	</th>
					    	<th scope="col">Конкурс</th>
					    	<th scope="col">Проходной балл</th>
					    	<th scope="col">Грант</th>
					    </tr>
					</thead>
					<tbody>
					    <tr>
					    	<td>Искусствоведение: хореография</td>
					    	<td>5150204</td>
					    	<td class="text-center">7 <p class="text-secondary mb-0">2 / 5</p></td>
					    	<td class="text-center">2.1 <p class="text-secondary mb-0">15</p></td>
					    	<td class="text-center">116.9 <p class="text-secondary mb-0">121.8</p></td>
					    	<td class="text-center">137.2 <p class="text-secondary mb-0">142.6</p></td>
					    </tr>
					    <tr>
					    	<td>Хореография (по видам)</td>
					    	<td>5150204</td>
					    	<td class="text-center">7 <p class="text-secondary mb-0">2 / 5</p></td>
					    	<td class="text-center">2.1 <p class="text-secondary mb-0">15</p></td>
					    	<td class="text-center">116.9 <p class="text-secondary mb-0">121.8</p></td>
					    	<td class="text-center">137.2 <p class="text-secondary mb-0">142.6</p></td>
					    </tr>
					</tbody>
				</table>
			</div>
			<div class="tab-pane" id="uzb" role="tabpanel" aria-labelledby="uzb-tab">
				<table class="table table-striped table-td-v-align-middle">
					<thead class="thead">
					    <tr>
					    	<th scope="col">Факультет</th>
					    	<th scope="col">Код</th>
					    	<th scope="col">План приёма	</th>
					    	<th scope="col">Конкурс</th>
					    	<th scope="col">Проходной балл</th>
					    	<th scope="col">Грант</th>
					    </tr>
					</thead>
					<tbody>
					    <tr>
					    	<td>Искусствоведение: хореография</td>
					    	<td>5150204</td>
					    	<td class="text-center">8 <p class="text-secondary mb-0">2 / 5</p></td>
					    	<td class="text-center">2.2 <p class="text-secondary mb-0">15</p></td>
					    	<td class="text-center">117.9 <p class="text-secondary mb-0">131.8</p></td>
					    	<td class="text-center">127.2 <p class="text-secondary mb-0">142.6</p></td>
					    </tr>
					    <tr>
					    	<td>Хореография (по видам)</td>
					    	<td>5150200</td>
					    	<td class="text-center">8 <p class="text-secondary mb-0">2 / 5</p></td>
					    	<td class="text-center">2.2 <p class="text-secondary mb-0">15</p></td>
					    	<td class="text-center">117.9 <p class="text-secondary mb-0">131.8</p></td>
					    	<td class="text-center">127.2 <p class="text-secondary mb-0">142.6</p></td>
					    </tr>
					</tbody>
				</table>
			</div>
		</div>
	</div> -->
@endsection

@section('scripts')
<script>
	$('[data-toggle=tab]').click(function (e) {

		e.preventDefault();
		$('[data-toggle=tab]').not($(this)).removeClass('btn--brand').addClass('btn--brand-outline');
		$(this).removeClass('btn--brand-outline').addClass('btn--brand');

		$('.tab-pane').hide();
		$($(this).attr('href')).show();
		
	});

	$('.tab-pane').hide();
	$('.tab-pane').eq(0).show();
	$('[data-toggle=tab]').eq(0).removeClass('btn--brand-outline').addClass('btn--brand');
	
</script>
@stop