@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    Тикеты
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="datatable" class="data-table table table-striped table-condensed table-bordered checkble table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Тема</th>
                            <th>Автор</th>
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
<script src="{{ asset('backend/js/datatables.min.js') }}"></script>
<script src="{{ asset('backend/js/crud.js') }}"></script>
<script>
    var crud = new Crud({
        list: {
            url: '{{ action("Backend\TicketController@data") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'theme', name: 'theme'},
                    {data: 'user_id', name: 'user_id'},
                ],
                columnDefs: [
                    {
                        targets: 2,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return val.user.name || 'deleted';
                        }
                    },
                    {
                        targets: 3,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return '<a href="{{ url()->current() }}/' + val.id + '/messages" class="btn btn-primary btn-edit">'
                            + '<i class="fa fa-envelope"></i> Сообщения'
                            + '</a>';
                        }
                    }
                ]
            }
        }
    });

</script>

@endsection
