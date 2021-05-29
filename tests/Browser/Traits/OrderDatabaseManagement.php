<?php


namespace Tests\Browser\Traits;

use App\Models\Order;
use Carbon\Carbon;

trait OrderDatabaseManagement
{
    public function makeOrder($body = [])
    {
        $body = object_merge([
            'user_id' => 1,
            'location_id' => 1,
            'code' => "TEST",
            'started_at' => Carbon::now()->format("Y-m-d H:i:s"),
            'finished_at' => Carbon::now()->addHour()->format("Y-m-d H:i:s"),
            'status' => "0"
        ], $body);
        return Order::create($body);
    }
}
