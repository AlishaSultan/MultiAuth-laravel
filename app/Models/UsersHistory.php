<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersHistory extends Model
{
    use HasFactory;

    protected $fillable = [            //mass assignment
           'name',
           'email',
           'role',
           'status',
           'login_time',

    ];

    //protected $guard = [] // Todo;       //not mass assignable
}
