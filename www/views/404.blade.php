@extends('layout')
<div class="login">
    @section('content')
        @if($errors)
            <p class="alert alert-danger">
                @foreach($errors as $e)
                    {{$e}}<br />
                @endforeach
            </p>
        @endif
        <h1>Ошибка 404</h1>
        <p>К сожалению, запрашиваемой Вами страницы не существует на сайте.</p>
        <a href="/">&laquo; на главную</a>
    @endsection
</div>