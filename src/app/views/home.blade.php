@extends('layout.main')


@section('js')
    @if(Auth::check())
    <script src="/content/js/app.js"></script>
    <script src="/content/js/controller.js"></script>
    @endif
@stop



@section('content')

    @if(Auth::check())

        <p>Привет, <b>{{Auth::user()->username}}</a>.</p>

        <div ng-view></div>

    @else

        <h2>вы не зарегистрированы</h2>

    @endif

@stop

