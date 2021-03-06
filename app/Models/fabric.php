<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fabric extends Model
{
    use Loggable;
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
    ];

    public $timestamps = false;


    public function orders(){
        return $this->belongsToMany(order::class,'orders_fabrics');
    }
}
