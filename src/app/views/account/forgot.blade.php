@extends('layout.main')

@section('content')

{{ Form::open( array('url' => URL::route('account-forgot-password-post'), 'class'=>'col-xs-6 col-sm-3')) }}

    <div class="form-group">
        {{ Form::label('email', 'Укажите свой email') }}
        {{ Form::email('email', '', array('placeholder'=>'example@gmail.com', 'class'=>'form-control'))}}
        {{ error_for('email', $errors) }}
    </div>

    {{ Form::submit('Восстановить пароль', array('class'=>'btn btn-primary')) }}
{{ Form::close() }}

@stop