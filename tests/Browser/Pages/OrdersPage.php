<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Tests\Browser\Traits\UserDatabaseManagement;

class OrdersPage extends Page
{
    use UserDatabaseManagement;
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/profile/orders';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser
            ->assertTitle('Я в Барнауле - Мои бронирования')
            ->assertSee('Мои бронирования')
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
            '@modal-open' => '#review-modal-button',
            '@send-review' => '#review-submit',
            '@comment' => 'textarea[name="content"]',
            "@rate" => '.rate-input-stars > .fa-star:first-of-type'
        ];
    }
}
