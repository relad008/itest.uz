@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    Отзывы
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
                            <th>Фото</th>
                            <th>Имя на русском</th>
                            <th>Отзыв</th>
                            <th>Регион</th>
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
                            {!! Form::label('name_ru', 'Имя (ru)') !!}
                            {!! Form::text('name_ru', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('name_uz', 'Имя (uz)') !!}
                            {!! Form::text('name_uz', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('comment_ru', 'Отзыв (ru)') !!}
                            {!! Form::textarea('comment_ru', null, ["class" => "form-control", 'rows' => 2]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('comment_uz', 'Отзыв (uz)') !!}
                            {!! Form::textarea('comment_uz', null, ["class" => "form-control", 'rows' => 2]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('ball', 'Балл') !!}
                            {!! Form::text('ball', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('region_id', 'Регион') !!}
                            {!! Form::select('region_id', $regions, null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('university_id', 'Категория') !!}
                            {!! Form::select('university_id', $universities, null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('image', 'Фото (1x1)') !!}
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
            url: '{{ action("Backend\ReviewController@form") }}',
        },

        list: {
            url: '{{ action("Backend\ReviewController@data") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'id', name: 'id'},
                    {data: 'name_ru', name: 'name_ru'},
                    {data: 'comment_ru', name: 'comment_ru'},
                    {data: 'region_id', name: 'region_id'},
                ],
                columnDefs: [
                    {
                        targets: 1,
                        data: null,
                        searchable:false, 
                        orderable:false,
                        render: function (row, type, val, meta) {
                            if (val.image) {
                                return '<img src="' + val.image + '" alt="" class="img-thumbnail" style="max-width:80px">'
                            }
                            return '';
                        }
                    },
                    {
                        targets: 4,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return val.region.name_ru || 'deleted';
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
                ]
            }
        },

        remove: {
            url: '{{ action("Backend\ReviewController@delete") }}',
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
