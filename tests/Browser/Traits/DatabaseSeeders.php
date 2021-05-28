<?php


namespace Tests\Browser\Traits;


trait DatabaseSeeders
{
    public function setUp() :void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }
}