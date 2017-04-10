<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations, \MailTracking;

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

    /** @test */
    public function a_confirmation_email_must_be_sent_after_registration()
    {
        $email = 'johndoe@gmail.com';
        $token = str_random(60);

        $response = $this->post('/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => $email,
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'email_verification_token' => $token
        ]);

        $this->seeEmailWasSent()
             ->seeEmailSubject("Confirm your Twitter account, John")
             ->seeEmailTo('johndoe@gmail.com')
             ->seeEmailContains(route('account.verify.email', ['token' => $token]));
    }

    /** @test */
    public function a_user_can_verify_their_email()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user)->get(route('account.verify.email', ['token' => $user->email_verification_token]));
        
        $this->assertNull($user->fresh()->email_verification_token);        
    }

    /** @test */
    public function a_user_can_create_a_tweet()
    {
        $user = factory('App\User')->create();
        $tweet = 'My first tweet';

        $this->actingAs($user)
             ->post(route('tweet.store', ['username' => $user->username]), [
            'body' => $tweet
        ]);

        $this->assertDatabaseHas('tweets', ['body' => $tweet]);
    }
}
