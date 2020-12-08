<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Like;
use Auth;

class LikeController extends Controller
{
    public function store(Request $request){
        Like::updateOrCreate([
        'post_id' => $request->post_id,
        'acc_user_id' => Auth::user()->id,
        'user_email' => Auth::user()->email,
       ]);
       $likes = Like::select()->where('post_id', $request->post_id)->get();
       $like_count = $likes->count();
       $post = Post::where('id',$request->post_id)->update(['likes' => $like_count]);
       $liked_users = array();
       foreach($likes as $obj)
       {
       array_push($liked_users ,$obj->acc_user_id);
       }
       $post = Post::where('id',$request->post_id)->update(['user_likes' => json_encode($liked_users)]);
       return response()->json(['posts' => Post::all()], 200);
    }

    public function delete(Request $request){
        $selected_like = Like::where([
        'acc_user_id' => Auth::user()->id,
        'user_email' => Auth::user()->email,
        'post_id' => $request->post_id, 
        ]);
        $selected_like->delete();
        $likes = Like::select()->where('post_id', $request->post_id)->get();
        $like_count = $likes->count();
        $post = Post::where('id',$request->post_id)->update(['likes' => $like_count]);
        $liked_users = array();
        foreach($likes as $obj)
        {
        array_push($liked_users ,$obj->acc_user_id);
        }
        array_splice($liked_users,Auth::user()->id);
       $post = Post::where('id',$request->post_id)->update(['user_likes' => json_encode($liked_users)]);
        return response()->json(['posts' => Post::all()], 200);
  }
}
