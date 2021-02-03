<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tryout extends Model
{
    use HasFactory;
    protected $table = 'tryout';

    protected $fillable = [
        'name', 'time_start', 'time_end'
    ];

    public $dates = ['time_start', 'time_end'];

    public function question(){
        return $this->hasMany(Question::class);
    }

    public function user_tryout(){
        return $this->hasMany(UserTryout::class);
    }

}
