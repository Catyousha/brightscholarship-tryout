<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $tryout = Tryout::latest()->get();
        return view('home', compact('tryout'));
    }
}
