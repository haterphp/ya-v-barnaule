<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Tests\Browser\Traits\DatabaseSeeders;
use Tests\Browser\Traits\UserDatabaseManagement;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations, UserDatabaseManagement, DatabaseSeeders;

    public function testEmptyBody()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new LoginPage)
                ->click('@submit')
                ->assertSee('Не верная почта или пароль');
        });
    }

    public function testIncorrectBody()
    {
        $this->browse(function (Browser $browser){
           $browser
               ->visit(new LoginPage)
               ->type('@email', 'incorrect@mail.ru')
               ->type('@password', 'incorrect')
               ->click('@submit')
               ->assertSee('Не верная почта или пароль');
        });
    }

    public function testCorrectBody()
    {
        $this->browse(function (Browser $browser){
            $user = $this->makeUser();
            $browser
                ->visit(new LoginPage)
                ->type('@email', $user->email)
                ->type('@password', $user->password)
                ->click('@submit')
                ->assertPathIs('/')
                ->assertAuthenticatedAs($this->findUser($user->id));
        });
    }
}
