<?php

namespace App\Livewire;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Addfollow extends Component
{
    public $username;
    public function save()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = User::where('username', $this->username)->first();

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

        session()->flash('success', 'User succesfully followed');
        return $this->redirect("/profile/{$this->username}", navigate: true);
    }

    public function render()
    {
        return view('livewire.addfollow');
    }
}
