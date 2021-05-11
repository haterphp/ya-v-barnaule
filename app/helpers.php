<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

function base64Upload(String $path, String $file) :String{

    File::isDirectory(public_path('storage/' . $path)) or File::makeDirectory(public_path('storage/' . $path), 0777, true, true);

    $extension = explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
    $replace = substr($file, 0, strpos($file, ',')+1);

    $image = str_replace($replace, '', $file);
    $image = str_replace(' ', '+', $image);
    $imageName = Str::random(25).'.'.$extension;

    $filepath = $path.'/'.$imageName;
    Storage::disk('public')->put($filepath, base64_decode($image));

    return $filepath;
}

function paymentMethod($method) {
    $methods = [
        'cash' => 'Наличными',
        'non-cash' => 'Безналичный'
    ];
    return $methods[$method];
}

function roleName($role){
    $role -= 1;
    $roles = [
        'Администратор',
        'Клиент'
    ];
    return $roles[$role];
}

function dateFormat($date, $format){
    return Carbon::make($date)->format($format);
}

function orderStatus($status, $icon=true){
    $scenarios = [
        ['warning', 'На рассмотрении'],
        ['success', 'Одобрено'],
        ['danger', 'Отказано'],
    ];
    $icon = $icon ? "<i class='fa text-" . $scenarios[$status][0] . " fa-info mr-2'></i>" : "";
    $tmp = "<p class='text-" . $scenarios[$status][0] ." mb-0'>" . $icon . $scenarios[$status][1] . "</p>";
    return $tmp;
}

function array_equal($a, $b) {
    return (
         is_array($a) 
         && is_array($b) 
         && count($a) == count($b) 
         && array_diff($a, $b) === array_diff($b, $a)
    );
}

function object_merge(...$arrays){
    $merged = [];
    foreach ($arrays as $array){
        foreach ($array as $key => $value){
            $merged[$key] = $value;
        }
    }
    return $merged;
}

function plural($endings, $number)
{
    $cases = [2, 0, 1, 1, 1, 2];
    $n = $number;
    return sprintf($endings[ ($n%100>4 && $n%100<20) ? 2 : $cases[min($n%10, 5)] ], $n);
}