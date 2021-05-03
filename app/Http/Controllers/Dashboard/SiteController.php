<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Order;
use Carbon\Carbon;
use DateTime;
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

    protected function getPopularLocations($count = 10){

        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        $begin = (new DateTime("first day of $year-$month"))->format('Y-m-d');
        $end = (new DateTime("last day of $year-$month"))->format('Y-m-d');

        $orders = Order::where('started_at', '>=', $begin)->where('started_at' , '<=', $end)->groupBy('location_id')->get()->map->location;
        return $orders->sortByDesc(function($item){
            return $item->ordersInMonth()->count();
        })->slice(0, $count);
    }

    protected function getPopularCategroies($count = 5){
        $labels = [];
        $counts = [];

        Category::all()
                ->sortByDesc(function($item) {
                    return $item->locations->count();
                })
                ->slice(0, $count)
                ->each(function($item) use (&$labels, &$counts){
                    $labels[] = $item['title'];
                    $counts[] = $item->locations->count();
                });

        return compact('labels', 'counts');
    }

    public function index()
    {
        $orders_count = $this->getOrdersCount();
        $locations = $this->getPopularLocations();
        $categories = $this->getPopularCategroies();
        return view('dashboard.index', compact('orders_count', 'locations', 'categories'));
    }
}
