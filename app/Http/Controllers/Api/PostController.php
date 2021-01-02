<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Auth;
class PostController extends Controller
{
    public function index()
    { 
        $posts = Post::orderBy('created_at', 'desc')->get();
        return response()->json(['posts' =>$posts], 200);
    }
    public function store(Request $request)
    {
        Post::updateOrCreate([
            'acc_user_id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'profile_image' => Auth::user()->profile_image,
            'post_image' => $request->post_image,
            'likes' => 0,
            'post_desc' => $request->post_desc,
            'post_tags' => json_encode($request->post_tags),
            'comment_count' => 0,
           ]);
           return response()->json(['posts' => Post::orderBy('created_at', 'desc')->get()], 200);
    }
}
