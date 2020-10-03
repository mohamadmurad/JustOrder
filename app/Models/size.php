<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class size extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'code',
    ];

    public function orders(){
        return $this->belongsToMany(order::class,'orders_sizes');
    }

}
