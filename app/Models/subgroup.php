<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subgroup extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'group_id',
        'idNum',
    ];

    public function group(){
        return $this->belongsTo(group::class);
    }


}
