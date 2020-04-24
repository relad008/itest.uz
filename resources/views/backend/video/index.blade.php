@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    Видеоуроки
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
                            <th>Обложка</th>
                            <th>Название на русском</th>
                            <th>Название на узбекском</th>
                            <th>URL</th>
                            <th>Автор</th>
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
                            {!! Form::label('description_ru', 'Описание (ru)') !!}
                            {!! Form::textarea('description_ru', null, ["class" => "form-control", 'rows' => 2]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description_uz', 'Описание (uz)') !!}
                            {!! Form::textarea('description_uz', null, ["class" => "form-control", 'rows' => 2]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('category_id', 'Категория') !!}
                            {!! Form::select('category_id', $categories, null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags', 'Тегы') !!}
                            {!! Form::text('tags', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('url', 'URL') !!}
                            {!! Form::text('url', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('image', 'Обложка (4:3)') !!}
                            {!! Form::file('image', null, ["class" => "form-control"]) !!}
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

@section('styles')
<link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">
@endsection

@section('scripts')
@include('partials.ajax-delete')
<script src="{{ asset('backend/js/select2.min.js') }}"></script>
<script src="{{ asset('backend/js/datatables.min.js') }}"></script>
<script src="{{ asset('backend/js/crud.js') }}"></script>
<script>
    
    var crud = new Crud({
        form: {
            url: '{{ action("Backend\VideoController@form") }}',
        },

        list: {
            url: '{{ action("Backend\VideoController@data") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'id', name: 'id'},
                    {data: 'name_ru', name: 'name_ru'},
                    {data: 'name_uz', name: 'name_uz'},
                    {data: 'url', name: 'url'},
                    {data: 'user_id', name: 'user_id'},
                ],
                columnDefs: [
                    {
                        targets: 1,
                        data: null,
                        searchable:false, 
                        orderable:false,
                        render: function (row, type, val, meta) {
                            if (val.video_image) {
                                return '<img src="' + val.video_image + '" alt="" height="60">'
                            }
                            return '';
                        }
                    },
                    {
                        targets: 5,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return val.user.name || 'deleted';
                        }
                    },
                    {
                        targets: 6,
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
                ]
            }
        },

        remove: {
            url: '{{ action("Backend\VideoController@delete") }}',
        }
    });

    // $('.js-select2').select2();
    // $(document).on('click', '.btn-edit', function() {
    //     var editData = crud.datatable.row($(this).closest("tr")).data();
    //     $('.js-select2').val(editData.category_id.split(','))
    //     $('.js-select2').select2();
    //     // console.log(editData.category_id.split(','));
    // })

</script>

@endsection
