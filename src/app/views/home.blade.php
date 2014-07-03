@extends('layout.main')


@section('content')

    @if(Auth::check())

        <p>Привет, {{Auth::user()->username}}.</p>

    @else

        <p>вы не зарегистрированы</p>

    @endif

@stop

