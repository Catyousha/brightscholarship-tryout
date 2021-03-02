<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Sesi;
use App\Models\Tryout;
use App\Models\UserAnswer;
use App\Models\UserTryout;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class AnswerController extends Controller
{
    public function save_answer(Request $request){
        $tryout_id = $request->t_id;
        $sesi_id   = $request->s_id;
        $to = Tryout::findOrFail($tryout_id);
        if($to->tryout_status() == "Telah Berakhir"){
            return response()->json(['data' => "timeout"]);
        }

      $question_id = $request->q_id;
      $choice_id = $request->c_id;
      Session::put("tryout_{$tryout_id}_sesi_{$sesi_id}.{$question_id}", "$choice_id");
      Session::save();
      return response()->json(['data' => "jawaban tersimpan"]);

    }

    public function submit_answer(Request $request)
    {
        $tryout_id = $request->t_id;
        $sesi_id = $request->s_id;
        Gate::authorize('view', [Tryout::find($tryout_id), Sesi::find($sesi_id)]);
        $jml_soal = Sesi::find($sesi_id)->question->count();
        $score = 0;
        $answer_data = Session::get("tryout_{$tryout_id}_sesi_{$sesi_id}");

        foreach ($answer_data as $q_id => $c_id) {
            $choice = Choice::find($c_id);
            $question = Question::find($q_id);
            if($question->tryout->id == $tryout_id){
                $submitted_answer = UserAnswer::updateOrCreate([
                    'user_id' => Auth::user()->id,
                    'tryout_id'     => $tryout_id,
                    'sesi_id'       => $sesi_id,
                    'question_id'   => $q_id,
                    'choice_id'     => $c_id
                ]);
                if(!$submitted_answer){
                    return redirect()->route('tryout.soal', ['id_tryout'=>$tryout_id, 'no_soal' => 1])
                    ->with(['error' => 'Jawaban Gagal Disimpan, Coba Beberapa Saat Lagi!']);
                }

                if($choice != null){
                    if($choice->correct){
                        $score+=$question->bobot->nilai_bobot;
                    }

                }
            }
        }

        $userTO = new UserTryout();
        $userTO->user_id   = Auth::user()->id;
        $userTO->tryout_id = $tryout_id;
        $userTO->sesi_id = $sesi_id;
        $userTO->mapel_id = Sesi::find($sesi_id)->mapel_id;
        $userTO->score = $score;

        //dd($request->session()->all());
        $request->session()->forget("tryout_{$tryout_id}_sesi_{$sesi_id}");
        if($userTO->save()){
            $next_sesi = Sesi::find($sesi_id+1);
            if($next_sesi && $next_sesi->tryout_id == $tryout_id){
                return redirect()->route('tryout.soal', ['id_tryout' => $tryout_id, 'no_soal' => 1]);
            } else{
                $request->session()->forget("ongoing_tryout");
                return redirect()->route('home');
            }
        } else{
            return redirect()->route('tryout.soal', ['id_tryout'=>$tryout_id, 'no_soal' => 1])
            ->with(['error' => 'Jawaban Gagal Disimpan, Coba Beberapa Saat Lagi!']);
        }

    }
}
