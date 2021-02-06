<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $table = 'mapel';

    protected $fillable = [
        'name'
    ];

    public function question(){
        return $this->belongsToMany(Question::class);
    }

    public function sesi(){
        return $this->hasMany(Sesi::class);
    }
}
