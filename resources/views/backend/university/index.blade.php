@extends('layouts.backend')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
      <div class="row">
        <div class="col-sm-8">
            ВУЗы
        </div>
        <div class="col-sm-4 text-center">
            <a href="#" class="btn btn-success btn-add pull-right" data-toggle="modal" data-target="#formModal">Добавить</a>
        </div>
      </div>
    </div>
   
    <div class="panel-body">
        <div class="table-responsive">
            <table id="datatable" class="data-table table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Фото</th>
                        <th>Название</th>
                        <th>Город</th>
                        <th>Oбщежитие</th>
                        <th>Иностранный</th>
                        <th width="200"></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Добавить</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach(Config::get('app.available_language') as $i=>$v)
                        <li role="presentation" @if($i==0)class="active" @endif><a href="#{{$v}}" aria-controls="{{$v}}"
                        role="tab" data-toggle="tab"
                        style="text-transform: uppercase">{{$v}}</a>
                        </li>
                    @endforeach    
                </ul>
                <form action="" id="form">
                    {!! Form::hidden('id', null) !!}
                    <div class="tab-content">
                        @foreach(Config::get('app.available_language') as $i=>$v)
                        <div role="tabpanel" class="tab-pane fade in @if($i==0) active @endif" id="{{$v}}">
                            <div class="form-group">
                                {!! Form::label('name', 'Название') !!}
                                {!! Form::text('name_'.$v, null, ["class" => "form-control"]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('subtitle', 'Подзаголовок') !!}
                                {!! Form::text('subtitle_'.$v, null, ["class" => "form-control"]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('address', 'Адрес') !!}
                                {!! Form::text('address_'.$v, null, ["class" => "form-control"]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('about', 'О ВУЗе') !!}
                                {!! Form::textarea('about_'.$v, null, ['class' => 'form-control']) !!}
                            </div>
                        </div>  
                        @endforeach  
                    </div>
                    <div class="form-group">
                        {!! Form::label('phone', 'Телефон') !!}
                        {!! Form::text('phone', null, ["class" => "form-control"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('city_id', 'Город*') !!}
                        {!! Form::select('city_id', $list, null, ["class" => "form-control"]) !!}
                    </div>
                    
                    <div class="form-group">
                        <label class="checkbox checkbox--textless">
                            {!! Form::checkbox('hostel', 1, null) !!}
                            <span>Oбщежитие</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox checkbox--textless">
                            {!! Form::checkbox('foreign', 1, null) !!}
                            <span>Иностранный ВУЗ</span>
                        </label>
                    </div>

                    <div class="form-group">
                        {!! Form::label('image', 'Фото') !!}
                        {!! Form::file('slider_ru', null, ['class' => 'form-control']) !!}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="progress js-progress-bar hide">
                    <div class="progress-bar"></div>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                <button type="submit" class="btn btn-primary ajax-form">Сохранить</button>
            </div>
        </div>
    </div>
</div>
  
@endsection

@section('scripts')

@include('partials.ajax-delete')
<script src="{{ asset('backend/js/datatables.min.js') }}"></script>
<script src="{{ asset('backend/js/crud.js') }}"></script>
<script>
    var crud = new Crud({
        form: {
            url: '{{ action("Backend\UniversityController@form") }}',
        },

        list: {
            url: '{{ action("Backend\UniversityController@data") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'id', name: 'id'},
                    {data: 'name_ru', name: 'name_ru'},
                    {data: 'city_name', name: 'city_id'},
                    {data: 'hostel', name: 'hostel'},
                    {data: 'foreign', name: 'foreign'}
                ],
                columnDefs: [
                    {
                        targets: 1,
                        data: null,
                        orderable:false,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            if (val.img) {
                                return '<img src="' + val.img + '" alt="' + val.id + '" class="img-thumbnail" style="width:150px;">';
                            } else {
                                return '<div class="img-thumbnail no-image">No image</div>'
                            }
                        }
                    },
                    {
                        targets: 4,
                        data: null,
                        searchable: false,
                        render: function (row, type, val, meta) {
                            return parseInt(val.hostel) ? '<i class="fa fa-check text-success"></i> Да' : '<i class="fa fa-times text-danger"></i> Нет';
                        }
                    },
                    {
                        targets: 5,
                        data: null,
                        searchable: false,
                        render: function (row, type, val, meta) {
                            return parseInt(val.foreign) ? '<i class="fa fa-check text-success"></i> Да' : '<i class="fa fa-times text-danger"></i> Нет';
                        }
                    },
                    {
                        targets: 6,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return '<a href="" class="btn btn-default">Факультеты</a> '
                            + crud.makeButton(val, 'btn-primary btn-edit', '<i class="fa fa-pencil"></i>', [
                                ['toggle', 'modal'],
                                ['target', '#formModal']
                            ])
                            + crud.makeButton(val, 'btn-danger', '<i class="fa fa-trash"></i>', [
                                ['toggle', 'modal'],
                                ['target', '#removeModal']
                            ]);
                        }
                    }
                ]
            }
        },

        remove: {
            url: '{{ action("Backend\UniversityController@delete") }}',
        }
    });

</script>

@stop