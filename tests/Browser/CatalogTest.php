<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatalogPage;
use Tests\Browser\Traits\DatabaseSeeders;
use Tests\DuskTestCase;

class CatalogTest extends DuskTestCase
{
    use DatabaseMigrations, DatabaseSeeders;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCatalogView()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new CatalogPage);
        });
    }

    public function testCatalogPagination()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new CatalogPage)
                ->assertVisible('.pagination');
        });
    }
}
