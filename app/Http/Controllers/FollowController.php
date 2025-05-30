<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use App\Models\User;

class FollowController extends Controller
{
    public function createFollow(User $user) {
        // You cannot follow yourself

        if ($user->id === auth()->user()->id) {
            return back()->with('failure', 'You cannot follow yourself');
        }

        // You cannot follow someone you're already following
        $existCheck = Follow::where([
            'user_id' => auth()->user()->id,
            'followeduser' => $user->id,
        ])->count();

        if ($existCheck) {
            return back()->with('failure', 'You are already following That user');
        }

        $newFollow = new Follow();
        $newFollow->user_id = auth()->user()->id;
        $newFollow->followeduser = $user->id;
        $newFollow->save();

        return back()->with('success', 'User successfully followed.');
    }

    public function removeFollow(User $user) {
        Follow::where([['user_id', '=', auth()->user()->id], ['followeduser', '=', $user->id]])->delete();
        return back()->with('success', 'User successfully unfollowed.');
    }
}
