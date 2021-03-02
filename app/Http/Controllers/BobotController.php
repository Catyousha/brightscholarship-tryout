<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BobotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('isAdmin');
        $bobot = Bobot::all();
        return view('bobot.manage_bobot', compact('bobot'));
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
        Gate::authorize('isAdmin');
        $this->validate($request, [
            'f_name'                  => 'required',
            'f_nilai_bobot'           => 'required'
         ]);

         $bobot               = new Bobot();
         $bobot->name         = $request->f_name;
         $bobot->nilai_bobot  = $request->f_nilai_bobot;
         if($bobot->save()){
            return redirect()->route('bobot.index')->with(['success' => 'Bobot berhasil ditambahkan!']);
         }else{
            return redirect()->route('bobot.index')->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bobot  $bobot
     * @return \Illuminate\Http\Response
     */
    public function show(Bobot $bobot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bobot  $bobot
     * @return \Illuminate\Http\Response
     */
    public function edit(Bobot $bobot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('isAdmin');
        $bobot = Bobot::findOrFail($id);
        $update_bobot = $bobot->update([
            'name' => $request->f_name,
            'nilai_bobot' =>$request->f_nilai_bobot
        ]);

        if($update_bobot){
            return redirect()->route('bobot.index')->with(['success' => 'Bobot Berhasil Diedit!']);
        } else{
            return redirect()->route('bobot.index')->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('isAdmin');
        $bobot = Bobot::findOrFail($id);
        $update_bobot = $bobot->update([
            'has_deleted' => 1
        ]);

        if($update_bobot){
            return redirect()->route('bobot.index')->with(['success' => 'Bobot Berhasil Dihapus!']);
        } else{
            return redirect()->route('bobot.index')->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
        }
    }
}
