<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Traits\DatabaseSeeders;
use Tests\Browser\Traits\UserDatabaseManagement;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    use DatabaseSeeders, DatabaseMigrations, UserDatabaseManagement;

    protected function url()
    {
        return '/auth/destroy';
    }

    public function testWithoutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->url())
                    ->assertPathIs('/auth/create');
        });
    }

    public function testWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $user = $this->makeUser();
            $browser->loginAs($this->findUser($user->id))
                    ->visit($this->url())
                    ->assertPathIs('/');
        });
    }
}
