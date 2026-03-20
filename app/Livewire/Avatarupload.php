<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;

class Avatarupload extends Component
{
    use WithFileUploads;

    public $avatar;

    public function save()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();

        $filename = $user->id . "-" . $user->username . "-" . uniqid() . ".jpg";

        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->avatar);
        $imageData = $image->cover(120, 120)->toJpeg();
        Storage::disk('public')->put('avatars/' . $filename, $imageData);

        $oldAvatar = $user->avatar;

        $user->avatar = $filename;
        $user->save();

        if ($oldAvatar !== '/fallback-avatar.jpg') {
            Storage::disk('public')->delete(str_replace("/storage/", "", $oldAvatar));
        }

        session()->flash('success', 'New avatar uploaded');
        return $this->redirect('/manage/avatar', navigate: true);
    }
    public function render()
    {
        return view('livewire.avatarupload');
    }
}
