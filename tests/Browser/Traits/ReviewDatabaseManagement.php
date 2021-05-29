<?php

namespace Tests\Browser\Traits;

use App\Models\Review;

trait ReviewDatabaseManagement
{
    public function makeReview($order, $body = [])
    {
        $body = object_merge([
            'user_id' => 1,
            'rate' => 5,
            'content' => 'test message'
        ], $body);
        return $order->reviews()->create($body);
    }
}
