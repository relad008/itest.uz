@extends('layouts.frontend')

@section('content')
	<div class="university video">
		<div class="container">

			<h2 class="title">@lang('video.title')</h2>
			<p class="text mb-xl text-blured">@lang('video.by_subjects')</p>

			<div class="row">
				<div class="col-md-3 col-sm-4">
					<div class="university__list university__list--nav mb-xl">
						<a href="{{ action('Frontend\VideoController@index') }}" class="university__list-link">@lang('video.all')</a>
						@foreach($subjects as $subject)
						<a href="{{ action('Frontend\VideoController@index', ['category_id' => $subject->id]) }}" class="university__list-link">{{ $subject->name }}</a>
						@endforeach
					</div>	<!-- /.university__list -->
				</div>
				<div class="col-md-9 col-sm-8">
					<div class="form-group form-group--search mb-xl">
						<input type="text" class="input input--no-inner-box-shadow" placeholder="@lang('video.search_by_subjects')">
					</div>
					<div class="row">
						@forelse($videos as $video)
							<div class="col-md-4">
								<div class="video__card">
									<a href="{{ route('video.show', $video->id) }}" class="video__card-img" style="background-image: url({{ asset(Upload::getFile('video-image', $video->id)) }})"></a>
									<div class="video__card-wrap">
										<a href="{{ route('video.show', $video->id) }}" class="video__card-title">{{ $video->name }}</a>
										<a href="{{ action('Frontend\VideoController@index', ['category_id' => $video->category_id]) }}" class="video__card-category">{{ $video->category->name ?? 'deleted' }}</a>
									</div>
								</div>	<!-- /.video__card -->
							</div>
						@empty
							<div class="no-content">
			                    <img src="{{ asset('assets/images/no-videos.svg') }}" class="no-content__thumb no-content__thumb--video">
			                    <div class="no-content__wrap no-content__wrap--fixed-lg mt-sm">
			                        <p class="mb-md">@lang('video.no_video_info')</p>
			                        <p class="mb-md">{!! __('video.no_video_email') !!}</p>
			                    </div>
			                </div>  <!-- /.no-content -->
						@endforelse
					</div>	<!-- /.row -->
				</div>
			</div>	<!-- /.row -->
			
		</div>	<!-- /.container -->
	</div>	<!-- /.university -->
@endsection