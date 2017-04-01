<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    /**
     *  Get the owner of the tweet.
     * 
     *  @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    

    /**
     *  Get the tweet url
     * 
     *  @return string
     */
    public function getUrlAttribute()
    {
        return route('tweet.show', ['username' => $this->owner->username, 'id' => $this->id]);
    }
}
