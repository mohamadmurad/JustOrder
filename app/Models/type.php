<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'MGR',
    ];


    public function groups(){
        return $this->hasMany(group::class);
    }
}
