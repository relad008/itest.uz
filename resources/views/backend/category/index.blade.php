@extends('layouts.backend')

@section('content')

@include('partials.breadcrumb')

    <div class="box">
        <table class="table table-straped table-hover">
            <thead>
                <tr>
                    <th>название ru</th>
                    <th>название uz</th>
                    <th>Показывать внутренние разделы</th>
                    <th>Формула</th>
                    <th width="60">Редактировать</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $c)
                <tr>
                    <td><a href="{{action('Backend\CategoryController@index', ['parent_id' => $c->id])}}">{{$c->name_ru}}</a></td>
                    <td><a href="{{action('Backend\CategoryController@index', ['parent_id' => $c->id])}}">{{$c->name_uz}}</a></td>
                    <td>{{ $c->view_final ? 'Да' : 'Нет' }}</td>
                    <td>{{ $c->from ? $c->from.'-'.$c->to : '' }}</td>
                    <td class="text-center">
                        <a href="{{ action('Backend\CategoryController@form', [
                            'parent_id' => $parent_id,
                            'cat_id' => $c->id
                        ]) }}" class="btn btn-primary">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ action('Backend\CategoryController@delete', [
                            'parent_id' => $parent_id,
                            'cat_id' => $c->id
                        ]) }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <a href="{{action('Backend\CategoryController@getEdit',[$parent_id])}}" class="btn btn-success">Добавить</a> --}}
        
        {!! $categories->render() !!}
    </div>
@endsection