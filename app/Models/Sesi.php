<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory;

    protected $table = 'sesi';

    protected $fillable = [
        'tryout_id', 'mapel_id', 'time_start', 'time_end'
    ];

    public $dates = ['time_start', 'time_end'];

    public function tryout(){
        return $this->belongsTo(Tryout::class);
    }

    public function mapel(){
        return $this->belongsTo(Mapel::class);
    }

    public function question(){
        return $this->hasMany(Question::class);
    }
}
