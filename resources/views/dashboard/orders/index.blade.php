@extends('dashboard.layouts.base')

@section('header')
    <h1 class="h2">Заказы</h1>
@endsection

@section('content')
    <div class="wrap">
        @if(session('alert'))
            @include('components.alert', session('alert'))
        @endif
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Код бронирования</th>
                    <th scope="col">Время бронирования</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Почта</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Локация</th>
                    <th scope="col">Статус</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)                    
                        <tr>
                            <th scope="row">{{ $order->code }}</th>
                            <td>
                                с {{ dateFormat($order->started_at, 'Y/m/d H:i') }} 
                                до {{ dateFormat($order->finished_at, 'Y/m/d H:i') }}
                            </td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->user->email }}</td>
                            <td>{{ $order->user->phone ?? '-' }}</td>
                            <th>
                                <a href="{{ route('dashboard.locations.show', ['location' => $order->location]) }}">
                                    {{ $order->location->title }}
                                </a>
                            </th>
                            <td>{!! orderStatus($order->status, false) !!}</td>
                            <td>
                                @if (!in_array($order->status, ['1', '2']))                              
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle not-arrow" type="button" id="location-dropdown-{{$key}}" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="location-dropdown-{{$key}}">
                                            <form action="{{ route('dashboard.orders.update', ['order' => $order]) }}" method="POST">
                                                @csrf
                                                @method('put')
                                                <button class="dropdown-item text-success" name="approve"><i class="far fa-thumbs-up mr-2"></i> Одобрить</button>
                                                <button class="dropdown-item text-danger" name="decline"><i class="far fa-thumbs-down mr-2"></i> Отказать</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
@endsection

@section('footer')
    {{ $orders->links() }}
@endsection