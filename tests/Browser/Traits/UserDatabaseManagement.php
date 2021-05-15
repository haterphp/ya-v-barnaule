<?php

namespace Tests\Browser\Traits;

use App\Models\User;

trait UserDatabaseManagement{
    protected $users = [];

    public function __construct()
    {
        $this->users = collect([]);
    }

    protected function makeUser($body = []){
        $body = object_merge([
            'name' => 'test',
            'email' => 'test@mail.ru',
            'password' => 'test',
            'role_id' => 2
        ], $body);
        $this->users->push(User::create($body));
    }

    protected function destroyUser($id){

    }
}