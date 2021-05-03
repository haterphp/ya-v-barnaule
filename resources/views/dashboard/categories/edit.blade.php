@extends('dashboard.layouts.base')

@section('header')
    <div class="d-flex align-items-center">
        <a class="btn rounded-circle mr-3" href="{{ url()->previous() }}"><i class="fa fa-arrow-left"></i></a>
        <h1 class="h2">Редактирование категории {{ $category->title }}</h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-4 col-md-6">
            <form action="{{ route('dashboard.categories.update', ['category' => $category]) }}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" class="form-control @error('title')is-invalid @enderror" name="title" value="{{ old('title', $category->title) }}">
                    @error('title')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <button class="btn btn-success">Обновить</button>
            </form>
        </div>
    </div>
@endsection