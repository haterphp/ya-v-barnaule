@extends('app.layouts.app')

@section('title', 'Я в Барнауле - ' . $location->title)

@section('content')
<div class="wrap wrap-catalog">
    <div class="site-container">
        <div class="row mt-3">
            <div class="col-12 col-lg-6 pr-5 catalog-slider">
                <div id="primary-slider" class="splide w-100">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($location->photos() as $image)
                                <li class="splide__slide rounded">
                                    <img src="{{ $image }}">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div id="secondary-slider" class="splide mt-4 w-100">
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($location->photos() as $image)
                                <li class="splide__slide rounded">
                                    <img src="{{ $image }}">
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-5 mt-lg-0 d-flex align-items-center">
                <div class="wrap">
                    @if(session('alert'))
                        @include('components.alert', session('alert'))
                    @endif
                    <div class="wrap d-flex justify-content-between align-items-center flex-wrap">
                        <h1 class="h2">{{ $location->title }}</h1>
                        <h2 class="price price-lg">{{ $location->price }} <span class="text-muted">₽ / час</span></h2>
                    </div>
                    <p class="mt-5 text-muted">{{ $location->description }}</p>
                    <p>
                        <b>Вид оплаты: </b>
                        @if ($location->payment_method->contains('cash'))
                            <span class="payment-icons">
                                <i class="fa fa-money-bill-wave fa-lg mr-2 text-success"></i> Наличными
                            </span>
                        @endif
                        @if ($location->payment_method->contains('non-cash'))
                            <span class="payment-icons">
                                <i class="fa fa-credit-card fa-lg mr-2 text-dark"></i> Безналичный расчет
                            </span>
                        @endif
                    </p>
                    <p>
                        <b class="mr-2">Категории:</b>
                        @foreach ($location->categories as $category)
                            <span class="category badge">{{ $category->title }}</span>
                        @endforeach
                    </p>
                    <p>
                        <b class="mr-2">Кол-во человек: </b>
                        <span class="text-muted mr-2">до {{ $location->person_count }} человек</span>
                        <i class="fa fa-user-alt fa-lg text-muted"></i>
                    </p>
                    <div class="d-flex align-items-center">
                        <b class="mr-3">Рейтинг:</b>
                        <div class="rate mt-0 mb-0">
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star checked"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </div>
                    </div>
                    <div class="wrap d-flex mt-4">            
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#booking-modal">Забронировать</button>
                        <form action="{{ route('wish.store', ['location' => $location]) }}" method="post">
                            @csrf
                            <button class="btn btn-light ml-2 d-flex align-items-center justify-content-center">
                                @if (auth()->user() && auth()->user()->wishList->pluck('id')->contains($location->id)) 
                                    <i class="fa fa-heart wish-list-icon active"></i>
                                @else 
                                    <i class="far fa-heart wish-list-icon"></i>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .wrap-catalog{
        margin-bottom: 40vh;
    }

    .price-lg{
        font-size: 50px
    }

    .price > span{
        font-size: 18px
    }

    .payment-icons{
        padding: 10px;
        display: flex;
        align-items: center
    }

    .category{
        padding: 10px !important;
        background: #3F3D56;
        color: #fff !important;
        margin: 5px 0;
    }

    .splide__slide img {
	    width : 100%;
	    height: auto;
    }

    
</style>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/splide.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/splide.min.js') }}"></script>
    <script>
        // Create and mount the thumbnails slider.
        const secondarySlider = new Splide( '#secondary-slider', {
            rewind      : true,
            fixedWidth  : 100,
            fixedHeight : 64,
            isNavigation: true,
            gap         : 10,
            focus       : 'center',
            pagination  : false,
            cover       : true,
            breakpoints : {
                '600': {
                    fixedWidth  : 66,
                    fixedHeight : 40,
                }
            }
        } ).mount();

        // Create the main slider.
        const primarySlider = new Splide( '#primary-slider', {
            type       : 'slide',
            heightRatio: 0.5,
            pagination : false,
            arrows     : false,
            cover      : true,
        } );

        // Set the thumbnails slider as a sync target and then call mount.
        primarySlider.sync( secondarySlider ).mount();
    </script>
    <script>
        const url = new URLSearchParams(location.search);
        const state = url.get('state') || null;
        if(state === 'modal') $('#booking-modal').modal('show');
        $('#booking-modal').on('show.bs.modal', function (e) {
            history.replaceState({state: 'modal'}, null, `?state=modal`)
        })
        $('#booking-modal').on('hidden.bs.modal', function (e) {
            history.replaceState({state: null}, null, '?')

        })
    </script>
@endpush

@push('modals')
  <div class="modal fade" id="booking-modal" tabindex="-1" role="dialog" aria-labelledby="booking-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="booking-modal-label">Бронирование локации {{ $location->title }}</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('order.store', ['location' => $location]) }}" id="booking-form" method="POST">
            @csrf
            @auth
                <p class="text-muted"><i class="fa text-muted fa-user-alt"></i> Клиент: {{ auth()->user()->name }} </p>
                <p class="text-muted"><i class="fas text-muted fa-envelope"></i> Почта: {{ auth()->user()->email }} </p>
            @else
                <p class="text-muted">Чтобы забронировать локацию, пожалуйста <a href="{{ route('auth.create') }}" class="btn-link">войдите</a> в профиль</p>
            @endauth       
            <div class="form-group">
                <label>Время Бронирование</label>
                <div class="row">
                    <div class="col-12 col-md-6 pl-0">
                        <div class="form-group mb-0">
                            <label class="text-muted">Начало</label>
                            <input type="datetime-local" value="{{ old('started_at') }}" class="form-control @error('started_at') is-invalid @enderror" placeholder="С" name="started_at">
                            @error('started_at')
                                <small class="invalid-feedback text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 pl-0">
                        <div class="form-group mb-0 mt-2 mt-md-0">
                            <label class="text-muted">Окончание</label>
                            <input type="datetime-local" value="{{ old('finished_at') }}" class="form-control @error('finished_at') is-invalid @enderror" placeholder="До" name="finished_at">
                            @error('finished_at')
                                <small class="invalid-feedback text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>        
          </form>
        </div>
        <div class="modal-footer d-flex justify-content-between align-items-center">
          <button @guest() disabled @endguest type="button" class="btn btn-primary" 
                    onclick="document.querySelector('#booking-form').submit()">Забронировать</button>
          <h3 class="price">{{ $location->price }} <span class="text-muted">₽ / час</span></h3>
        </div>
      </div>
    </div>
  </div>
@endpush