@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    Цены
                </div>
                <div class="col-sm-6 text-right">
                    <a href="#" class="btn btn-success btn-add" data-toggle="modal" data-target="#formModal">
                        <i class="fa fa-plus"></i> Добавить
                    </a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="datatable" class="data-table table table-striped table-condensed table-bordered checkble table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Название на русском</th>
                            <th>Название на узбекском</th>
                            <th>Стоимость</th>
                            <th width="50">Дней до окончания</th>
                            <th>Тематический</th>
                            <th>По направлению</th>
                            <th>Чат</th>
                            <th width="90">Редактировать</th>
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
                    <form action="" id="form">
                        {!! Form::hidden('id', null) !!}
                        <div class="form-group">
                            {!! Form::label('name_ru', 'Название (ru)') !!}
                            {!! Form::text('name_ru', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name_uz', 'Название (uz)') !!}
                            {!! Form::text('name_uz', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('price', 'Стоимость') !!}
                            {!! Form::text('price', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('months_count', 'Количество месяцев') !!}
                            {!! Form::text('months_count', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('economy', 'Экономия') !!}
                            {!! Form::text('economy', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            <label class="checkbox checkbox--textless">
                                {!! Form::checkbox('thematic_available', 1, null) !!}
                                <span>Тематический тест</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="checkbox checkbox--textless">
                                {!! Form::checkbox('direction_available', 1, null) !!}
                                <span>Тест по направлению</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="checkbox checkbox--textless">
                                {!! Form::checkbox('has_chat', 1, null) !!}
                                <span>Чат</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="checkbox checkbox--textless">
                                {!! Form::checkbox('disabled', 1, null) !!}
                                <span>Выключено</span>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
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
            url: '{{ action("Backend\PriceController@form") }}',
        },

        list: {
            url: '{{ action("Backend\PriceController@data") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name_ru', name: 'name_ru'},
                    {data: 'name_uz', name: 'name_uz'},
                    {data: 'price', name: 'price'},
                    {data: 'days_to_expired', name: 'days_to_expired'},
                    {data: 'thematic_available', name: 'thematic_available'},
                    {data: 'direction_available', name: 'direction_available'},
                    {data: 'has_chat', name: 'has_chat'}
                ],
                columnDefs: [
                    {
                        targets: 5,
                        data: null,
                        searchable: false,
                        render: function (row, type, val, meta) {
                            return parseInt(val.thematic_available) ? '<i class="fa fa-check text-success"></i> Да' : '<i class="fa fa-times text-danger"></i> Нет';
                        }
                    },
                    {
                        targets: 6,
                        data: null,
                        searchable: false,
                        render: function (row, type, val, meta) {
                            return parseInt(val.direction_available) ? '<i class="fa fa-check text-success"></i> Да' : '<i class="fa fa-times text-danger"></i> Нет';
                        }
                    },
                    {
                        targets: 7,
                        data: null,
                        searchable: false,
                        render: function (row, type, val, meta) {
                            return parseInt(val.has_chat) ? '<i class="fa fa-check text-success"></i> Да' : '<i class="fa fa-times text-danger"></i> Нет';
                        }
                    },
                    {
                        targets: 8,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return crud.makeButton(val, 'btn-primary btn-edit', '<i class="fa fa-pencil"></i>', [
                                ['toggle', 'modal'],
                                ['target', '#formModal']
                            ])
                            +  crud.makeButton(val, 'btn-danger', '<i class="fa fa-trash"></i>', [
                                    ['toggle', 'modal'],
                                    ['target', '#removeModal']
                                ]);
                        }
                    }
                ],
                rowCallback: function(row, data, index) {
                    if (parseInt(data.disabled)) {
                        $(row).find('td:eq(0)').addClass('bg-danger');
                    }
                }
            }
        },

        remove: {
            url: '{{ action("Backend\PriceController@delete") }}',
        }
    });

</script>

@endsection
