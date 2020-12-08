<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Following;
use App\User;
use Auth;
class FollowingController extends Controller
{
    public function index()
    {
        $data = Following::select()->where('acc_user_id', Auth::user()->id)->get();
        $following_users = array();
        foreach($data as $obj)
        {
        array_push($following_users ,$obj->user_id);
        }
        return response()->json(['following_users' =>$following_users], 200);
    }

    public function store(Request $request)
    {
        Following::updateOrCreate([
            'user_id' => $request->user_id,
            'acc_user_id' => Auth::user()->id,
            'email' => $request->email,
            'profile_image' => $request->profile_image,
           ]);
           $following = Following::where('acc_user_id', Auth::user()->id);
           $followers = Following::where('email', Auth::user()->email);
           $following_count = $following->count();
           $followers_count = $followers->count();
           $user = User::find(Auth::user()->id);
           $user->following = $following_count;
           $user->followers = $followers_count;
           $data = Following::select()->where('acc_user_id', Auth::user()->id)->get();
           $following_users = array();
           foreach($data as $obj)
           {
           array_push($following_users ,$obj->user_id);
           }
           $user->followed_users = $following_users;
           $user->save();
           return response()->json(['user_data' => User::find(Auth::user()->id),
           'message' =>'you followed '.$request->name,
           'following_users' =>$following_users,
        ], 200);
    }
     public function delete(Request $request){
           $followed_user = Following::where(['acc_user_id' => $request->user_id, 'email' => $request->email,]);
           $followed_user->delete();
           $following = Following::where('acc_user_id', Auth::user()->id);
           $followers = Following::where('email', Auth::user()->email);
           $following_count = $following->count();
           $followers_count = $followers->count();
           $user = User::find(Auth::user()->id);
           $user->following = $following_count;
           $user->followers = $followers_count;
           $data = Following::select()->where('acc_user_id', Auth::user()->id)->get();
           $following_users = array();
           foreach($data as $obj)
           {
           array_push($following_users ,$obj->user_id);
           }
           $user->followed_users = $following_users;
           $user->save();
           return response()->json(['user_data' => User::find(Auth::user()->id),
           'message' =>'you unfollowed '.$request->name,
           'following_users' =>$following_users,
        ], 200);
     }
}
