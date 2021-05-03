<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create()
    {
        return view('app.auth.signup');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ], $this->validation_responses)->validate();

        $user = User::create($request->all()+['role_id' => 2]);

        if ($user) {
            return User::login($request);
        }

        return back()->with('alert', [
            'status' => 'danger',
            'message' => 'Ошибка при создании пользователя'
        ]);
    }
}
