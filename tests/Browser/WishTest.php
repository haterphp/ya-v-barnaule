<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatalogPage;
use Tests\Browser\Pages\WishPage;
use Tests\Browser\Traits\DatabaseSeeders;
use Tests\Browser\Traits\OrderDatabaseManagement;
use Tests\Browser\Traits\UserDatabaseManagement;
use Tests\Browser\Traits\WishDatabaseManagement;
use Tests\DuskTestCase;

class WishTest extends DuskTestCase
{
    use DatabaseMigrations, DatabaseSeeders, UserDatabaseManagement, WishDatabaseManagement;

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

    public function testViewWish()
    {
        $this->browse(function (Browser $browser){
            $this->makeWish([
                'location_id' => 1
            ]);
            $browser->loginAs($this->findUser(1))
                ->visit(new WishPage)
                ->assertVisible('.catalog-card');
        });
    }
}
