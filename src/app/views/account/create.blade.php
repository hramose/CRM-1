@extends('layout.main')

@section('content')

{{ Form::open(array('url' => URL::route('account-create-post'), 'class'=>'col-xs-6 col-sm-3')) }}
    <hr>
    <div class="form-group">
        {{ Form::label('email', 'Адрес e-mail') }}
        {{ Form::email('email', '', array('placeholder'=>'example@gmail.com', 'class'=>'form-control'))}}
        {{ error_for('email', $errors) }}
    </div>

    <div class="form-group">
        {{ Form::label('username', 'Имя') }}
        {{ Form::text('username', '', array('class'=>'form-control')) }}
        {{ error_for('username', $errors) }}
    </div>

    <div class="form-group">
        {{ Form::label('password', 'Пароль') }}
        {{ Form::password('password', array('class'=>'form-control')) }}
        {{ error_for('password', $errors) }}
    </div>

    <div class="form-group">
        {{ Form::label('password_again', 'Пароль') }}
        {{ Form::password('password_again', array('class'=>'form-control')) }}
        {{ error_for('password_again', $errors) }}
    </div>



    {{ Form::submit('Зарегистрироваться', array('class'=>'btn btn-primary')) }}

{{ Form::close() }}


@stop
