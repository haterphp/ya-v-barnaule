<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request, Location $location)
    {
        Validator::make($request->all(), [
            'started_at' => 'required|date|after:today',
            'finished_at' => 'required|date|after_or_equal:started_at',
        ], [
            'required' => 'Поле обязательно для заполнения',
            'after' => 'Дата бронирования не раньше чем сегодня',
            'after_or_equal' => 'Дата окончания бронирование не должна быть раньше, чем дата начала'
        ])->validate();

        Order::create([
            'user_id' => Auth::id(),
            'location_id' => $location->id,
            'code' => Str::upper(Str::random(10))
        ]+$request->only('started_at', 'finished_at'));

        return redirect()
            ->route('catalog.show', ['location' => $location])
            ->with('alert', [
                'status' => 'success',
                'message' => "Бронирование успешно совершено. 
                Чтобы посмотреть все свои бронирования зайдите в <a class='btn-link' href='" . route('profile.orders') . "'>личный кабинет</a>. 
                Так же наши менеджеры свяжутся с вами по указаной вами электронной почте."
            ]);
    }

    public function index()
    {
        $locations = auth()->user()->orders;
        return view('app.profile.orders', compact('locations'));
    }
}
