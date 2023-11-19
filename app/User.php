<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $table = 'can_bo_quan_ly';
    protected $primaryKey = 'idcanbo';
    public $incrementing = false;
    protected $fillable = [
        'tencanbo', 'username', 'password',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

        'remember_token' => 'string'
    ];
}
