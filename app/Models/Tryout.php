<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function tryout_status(){
        $time_now = now();
        $user_check = Tryout::find(1)->user_tryout()
                                     ->where('user_id', Auth::user()->id)
                                     ->first();
        if($this->time_start > $time_now){
            return 'Dijadwalkan';
        } else if($user_check != null){
            return 'Telah Diselesaikan';
        } else{
            return 'Sedang Berlangsung';
        }
    }

    public function tryout_css(){
        //wip
    }

}
