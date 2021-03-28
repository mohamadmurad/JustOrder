<?php

namespace App\Http\Livewire;

use App\Models\brand;
use App\Models\color;
use App\Models\fabric;
use App\Models\FabricSource;
use App\Models\group;
use App\Models\order;
use App\Models\reOrder;
use App\Models\season;
use App\Models\size;
use App\Models\subgroup;
use App\Models\supplier;
use App\Models\type;
use App\Models\Years;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class ReportsOrders extends Component
{

    public int $sel_year = 0 ,
        $sel_brand = 0 ,
        $sel_type = 0 ,
        $sel_group = 0 ,
        $sel_subgroup = 0 ,
        $sel_season = 0 ,
        $sel_supplier = 0 ,
        //$sel_color = 0 ,
       // $sel_size = 0 ,
        $sel_fabricSource = 0 ,
        $sel_fabric = 0 ;

    public $sel_done = 'all' ;




    public $orders = null;
    public $reOrders = null;

    public $subgroups = null;


    public function render()
    {

        $years = Years::all();
        $brands = brand::all()->sortBy('name');;
        $types = type::all()->sortBy('name');;
        $groups = group::all()->sortBy('name');;
        if($this->sel_group == 0 ){

            $this->subgroups = subgroup::all()->sortBy('name');
        }else{

            $this->subgroups = subgroup::where('group_id','=',$this->sel_group)->get()->sortBy('name');
        }

        $seasons = season::all();
        $suppliers = supplier::all()->sortBy('name');;
        $colors = color::all()->sortBy('name');;
        $sizes = size::all()->sortBy('name');
        $fabricSources = FabricSource::all();
        $fabrics = fabric::all()->sortBy('name');

        return view('livewire.reports-orders',[
            'years' => $years,
            'brands' => $brands,
            'types' => $types,
            'groups' => $groups,
            'subgroups' => $this->subgroups,
            'seasons' => $seasons,
            'suppliers' => $suppliers,
            'colors' => $colors,
            'sizes' => $sizes,
            'fabricSources' => $fabricSources,
            'fabrics' => $fabrics,
        ]);
    }

    public function updated($propertyName)
    {
        $this->submit();
    }
    public function submit(){


        $data = [
            'brand_id' => $this->sel_brand,
            'fabric_id' => $this->sel_fabric,
            'type_id' => $this->sel_type,
            'group_id' => $this->sel_group,
            'subgroup_id' => $this->sel_subgroup,
            'season_id' => $this->sel_season,
            'year_id' => $this->sel_year,
            'supplier_id' => $this->sel_supplier,
            'fabric_source_id' => $this->sel_fabricSource,
            'done' => $this->sel_done,
        ];
        if (Auth::user()->isAdmin) {

            //$this->orders = order::FilterData($data)->get();

            $this->orders = order::FilterData($data)->with(['group','type','subgroup'])->get();

            $this->reOrders = reOrder::with(['order' => function ($q) use($data){
                $q->FilterData($data);
            },'order.group','order.type','order.subgroup'])->get()->where('order','!=',null)->values();



            //  dd($orders);

        } else {
            $users_in_dep = Auth::user()->department()->first()->users()->get()->pluck('id');
            $this->orders = order::whereIn('user_id', $users_in_dep)->FilterData($data)->get();
        }


    }


}
