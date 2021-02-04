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

    public function user_score(){
        return $this->user_tryout->where('user_id', Auth::id())->first()->score;
    }

    public function tryout_status(){
        $time_now = now();
        $user_check = $this->user_tryout()
                                    ->where('user_id', Auth::user()->id)
                                    ->first();
        if($this->time_start > $time_now){
            return 'Dijadwalkan';
        } else if($this->time_end < $time_now){
            return 'Telah Berakhir';
        }
         else if($user_check != null){
            return 'Telah Diselesaikan';
        } else{
            return 'Sedang Berlangsung';
        }
    }

    public function tryout_css($stat){

        if($stat == 'Dijadwalkan'){
            return (object) array(
                'border_pinggir' => 'border-left-secondary',
                'teks' => 'text-secondary',
                'badge' => 'badge-secondary',
                'btn' => 'btn-secondary'
            );
        } else if($stat == 'Sedang Berlangsung'){
            return (object) array(
                'border_pinggir' => 'border-left-primary',
                'teks' => 'text-primary',
                'badge' => 'badge-primary',
                'btn' => 'btn-primary'
            );
        } else if($stat == 'Telah Berakhir'){
            return (object) array(
                'border_pinggir' => 'border-left-danger',
                'teks' => 'text-danger',
                'badge' => 'badge-danger',
                'btn' => 'btn-danger'
            );
        } else if($stat == 'Telah Diselesaikan'){
            return (object) array(
                'border_pinggir' => 'border-left-success',
                'teks' => 'text-success',
                'badge' => 'badge-success',
                'btn' => 'btn-success'
            );
        }
    }

}
