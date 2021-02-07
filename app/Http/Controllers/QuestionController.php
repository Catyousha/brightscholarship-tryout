<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Observers\UserAnswerObserver;
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
        $this->validate($request, [
            'f_question_text'     => 'required',
            'f_correct'           => 'required',
         ]);

         $soal = new Question();
         $soal->tryout_id     = $request->f_tryout_id;
         $soal->sesi_id      = $request->f_sesi_id;
         $soal->mapel_id      = $request->f_mapel_id;
         $soal->question_text = $request->f_question_text;
         $soal->question_num  = $request->f_question_num;
         if(!$soal->save()){
            return redirect()->route('tryout.edit', $request->f_tryout_id)->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
         }

         $i = 0;
         foreach ($request->f_choice_symbol as $c) {
            $choice = Choice::create([
                'question_id' => $soal->id,
                'choice_text' => $request->f_choice_text[$i],
                'choice_symbol' => $c,
                'correct' => ($request->f_correct == $c) ? 1 : 0,
            ]);
            if(!$choice){
                return redirect()->route('sesi.edit', $request->f_sesi_id)->with(['error' => 'Terjadi kesalahan, coba beberapa saat lagi...']);
            }

            $i++;
         }

         return redirect()->route('sesi.edit', $request->f_sesi_id)->with(['success' => 'Soal berhasil ditambahkan!']);

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


            $userAnswer = UserAnswer::where('choice_id', $cid)->get();
            $obs = new UserAnswerObserver();
            foreach ($userAnswer as $u) {
                $obs->perbaiki_skor($u);
            }

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
        $soal = Question::findOrFail($id);
        $no_soal = $soal->question_num;
        $id_to = $soal->tryout_id;

        $soal->choice()->delete();
        $soal->delete();

        $soal_next = Question::where([
            ['question_num', '>', $no_soal],
            ['tryout_id', '=', $id_to],
        ]);
        $soal_next->decrement('question_num');

        $userAnswer = UserAnswer::where('question_id', $id);
        $obs = new UserAnswerObserver();
        foreach ($userAnswer->get() as $u) {
            $obs->perbaiki_skor($u);
        }
        $userAnswer->delete();

        return response()->json(['data' => "success"]);
    }
}
