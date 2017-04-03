<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_view_a_tweet()
    {
        $tweet = factory('App\Tweet')->create();
        
        $response = $this->get($tweet->url);

        $response->assertSee($tweet->body);
    }

    /** @test */
    public function a_user_can_register()
    {
        $email = 'johndoe@gmail.com';

        $response = $this->post('/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => $email,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);

        $response->assertRedirect('/home');
    }
}
