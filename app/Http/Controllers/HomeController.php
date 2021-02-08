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
        if(Session::has('ongoing_tryout')){
            $id = Session::get('ongoing_tryout');
            return redirect()->route('tryout.soal', ['id_tryout'=>$id, 'no_soal'=>1]);
        }

        $tryout = Tryout::latest()->get();
        return view('home', compact('tryout'));
    }
}
