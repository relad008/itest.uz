@extends('layouts.backend')

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Профиль
            </div>
            <div class="panel-body">        
                {!! Form::open(['files' => true]) !!} 
            
                    <div class="form-group">
                        {!! Form::label('password', 'Пароль') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password_confirmation', 'Подтвердите пароль') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                                                                                                         
                    <div class="form-group">
                        {!! Form::submit('Сохранить', array('class' => 'btn btn-primary')) !!}
                        <a href="{{ route('backend.dashboard') }}" class="btn btn-default">Отменить</a>
                    </div>
                    
                {!! Form::close() !!} 
            </div>
        </div>    
    </div>
</div>
@endsection