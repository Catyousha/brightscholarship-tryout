<?php

namespace App\Http\Controllers;

use App\Models\Pilihan;
use App\Models\Sesi;
use App\Models\Tryout;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\UserTryout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class TryoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tryout = ($request->query('name')) ?
        Tryout::like('name', $request->query('name'))->orderBy('name')->paginate(10)
       : Tryout::orderBy('name')->paginate(10);
        return view('tryout.list', compact('tryout'));
    }


    public function solve($id_tryout, $no_soal)
    {
        $tryout         = Tryout::findOrFail($id_tryout);

        $sesi           = $tryout->sesi()->where('time_start', '<=', Carbon::now())
                                         ->where('time_end', '>', Carbon::now())
                                         ->firstOrFail();
        if($sesi->istirahat){
            return redirect()->route('tryout.istirahat', ['id_tryout' => $tryout->id]);
        }
        Gate::authorize('view', [$tryout, $sesi]);

        $soal           = $tryout->question()
                                         ->where('sesi_id', $sesi->id)
                                         ->where('question_num', $no_soal)
                                         ->firstOrFail();
        $soal->terakhir = ($tryout->question()->where('question_num', $no_soal+1)->first() == null);
        if(!Session::has('ongoing_tryout')){
            Session::put('ongoing_tryout', $tryout->id);
        }
        return view('tryout.soal', compact('tryout', 'soal', 'sesi'));
    }

    public function istirahat($id_tryout){

        $tryout         = Tryout::findOrFail($id_tryout);

        $sesi           = $tryout->sesi()->where('time_start', '<=', Carbon::now())
                                         ->where('time_end', '>', Carbon::now())
                                         ->where('istirahat', 1)
                                         ->firstOrFail();

        Gate::authorize('view', [$tryout, $sesi]);

        if(!Session::has('ongoing_tryout')){
            Session::put('ongoing_tryout', $tryout->id);
        }

        return view('tryout.istirahat', compact('tryout', 'sesi'));
    }

    public function pemeringkatan($name){
        if(Session::has('ongoing_tryout')){
            $id = Session::get('ongoing_tryout');
            return redirect()->route('tryout.soal', ['id_tryout'=>$id, 'no_soal'=>1]);
        }
        if($name == "ALL"){
            return $this->all_pemeringkatan();
        }
        $pilihan = Pilihan::where('name', $name)->firstOrFail();
        $tryout  = Tryout::where('pilihan_id', $pilihan->id);
        if($tryout->count() > 1){
            return view('tryout.list', compact('tryout'));
        } else{
            return $this->peserta_list($tryout->firstOrFail()->id);
        }

    }

    public function all_pemeringkatan(){
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
            ) AS avg_score FROM `user_tryout` as ut2 WHERE ut2.user_id = ut1.user_id) AS avg_score"))
                                                         ->orderByDesc('avg_score')
                                                         ->get()->unique('user_id');
        return view('tryout.all_ranking', compact('peserta_tryout', 'tryout'));
    }

    //AKA RANKING SALAH SATU TO
    public function peserta_list($id){
        $tryout         = Tryout::findOrFail($id);
        //$peserta_tryout = UserTryout::where('tryout_id', $id)->orderBy('score')->get();
        $peserta_tryout = DB::table('user_tryout AS ut1')->select(DB::raw("*, (SELECT SUM(score)/".$tryout->sesi->where('istirahat', '=', 0)->count()." AS avg_score FROM `user_tryout` WHERE user_id = ut1.user_id) AS avg_score"))
                                                         ->where('tryout_id', $id)
                                                         ->orderByDesc('avg_score')
                                                         ->get()->unique('user_id');
        return view('tryout.list_peserta', compact('peserta_tryout', 'tryout'));
    }

    public function lembar_jawaban($tryout_id, $user_id){
        if(Auth::user()->role != 'admin' && Auth::user()->id != $user_id){
            return redirect()->route('home');
        }
        $tryout          = Tryout::findOrFail($tryout_id);
        //$usertryout      = UserTryout::where('tryout_id', $tryout_id)->where('user_id', $user_id)->get();
        $usertryout = DB::table('user_tryout AS ut1')->select(DB::raw("*, (SELECT SUM(score)/".$tryout->sesi->where('istirahat', 0)->count()." AS avg_score FROM `user_tryout` WHERE user_id = ut1.user_id) AS avg_score"))
            ->where('tryout_id', $tryout_id)
            ->where('user_id', $user_id)
            ->get();
        $jawaban_peserta = UserAnswer::where('tryout_id', $tryout_id)->where('user_id', $user_id);
        return view('tryout.lembar_jawaban', compact('tryout', 'usertryout', 'jawaban_peserta'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('isAdmin');
        $this->validate($request, [
            'f_name'               => 'required',
            'f_pilihan'            => 'required',
            'f_time_start'         => 'required',
            'f_time_end'           => 'required|after:f_time_start',
         ]);

         $tryout             = new Tryout();
         $tryout->name       = $request->f_name;
         $tryout->pilihan_id = $request->f_pilihan;
         $tryout->time_start = $request->f_time_start;
         $tryout->time_end   = $request->f_time_end;

         if($tryout->save()){
            return redirect()->route('tryout.edit', $tryout->id)->with(['success' => 'Tryout berhasil ditambahkan!']);
         }else{
            return redirect()->route('tryout.list')->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('isAdmin');
        $tryout = Tryout::findOrFail($id);
        return view('tryout.edit_tryout', compact('tryout'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('isAdmin');
        $tryout = Tryout::findOrFail($id);

        $update_tryout = $tryout->update([
            'name' => $request->f_name,
            'pilihan_id' =>$request->f_pilihan,
            'time_start' => $request->f_time_start,
            'time_end' => $request->f_time_end
        ]);

        if($update_tryout){
            return redirect()->route('tryout.edit', $id)->with(['success' => 'Tryout Berhasil Diedit!']);
        } else{
            return redirect()->route('tryout.edit', $id)->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('isAdmin');
        $tryout = Tryout::findOrFail($id);
        foreach($tryout->question as $q){
            $q->choice()->delete();
            $q->delete();
        }
        Sesi::where('tryout_id', $id)->delete();
        UserAnswer::where('tryout_id', $id)->delete();
        UserTryout::where('tryout_id', $id)->delete();

        $tryout->delete();

        return redirect()->route('tryout.index')->with(['success' => 'Tryout Berhasil Dihapus!']);
    }
}
