<?php

namespace App\Http\Controllers;

use App\Ring;
use App\Type;
use Illuminate\Http\Request;

class RingTypesController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return view('order', compact('types'));
    }

    public function detail($slug)
    {
        $type = Type::where('slug', $slug)->first();
        $rings = $type->rings; //Krijg alle ringen van een bepaald type
        return view('order-show', compact('type', 'rings'));
    }

    public function home()
    {
        $types = Type::all();
        return view('dashboard', compact('types'));
    }

    public function welcome()
    {
        $types = Type::all();
        return view('welcome', compact('types'));
    }
}
