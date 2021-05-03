@extends('app.layouts.app')

@section('title', 'Я в Барнауле - Главная')

@section('content')
    <section class="start-panel panel" style="height: calc( 100vh - 139px) !important">
        <div class="site-container h-100">
            <div class="wrap h-100 d-flex align-items-center">
                <div class="content">
                    <h1>Отдыхай вместе
                        <br>с нами</h1>
                    <p class="text-large">Большой выбор мест для отдыха <br>
                        в Барнауле на любой вкус </p>
                </div>
                <img src="{{ asset('assets/sources/scroll-down.svg') }}" alt="scroll-down" class="scroll-down">
            </div>
        </div>
        <img id="start-image" src="{{ asset('assets/sources/images/start-panel.png') }}" alt="img" style="height: 90%; position: absolute; right: 0; top: 10px;">
    </section>
    <section class="advantages-panel panel">
        <div class="site-container h-100">
            <div class="wrap h-100 d-flex align-items-center justify-content-end">
                <div class="content">
                    <h1 class="mb-4">Почему стоит отдыхать
                        <br>в Барнауле?</h1>
                    <p class="text-large">Барнаул — один из крупнейших и быстро
                        развивающихся городов Сибири. Сюда
                        достаточно легко добраться из любой точки
                        России.</p>
                    <p class="text-large">В Барнауле есть огромное кол-во
                    достопримечательностей и баз отдыха,
                    в которых можно с удовольствие провести
                    время. </p>
                </div>
            </div>
        </div>
        <img id="advantages-image" src="{{ asset('assets/sources/images/advantages-panel.png') }}" alt="img" style="height: 80%; position: absolute; left: 0; top: 10%">
    </section>
    <section class="about-panel panel" id="about" style="margin: 100px 0">
        <div class="site-container h-100">
            <div class="wrap h-100 d-flex flex-column align-items-center justify-content-center">
                <h1 class="mb-4 text-white text-center">Почему стоит отдыхать
                    <br>в Барнауле?</h1>
                <div class="wrap d-flex align-items-center justify-content-between w-100">
                    <div class="content">
                        <p class="text-large text-white">На Алтае есть огромное кол-во мест отдыха
                            и наш сервис призван помочь вам выбрать
                            <br>лучшее из них.</p>
                        <p class="text-large text-white">В приоритете нашей компании стоит ваш комфорт
                            <br>и безопасность.</p>
                    </div>
                    <img id="camping-image" src="{{ asset('assets/sources/camping.svg') }}" alt="camping">
                </div>
            </div>
        </div>
        <img id="about-image" src="{{ asset('assets/sources/images/about-panel.png') }}" alt="about-panel-bg" style="height: 120%; position: absolute; top: -10%; width: 100%; z-index: -1">
    </section>
    <section class="catalog-panel panel">
        <div class="site-container h-100">
            <div class="wrap h-100 d-flex align-items-center">
                <div class="row w-100">
                    <div class="col-12 col-lg-6">
                        <div class="wrap catalog-wrap">
                            <h1>Ищи локации для отдыха
                                <br>вместе с нами</h1>
                            <p class="text-large">Мы постарались и отобрали самые лучшие
                                <br>локации для вашего отдыха</p>
                            <div class="wrap d-flex justify-content-between align-items-center">
                                <a href="{{  route('catalog') }}" class="btn btn-primary btn-lg">Больше локаций</a>
                                <img id="people-image" src="{{ asset('assets/sources/people.svg') }}" style="height: 300px; margin-left: 50px" alt="people">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="wrap d-flex align-items-center justify-content-end h-100">
                            <div class="splide" id="catalog-slider">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        @foreach ($locations as $location)
                                        <li class="splide__slide">
                                            <div class="slide__container h-100 d-flex w-100 align-items-center justify-content-center">
                                                <div class="slide__photo">
                                                    <div class="backdrop">
                                                        <div class="wrap h-100 w-100 d-flex align-items-center justify-content-center flex-column">
                                                            <h4 class="text-white mb-3 text-center">{{ $location->title }}</h4>
                                                            <div class="rate">
                                                                <span class="fa fa-star checked"></span>
                                                                <span class="fa fa-star checked"></span>
                                                                <span class="fa fa-star checked"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                            </div>
                                                            <a class="btn btn-primary mt-3" href="{{ route('catalog.show', ['location' => $location]) }}">Подробнее</a>
                                                        </div>
                                                    </div>
                                                    <img src="{{ $location->photos(0) }}" alt="image">
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach 
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/splide.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('assets/js/splide.min.js') }}"></script>
    <script>
        new Splide('#catalog-slider', {
            rewind: true
        }).mount();
    </script>
@endpush