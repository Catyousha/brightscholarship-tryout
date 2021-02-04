<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
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
        //
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
        $soal = Question::findOrFail($id);
        return view('question.edit', compact('soal'));
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
        $soal = Question::findOrFail($id);
        $update_soal = $soal->update([
            'question_text' => $request->f_question_text
        ]);

        if(!$update_soal){
            return redirect()->route('soal.edit', $id)->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
        }

        $i = 0;
        foreach ($request->f_choice_id as $cid) {
            $choice = Choice::find($cid);
            $upd_choice = $choice->update([
                'choice_text' => $request->f_choice_text[$i],
                'correct' => ($request->f_correct == $choice->choice_symbol) ? 1 : 0
            ]);
            $i++;
            if(!$upd_choice){
                return redirect()->route('soal.edit', $id)->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
            }
        }

        return redirect()->route('soal.edit', $id)->with(['success' => 'Soal berhasil diubah!']);

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
