<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    protected $fillable = [
        'email', 'acc_user_id','profile_image','id','name','user_id'
    ];
}
