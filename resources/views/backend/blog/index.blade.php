@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    Блог - посты
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ action('Backend\BlogController@form') }}" class="btn btn-success">
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
                            <th>Заголовок</th>
                            <th>Язык</th>
                            <th>Дата</th>
                            <th width="90"></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
    

        </div>
    </div>
   
@endsection

@section('scripts')
@include('partials.ajax-delete')
<script src="{{ asset('backend/js/datatables.min.js') }}"></script>
<script src="{{ asset('backend/js/crud.js') }}"></script>
<script>
    var formUrl = "{{ action('Backend\BlogController@form') }}";
    var crud = new Crud({
        list: {
            url: '{{ action("Backend\BlogController@data") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'lang', name: 'lang'},
                    {data: 'created_at', name: 'created_at'}
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
                        targets: 5,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return '<a href="' + formUrl + '/' + val.id + '" class="btn btn-primary btn-edit"><i class="fa fa-pencil"></i></a> '
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
            url: '{{ action("Backend\BlogController@delete") }}',
        }
    });

</script>

@endsection
