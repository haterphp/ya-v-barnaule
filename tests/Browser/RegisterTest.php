<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\RegisterPage;
use Tests\Browser\Traits\DatabaseSeeders;
use Tests\Browser\Traits\UserDatabaseManagement;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations, DatabaseSeeders, UserDatabaseManagement;

    public function testEmptyBody()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegisterPage)
                    ->click('@submit')
                    ->assertSee('Это поле обязательное.');
        });
    }

    public function testIncorrectBody()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegisterPage)
                    ->type('@name', "test")
                    ->type('@phone', "8-(800)-555-3535")
                    ->type('@email', "incorrect-email-address")
                    ->type('@password', "1234")
                    ->click('@submit')
                    ->assertSee('Не верный формат почты.')
                    ->assertSee('Минимальное кол-во символов: 8.');
        });
    }

    public function testUniqueEmail()
    {
        $this->browse(function (Browser $browser){
            $email = 'unique.email@test.info';
            $user = $this->makeUser(compact('email'));
            $browser->visit(new RegisterPage)
                    ->type('@name', "test")
                    ->type('@phone', "8-(800)-555-3535")
                    ->type('@email', $email)
                    ->type('@password', "12345678")
                    ->click('@submit')
                    ->assertSee('Такое значение поля E-Mail адрес уже существует.');
        });
    }

    public function testCorrectBody()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(new RegisterPage)
                    ->type('@name', "test")
                    ->type('@phone', "8-(800)-555-3535")
                    ->type('@email', 'unique.email@test.info')
                    ->type('@password', "12345678")
                    ->click('@submit')
                    ->assertPathIs('/');
        });
    }
}
