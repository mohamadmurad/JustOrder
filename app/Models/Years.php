<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Years extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name'];

    public function season(){
        return $this->hasMany(season::class);
    }
}
