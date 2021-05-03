@extends('dashboard.layouts.base')

@section('header')
    <h1 class="h2">Добро пожаловать, {{ auth()->user()->name }}</h1>
@endsection

@section('content')
    <canvas id="month-stats" style="width: 100%; height: 300px"></canvas>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.0/chart.min.js" integrity="sha512-VMsZqo0ar06BMtg0tPsdgRADvl0kDHpTbugCBBrL55KmucH6hP9zWdLIWY//OTfMnzz6xWQRxQqsUFefwHuHyg==" crossorigin="anonymous"></script>
    <script>
        const ctx = document.querySelector('#month-stats');
        const orders = @json($orders_count);
        const chart = new Chart(ctx, {
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
    </script>
@endpush