<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FabricSource extends Model
{
    use HasFactory;
    public $timestamps = false;
  //  protected $table = 'FabricSource';
    protected $fillable = ['name'];
}
