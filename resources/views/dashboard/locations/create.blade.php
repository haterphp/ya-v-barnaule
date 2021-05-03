@extends('dashboard.layouts.base')

@section('header')
    <div class="d-flex align-items-center">
        <a class="btn rounded-circle mr-3" href="{{ url()->previous() }}"><i
                    class="fa fa-arrow-left"></i></a>
        <h1 class="h2">Добавить место отдыха</h1>
    </div>
@endsection

@section('content')
<form action="{{ route('dashboard.locations.store') }}" method="post" id="location-store">
    @csrf
    <div class="row">
        <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Название</label>
                    <input type="text" class="form-control @error('title')is-invalid @enderror" name="title"
                           value="{{ old('title') }}">
                    @error('title')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" cols="10"
                              class="form-control @error('description')is-invalid @enderror"
                              rows="5">{{ old('description') }}</textarea>
                    @error('description')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Цена</label>
                    <input type="text" class="form-control @error('price')is-invalid @enderror" name="price"
                           value="{{ old('price') }}">
                    @error('price')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Категории</label>
                    <div class="wrap d-flex flex-wrap form-categories-wrap">
                        @foreach($categories as $category)
                            <div class="multiple-checkbox-custom">
                                <input type="checkbox" name="categories[]" id="category-checkbox-{{$category->id}}" value="{{ $category->id }}" @if(collect(old('categories'))->contains($category->id))checked @endif>
                                <label for="category-checkbox-{{$category->id}}" class="btn btn-outline-primary">{{ $category->title }}</label>
                            </div>
                        @endforeach
                        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-outline-secondary"><i class="fa fa-plus mr-2"></i> Добавить категорию</a>
                    </div>
                    @error('categories')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Метод оплаты</label>
                    <div class="form-group form-checkbox">
                        <input type="checkbox" name="payment_method[]" value="cash" @if(collect(old("payment_method"))->contains('cash'))checked @endif id="payment-method-cash">
                        <label class="form-checkbox-label" for="payment-method-cash">
                            <span>
                                <i class="fa fa-money-bill-wave fa-lg mr-2 text-success"></i> Наличный расчет
                            </span>
                        </label>
                    </div>
                    <div class="form-group form-checkbox">
                        <input type="checkbox" name="payment_method[]" value="non-cash" id="payment-method-non-cash" @if(collect(old('payment_method'))->contains('non-cash'))checked @endif>
                        <label class="form-checkbox-label" for="payment-method-non-cash">
                            <span>
                                <i class="fa fa-credit-card fa-lg mr-2 text-dark"></i> Безналичный расчет
                            </span>
                        </label>
                    </div>
                    @error('payment_method')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Кол-во персон</label>
                    <input type="number" class="form-control @error('person_count')is-invalid @enderror" name="person_count"
                           value="{{ old('person_count') }}">
                    @error('person_count')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-lg-0 mt-4">
                <h4>Управление фотографиями</h4>
                <div id="photo-preview-container"></div>
                @error('photos')
                    <small class="text-danger">Пожалуйста выберете хотя бы одну фотографию</small>
                @enderror
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <button class="btn btn-success" onclick="document.querySelector('#location-store').submit()">Создать локацию</button>
@endsection

@push('js')
    <script src="{{ asset('assets/js/photo-preview.js') }}"></script>
    <script>
        const photos = @json(old('photos')) || [];
        const $container = document.querySelector('#photo-preview-container');
        const photoModule = new PhotoPreview($container, photos);
    </script>
@endpush