<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class season extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'start',
        'end',
        'year_id',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    protected $dateFormat = 'Y-m-d';


    public function year(){
        return $this->belongsTo(Years::class);
    }


}
