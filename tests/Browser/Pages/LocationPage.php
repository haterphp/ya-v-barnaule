<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

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
        $location = \App\Models\Location::find(1);
        $browser
            ->assertTitle("Я в Барнауле - {$location->title}")
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
            '@booking-button' => '#btn-booking',
            '@started_at' => 'input[name="started_at"]',
            '@finished_at' => 'input[name="finished_at"]',
            '@remove-review-button' => '.remove-review-button'
        ];
    }
}
