@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            @if(count($price))
                Редактировать
            @else 
                Добавить
            @endif
        </div>
        <div class="panel-body">
            <div class="form" ng-controller="editPriceC">
                <h1></h1> 
                <div class="form-group">
                    <label for="name_ru">Название на русском</label>
                    <input type="text" id="name_ru" ng-model="data.name_ru" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="name_uz">Название на узбекском</label>
                    <input type="text" id="name_uz" ng-model="data.name_uz" class="form-control">
                </div>

                <div class="form-group">
                    <label for="price">Стоимость</label>
                    <input type="text" id="price" ng-model="data.price" class="form-control">
                </div>

                <div class="form-group">
                    <label for="months_count">Количество месяцев</label>
                    <input type="text" id="months_count" ng-model="data.months_count" class="form-control">
                </div>

                <div class="form-group">
                    <label for="economy">Экономия</label>
                    <input type="text" id="economy" ng-model="data.economy" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Доступен тематический тест</label>
                    <div class="radio">
                    <label class="radio-inline">
                        <input type="radio" ng-model="data.thematic_available" name="thematic_available" value="1" class="radio">
                        да
                    </label>
                    <label class="radio-inline">
                        <input type="radio" ng-model="data.thematic_available" name="thematic_available" value="0" class="radio">
                        нет
                    </label>
                    </div>
                
                </div>
                
                <div class="form-group">
                    <label for="">Доступен тест по направлению</label>
                    <div class="radio">
                    <label class="radio-inline">
                        <input type="radio" ng-model="data.direction_available" name="direction_available" value="1" class="radio">
                        да
                    </label>
                    <label class="radio-inline">
                        <input type="radio" ng-model="data.direction_available" name="direction_available" value="0" class="radio">
                        нет
                    </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Доступен чат</label>
                    <div class="radio">
                    <label class="radio-inline">
                        <input type="radio" ng-model="data.has_chat" name="has_chat" value="1" class="radio">
                        да
                    </label>
                    <label class="radio-inline">
                        <input type="radio" ng-model="data.has_chat" name="has_chat" value="0" class="radio">
                        нет
                    </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="">Выключено</label>
                    <div class="radio">
                    <label class="radio-inline">
                        <input type="radio" ng-model="data.disabled" name="disabled" value="1" class="radio">
                        да
                    </label>
                    <label class="radio-inline">
                        <input type="radio" ng-model="data.disabled" name="disabled" value="0" class="radio">
                        нет
                    </label>
                    </div>
                </div>
                
                <button class="btn btn-primary" ng-click="save()">Сохранить</button>
                <a href="#" class="btn btn-default">Отменить</a>
            </div>
        </div>
    </div>
@endsection