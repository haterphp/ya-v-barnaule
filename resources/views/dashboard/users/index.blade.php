@extends('dashboard.layouts.base')

@section('header')
    <h1 class="h2">Управление пользователями: {{ roleName($role) }}</h1>
    <a href="{{ route('dashboard.users.create', compact('role')) }}" class="btn btn-success">Добавить пользователя</a>
@endsection

@section('content')
    @if(session('alert'))
        @include('components.alert', session('alert'))
    @endif
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ФИО</th>
                <th scope="col">Телефон</th>
                <th scope="col">Почта</th>
                <th scope="col">Статус</th>
                <th scope="col"></th>
            </tr>
        </thead>
            <tbody>
            @foreach($users as $key => $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{!! $user->status() !!}</td>
                    <td>
                        @if((($role == 1 and auth()->id() == 1) or $role == 2) and $user->id !== auth()->id())
                            <div class="dropdown">
                                <button class="btn dropdown-toggle not-arrow" type="button" id="location-dropdown-{{$key}}" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="location-dropdown-{{$key}}">
                                    <a class="dropdown-item text-primary" href="{{ route('dashboard.users.edit', ['user' => $user]) }}"><i class="fa fa-pen-alt mr-2"></i> Изменить</a>
                                    <form action="{{ route('dashboard.users.destroy', ['user' => $user]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        @if($user->is_banned)
                                            <button class="dropdown-item text-success"><i class="fa fa-ban mr-2"></i> Разблокировать</button>
                                        @else
                                            <button class="dropdown-item text-danger"><i class="fa fa-ban mr-2"></i> Заблокировать</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endsection
