<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CatalogPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/catalog';
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
            ->assertTitle('Я в Барнауле - Каталог')
            ->assertSee('Каталог')
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
            '@title' => 'input[name="title"]',
            '@price' => 'input[name="price"]',
            '@cash' => 'input[name="payment_method[]"][value="cash"]',
            '@non-cash' => 'input[name="payment_method[]"][value="non-cash"]',
            '@persons' => 'input[name="person_count"]',
            '@categories' => 'input[name="categories[]"][id="category-checkbox-1"]',
        ];
    }
}
