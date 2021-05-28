<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class RegisterPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/user/create';
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
            ->assertTitle('Я в Барнауле - Регистрация')
            ->assertSee('Регистрация')    
            ->assertPathIs($this->url());
    }

    public function assertSeeError(Browser $browser)
    {
        $browser->assertSee('Это поле обязательное.');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            "@name" => "input[name='name']",
            "@email" => "input[name='email']",
            "@phone" => "input[name='phone']",
            "@password" => "input[name='password']",
            '@submit' => '#btn-signup',
        ];
    }
}
