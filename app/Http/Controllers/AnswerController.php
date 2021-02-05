<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Tryout;
use App\Models\UserAnswer;
use App\Models\UserTryout;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AnswerController extends Controller
{
    public function save_answer(Request $request){
      $request->session()->put("$request->t_id.$request->q_id", $request->c_id);
      return response()->json(['data' => "Jawaban tersimpan"]);
    }

    public function submit_answer(Request $request)
    {
        Gate::authorize('view', Tryout::find($request->t_id));

        $tryout_id = $request->t_id;
        $jml_soal = Tryout::find($tryout_id)->question->count();
        $score = 0;
        foreach ($request->session()->get("$tryout_id") as $q_id => $c_id) {
            $choice = Choice::find($c_id);
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
        $skorAkhir = ($score/$jml_soal) * 100;

        $userTO = new UserTryout();
        $userTO->user_id   = Auth::user()->id;
        $userTO->tryout_id = $tryout_id;
        $userTO->score = $skorAkhir;

        if($userTO->save()){
            return redirect()->route('home')->with(['success' => 'Tryout Telah Selesai Dikerjakan! Skor: '.$skorAkhir]);
        } else{
            return redirect()->route('tryout.soal', ['id_tryout'=>$tryout_id, 'no_soal' => 1])->with(['error' => 'Jawaban Gagal Disimpan, Coba Beberapa Saat Lagi!']);
        }

    }
}