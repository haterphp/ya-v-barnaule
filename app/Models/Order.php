<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_id',
        'code',
        'started_at',
        'finished_at',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public static function ordersInInterval($interval)
    {
        $begin = $interval[0];
        $end = $interval[1];

        return Order::query()
                    ->where('started_at', '>=', $begin)
                    ->where('started_at', '<=', $end)
                    ->get()
                    ->filter(function($item){
                        return $item['status'] == 1;
                    });
    }
}
