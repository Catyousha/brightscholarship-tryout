<?php

namespace App\Observers;

use App\Models\Choice;
use App\Models\Tryout;
use App\Models\UserAnswer;
use App\Models\UserTryout;
use Illuminate\Support\Facades\Auth;

class UserAnswerObserver
{
    public function perbaiki_skor(UserAnswer $userAnswer){
        $usertryout   =  UserTryout::where('user_id', $userAnswer->user_id)->where('tryout_id', $userAnswer->tryout_id)->first();
        $jml_soal     =  Tryout::find($userAnswer->tryout_id)->question->count();
        $soal_dijawab =  UserAnswer::where('tryout_id', $userAnswer->tryout_id)->where('user_id', $userAnswer->user_id)->get();
        $jml_benar    =  0;

        foreach ($soal_dijawab as $s) {

            if(Choice::find($s->choice_id)->correct ?? false){
                $jml_benar += 1;
            }
        }

        $usertryout->score = ($jml_benar/$jml_soal) * 100;
        $usertryout->save();
    }

    /**
     * Handle the UserAnswer "created" event.
     *
     * @param  \App\Models\UserAnswer  $userAnswer
     * @return void
     */
    public function created(UserAnswer $userAnswer)
    {
        //$this->perbaiki_skor($userAnswer);
    }

    /**
     * Handle the UserAnswer "updated" event.
     *
     * @param  \App\Models\UserAnswer  $userAnswer
     * @return void
     */
    public function updated(UserAnswer $userAnswer)
    {
        //$this->perbaiki_skor($userAnswer);
    }

    /**
     * Handle the UserAnswer "deleted" event.
     *
     * @param  \App\Models\UserAnswer  $userAnswer
     * @return void
     */
    public function deleted(UserAnswer $userAnswer)
    {
        //$this->perbaiki_skor($userAnswer);
    }

    /**
     * Handle the UserAnswer "restored" event.
     *
     * @param  \App\Models\UserAnswer  $userAnswer
     * @return void
     */
    public function restored(UserAnswer $userAnswer)
    {
        //$this->perbaiki_skor($userAnswer);
    }

    /**
     * Handle the UserAnswer "force deleted" event.
     *
     * @param  \App\Models\UserAnswer  $userAnswer
     * @return void
     */
    public function forceDeleted(UserAnswer $userAnswer)
    {
        //$this->perbaiki_skor($userAnswer);
    }
}
