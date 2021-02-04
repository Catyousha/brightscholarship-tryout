<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
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
    public function index()
    {
        $tryout = Tryout::latest()->paginate(5);
        return view('tryout.list', compact('tryout'));
    }


    public function solve($id_tryout, $no_soal)
    {
        $tryout         = Tryout::findOrFail($id_tryout);
        //selain sedang berlangsung, tolak.
        Gate::authorize('view', $tryout);

        $soal           = $tryout->question()->where('question_num', $no_soal)->firstOrFail();
        $soal->terakhir = ($tryout->question()->where('question_num', $no_soal+1)->first() == null);

        return view('tryout.soal', compact('tryout', 'soal'));
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
        //
    }
}
