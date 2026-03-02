<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public $name = 'Goja';
    public $animales = ['dog', 'cat', 'hamster'];
    public function homepage()
    {

        return view('homepage', ['name' => $this->name, 'animales' => $this->animales]);
    }

    public function about()
    {
        return view('about');
    }
}
