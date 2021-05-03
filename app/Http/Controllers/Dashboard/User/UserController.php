<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role') ?? 1;
        $users = User::query()->where('role_id', $role)->paginate(10);
        return view('dashboard.users.index', compact('users', 'role'));
    }

    public function create(Request $request)
    {
        $role = $request->get('role') ?? 1;
        return view('dashboard.users.create', compact('role')
        );
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ])->validate();

        User::create($request->all());

        return redirect()
            ->route('dashboard.users.index', ['role' => $request->get('role_id')])
            ->with('alert', [
                'status' => 'success',
                'message' => 'Пользователь успешно создан'
            ]);
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->fill($request->only('name', 'email'))->save();
        
        return redirect()
            ->route('dashboard.users.index', ['role' => $user->role_id])
            ->with('alert', [
                'status' => 'success',
                'message' => 'Пользователь успешно изменен'
            ]);
    }

    public function destroy(User $user)
    {
        $user->is_banned = !$user->is_banned;
        $user->save();

        $message = 'Пользователь успшено ' . ($user->is_banned ? 'заблокирован' : 'разблокирован');

        return back()->with('alert', [
           'status' => 'success',
           'message' => $message
        ]);
    }
}
