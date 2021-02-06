<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilihan extends Model
{
    use HasFactory;
    protected $table = 'pilihan';

    protected $fillable = [
        'name'
    ];

    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function tryout(){
        return $this->belongsToMany(Tryout::class);
    }
}
