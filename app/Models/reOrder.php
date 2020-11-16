<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class reOrder extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'order_id',
        're_order_number',
        'siresSizeQty',
        'siresColorQty',
        'siresQty',///
        'siresItemNumber',///
        'quantity',///
        'reservedQuantity',
        'receivedQty',
        'orderDate',
        'reservedDate',
        'fabricDate',
        'done',
        'notes',
        'image',



    ];

    protected $dates = [
        'orderDate',
        'reservedDate',
    ];

    public function order(){
        return $this->belongsTo(order::class);
    }


    // many - to - many
    public function colors(){
        return $this->belongsToMany(color::class,'reOrders_colors','reOrder_id');
    }

    public function sizes(){
        return $this->belongsToMany(size::class,'reOrders_sizes','reOrder_id');
    }


}
