@extends('layouts.backend')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    Студенты
                </div>
                {{-- <div class="col-sm-6 text-right">
                    <a href="#" class="btn btn-success btn-add" data-toggle="modal" data-target="#formModal">
                        <i class="fa fa-plus"></i> Добавить
                    </a>
                </div> --}}
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table id="datatable" class="data-table table table-striped table-condensed table-bordered checkble table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Имя</th>
                            <th>Cчет</th>
                            <th>Пройдено тестов</th>
                            <th width="120"></th>
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
                            {!! Form::label('name', 'ФИО*') !!}
                            {!! Form::text('name', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('phone', 'Телефон') !!}
                            {!! Form::text('phone', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::text('email', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password', 'Пароль (оставить пустым если не хотите изменить)') !!}
                            {!! Form::password('password', ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'Подтверждение') !!}
                            {!! Form::password('password_confirmation', ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('district_id', 'Регион*') !!}
                            {!! Form::select('district_id', $regions->whereIn('parent_id', 0)->pluck('name', 'id'), null, ["class" => "form-control js-district"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('city_id', 'Город*') !!}
                            {!! Form::select('city_id', [], null, ["class" => "form-control js-city"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('birthdate', 'Дата рождения*') !!}
                            {!! Form::text('birthdate', null, ["class" => "form-control js-date"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('address', 'Адрес') !!}
                            {!! Form::text('address', null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('lang', 'Язык обучения') !!}
                            {!! Form::select('lang', array_combine(config('app.available_language'), config('app.available_language')), null, ["class" => "form-control"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('university_id', 'ВУЗ*') !!}
                            {!! Form::select('university_id', $universities, null, ["class" => "form-control js-university"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('faculty_id', 'Факультет*') !!}
                            {!! Form::select('faculty_id', [], null, ["class" => "form-control js-faculty"]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Предметы') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    3.1
                                </span>
                                {!! Form::select('subject_1_id', $subjects, null, ["class" => "form-control"]) !!}
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    2.1
                                </span>
                                {!! Form::select('subject_2_id', $subjects, null, ["class" => "form-control"]) !!}
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    1.1&nbsp;
                                </span>
                                {!! Form::select('subject_3_id', $subjects, null, ["class" => "form-control"]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="checkbox checkbox--textless">
                                {!! Form::checkbox('year_subscribe', 1, null) !!}
                                <span>Годовая подписка</span>
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

@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/css/daterangepicker.css') }}">
@stop

@section('scripts')
@include('partials.ajax-delete')
<script src="{{ asset('backend/js/datatables.min.js') }}"></script>
<script src="{{ asset('backend/js/crud.js') }}"></script>
<script src="{{ asset('backend/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/daterangepicker.js') }}"></script>
<script>
    var auth = {
        id: {{ auth()->user()->id }}
    };

    $(function(){
        uiDate();
    });
    
    var locale = {
        format: 'YYYY-MM-DD',
        "daysOfWeek": [
            "Вс",
            "Пн",
            "Вт",
            "Ср",
            "Чт",
            "Пт",
            "Сб"
        ],

         "monthNames": [
            "Январь",
            "Февраль",
            "Март",
            "Апрель",
            "Май",
            "Июнь",
            "Июль",
            "Август",
            "Сентябрь",
            "Октябрь",
            "Ноябрь",
            "Декабрь"
        ]
    };

    function uiDate(){
        $('.js-date').daterangepicker({
            singleDatePicker: true,
            locale: locale
        });
    }

    var cities = {!! json_encode($regions->whereNotIn('parent_id', 0)->groupBy('parent_id')) !!};
    var faculties = {!! json_encode($faculties) !!};
    var crud = new Crud({
        form: {
            url: '{{ action("Backend\UserController@studentForm") }}',
        },

        list: {
            url: '{{ action("Backend\UserController@studentData") }}',
            datatable: {
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'name', name: 'name'},
                    {data: 'account', name: 'account'},
                    {data: 'total_tests', name: 'total_tests'}
                ],
                columnDefs: [
                    {
                        targets: 6,
                        data: null,
                        searchable:false, 
                        render: function (row, type, val, meta) {
                            return '<a href="#" class="btn btn-info" title="Войти как ' + val.name + '"><i class="fa fa-sign-in"></i></a> '
                            + crud.makeButton(val, 'btn-primary btn-edit', '<i class="fa fa-pencil"></i>', [
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
                    $(row).find('td:eq(4)').addClass((data.year_subscribe != 0 ? 'success' : 'danger') +' text-center');
                }
            }
        },

        remove: {
            url: '{{ action("Backend\UserController@delete") }}',
        }
    });

    var student = {};

    student.faculties = function(){
        var univerId = $('.js-university :selected').val();
        $('.js-faculty').html('<option value=""></option>');
        $.each(faculties[univerId], function(i, item) {
            $('.js-faculty').append('<option value="' + item.id + '">' + item.name + '</option>');
        })
    }

    student.cities = function(){
        var disID = $('.js-district :selected').val();
        $('.js-city').html('<option value=""></option>');
        $.each(cities[disID], function(i, item) {
            $('.js-city').append('<option value="' + item.id + '">' + item.name + '</option>');
        })
    }

    $('.js-university').on('change', function() {
        student.faculties();
    });

    $('.js-district').on('change', function() {
        student.cities();
    });

    $('body').on('click', '.btn-edit', function() {
        student.faculties();
        student.cities();
        var data = crud.datatable.row($(this).closest("tr")).data();
        $('.js-faculty').val(data.faculty_id);
        $('.js-city').val(data.city_id);
        if (data.birthdate) {
            uiDate();
        }
    })

</script>

@endsection
