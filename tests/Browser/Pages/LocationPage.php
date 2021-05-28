<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use phpDocumentor\Reflection\Location;

class LocationPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/catalog/1';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $location = Location::find(1);
        $browser
            ->assertTitle("Я в Баранауле - {$location->title}")
            ->assertSee($location->title)
            ->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@open-modal' => '#btn-booking-modal',
            '@booking-button' => '#btn-booking'
        ];
    }
}
