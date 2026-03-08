<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function createFollow(User $user)
    {
        // You cannot follow yourself
        if ($user->id === Auth::user()->id) {
            return back()->with('failure', 'You cannot follow yourself!');
        }

        // You cannot follow someone you're alredy follow
        $existCheck = Follow::where([['user_id', '=', Auth::user()->id], ['followeduser', '=', $user->id]])->count();
        if ($existCheck) {
            return back()->with('failure', 'You alredy following this user');
        }

        $newFollow = new  Follow;
        $newFollow->user_id = Auth::user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'Youser succesfuly followed');
    }

    public function removeFollow(User $user)
    {
        Follow::where([['user_id', '=', Auth::user()->id], ['followeduser', '=', $user->id]])->delete();
        return back()->with('success', 'User succesfully unfolowed');
    }
}
