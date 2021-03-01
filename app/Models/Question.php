<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'question';

    protected $fillable = [
        'tryout_id', 'mapel_id', 'sesi_id', 'question_num', 'question_text', 'bobot_id'
    ];

    public function tryout(){
        return $this->belongsTo(Tryout::class);
    }

    public function mapel(){
        return $this->hasOne(Mapel::class);
    }

    public function sesi(){
        return $this->belongsTo(Sesi::class);
    }

    public function choice(){
        return $this->hasMany(Choice::class);
    }

    public function bobot(){
        return $this->hasOne(Bobot::class, 'id', 'bobot_id');
    }
}
