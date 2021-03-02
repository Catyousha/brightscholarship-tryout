<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Tryout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PdfController extends Controller
{
    public function index($type){
        if($type == "RANK_ALL"){

            $tryout         = Tryout::all();
            //$peserta_tryout = UserTryout::where('tryout_id', $id)->orderBy('score')->get();
            $peserta_tryout = DB::table('user_tryout AS ut1')->select(DB::raw("*, (SELECT SUM(score)/8 AS avg_score FROM `user_tryout` WHERE user_id = ut1.user_id) AS avg_score"))
                                                             ->orderByDesc('avg_score')
                                                             ->get();
            $data = array('tryout' => $tryout, 'peserta_tryout' => $peserta_tryout);

            $pdf = PDF::loadView('PDF.rank_all', $data)->setPaper('a3', 'landscape');
            return $pdf->stream('test.pdf');
            //return view('PDF.rank_all', compact('tryout', 'peserta_tryout'));
        }
    }
}
