@extends('app.layouts.app')

@section('title', 'Я в Барнауле - Каталог')

@section('content')
    <div class="wrap wrap-catalog">
        <div class="site-container">
            <div class="row mt-3">
                <div class="col-12 col-md-5 col-xl-3">
                    @include('app.components.filter')
                </div>
                <div class="col-12 col-md-7 col-xl-9 mt-5 mt-md-0">
                    <div class="form-group" style="padding-left: 15px">
                        <input type="text" oninput="cloneTitleValue()" onchange="searchByTitle()" value="{{ $filters['title'] }}" placeholder="Название локации" class="form-control" id="input-title" name="title">
                    </div>
                    <h1 class="h2" style="padding-left: 15px">Каталог</h1>
                    <div class="wrap mt-3">
                        <div class="row">
                            @foreach ($locations as $location)
                                <div class="col-12 col-md-6 col-xl-4">
                                    @include('app.components.outline-card', compact('location'))
                                </div>
                            @endforeach
                        </div>
                        @if (!count($locations))
                            <div class="wrap mt-3" style="margin-left: 15px">
                                <h3 class="text-muted">По данному запросу ничего не найдено</h3>
                                <p class="text-muted">Выберете другие параметры и попробуйте снова</p>
                            </div>
                        @endif
                    </div>
                    @include('components.paginate', ['body' => $locations])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .wrap-catalog{
            min-height: 100vh;
            margin-bottom: 30vh;
        }
    </style>
@endpush

@push('js')
    <script>
        const inputTitleClone = document.querySelector('#input-title-clone');

        function cloneTitleValue() {
            inputTitleClone.value = event.target.value;
        }

        function searchByTitle() {
            document.querySelector('.filter-form').submit()
        }
    </script>
@endpush