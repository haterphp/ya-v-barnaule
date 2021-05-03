@extends('dashboard.layouts.base')

@section('header')
    <div class="d-flex align-items-center">
        <a class="btn rounded-circle mr-3" href="{{ url()->previous() }}"><i
                class="fa fa-arrow-left"></i></a>
        <h1 class="h2">Добавление пользователя: {{ roleName($role) }}</h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-4 col-md-6">
            <form action="{{ route('dashboard.users.store') }}" method="post">
                @csrf
                <input type="hidden" value="{{ $role }}" name="role_id">
                <div class="form-group">
                    <label>ФИО</label>
                    <input type="text" class="form-control @error('name')is-invalid @enderror" name="name" value="{{ old('name') }}">
                    @error('name')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Номер телефона</label>
                    <input type="text" class="form-phone form-control @error('phone')is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Почта</label>
                    <input type="text" class="form-control @error('email')is-invalid @enderror" name="email" value="{{ old('email') }}">
                    @error('email')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" class="form-control @error('password')is-invalid @enderror" name="password" value="{{ old('password') }}">
                    @error('password')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <button class="btn btn-success">Создать</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/jquery.mask.js') }}"></script>
    <script>
        $('.form-phone').mask('9-(999)-999-9999');
    </script>
@endpush
