<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_must_have_a_username()
    {
        $user = factory('App\User')->create();

        $this->assertNotNull($user->username);
    }
}
