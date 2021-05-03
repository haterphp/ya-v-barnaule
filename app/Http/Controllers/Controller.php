<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $validation_responses = [
        'required' => "Это поле обязательное.",
        'email' => 'Не верный формат почты.',
        'min' => 'Минимальное кол-во символов: :min.',
        'unique.email' => 'Такая почта уже занята, попробуйте другую.'
    ];
}
