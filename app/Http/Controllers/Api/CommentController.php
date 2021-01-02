<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $post = Post::where('id',$request->post_id);
    Comment::updateOrCreate([
        'user_id' => Auth::user()->id,
        'user_image' => Auth::user()->profile_image,
        'user_name' => Auth::user()->name,
        'post_id' => $request->post_id,
        'comment' => $request->comment,
    ]);
    $comments = Comment::select()->where('post_id',$request->post_id)->get();
     /*  $new_comment = (object) [
        'name' => Auth::user()->name,
        'image' => Auth::user()->profile_image,
        'comment' => $request->comment,
    ];*/
    $post_comments = array();
    foreach($comments as $obj)
    {
    array_push(
        $post_comments,
       [
            'user_id' => $obj->user_id,
            'name' => $obj->user_name,
            'image' => $obj->user_image,
            'comment' => $obj->comment,
            'created_at' => $obj->created_at,
        ]
    );
    }
    $post->update(['post_comments' => array_reverse($post_comments),'comment_count' => count($post_comments)]);
    return response()->json(['posts' => Post::orderBy('created_at', 'desc')->get()], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
