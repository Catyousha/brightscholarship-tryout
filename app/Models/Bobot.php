<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bobot extends Model
{
    use HasFactory;
    protected $table = 'bobot';

    protected $fillable = [
        'name', 'nilai_bobot', 'has_deleted'
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
