<?php

namespace App\Http\Controllers\Web\Location;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    protected function rangeFormatter(&$arr)
    {
        $arr = ['min' => $arr[0], 'max' => $arr[1]];
    }

    protected function getFilters(Request $request)
    {
        $price = $request->get('price') ? explode(',', $request->get('price')) : [1000, 10000];
        // $time = $request->get('time') ? explode(',', $request->get('time')) : [8, 23];
        $payment_method = $request->get('payment_method') ?? [];
        $person_count = $request->get('person_count');
        $categories = $request->get('categories') ?? [];

        $this->rangeFormatter($price);
        // $this->rangeFormatter($time);
        return compact('price', 'payment_method', 'person_count', 'categories');
    }

    public function index(Request $request)
    {
        $filters = $this->getFilters($request);

        $locations = Location::query();

        $locations->whereBetween('price', $filters['price']);

        foreach($filters['categories'] as $category){
            $locations->whereHas('categories', function($query) use ($category){
                $query->where('categories.id', $category);
            });
        }

        if($filters['person_count']){
            $locations->where('person_count', '>', $filters['person_count']);
        }   
        
        $locations = $locations->orderBy('created_at', 'DESC')
            ->get();

        if(count($filters['payment_method'])){
            $locations = $locations->filter(function($item) use($filters){
                return array_equal($item->payment_method->toArray(), $filters['payment_method']);
            });
        }

        $locations = CollectionHelper::paginate($locations, 10);

        $categories = Category::all()->sortByDesc(function($item){
            return $item->locations->count();
        })->slice(0, 10);   

        return view('app.catalog.index', compact('locations', 'filters', 'categories'));
    }

    protected function locationReviewsCount($reviews){
        $instance = [
            "5" => 0,
            "4" => 0,
            "3" => 0,
            "2" => 0,
            "1" => 0,
        ];
        return object_merge($instance, $reviews->groupBy('rate')->map->count()->toArray());
    }

    public function show(Location $location)
    {
        $reviewsCount = $this->locationReviewsCount($location->reviews());
        $reviews = CollectionHelper::paginate($location->reviews(), 10);
        return view('app.catalog.show', compact('location', 'reviews', 'reviewsCount'));
    }
}
