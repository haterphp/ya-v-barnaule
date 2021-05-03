@extends('dashboard.layouts.base')

@section('header')
    <div class="d-flex align-items-center">
        <a class="btn rounded-circle mr-3" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
        <h1 class="h2">Добавить категорию</h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-4 col-md-6">
            <form action="{{ route('dashboard.categories.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" class="form-control @error('title')is-invalid @enderror" name="title">
                    @error('title')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <button class="btn btn-success">Создать</button>
            </form>
        </div>
    </div>
@endsection