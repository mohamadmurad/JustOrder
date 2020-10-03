<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fabric extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
    ];

    public $timestamps = false;
}
