@extends('dashboard.layouts.base')

@section('header')
    <div class="d-flex align-items-center">
        <a class="btn rounded-circle mr-3" href="{{ url()->previous() }}"><i
                class="fa fa-arrow-left"></i></a>
        <h1 class="h2">Редактирование пользователя: {{ $user->name }}</h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-4 col-md-6">
            <form action="{{ route('dashboard.users.update', ['user' => $user]) }}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label>ФИО</label>
                    <input type="text" class="form-control @error('name')is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}">
                    @error('name')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Почта</label>
                    <input type="text" class="form-control @error('email')is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}">
                    @error('email')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <button class="btn btn-success">Редактировать</button>
            </form>
        </div>
    </div>
@endsection
