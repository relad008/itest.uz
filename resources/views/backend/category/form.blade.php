@extends('layouts.backend')

@section('content')
    <div class="box">
        <form action="" class="form">
            <div class="form-group">
                <label for="i1">Название категории ru</label>
                <input type="text" class="form-control" id="i1" ng-model="data.name_ru" placeholder="Название категории  ru">
            </div>
            <div class="form-group">
                <label for="i1">Название категории uz</label>
                <input type="text" class="form-control" id="i1" ng-model="data.name_uz" placeholder="Название категории  uz">
            </div>
            <div class="form-group">
                <label for="i2">Количество вопросов из этой категории от</label>
                <input type="text" class="form-control" id="i2" ng-model="data.from" placeholder="Количество вопросов из этой категории от">
            </div>
   
            <div class="form-group">
                <label for="i3">Количество вопросов из этой категории до</label>
                <input type="text" class="form-control" id="i3" ng-model="data.to" placeholder="Количество вопросов из этой категории до">
            </div>
   
            {{-- <div ng-if="data.depth==0"> --}}
            @if(1)
                <div class="form-group" >
                    <label for="i4">Тип предмета</label>
                    <select ng-model="data.subject_type"  class="form-control">
                        <option value="-">---</option>
                        <option value="foreign">Иностранный язык</option>
                        <option value="native">Родной язык</option>
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="i5">Язык предмета (для родного языка)</label>
                    <input type="text" class="form-control" id="i5" ng-model="data.subject_lang" placeholder="Язык предмета (для родного языка)">
                </div>
            @endif
   
            <div class="checkbox">
                <label for="text"><input type="checkbox" ng-model="data.need_text"  id="text" > Возможно связать текст</label>
            </div>

            <div class="alert alert-info" ng-if="message">@{{message}}</div>
            <div class="alert alert-danger" ng-if="error">@{{error}}</div>
            <button class="btn btn-success" ng-click="save()">Сохранить</button>
            <a class="btn btn-warning" href="{{ action('Backend\CategoryController@form', $parent_id) }}">Добавить еще</a>
            <a href="{{ action('Backend\CategoryController@index', $parent_id) }}" class="btn btn-primary">Назад</a>
        </form>
    </div>
@endsection