<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class LoginPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/auth/create';
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
            ->assertTitle('Я в Барнауле - Вход')
            ->assertSee('Авторизация')
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
            '@email' => 'input[name="email"]',
            '@password' => 'input[name="password"]',
            '@submit' => '#btn-login',
        ];
    }
}
