<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'type_id',
    ];


    public function type(){
        return $this->belongsTo(type::class);
    }

    public function subgroup(){
        return $this->hasMany(subgroup::class);
    }



}
