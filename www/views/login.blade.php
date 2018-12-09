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
        <!-- @delete -->
        <div class="text-center">
            <form class="form-signin" method="post" action="/login/">
                <h1 class="h3 mb-3 font-weight-normal">Вход</h1>
                <label for="inputEmail" class="sr-only">E-mail</label>
                <input name="email" type="text" value="{{ $_POST['email'] ?? ''}}" id="inputEmail" class="form-control" placeholder="Валидный E-mail"  autofocus>
                <label for="inputPassword" class="sr-only">Пароль</label>
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Пароль не должен быть пустым">
                <input name="password_confirm" type="password" id="inputPasswordConfirm" class="form-control @if(!$_POST['signup']) hidden @endif" placeholder="Повторите пароль">
                <label class="form-check-label mt-10 mb-10 display-block">
                    <input class="form-check-input" type="checkbox" name="signup" value="1" @if($_POST['signup']) checked @endif> хочу зарегистрироваться
                </label>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
            </form>
        </div>
    @endsection
</div>