<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $tryout = Tryout::latest()->where('pilihan_id', Auth::user()->pilihan_id)->get();
        $peserta_tryout = ($tryout[0]->time_end < Carbon::now()) ? DB::table('user_tryout AS ut1')->select(DB::raw("*, (SELECT SUM(score)/".$tryout[0]->sesi->where('istirahat', 0)->count()." AS avg_score FROM `user_tryout` WHERE user_id = ut1.user_id) AS avg_score"))
            ->where('tryout_id', $tryout[0]->id)
            ->orderByDesc('avg_score')
            ->get()->unique('user_id')->take(3)
            : null;
        return view('home', compact('tryout', 'peserta_tryout'));
    }
}
