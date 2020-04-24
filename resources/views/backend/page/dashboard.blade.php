@extends('layouts.backend')

@section('content')
<div class="box">
    @if ($parents_arr)
    <?php
        array_pop($parents_arr)
    ?>
    <p>
        <a href="{{ route('backend.dashboard', $parents_arr) }}" class="btn btn-default">Назад</a>
    </p>
    @endif
    @if(count($categories))
    <table class="table table-straped table-hover">
        <thead>

            <tr>
                <th>Категория</th>
                <th>С темой связано вопросов ru</th>
                <th>С темой связано вопросов uz</th>
            </tr>
        </thead>
	    @foreach($categories as $cat)
            <tbody>
                <tr>
                    <td>
                    <a href="{{ action('Backend\PageController@dashboard', $cat->getIdsForChild()) }}"><i class="fa fa-folder"></i> {{ $cat->name }}</a>

                    </td>
                    <td>{{ $cat->allQuestionsCount('ru') }}</td>
                    <td>{{ $cat->allQuestionsCount('uz') }}</td>

                </tr>

            </tbody>
	    @endforeach
	  </table>
	@else
        <p>Подкатегорий нет</p>
    @endif
</div>
@endsection