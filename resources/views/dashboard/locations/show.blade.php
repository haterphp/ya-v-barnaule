@extends('dashboard.layouts.base')

@push('css')
<style>
    .image-preview-header {
        margin-top: 215px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 250px;
        width: 100%;
        left: 0;
        z-index: 1;
        position: absolute;
    }

    .image-preview-header::after {
        content: "";
        position: inherit;
        top: 0;
        left: 0;
        z-index: -1;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .preview-content {
        margin-top: 250px;
    }

    #carousel-preview{
        max-height: 250px;
        overflow: hidden;
        border-radius: .25rem;
    }
</style>
@endpush

@section('header')
<div class="image-preview-header" style="background-image: url('{{ $location->photos(0) }}');">
    <div class="wrap pl-5 h-100 d-flex flex-column justify-content-center">
        <h1 class="h2 text-white w-50">{{ $location->title }}</h1>
        <p class="text-white w-75">{{ $location->description }}</p>
    </div>
</div>
@endsection

@section('content')
<div class="wrap preview-content pt-2">
    <div class="row">
        <div class="col-12 col-md-7">
            <h3>{{ $location->title }}</h3>
            <p>{{ $location->description }}</p>
            <p>Категории:
                @foreach($location->categories as $category)
                <span class="badge badge-primary">{{ $category->title }}</span>
                @endforeach
            </p>
            <p>Цена за час: <span class="text-success">{{ $location->price }} ₽</span></p>
            <p>Кол-во персон: <span class="text-primary">{{ $location->person_count }}</span></p>
            <p>Доступные методы оплаты:
                @foreach($location->payment_method as $method)
                <span class="badge badge-success">{{ paymentMethod($method) }}</span>
                @endforeach
            </p>
            <hr>
            <h6 class="text-muted">Бронирования локации</h6>
            <div class="wrap mt-3">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                          <tr>
                            <th scope="col">Код бронирования</th>
                            <th scope="col">Время бронирования</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Почта</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Статус</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($location->orders->sortBy(function($item){
                                return $item->started_at;
                            }) as $key => $order)                    
                                <tr>
                                    <th scope="row">{{ $order->code }}</th>
                                    <td>
                                        с {{ dateFormat($order->started_at, 'Y/m/d H:i') }} 
                                        до {{ dateFormat($order->finished_at, 'Y/m/d H:i') }}
                                    </td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->user->email }}</td>
                                    <td>{{ $order->user->phone ?? '-' }}</td>
                                    <td>{!! orderStatus($order->status, false) !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card" style="position: sticky; top: 75px;">
                <div class="card-body">
                    <h6 class="card-title">Фотографии локации</h6>
                    <div id="carousel-preview" class="carousel slide mt-4" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($location->photos() as $key => $photo)
                                <div class="carousel-item @if($key === 0) active @endif">
                                    <img class="d-block w-100" src="{{ $photo }}"
                                        alt="First slide">
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carousel-preview" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-preview" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
<div class="wrap d-flex">
    <a class="btn btn-primary mr-2" href="{{ route('dashboard.locations.edit', ['location' => $location]) }}"><i
            class="fa fa-pen-alt mr-2"></i> Изменить</a>
    <form action="{{ route('dashboard.locations.destroy', ['location' => $location]) }}" method="post">
        @csrf
        @method('delete')
        <button class="btn btn-danger"><i class="fa fa-trash-alt mr-2"></i> Удалить</button>
    </form>
</div>
@endsection