@if(!empty($breadcrumbs))
<ol class="breadcrumb">
	@foreach($breadcrumbs['links'] as $link=>$title)
	  <li><a href="{{$link}}">{{$title}}</a></li>
    @endforeach
	<li class="active">{{$breadcrumbs['active']}}</li>
</ol>
@endif