<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    /**
     *  Get the tweet url
     * 
     *  @return string
     */
    public function getUrlAttribute()
    {
        return route('user.tweet.show', ['user' => $this->user->slug, 'id' => $this->id]);
    }
}
