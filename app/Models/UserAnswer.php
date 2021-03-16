<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;
    protected $table = 'user_answer';
    protected $fillable = [
        'user_id', 'tryout_id', 'sesi_id', 'question_id', 'choice_id'
    ];

    public function question(){
        return $this->hasOne(Question::class, 'id', 'question_id')->orderBy('question_num');;
    }

    public function choice(){
        return $this->hasOne(Choice::class, 'id', 'choice_id');
    }

    public function tryout(){
        return $this->hasMany(Tryout::class, 'id', 'tryout_id');
    }

    public function sesi(){
        return $this->hasMany(Sesi::class, 'id', 'sesi_id');
    }

    public function checkCorrect(){
        return $this->choice->correct;
    }

}
