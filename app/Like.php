<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'acc_user_id', 'user_email', 'post_id'
    ];
}
