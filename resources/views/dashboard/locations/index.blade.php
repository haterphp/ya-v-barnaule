@extends('dashboard.layouts.base')

@section('header')
 <h1 class="h2">Места отдыха</h1>
 <div class="wrap d-flex">
    <a href="{{ route('dashboard.locations.create') }}" class="btn btn-success ml-2">Добавить место отдыха</a>
 </div>
@endsection

@section('content')
    @if(session('alert'))
        @include('components.alert', session('alert'))
    @endif
    <div class="row">
        @foreach($locations as $key => $location)
            <div class="col-md-6 col-xl-4 col-12 mt-3">
                <div class="card">
                    <img src="{{ $location->photos(0) }}" alt="{{ $location->title }}" class="card-image w-100" style="max-height: 200px;object-fit: cover;border-radius: .25rem .25rem 0 0 ;">
                    <div class="card-body position-relative">
                        <div class="dropdown position-absolute" style="right: 1rem; top: 1rem">
                            <button class="btn dropdown-toggle not-arrow" type="button" id="location-dropdown-{{$key}}" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="location-dropdown-{{$key}}">
                                <a class="dropdown-item text-primary" href="{{ route('dashboard.locations.show', ['location' => $location]) }}"><i class="fa fa-eye mr-2"></i> Подробнее</a>
                                <a class="dropdown-item text-primary" href="{{ route('dashboard.locations.edit', ['location' => $location]) }}"><i class="fa fa-pen-alt mr-2"></i> Изменить</a>
                                <form action="{{ route('dashboard.locations.destroy', ['location' => $location]) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="dropdown-item text-danger"><i class="fa fa-trash-alt mr-2"></i> Удалить</button>
                                </form>
                            </div>
                        </div>
                        <h4 class="card-title">{{ $location->title }}</h4>
                        <p class="card-text">Кол-во бронирований: {{ $location->orders->filter(function($item) { return $item->status == 1; })->count() }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('footer')
    {{ $locations->links() }}
@endsection