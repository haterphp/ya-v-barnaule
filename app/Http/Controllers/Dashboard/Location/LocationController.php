<?php

namespace App\Http\Controllers\Dashboard\Location;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locations = Location::query()
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);
        return view('dashboard.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.locations.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'categories' => 'required',
            'payment_method' => 'required',
            'person_count' => 'required|integer',
            'photos' => 'required'
        ])->validate();
    
        $location = Location::create($request->all());
        $location->uploadPhotos($request->get('photos'));
        $location->categories()->attach($request->get('categories'));
        return redirect()
            ->route('dashboard.locations.show', ['location' => $location])
            ->with('alert', [
                'status' => 'success',
                'message' => 'Локация успешно создана'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return view('dashboard.locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $categories = Category::all();
        return view('dashboard.locations.edit', compact('location', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'categories' => 'required',
            'payment_method' => 'required',
            'person_count' => 'required|integer',
            'photos' => 'required'
        ])->validate();

        $location->fill($request->all())->save();
        $location->uploadPhotos($request->get('photos'));
        $location->categories()->sync($request->get('categories'));

        return redirect()
            ->route('dashboard.locations.show', ['location' => $location])
            ->with('alert', [
                'status' => 'success',
                'message' => 'Локация успешно обновлена'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        File::deleteDirectory(public_path('storage/locations/' . $location->id));
        $location->delete();

        return redirect()->route('dashboard.locations.index')->with('alert', [
            'status' => 'success',
            'message' => 'Вы успешно удалили локацию'
        ]);
    }
}
