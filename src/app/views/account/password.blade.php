@extends('layout.main')


@section('content')

{{ Form::open(array('url'=>URL::route('account-change-password-post'), 'class'=>'col-xs-6 col-sm-3')) }}

    <div class="form-group">
        {{ Form::label('old_password', 'Старый пароль:') }}
        {{ Form::password('old_password', array('class'=>'form-control')) }}
        {{ error_for('old_password', $errors) }}
    </div>

    <div class="form-group">
        {{ Form::label('password', 'Новый пароль:') }}
        {{ Form::password('password', array('class'=>'form-control')) }}
        {{ error_for('password', $errors) }}
    </div>

    <div class="form-group">
        {{ Form::label('password_again', 'Новый пароль:') }}
        {{ Form::password('password_again', array('class'=>'form-control')) }}
        {{ error_for('password_again', $errors) }}
    </div>



    {{ Form::submit('Изменить пароль', array('class'=>'btn btn-primary')) }}
{{ Form::close() }}



@stop