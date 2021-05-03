@extends('dashboard.layouts.base')

@section('header')
    <h1 class="h2">Добро пожаловать, {{ auth()->user()->name }}</h1>
@endsection

@section('content')
    <canvas id="month-stats" style="width: 100%; height: 300px"></canvas>
    <div class="wrap mt-5">
        <div class="row">
            <div class="col-lg-6 col-12">
                <h3>Популярные локации</h3>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>ID</th>
                            <th class="col">Название</th>
                            <th class="col">Кол-во бронирований</th>
                        </thead>
                        <tbody>
                            @foreach ($locations as $location)
                                <tr>
                                    <td>{{  $location->id }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.locations.show', ['location' => $location]) }}">
                                            {{  $location->title }}
                                        </a>
                                    </td>
                                    <td>{{ $location->ordersInMonth()->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <canvas id="categories-stats" style="width: 100%; height: 300px"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js" integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg==" crossorigin="anonymous"></script>
    <script>
        const orders = @json($orders_count);
        const categories = @json($categories);
        new Chart(document.querySelector('#month-stats'), {
            type: 'line',
            data: {
                labels: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                datasets: [{
                    label: 'Кол-во бронирований в месяц',
                    data: orders,
                    borderColor: [
                        'rgb(255,169,68)'
                    ],
                    backgroundColor: [
                        'rgb(255,169,68)'
                    ],
                    borderWidth: 3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        new Chart(document.querySelector('#categories-stats'), {
            type: 'bar',
            data: {
                labels: categories.labels,
                datasets: [
                {
                    label: 'Категории',
                    data: categories.counts,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    </script>
@endpush