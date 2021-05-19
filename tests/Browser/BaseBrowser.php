<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\TextUI\XmlConfiguration\PHPUnit;

class BaseBrowser extends Browser
{

    public function assertElementsCountIs( $count, $selector )
    {
        PHPUnit::assertEquals( $count, count($this->elements( $selector )));
        return $this;
    }

}