<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
         'post_id','user_image','user_id','user_name','comment'
    ];
}
