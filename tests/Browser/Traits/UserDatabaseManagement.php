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
        return (object) object_merge($user->toArray(), [ 'password' => $body['password'] ]);
    }

    protected function destroyUser($id){
        User::findAndDelete($id);
    }

    protected function findUser($id){
        return User::find($id);
    }
}