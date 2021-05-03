@extends('app.layouts.profile')

@section('title', 'Я в Барнауле - Мои бронирования')

@section('profile-content')
    <h1 class="h2" style="margin-left: 15px">Мои бронирования</h1>    
    <div class="row mt-3">
        @foreach ($locations as $location)
            <div class="col-12 col-md-6 col-xl-4 mt-3">
                @include('app.components.outline-card', compact('location'))
            </div>
        @endforeach
        @if (!count($locations))
            <div class="wrap mt-3" style="margin-left: 15px">
                <h3 class="text-muted">Здесь пока ничего нет</h3>
                <p class="text-muted">Но вы можете перейти в <a href="{{ route('catalog') }}" class="btn-link">каталог</a> и <br>забронировать то, что вам понравилось.</p>
            </div>
        @endif
    </div>
@endsection
