<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\UserAnswer;
use App\Models\UserTryout;
use Illuminate\Http\Request;

class SesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'f_mapel'               => 'required',
            'f_time_start'         => 'required',
            'f_time_end'           => 'required|after:f_time_start',
         ]);

         $sesi             = new Sesi();
         $sesi->tryout_id  = $request->f_tryout_id;
         $sesi->mapel_id   = $request->f_mapel;
         $sesi->time_start = $request->f_time_start;
         $sesi->time_end   = $request->f_time_end;

         if($sesi->save()){
            return redirect()->route('sesi.edit', $sesi->id)->with(['success' => 'Sesi berhasil ditambahkan!']);
         }else{
            return redirect()->route('sesi.edit', $sesi->sesi->id)->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
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
        $sesi = Sesi::findOrFail($id);
        return view('sesi.edit_sesi', compact('sesi'));
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
        $this->validate($request, [
            'f_mapel'            => 'required',
            'f_time_start'         => 'required',
            'f_time_end'           => 'required|after:f_time_start',
         ]);

         $sesi = Sesi::findOrFail($id);
         $update_sesi = $sesi->update([
            'mapel' => $request->f_mapel,
            'time_start' => $request->f_time_start,
            'time_end' => $request->f_time_end
        ]);

         if($update_sesi){
            return redirect()->route('sesi.edit', $sesi->id)->with(['success' => 'Sesi berhasil diubah!']);
         }else{
            return redirect()->route('sesi.edit', $sesi->id)->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
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
        $sesi = Sesi::findOrFail($id);
        $tryout_id = $sesi->tryout_id;
        foreach($sesi->question as $q){
            $q->choice()->delete();
            $q->delete();
        }

        UserAnswer::where('sesi_id', $id)->delete();
        UserTryout::where('sesi_id', $id)->delete();

        $sesi->delete();

        return redirect()->route('tryout.edit', $tryout_id)->with(['success' => 'Tryout Berhasil Dihapus!']);
    }
}
