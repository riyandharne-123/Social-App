<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'acc_user_id','name', 'profile_image','post_image','likes','user_likes','post_desc','post_tags','comment_count','post_comments',
    ];
}
