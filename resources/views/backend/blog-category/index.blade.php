@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    Категории
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
                            <th width="90"></th>
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
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('meta_description_ru', 'Meta description (ru)') !!}
                                    {!! Form::textarea('meta_description_ru', null, ["class" => "form-control", "rows" => 2]) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('meta_description_uz', 'Meta description - (uz)') !!}
                                    {!! Form::textarea('meta_description_uz', null, ["class" => "form-control", "rows" => 2]) !!}
                                </div>
                            </div>
                        </div>
                        <p>
                            <small>от 50 до 160 символов</small>
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('meta_keywords_ru', 'Meta keywords (ru)') !!}
                                    {!! Form::textarea('meta_keywords_ru', null, ["class" => "form-control", "rows" => 2]) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('meta_keywords_uz', 'Meta keywords (uz)') !!}
                                    {!! Form::textarea('meta_keywords_uz', null, ["class" => "form-control", "rows" => 2]) !!}
                                </div>
                            </div>
                        </div>
                        <p>
                            <small>не должен превышать 160 символов</small>
                        </p>
                        
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
            url: '{{ action("Backend\BlogCategoryController@form") }}',
        },

        list: {
            url: '{{ action("Backend\BlogCategoryController@data") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name_ru', name: 'name_ru'},
                    {data: 'name_uz', name: 'name_uz'}
                ],
                columnDefs: [
                    {
                        targets: 3,
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
            url: '{{ action("Backend\BlogCategoryController@delete") }}',
        }
    });

</script>

@endsection
