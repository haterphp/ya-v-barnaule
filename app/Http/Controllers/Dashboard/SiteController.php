<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected function getOrdersCount(){
        $year = Carbon::now()->format('Y');
        $dates = [];

        for ($i = 1; $i <= 12; $i++){
            $begin = "first day of $year-$i";
            $end = "last day of $year-$i";

            $begin = new \DateTime($begin);
            $end = new \DateTime($end);

            $dates[] = [$begin->format('Y-m-d'), $end->format('Y-m-d')];
        }

        $orders_count = [];
        foreach ($dates as $interval){
            $orders_count[] = Order::ordersInInterval($interval)->count();
        }

        return $orders_count;
    }

    public function index()
    {
        $orders_count = $this->getOrdersCount();
        return view('dashboard.index', compact('orders_count'));
    }
}
