@extends('layout')
@section('content')
    @include('nav')
    <p>
        <br />
        <a class="btn btn-primary" href="/tasks/create/">+ Новая задача</a>
    </p>
    <form class="form-horizontal" method="post" action="/tasks/{{ $task ? $task->id.'/' : '' }}">
        <input type="hidden" value="put" name="_method" />
        @include('partials.form')
    </form>
@endsection