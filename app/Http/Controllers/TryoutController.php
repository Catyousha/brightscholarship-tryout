<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\UserTryout;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        //selain sedang berlangsung, tolak.
        //Gate::authorize('view', $tryout);

        $soal           = $tryout->question()->where('question_num', $no_soal)->firstOrFail();
        $soal->terakhir = ($tryout->question()->where('question_num', $no_soal+1)->first() == null);

        return view('tryout.soal', compact('tryout', 'soal'));
    }

    public function peserta_list($id){
        $tryout         = Tryout::findOrFail($id);
        $peserta_tryout = UserTryout::where('tryout_id', $id)->orderByDesc('score')->get();
        return view('tryout.list_peserta', compact('peserta_tryout', 'tryout'));
    }

    public function lembar_jawaban($tryout_id, $user_id){
        $usertryout      = UserTryout::where('tryout_id', $tryout_id)->where('user_id', $user_id)->firstOrFail();
        $jawaban_peserta = UserAnswer::where('tryout_id', $tryout_id)->where('user_id', $user_id)->get()->sortBy('question_id');
        return view('tryout.lembar_jawaban', compact('usertryout', 'jawaban_peserta'));
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
        $tryout = Tryout::findOrFail($id);
        $update_tryout = $tryout->update([
            'name' => $request->f_name,
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
        $tryout = Tryout::findOrFail($id);
        foreach($tryout->question as $q){
            $q->choice()->delete();
            $q->delete();
        }
        UserAnswer::where('tryout_id', $id)->delete();
        UserTryout::where('tryout_id', $id)->delete();

        $tryout->delete();

        return redirect()->route('tryout.index')->with(['success' => 'Tryout Berhasil Dihapus!']);
    }
}
