<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatalogPage;
use Tests\Browser\Traits\DatabaseSeeders;
use Tests\Browser\Traits\UserDatabaseManagement;
use Tests\DuskTestCase;

class WishTest extends DuskTestCase
{
    use DatabaseMigrations, DatabaseSeeders, UserDatabaseManagement;

    protected function url(){
        return '/user/wish/1';
    }

    public function testWithoutAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new CatalogPage)
                    ->click('.btn-wish')
                    ->assertPathIs('/auth/create');
        });
    }

    public function testWithAuth()
    {
        $this->browse(function (Browser $browser) {
            $user = $this->makeUser();
            $browser->loginAs($this->findUser($user->id))
                    ->visit(new CatalogPage)
                    ->click('.btn-wish')
                    ->assertPathIsNot('/auth/create');
        });
    }
}
