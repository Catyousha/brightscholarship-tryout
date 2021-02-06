<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'pilihan_id', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public  function scopeLike($query, $field, $value){
        return $query->where($field, 'LIKE', "%$value%");
    }

    public function pilihan(){
        return $this->hasOne(Pilihan::class, 'id', 'pilihan_id');
    }

    public function user_answer(){
        return $this->hasMany(UserAnswer::class, 'id');
    }

    public function user_tryout(){
        return $this->hasMany(UserTryout::class, 'id');
    }

    public function getFullNameAttribute()
    {
        if (is_null($this->last_name)) {
            return "{$this->name}";
        }

        return "{$this->name} {$this->last_name}";
    }

}
