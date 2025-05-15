<?php

namespace App\Livewire;

use App\Models\Follow;
use App\Models\User;
use Livewire\Component;

class Addfollow extends Component
{
    public $username;

    public function save()
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        $user = User::where('username', $this->username)->first();

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

        session()->flash('success', 'User successfully followed.');
        return $this->redirect("/profile/{$this->username}", navigate: true);
    }

    public function render()
    {
        return view('livewire.addfollow');
    }
}
