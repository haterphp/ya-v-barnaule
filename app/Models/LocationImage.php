<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LocationImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'filepath',
        'location_id'
    ];

    public function getFileObject()
    {
        $ext = explode('.', $this->filepath)[1];
        return [
            "id" => $this->id,
            "url" => "data:image/$ext;base64," . base64_encode(Storage::disk('public')->get($this->filepath))
        ];
    }
}
