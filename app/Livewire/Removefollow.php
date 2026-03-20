<?php

namespace App\Livewire;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Removefollow extends Component
{
    public $username;

    public function save()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }
        $user = User::where('username', $this->username)->first();
        Follow::where([['user_id', '=', Auth::user()->id], ['followeduser', '=', $user->id]])->delete();
        session()->flash('success', 'User succesfully unfollowed');
        return $this->redirect("/profile/{$this->username}", navigate: true);
    }

    public function render()
    {
        return view('livewire.removefollow');
    }
}
