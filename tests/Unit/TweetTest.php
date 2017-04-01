<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TweetTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_tweet_url_must_not_be_null()
    {
        $tweet = factory('App\Tweet')->create();
                               
        $this->assertNotNull($tweet->url);
    }

    /** @test */
    public function a_tweet_url_must_be_in_correct_format()
    {
        $tweet = factory('App\Tweet')->create();

        $url = url($tweet->owner->username.'/tweet/'.$tweet->id);

        $this->assertEquals($url, $tweet->url);
    }
}
