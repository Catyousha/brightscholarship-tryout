<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;
    protected $table = 'user_answer';
    protected $fillable = [
        'user_id', 'tryout_id', 'question_id', 'choice_id'
    ];

    public function question(){
        return $this->hasOne(Question::class);
    }

    public function choice(){
        return $this->hasOne(Choice::class);
    }

    public function tryout(){
        return $this->hasMany(Tryout::class);
    }

    public function checkCorrect(){
        return $this->choice->correct;
    }

}
