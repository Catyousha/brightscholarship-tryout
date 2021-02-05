<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;
    protected $table = 'choice';

    protected $fillable = [
        'question_id', 'choice_symbol', 'choice_text', 'correct'
    ];

    protected $attributes = [
        'correct' => false,
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user_answer(){
        return $this->belongsTo(UserAnswer::class, 'id');
    }
}
