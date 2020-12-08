<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Auth;

class UserPostController extends Controller
{
    public function index()
    {
        $posts = Post::select()->where('acc_user_id', Auth::user()->id)->get();
        return response()->json(['posts' =>$posts], 200);
    }

    public function destroy($id)
    {
      $post = Post::find($id);
      $post->delete();
      $posts = Post::select()->where('acc_user_id', Auth::user()->id)->get();
      return response()->json(['posts' =>$posts], 200);
    }
}
