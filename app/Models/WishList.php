<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory;

    protected $table = 'user_wish_lists';
    
    protected $fillable = [
        'user_id',
        'location_id'
    ];
}
