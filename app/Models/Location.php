<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'payment_method',
        'person_count'
    ];

    public function setPaymentMethodAttribute($value)
    {
        $this->attributes['payment_method'] = json_encode($value);
    }

    public function getPaymentMethodAttribute()
    {
        return collect(json_decode($this->attributes['payment_method']));
    }

    public function getBase64ImagesAttribute()
    {
        return $this->images->map->getFileObject();
    }

    public function images()
    {
        return $this->hasMany(LocationImage::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'location_categories');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->orders->map->reviews->flatten()->reverse();
    }

    public function rate()
    {
        $reviews = $this->reviews();
        $count = $reviews->count();
        if($count == 0) return 0;
        $rateSum = $reviews->map->rate->sum();
        return ceil($rateSum / $count);
    }

    public function uploadPhotos($photos)
    {
        
        $photos_to_upload = collect($photos)->map(function($photo) {
            if($photo['id'] === "null") $filepath = \base64Upload('locations/' . $this->id, $photo['url']);
            else {
                $idx = $this->images->search(function($item) use($photo) {
                    return $item->id === +$photo['id'];
                });
                $filepath = $this->images[$idx]->filepath;
            }
            return compact('filepath');
        });

        $this->images->each(function($image) use ($photos){
            if(collect($photos)->pluck('id')->contains($image->id)) return;
            Storage::disk('public')->delete($image->filepath);
        });

        $this->images()->delete();
        $this->images()->createMany($photos_to_upload);
    }

    public function pathToImage($path)
    {
        return URL::to('/storage') . '/' . $path;
    }

    public function photos($idx = null)
    {
        $photos = $this->images->map(function($image) {
            return $this->pathToImage($image->filepath);
        });

        return $idx === null ? $photos : $photos[$idx];
    }

    public function ordersInMonth()
    {
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        $begin = (new DateTime("first day of $year-$month"))->format('Y-m-d');
        $end = (new DateTime("last day of $year-$month"))->format('Y-m-d');

        return $this->orders->filter(function($item) use($begin, $end){
            return $item['started_at'] >= $begin && $item['started_at'] <= $end && $item['status'] == 1;
        });
    }
}
