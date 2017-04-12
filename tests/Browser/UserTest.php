<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_logged_in_user_can_create_a_tweet()
    {
        $this->browse(function (Browser $browser) {
            $user = factory('App\User')->create();
            $tweet = 'My first tweet';

            $browser->loginAs($user)
                    ->visit('/')
                    ->type('body', $tweet)
                    ->press('Tweet');

            $this->assertDatabaseHas('tweets', ['body' => $tweet]);
        });


    }
}
