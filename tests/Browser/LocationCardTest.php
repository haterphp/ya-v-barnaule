<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LocationPage;
use Tests\DuskTestCase;

class LocationCardTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testShowLocation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LocationPage)
                    ->assertSee('Laravel');
        });
    }
}
