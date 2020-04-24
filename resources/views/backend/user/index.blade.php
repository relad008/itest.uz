@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    Сотрудники
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
                            <th>Email</th>
                            <th>Имя</th>
                            <th>Роль</th>
                            <th>Направление учителя</th>
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
                            {!! Form::label('name', 'Имя') !!}
                            {!! Form::text('name', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::text('email', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', 'Пароль') !!}
                            {!! Form::password('password', ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('role', 'Роль') !!}
                            {!! Form::select('role', $roles, null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('category_id', 'Направление учителя') !!}
                            {!! Form::select('category_id', $categories, null, ["class" => "form-control"]) !!}
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
    var roles = {!! json_encode($roles) !!};
    var auth = {
        id: {{ auth()->user()->id }},
        isMainTeacher: {{ auth()->user()->hasRole(['main_teacher']) ? 1 : 0 }}
    };
    var crud = new Crud({
        form: {
            url: '{{ action("Backend\UserController@form") }}',
        },

        list: {
            url: '{{ action("Backend\UserController@userData") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'email', name: 'email'},
                    {data: 'name', name: 'name'},
                    {data: 'role', name: 'role'},
                    {data: 'category_id', name: 'category_id'}
                ],
                columnDefs: [
                    {
                        targets: 3,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return roles[val.role];
                        }
                    },
                    {
                        targets: 4,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return val.category_name;
                        }
                    },
                    {
                        targets: 5,
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
                    if (auth.isMainTeacher && auth.id != data.creator_id) {
                        $(row).find('td:eq(5)').addClass('bg-danger').html('<small>У вас нет разрешения на редактирование</small>');
                    }
                }
            }
        },

        remove: {
            url: '{{ action("Backend\UserController@delete") }}',
        }
    });

</script>

@endsection
