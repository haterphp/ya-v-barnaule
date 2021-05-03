<header class="header">
    <div class="site-container d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/sources/logo.svg') }}" alt="Logo">
            </a>
        </div>
        <label for="toggle-menu" class="btn btn-primary btn-menu"><i class="fa fa-bars text-white"></i></label>
        <input type="checkbox" id="toggle-menu" class="d-none">
        <div class="nav-mobile">
            <nav class="nav">
                <a href="{{ route('home') }}" class="nav-item {{ (request()->is('/')) ? 'active' : '' }}">Главная</a>
                <a href="{{ route('home') }}#about" class="nav-item">О сервисе</a>
                <a href="{{ route('catalog') }}" class="nav-item {{ (request()->is('catalog')) ? 'active' : '' }}">Каталог</a>
            </nav>
            <div class="d-flex login-wrap-mobile">
                @auth()
                    <div class="wrap d-flex align-items-center">
                        <p class="m-0" style="width: 150px">Добро пожаловать,</p>
                        <a href="{{ route('profile.orders') }}" class="btn-link ml-2">{{ auth()->user()->name }}</a>
                    </div>
                @else()
                    <a href="{{ route('auth.create') }}" class="btn btn-primary rounded-circle btn-login desktop"><i class="fa fa-user-alt text-white"></i></a>
                    <a href="{{ route('auth.create') }}" class="btn btn-primary mobile">Войти</a>
                @endauth
            </div>
        </div>
        <nav class="nav nav-desktop">
            <a href="{{ route('home') }}" class="nav-item {{ (request()->is('/')) ? 'active' : '' }}">Главная</a>
                <a href="{{ route('home') }}#about" class="nav-item">О сервисе</a>
                <a href="{{ route('catalog') }}" class="nav-item {{ (request()->is('catalog')) ? 'active' : '' }}">Каталог</a>
        </nav>
        <div style="width: 204px;" class="d-flex justify-content-end login-wrap-desktop">
            @auth()
                <div style="white-space: nowrap;" class="wrap d-flex align-items-center">
                    <p class="m-0">Добро пожаловать,</p>
                    <a href="{{ route('profile.orders') }}" class="btn-link ml-2">{{ auth()->user()->name }}</a>
                </div>
            @else()
                <a href="{{ route('auth.create') }}" class="btn btn-primary rounded-circle btn-login"><i class="fa fa-user-alt text-white"></i></a>
            @endauth
        </div>
    </div>
</header>