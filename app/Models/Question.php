<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'question';

    protected $fillable = [
        'tryout_id', 'question_text'
    ];

    public function tryout(){
        $this->belongsTo(Tryout::class);
    }

    public function choice(){
        $this->hasMany(Choice::class);
    }
}
