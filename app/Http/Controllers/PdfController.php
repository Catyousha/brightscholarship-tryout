<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Tryout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PdfController extends Controller
{
    public function index($type, $id_tryout = null){
        Gate::authorize('isAdmin');

        if($type == "ALL"){
            $tryout         = Tryout::all();
            //$peserta_tryout = UserTryout::where('tryout_id', $id)->orderBy('score')->get();
            $peserta_tryout = DB::table('user_tryout AS ut1')->select(DB::raw("*, (SELECT (
                CASE
                WHEN ut1.tryout_id = 4 THEN SUM(score)/8
                WHEN ut1.tryout_id = 5 THEN SUM(score)/8
                WHEN ut1.tryout_id = 6 THEN SUM(score)/12
                ELSE
                SUM(score)/8
                END
                ) AS avg_score FROM `user_tryout` as ut2 WHERE ut2.user_id = ut1.user_id ) AS avg_score"))
                                                             ->orderByDesc('avg_score')
                                                             ->get();
            $data = array('tryout' => $tryout, 'peserta_tryout' => $peserta_tryout);

            $pdf = PDF::loadView('PDF.rank_all', $data)->setPaper('a3', 'landscape');
            return $pdf->stream('Hasil Pemeringkatan Seluruh Peserta BSTO UM.pdf');


        } else if($type == "SAINTEK" || $type == "SOSHUM" || $type == "CAMPURAN") {
            if($id_tryout == null){
                $id_pilihan = array(
                    "SAINTEK" => 1,
                    "SOSHUM" => 2,
                    "CAMPURAN" => 3
                );
                $id_tryout = $id_pilihan[$type];
            }
            $tryout         = Tryout::findOrFail($id_tryout);
            if($tryout->pilihan->name != $type){
                return redirect()->route('tryout.index');
            }

            $peserta_tryout = DB::table('user_tryout AS ut1')->select(DB::raw("*, (SELECT SUM(score)/".$tryout->sesi->where('istirahat', 0)->count()." AS avg_score FROM `user_tryout` WHERE user_id = ut1.user_id) AS avg_score"))
            ->where('tryout_id', $id_tryout)
            ->orderByDesc('avg_score')
            ->get()->unique('user_id');

            $data = array('tryout' => $tryout, 'peserta_tryout' => $peserta_tryout, 'pilihan' => $type);
            $pdf = PDF::loadView('PDF.rank_to', $data)->setPaper('a3', 'landscape');
            return $pdf->stream('Hasil Pemeringkatan Peserta '.$type.' BSTO UM.pdf');
        }
    }
}
