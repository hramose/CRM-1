@extends('layout.main')

@section('content')

{{ Form::open(array('url' => URL::route('account-sign-in-post'), 'class'=>'form-signin')) }}
    <h1 class="form-signin-heading text-muted">Авторизация</h1>

    {{ Form::email('email', '', array('placeholder'=>'example@gmail.com', 'class'=>'form-control', 'required'=>'', 'autofocus'=>'')) }}
    @if($errors->has('email'))
        {{ $errors->first('email') }}
    @endif

    {{ Form::password('password', array('placeholder'=>'password', 'class'=>'form-control', 'required'=>'')) }}
    @if($errors->has('password'))
        {{ $errors->first('password') }}
    @endif

    {{ Form::submit('Авторизоваться', array('class'=>'btn btn-lg btn-primary btn-block')) }}

{{ Form::close() }}


@stop