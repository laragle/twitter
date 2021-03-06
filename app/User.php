<?php

namespace App;

use App\Events\UserHasRegistered;
use App\Traits\MySQLJSONColumnManager;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Sluggable, MySQLJSONColumnManager;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'email_verification_token', 'options',
    ];

    /**
     *  The event map for the model.
     * 
     *  @var array
     */
    protected $events = [
        'created' => UserHasRegistered::class,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *  The attributes that should be casted to native types.
     * 
     *  @var array
     */
    protected $casts = [
        'options' => 'json'
    ];

    /**
     *  Get all the user tweets
     * 
     *  @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    /**
     *  Get the route key for the model.
     * 
     *  @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'username' => [
                'source' => ['first_name', 'last_name']
            ]
        ];
    }

    /**
     *  Verify user's email
     * 
     *  @return \App\User
     */
    public function verifyEmail()
    {
        $this->email_verification_token = null;
        $this->save();

        return $this;
    }

    /**
     *  Get the email verification url.
     * 
     *  @return string
     */
    public function getEmailVerificationUrlAttribute()
    {
        return route('account.verify.email', ['token' => $this->email_verification_token]);
    }

    /**
     * Get user full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
