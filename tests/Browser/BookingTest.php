<?php

namespace Tests\Browser;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LocationPage;
use Tests\Browser\Traits\DatabaseSeeders;
use Tests\Browser\Traits\UserDatabaseManagement;
use Tests\DuskTestCase;

class BookingTest extends DuskTestCase
{
    use DatabaseMigrations, DatabaseSeeders, UserDatabaseManagement;

    public function testEmptyBody()
    {
        $this->browse(function (Browser $browser){
            $browser->loginAs($this->findUser(1))
                ->visit(new LocationPage)
                ->click('@open-modal')
                ->pause(700)
                ->click('@booking-button')
                ->pause(700)
                ->assertSee('Поле обязательно для заполнения');
        });
    }

    private function getDateKeys(Carbon $datetime): array{
        $array = explode(' ', $datetime->format('d m Y H i'));
        return [
            ...array_slice($array, 0, 3),
            '{tab}',
            ...array_slice($array, 3, 6),
        ];
    }

    public function testIncorrectBody()
    {
        $this->browse(function (Browser $browser){
            $browser->loginAs($this->findUser(1))
                ->visit(new LocationPage)
                ->click('@open-modal')
                ->pause(700)
                ->keys('@started_at', ...$this->getDateKeys(Carbon::now()->addDays(-1)))
                ->pause(100)
                ->keys('@finished_at', ...$this->getDateKeys(Carbon::now()->addDays(-2)))
                ->pause(100)
                ->click('@booking-button')
                ->pause(700)
                ->assertSee('Дата бронирования не раньше чем сегодня')
                ->assertSee('Дата окончания бронирование не должна быть раньше, чем дата начала');
        });
    }

    public function testCorrectBody()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->findUser(1))
                ->visit(new LocationPage)
                ->click('@open-modal')
                ->pause(700)
                ->keys('@started_at', ...$this->getDateKeys(Carbon::now()->addHour()))
                ->pause(100)
                ->keys('@finished_at', ...$this->getDateKeys(Carbon::now()->addHours(2)))
                ->pause(100)
                ->click('@booking-button')
                ->pause(700)
                ->assertSee('Бронирование успешно совершено. Чтобы посмотреть все свои бронирования зайдите в личный кабинет. Так же наши менеджеры свяжутся с вами по указаной вами электронной почте');
        });
    }
}
