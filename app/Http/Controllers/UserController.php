<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {
        $incomingFields = $request->validate(
            [
                'username' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|min:5|max:255'
            ],
            [
                'username.required' => 'Molim vas da unesete korisničko ime.',
                'email.required' => 'Molim vas da unesete email adresu.',
                'password.required' => 'Molim vas da unesete lozinku.'
            ]
        );
        User::create($incomingFields);
        return 'Uspješno ste se registrovali!';
    }
}
