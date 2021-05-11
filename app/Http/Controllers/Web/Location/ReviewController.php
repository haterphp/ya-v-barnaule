<?php

namespace App\Http\Controllers\Web\Location;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        Validator::make($request->all(), [
            'content' => 'required',
            'rate' => 'required'
        ], [
            'required.content' => "Поле Комментарий обязательно для заполнения.",
            'required.rate' => "Пожалуйста укажите рейтинг",
        ])->validate();

        $order->reviews()->create($request->all()+['user_id' => Auth::id()]);

        return redirect()->route('catalog.show', ['location' => $order->location])
            ->with('alert', [
                'status' => 'success',
                'message' => 'Отзыв успешно оставлен'
            ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('alert', [
                'status' => 'success',
                'message' => 'Отзыв успешно удален'
            ]);
    }
}
