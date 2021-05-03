<div class="sidebar-sticky">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ (request()->is('dashboard')) ? 'active' : '' }}" href="{{ route('dashboard.home') }}">
                <i class="fab fa-accessible-icon feather"></i> Главная <span class="sr-only">(current)</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (request()->is('dashboard/categories*')) ? 'active' : '' }}" href="{{ route('dashboard.categories.index') }}">
                <i class="fa fa-stream feather"></i> Категории
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (request()->is('dashboard/locations*')) ? 'active' : '' }}" href="{{ route('dashboard.locations.index') }}">
                <i class="fas fa-route feather"></i> Места отдыха
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (request()->is('dashboard/users*')) ? 'active' : '' }}" data-toggle="collapse" href="#users-collapse" role="button" aria-expanded="true" aria-controls="users-collapse">
                <i class="fa fa-users feather"></i> Управление пользователями
            </a>
            <div class="collapse show" id="users-collapse">
                <ul class="nav flex-column pl-4">
                    <li class="nav-item">
                        <a class="nav-link sub-link" href="{{ route('dashboard.users.index', ['role' => 1]) }}">Администраторы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sub-link" href="{{ route('dashboard.users.index', ['role' => 2]) }}">Клиенты</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (request()->is('dashboard/orders*')) ? 'active' : '' }}" href="{{ route('dashboard.orders.index') }}">
                <i class="fa fa-shopping-cart feather"></i> Заказы
            </a>
        </li>
    </ul>
</div>
