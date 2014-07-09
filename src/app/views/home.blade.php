@extends('layout.main')


@section('content')

    @if(Auth::check())

        <p>Привет, {{Auth::user()->username}}.</p>

        @include('profile.company-list')

    @else

        <h2>вы не зарегистрированы</h2>

    @endif

@stop

