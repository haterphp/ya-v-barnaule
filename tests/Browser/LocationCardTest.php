<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LocationPage;
use Tests\Browser\Traits\DatabaseSeeders;
use Tests\Browser\Traits\OrderDatabaseManagement;
use Tests\Browser\Traits\ReviewDatabaseManagement;
use Tests\DuskTestCase;

class LocationCardTest extends DuskTestCase
{
    use DatabaseMigrations, DatabaseSeeders, OrderDatabaseManagement, ReviewDatabaseManagement;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testShowLocation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LocationPage);
        });
    }

    public function testLocationReviews()
    {
        $this->browse(function (Browser $browser){
            $order = $this->makeOrder();
            $this->makeReview($order);
            $browser
                ->visit(new LocationPage)
                ->assertVisible('.review-card');
        });
    }
}
