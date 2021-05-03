@extends('app.layouts.auth')

@section('title', 'Я в Барнауле - Вход')

@section('content')

    <h2>Авторизация</h2>
    <form action="{{ route('auth.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label>Почта</label>
            <input type="text" class="form-control" placeholder="Введите почту" name="email" value="{{ old('email') }}">
            <small class="invalid-feedback text-danger">message</small>
        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" class="form-control" placeholder="Введите пароль" name="password">
            <small class="invalid-feedback text-danger">message</small>
        </div>
        <div class="d-flex align-items-center">
            <button class="btn btn-primary text-white">Войти</button>
            <a href="{{ route('user.create') }}" class="btn btn-link">Регистрация</a>
        </div>
    </form>
@endsection