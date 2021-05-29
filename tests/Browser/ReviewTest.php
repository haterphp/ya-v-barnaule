<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LocationPage;
use Tests\Browser\Pages\OrdersPage;
use Tests\Browser\Traits\DatabaseSeeders;
use Tests\Browser\Traits\OrderDatabaseManagement;
use Tests\Browser\Traits\ReviewDatabaseManagement;
use Tests\Browser\Traits\UserDatabaseManagement;
use Tests\DuskTestCase;

class ReviewTest extends DuskTestCase
{
    use DatabaseMigrations, DatabaseSeeders, OrderDatabaseManagement, UserDatabaseManagement, ReviewDatabaseManagement;

    public function testNotApproveLocation()
    {
        $this->browse(function (Browser $browser) {
            $order = $this->makeOrder();
            $browser
                ->loginAs($this->findUser(1))
                ->visit(new OrdersPage)
                ->assertVisible('@modal-open');
        });
    }

    public function testEmptyBody()
    {
        $this->browse(function (Browser $browser) {
            $this->makeOrder([
                'status' => '1'
            ]);
            $browser
                ->loginAs($this->findUser(1))
                ->visit(new OrdersPage)
                ->click('@modal-open')
                ->pause(700)
                ->click('@send-review')
                ->pause(700)
                ->assertSee('Поле обязательно для заполнения');
        });
    }

    public function testCorrectBody()
    {
        $this->browse(function (Browser $browser){
            $this->makeOrder([
                'status' => '1'
            ]);
            $browser
                ->loginAs($this->findUser(1))
                ->visit(new OrdersPage)
                ->click('@modal-open')
                ->pause(700)
                ->type('@comment', "test comment")
                ->click('@rate')
                ->click('@send-review')
                ->pause(700)
                ->assertPathIs('/catalog/1')
                ->assertSee('Отзыв успешно оставлен');
        });
    }

    public function testBlockReview()
    {
        $this->browse(function (Browser $browser){
            $order = $this->makeOrder([
                'status' => '1'
            ]);
            $this->makeReview($order);
            $browser
                ->loginAs($this->findUser(1))
                ->visit(new LocationPage)
                ->click('@remove-review-button')
                ->assertSee('Отзыв успешно удален');
        });
    }
}
