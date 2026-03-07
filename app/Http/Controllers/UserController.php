<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    public function showCorrectHomepage()
    {
        if (Auth::check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }
    public function registerUser(Request $request)
    {
        $incomingFields = $request->validate(
            [
                'username' => ['required', 'min:3', 'max:255', Rule::unique('users', 'username')],
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
                'password' => ['required', 'min:5', 'max:255', 'confirmed']
            ],
            [
                'username.required' => 'Molim vas da unesete korisničko ime.',
                'username.min' => 'Korisničko ime mora imati najmanje 3 karaktera.',
                "username.unique" => 'Korisničko ime već postoji, molim vas da odaberete drugo.',
                'email.required' => 'Molim vas da unesete email adresu.',
                'email.email' => 'Molim vas da unesete ispravnu email adresu.',
                'email.unique' => 'Email adresa već postoji, molim vas da odaberete drugu.',
                'email.max' => 'Email adresa ne smije biti duža od 255 karaktera.',
                'password.required' => 'Molim vas da unesete lozinku.',
                'password.min' => 'Lozinka mora imati najmanje 5 karaktera.',
                'password.confirmed' => 'Lozinka i potvrda lozinke se ne poklapaju.'
            ]
        );
        $user = User::create($incomingFields);
        Auth::login($user);
        return redirect('/')->with('success', 'Uspešno ste se registrovali');
    }

    public function login(Request $request)
    {
        $incomingFields = $request->validate(
            [
                'loginusername' => ['required'],
                'loginpassword' => ['required']
            ],
            [
                'loginusername.required' => 'Molim vas da unesete korisničko ime.',
                'loginpassword.required' => 'Molim vas da unesete lozinku.'
            ]
        );

        if (Auth::attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'Uspješno ste se prijavili!');
        } else {
            return redirect('/')->with('failure', 'Neispravno korisničko ime ili lozinka. Pokušajte ponovo.');
        }

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Uspješno ste se odjavili!');
    }

    public function profile(User $user)
    {
        return view('profile-posts', ['avatar' => $user->avatar,  'username' => $user->username, 'posts' => $user->posts()->latest()->get(), 'postCount' => $user->posts()->count()]);
    }

    public function showAvatarForm()
    {
        return view('avatar-form');
    }

    public function storeAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:8000']
        ]);

        $user = Auth::user();

        $filename = $user->id . "-" . $user->username . "-" . uniqid() . ".jpg";

        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file("avatar"));
        $imageData = $image->cover(120, 120)->toJpeg();
        Storage::disk('public')->put('avatars/' . $filename, $imageData);

        $oldAvatar = $user->avatar;

        $user->avatar = $filename;
        $user->save();

        if ($oldAvatar !== '/fallback-avatar.jpg') {
            Storage::disk('public')->delete(str_replace("/storage/", "", $oldAvatar));
        }

        return back()->with('success', 'Avatar je promenjen');
    }
}
