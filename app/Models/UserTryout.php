<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTryout extends Model
{
    use HasFactory;
    protected $table = 'user_tryout';
    protected $fillable = [
        'user_id', 'tryout_id', 'score'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tryout(){
        return $this->belongsTo(Tryout::class);
    }

    public function sesi(){
        return $this->hasOne(Sesi::class);
    }
}
