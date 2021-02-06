<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
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
        $to = Tryout::find($tryout_id);
        if($to->tryout_status() == "Telah Berakhir"){
            return response()->json(['data' => "timeout"]);
        }

      $question_id = $request->q_id;
      $choice_id = $request->c_id;
      Session::put("tryout_$tryout_id.$question_id", "$choice_id");
      Session::save();
      return response()->json(['data' => "jawaban tersimpan"]);

    }

    public function submit_answer(Request $request)
    {
        Gate::authorize('view', Tryout::find($request->t_id));

        $tryout_id = $request->t_id;
        $jml_soal = Tryout::find($tryout_id)->question->count();
        $score = 0;
        $answer_data = Session::get("tryout_$tryout_id");

        foreach ($answer_data as $q_id => $c_id) {
            $choice = Choice::find($c_id);
            $question = Question::find($q_id);
            if($question->tryout->id == $tryout_id){
                $submitted_answer = UserAnswer::updateOrCreate([
                    'user_id' => Auth::user()->id,
                    'tryout_id' => $tryout_id,
                    'question_id' => $q_id,
                    'choice_id' => $c_id
                ]);
                if(!$submitted_answer){
                    return redirect()->route('tryout.soal', ['id_tryout'=>$tryout_id, 'no_soal' => 1])->with(['error' => 'Jawaban Gagal Disimpan, Coba Beberapa Saat Lagi!']);
                }

                if($choice != null){
                    if($choice->correct){
                        $score+=1;
                    }

                }
            }
        }
        $skorAkhir = ($score/$jml_soal) * 100;

        $userTO = new UserTryout();
        $userTO->user_id   = Auth::user()->id;
        $userTO->tryout_id = $tryout_id;
        $userTO->score = $skorAkhir;

        //dd($request->session()->all());
        $request->session()->forget("tryout_$tryout_id");
        if($userTO->save()){
            return redirect()->route('home')->with(['success' => 'Tryout Telah Selesai Dikerjakan! Skor: '.$skorAkhir]);
        } else{
            return redirect()->route('tryout.soal', ['id_tryout'=>$tryout_id, 'no_soal' => 1])->with(['error' => 'Jawaban Gagal Disimpan, Coba Beberapa Saat Lagi!']);
        }

    }
}
