<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tryout = Tryout::all();
        return view('home', compact('tryout'));
    }
}
