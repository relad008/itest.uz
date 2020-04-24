@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Рефералы
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="datatable" class="data-table table table-striped table-condensed table-bordered checkble table-hover">
                    <thead>
                        <tr>
                            <th>Ключ</th>
                            <th>Количество прямых заходов</th>
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
            url: '{{ action("Backend\PageController@referalStatData") }}',
            datatable: {
                columns: [
                    {data: 'from', name: 'from'},
                    {data: 'count', name: 'count'}
                ]
            }
        }
    });

</script>

@endsection
