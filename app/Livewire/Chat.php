<?php

namespace App\Livewire;

use App\Events\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chat extends Component
{
    public $textvalue = '';
    public $chatLog = [];

    public function getListeners()
    {
        return [
            "echo-private:chatchannel,ChatMessage" => 'notifyNewMessage'
        ];
    }

    public function notifyNewMessage($x)
    {
        array_push($this->chatLog, $x['chat']);
    }

    public function send()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorised');
        }

        if (trim(strip_tags($this->textvalue)) === "") {
            return;
        }

        array_push($this->chatLog, ['selfmessage' => true, 'username' => Auth::user()->usrname, 'textvalue' => strip_tags($this->textvalue), 'avatar' => Auth::user()->avatar]);

        broadcast(new ChatMessage(['selfmessage' => false, 'username' => Auth::user()->usrname, 'textvalue' => strip_tags($this->textvalue), 'avatar' => Auth::user()->avatar]))->toOthers();

        $this->textvalue = '';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
