<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('app.auth.login');
    }

    public function store(Request $request)
    {
        return User::login($request);
    }

    public function destroy()
    {
        if(Auth::check()){
            Auth::logout();
        }
        return redirect(route('home'));
    }
}
