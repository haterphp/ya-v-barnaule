<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function store(Location $location)
    {
        $user = auth()->user(); 

        if(!$user->wishList->pluck('id')->contains($location->id)) $user->wishList()->attach($location);
        else $user->wishList()->detach($location);

        return back();
    }

    public function index()
    {
        $locations = auth()->user()->wishList->sortByDesc(function($item){
            return $item->pivot->created_at;
        });
        return view('app.profile.wish', compact('locations'));
    }
}
