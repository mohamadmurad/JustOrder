<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'barcode',
        'modelName',
        'modelDesc',
        'siresSizeQty',
        'siresColorQty',
        'siresQty',///
        'siresItemNumber',///
        'quantity',///
        'reservedQuantity',
        'receivedQty',
        'fabricFormula',
        'siresNumber',
        'itemsNumber',
        'orderDate',
        'reservedDate',
        'fabricDate',
        'done',
        'notes',
        'image',
        'image2',
        'image3',
        'user_id',


        'brand_id',
        'fabric_id',
        'type_id',
        'group_id',
        'subgroup_id',
        'season_id',
        'year_id',
        'supplier_id',
        'fabric_source_id',

    ];

    protected $dates = [
        'orderDate',
        'reservedDate',
    ];


    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::deleting(function ($order){
           File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/'). $order->image));
           File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/'). $order->image2));
           File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/'). $order->image3));
        });

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('group_id', 'ASC')
                ->orderBy('subgroup_id', 'ASC')
                ->orderBy('brand_id', 'ASC')
                ->orderBy('type_id', 'ASC')
                ->orderBy('season_id', 'ASC')
                ->orderBy('year_id', 'ASC');

        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function brand(){
        return $this->belongsTo(brand::class);
    }

    public function fabric(){
        return $this->belongsTo(fabric::class);
    }

    public function type(){
        return $this->belongsTo(type::class);
    }

    public function group(){
        return $this->belongsTo(group::class);
    }

    public function subgroup(){
        return $this->belongsTo(subgroup::class);
    }

    public function season(){
        return $this->belongsTo(season::class);
    }

    public function year(){
        return $this->belongsTo(Years::class);
    }

    public function supplier(){
        return $this->belongsTo(supplier::class);
    }

    public function fabricSource(){
        return $this->belongsTo(FabricSource::class);
    }


    // many - to - many
    public function colors(){
        return $this->belongsToMany(color::class,'orders_colors');
    }

    public function sizes(){
        return $this->belongsToMany(size::class,'orders_sizes');
    }


    public function scopeFilterData($query,$request){
        $columns = ['brand_id',
            'fabric_id',
            'type_id',
            'group_id',
            'subgroup_id',
            'season_id',
            'year_id',
            'supplier_id',
            'fabric_source_id',

            ];


        foreach ($columns as $column){
            $col_request = $request->get($column);

            if (!empty($col_request)){

                if ($col_request !== '0'){

                    $query->where($column,'=', $col_request);
                }

            }
        }

        if ($request->has('done')){

            $done = $request->get('done');

            if ($done !== 'all'){
                $query->where('done','=', intval($done));
            }
        }


        return $query;
    }


}
