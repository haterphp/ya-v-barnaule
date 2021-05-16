<?php

namespace Tests\Browser\Traits;

use App\Models\User;

trait UserDatabaseManagement{
    protected $users = [];

    protected function makeUser($body = []){
        $body = object_merge([
            'name' => 'test',
            'email' => 'test@mail.ru',
            'password' => 'test',
            'role_id' => 2
        ], $body);
        $user = User::create($body);
        $this->users[$user->id] = $user;
        return $user;
    }

    protected function destroyUser($id){

    }
}