@extends('layouts.backend')

@section('content')
    <div class="row">

        <div class="col-md-3 col-sm-6">
            <div class="box">
                <div class="box-icon bg-warning">
                    <i class="fa fa-money"></i>
                </div>
                <div class="box-title">Всего</div>
                <div class="box-content">{{ $total }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="box">
                <div class="box-icon bg-primary">
                    <i class="fa fa-money"></i>
                </div>
                <div class="box-title">Всего по Click</div>
                <div class="box-content">{{ $total_by_service['click'] }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="box">
                <div class="box-icon bg-success">
                    <i class="fa fa-money"></i>
                </div>
                <div class="box-title">Всего по Paynet</div>
                <div class="box-content">{{ $total_by_service['paynet'] }}</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="box">
                <div class="box-icon bg-info">
                    <i class="fa fa-money"></i>
                </div>
                <div class="box-title">Всего по Paycom</div>
                <div class="box-content">{{ $total_by_service['paycom'] }}</div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            Платежи
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="datatable" class="data-table table table-striped table-condensed table-bordered checkble table-hover">
                    <thead>
                        <tr>
                            <tr>
                                <th>#</th>
                                <th>Пользователь</th>
                                <th>Сумма</th>
                                <th>Платежная система</th>
                                <th>Телефон</th>
                                <th>Дата оплаты</th>
                            </tr>
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
            url: '{{ action("Backend\PaymentController@data") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'amount_format', name: 'amount'},
                    {data: 'system', name: 'system'},
                    {data: 'user.phone', name: 'user.phone'},
                    {data: 'created_at', name: 'created_at'}
                ],
                columnDefs: [
                    {
                        targets: 1,
                        data: null,
                        render: function (row, type, val, meta) {
                            return '<a href="#">' + val.user.name + '</a>';
                        }
                    },
                    {
                        targets: 4,
                        data: null,
                        render: function (row, type, val, meta) {
                            return '<a href="tel:+' + val.user.phone + '">' + val.user.phone + '</a>';
                        }
                    }
                ]
            }
        }
    });

</script>

@endsection
