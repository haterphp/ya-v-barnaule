@extends('app.layouts.auth')

@section('title', 'Я в Барнауле - Регистрация')

@section('content')
    <h2>Регистрация</h2>
    <form action="{{ route('user.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label>ФИО</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Введите ФИО"
                   name="name" value="{{ old('name') }}">
            @error('name')
            <small class="invalid-feedback text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Номер телефона</label>
            <input type="text" class="form-phone form-control @error('phone') is-invalid @enderror" placeholder="Введите номер телефона"
                   name="phone" value="{{ old('phone') }}">
            @error('phone')
            <small class="invalid-feedback text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Почта</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Введите почту"
                   name="email" value="{{ old('email') }}">
            @error('email')
            <small class="invalid-feedback text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Введите пароль" name="password" value="{{ old('password') }}">
            @error('password')
            <small class="invalid-feedback text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="d-flex align-items-center flex-wrap">
            <button class="btn btn-primary text-white mr-3 mt-2 mb-2">Создать аккаунт</button>
            <a href="{{ route('auth.create') }}" class="btn-link">Войти в аккаунт</a>
        </div>
    </form>
@endsection

@push('js')
    <script src="{{ asset('assets/js/jquery.mask.js') }}"></script>
    <script>
        $('.form-phone').mask('9-(999)-999-9999');
    </script>
@endpush