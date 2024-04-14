<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Broadcasting\PrivateChannel;

use Laravel\Sanctum\HasApiTokens;

class Grade extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'session_year_id',
        'session_id',
        'SGPA',
        'CGPA',
    ];


    public function receivesBroadcastNotificationsOn()
    {
        //echo $this->id;
        return 'App.Models.User.' . $this->id;
    }
}