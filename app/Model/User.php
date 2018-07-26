<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function challengers()
    {
        return $this->belongsToMany('App\Model\User', 'challenge_user', 'challenged_id', 'challenger_id')
            ->withPivot('accepted', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function challenged()
    {
        return $this->belongsToMany('App\Model\User', 'challenge_user', 'challenger_id', 'challenged_id')
            ->withPivot('accepted', 'id');
    }
}
