@extends('layouts.frontend')

@section('content')
	<div class="video">
		<div class="container">
			<div class="row">
				
				<div class="col-md-9">
					<div class="rounded o-hidden">
						<iframe class="video__frame" src="{{ $video->url }}" frameborder="0" allowfullscreen></iframe>
					</div>
					<h3 class="video__title">{{ $video->name }}</h3>
					<div class="video__category">
						<span>@lang('video.category'):</span>
						<a href="#" class="video__category-item">Русский язык</a>
					</div>
					<div class="video__tags">
						<span class="text-lg">@lang('video.tags'):</span>
						<a href="#" class="video__tags-item">русский язык</a>
						<a href="#" class="video__tags-item">сша</a>
						<a href="#" class="video__tags-item">грамматика</a>
						<a href="#" class="video__tags-item">легкий</a>
					</div>
					<p class="text text-lightgray mb-lg pb-xs">@lang('video.published'): {{ $video->created_at }}</p>
					<p class="video__info">{{ $video->description }}</p>
				</div>	<!-- /.col-md-8 -->

				<div class="col-md-3">
					@foreach($relatives as $item)
					<div class="video__card">
						<a href="{{ route('video.show', $item->id) }}" class="video__card-img" style="background-image: url({{ asset(Upload::getFile('video-image', $item->id)) }})"></a>
						<div class="video__card-wrap">
							<a href="{{ route('video.show', $item->id) }}" class="video__card-title">{{ $item->title }}</a>
							<a href="#" class="video__card-category">Русский язык</a>
						</div>
					</div>	<!-- /.video__card -->
					@endforeach
				</div>	<!-- /.col-md-4 -->

			</div>	<!-- /.row -->
		</div>	<!-- /.container -->
	</div>
@endsection