@extends('dashboard.layouts.base')

@section('header')
    <h1 class="h2">Категории</h1>
    <div class="wrap d-flex">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-success ml-2">Добавить категорию</a>
    </div>
@endsection

@section('content')
    @if(session('alert'))
        @include('components.alert', session('alert'))
    @endif
    <div class="row">
        @foreach($categories as $key => $category)
            <div class="col-sm-6 col-md-4 col-lg-2 col-12 mt-3">
                <div class="card">
                    <div class="card-body position-relative">
                        <div class="dropdown position-absolute" style="right: 0; top: 0">
                            <button class="btn dropdown-toggle not-arrow" type="button" id="category-dropdown-{{$key}}" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="category-dropdown-{{$key}}">
                                <a class="dropdown-item text-primary" href="{{ route('dashboard.categories.edit', ['category' => $category]) }}"><i class="fa fa-pen-alt mr-2"></i> Изменить</a>
                                <form action="{{ route('dashboard.categories.destroy', ['category' => $category]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item text-danger"><i class="fa fa-trash-alt mr-2"></i> Удалить</button>
                                </form>
                            </div>
                        </div>
                        <h4 class="card-title">{{ $category->title }}</h4>
                        <p class="card-text">Кол-во локаций: {{ $category->locations->count() }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('footer')
    {{ $categories->links() }}
@endsection