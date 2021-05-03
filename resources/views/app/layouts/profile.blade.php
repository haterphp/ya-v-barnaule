@extends('app.layouts.app')

@section('content')
    <div class="wrap" style="min-height: 70vh">
        <div class="site-container">
            <div class="row">
                <div class="col-12 col-md-5 col-xl-3">
                    <div class="card" style="position: sticky; top: 35px;">
                        <div class="card-header">
                            <h5 class="mb-0">Личный кабинет</h5>
                        </div>
                        <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                            <a href="{{ route('profile.orders') }}" class="nav-link {{ (request()->is('profile/orders')) ? 'active' : '' }}"><i class="fa fa-clock mr-2"></i> Мои бронирования</a>
                            <a href="{{ route('profile.wish') }}" class="nav-link {{ (request()->is('profile/wish')) ? 'active' : '' }}"><i class="fa fa-heart mr-2"></i> Избранное</a>
                            <a href="{{ route('auth.logout') }}" class="nav-link"><i class="fa fa-sign-out-alt mr-2"></i> Выход</a>   
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7 col-xl-9 mt-5 mt-md-0">
                    <div class="wrap wrap-profile">
                        @yield('profile-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .nav-pills .nav-link{
            cursor: pointer;
        }

        .nav-pills .nav-link:hover, .nav-pills .nav-link.active{
            background: #3F3D56;
            color: #fff !important;
        }

        .nav-pills .nav-link:hover .fa, .nav-pills .nav-link.active .fa{
            color: #fff !important;
        }

        .wrap-profile{
            margin-bottom: 30vh;
        }
    </style>
@endpush