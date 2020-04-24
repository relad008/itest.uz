@extends('layouts.backend')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        Вопросы
    </div>
    <div class="panel-body"> 
        <ul class="nav nav-pills">
            <li><a href="{{ action('Backend\QuestionController@index') }}"><i class="fa fa-user"></i> мои вопросы</a></li>
            <li><a href="{{ action('Backend\QuestionController@index', ['all']) }}"><i class="fa fa-random"></i> все вопросы</a></li>
            <li><a href="{{ action('Backend\QuestionController@index', ['not_mine']) }}"><i class="fa fa-briefcase"></i> не мои вопросы</a></li>
            <li><a href="{{ action('Backend\QuestionController@index', ['category']) }}"><i class="fa fa-retweet"></i> по категориям</a></li>
            <li><a href="{{ action('Backend\QuestionController@index', ['duplicate']) }}"><i class="fa fa-copy"></i> Дубли</a></li>
            <li><a href="{{ action('Backend\QuestionController@index', ['duplicate_a']) }}"><i class="fa fa-copy"></i> Дубли ответов</a></li>
        </ul>

        <!-- Categories -->
        @if(count($categories))
            <div class="table-responsive mb-10">
                <table class="table able-striped">
                    <thead>
                        <tr>
                        @if($filter_arr[0]=='category')
                            <th>Категория</th>
                            <th>Связано c подкатегориями</th>
                            <th>Связано c категорией </th>
                        @else
                            <th>Тема</th>
                            <th>Связано c подтемой uz</th>
                            <th>Связано c темой  uz</th>
                            <th>Связано c подтемой ru</th>
                            <th>Связано c темой ru</th>
                        @endif
                        </tr>
                    </thead>
                    @foreach($categories as $cat)
                    <tbody>
                        <tr>
                            <td>
                                <a href="{{action('Backend\QuestionController@index', array_merge($filter_arr, [$cat->id])) }}"><i class="fa fa-folder"></i> {{ $cat->name }}</a>
                            </td>
                            <td>{{ $cat->childQuestionsCount('uz') }}</td>
                            <td>{{ $cat->questionsCount('uz') }}</td>
                            <td>{{ $cat->childQuestionsCount('ru') }}</td>
                            <td>{{ $cat->questionsCount('ru') }}</td>
                        </tr>
                    </tbody>
                    @endforeach


                </table>
            </div>
        @elseif(!empty($filter_arr['0']) && ($filter_arr['0']=='category' || $filter_arr['0']=='theme'))
            <div class="mb-10">
                Подкатегорий нет
            </div>
        @endif
        <!-- End Categories -->
        
        <!-- Question search form -->
        <form action="{{ action('Backend\QuestionController@findQuestion') }}"  method="get" class="mb-20">
            <div class="input-group">
                <input type="text" name="search" class="form-control" value="{{ request()->input('search') }}">
                <div class="input-group-btn">
                    <button class="btn btn-success"><i class="fa fa-search"></i> Найти вопрос</button>
                </div>
            </div>
        </form>
        <!-- End Questions search form -->

        <!-- Question table -->
        <form action="{{ action('Backend\QuestionController@doAction') }}" method="post">
            
            <div class="mb-20">
                <button class="btn btn-default _check_all" type="button">
                    <i class="fa fa-check"></i> выбрать все
                </button>
                <a class="btn btn-info " href="{{action('Backend\QuestionController@edit')}}">
                    <i class="fa fa-plus"></i>Добавить
                </a>
            </div>

            <div class="table-responsive">
                <table class="tabe table-striped table-condensed table-bordered checkble table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Автор</th>
                            <th>Категория</th>
                            {{-- <th>Тема</th> --}}
                            <th>Вопрос</th>
        
                            @foreach(\App\Library\Parser::$answers as $name)
                            <th>{{$name}}</th>
                            @endforeach
                            <th>Редактировать</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $q)
        
                        <tr>
                            <td class="bg-{{$q->lang=='uz'?'warning':'info'}}"><label for="ch_{{$q->id}}">
                            @if($q->creator_id==auth()->user()->id || auth()->user()->hasRole(['main_teacher']))
                                <input type="checkbox" name="ids[]" value="{{$q->id}}">
                            @endif
                            {{$q->id}}</label></td>
                                <td>{{$q->creator->name}}</td>
                            <td>
                                @foreach($q->getParentCategories() as $c)
                            <span class="label label-default label-category">{{$c->name}}</span>
                            @endforeach
                            </td>
                            {{-- <td>
                                @foreach($q->getParentThemes() as $c)
                            <span class="label label-default label-category">{{$c->name}}</span>
                            @endforeach
                            </td> --}}
                            <td>{!!$q->description!!}</td>
                            @foreach(\App\Library\Parser::$answers as $name)
                            <td class="{{$name == $q->correct_answer ? 'bg-success' : ''}}">{!!$q->$name!!}</td>
                            @endforeach
                            <td>
                                <a href="{{action('Backend\QuestionController@edit', ['id' => $q->id])}}?page={{ request()->get('page', 1) }}" class="fa fa-edit"> </a>
                                <a href="{{action('Backend\QuestionController@remove', ['id' => $q->id])}}" class="fa fa-trash"> </a>
                            </td>
                        </tr>
                        @endforeach
                        <tr></tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    {!! $paginate->render() !!}
                </div>
            </div>
            <button class="btn btn-default _check_all" type="button"> <i class="fa fa-check"></i> выбрать все </button>
            

            <div ng-controller="editQuestionC">
                <!-- removing -->
                <div class="form-group">
                <button class="btn btn-danger" type="submit" name="action" value="remove"> <i class="fa fa-remove"></i> Удалить Выбранные</button>
                </div>
                <!-- Category -->
    
                <div class="form-group" ng-repeat="(type,name) in categ_types">
                        <label for="">@{{name}} для  выбранных</label>
                    <button class="btn btn-default " ng-click="selectCategory(type)" type="button" ng-if="!cat_list[type].length">
                    @{{this[type+'_name']}}
                    </button>
                    <input type="hidden" name="@{{type}}_id" value="@{{data[type+'_id']}}">
                        <div class="form-group" ng-repeat="(ind,categories) in cat_list[type]" >
                        <select class="form-control" ng-options=" cat.id as cat.name for cat in categories" ng-model="categs[type][ind]" ng-change="cat_select(type,ind)">
                        </select>
                        </div>
                    <button class="btn btn-warning" type="submit" name="action" value="set_@{{type}}" ng-if="data[type+'_id']"> <i class="fa fa-check"></i>Применить</button>
                </div>
            
                  </div>
                      <!-- TEXTS -->
                      @if(count($texts))
                      <div class="form-inline" >
                          <div class="form-group" >
                            <select class="form-control"  name="text_id" >
                                <option value="0">----</option>
                                @foreach($texts as $el)
                                    <option value="{{$el->id}}">{{$el->name}}</option>
                                @endforeach
                            </select>
                           </div>
                          <div class="form-group">
                              <button class="btn btn-success" type="submit" name="action" value="set_text" >Связать текст</button>
                          </div>
                        </div>
                        @endif
            
            
                </form>

    </div>
</div>    
@endsection