<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
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
        User::create($incomingFields);
        return 'Uspješno ste se registrovali!';
    }
}
