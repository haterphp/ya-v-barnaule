<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $locations = $locations->sortByDesc(function($location){
            return $location->orders->count();
        })->slice(0, 5);
        return view('app.index', compact('locations'));
    }
}
