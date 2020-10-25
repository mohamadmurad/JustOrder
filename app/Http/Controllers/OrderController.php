<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoneRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\brand;
use App\Models\color;
use App\Models\fabric;
use App\Models\FabricSource;
use App\Models\group;
use App\Models\order;
use App\Models\season;
use App\Models\size;
use App\Models\subgroup;
use App\Models\supplier;
use App\Models\type;
use App\Models\Years;
use App\Traits\UploadAble;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class OrderController extends Controller
{

    use UploadAble;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $orders = order::paginate();


      //  dd($today10);
       // dd($notification);
        return view('order.index',compact(['orders']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $years = Years::all();
        $brands = brand::all()->sortBy('name');
        $types = type::all()->sortBy('name');
        $groups = group::all()->sortBy('name');
        $subgroups = subgroup::all()->sortBy('name');
        $seasons = season::all();
        $suppliers = supplier::all()->sortBy('name');
        $colors = color::all()->sortBy('name');
        $sizes = size::all()->sortBy('name');
        $fabricSources = FabricSource::all();
        $fabrics = fabric::all()->sortBy('name');
        return view('order.create',compact([
            'years','brands','types','groups','subgroups',
            'seasons','suppliers','colors','sizes','fabricSources','fabrics']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreOrderRequest $request)
    {
        $year = Years::findOrFail($request->get('year_id'));
        $yearCode = Carbon::create($year->name)->format('y');

        $season = season::findOrFail($request->get('season_id'));
        $supplier = supplier::findOrFail($request->get('supplier_id'));
        $subGroup = subgroup::findOrFail($request->get('subgroup_id'));
        $group = group::findOrFail($request->get('group_id'));
        $brand = brand::findOrFail($request->get('brand_id'));
        $brandCode = substr($brand->name, 0, 1);
        $type = type::findOrFail($request->get('type_id'));
        $typeCode = substr($type->name, 0, 1); //////////

        $sequenceNumber = 1;
        $exitsNumberOfSubGroup = order::where('subgroup_id','=',$subGroup->idNum)
            ->where('brand_id','=',$brand->id)->orderBy('id','desc')->get();


        if ( count($exitsNumberOfSubGroup) == 0){
            $sequenceNumber = 1 ;
        }else{
            $oldBarcode = $exitsNumberOfSubGroup->first()->barcode;
            $lastNumber = intval(substr($oldBarcode, 7,3));
            $sequenceNumber = $lastNumber+1;
        }

        $sequenceNumber = sprintf('%03u', $sequenceNumber);

        $barCode = $yearCode . $season->id . $typeCode . $brandCode . $group->id .$subGroup->idNum . $sequenceNumber . $supplier->code;


        $siresQty = $request->get('siresColorQty') *  $request->get('siresSizeQty');
        $saved_files_for_roleBack = [];
        DB::beginTransaction();
        try {



            if ( $request->hasFile('image')){
                $image = $request->file('image');
                    $saved_file = $this->upload($image, $barCode.'_1', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                    $saved_files_for_roleBack += [$saved_file->getFilename()];

            }

            if ( $request->hasFile('image2')){
                $image = $request->file('image2');
                $saved_file2 = $this->upload($image, $barCode.'_2', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                $saved_files_for_roleBack += [$saved_file2->getFilename()];
            }

            if ( $request->hasFile('image3')){
                $image = $request->file('image3');
                $saved_file3 = $this->upload($image, $barCode.'_3', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                $saved_files_for_roleBack += [$saved_file3->getFilename()];
            }


            $newOrder = order::create([

                'barcode' => $barCode,
                'modelName' => $request->get('modelName'),
                'modelDesc'  => $request->get('modelDesc'),
                'siresSizeQty' => $request->get('siresSizeQty'),
                'siresColorQty' =>  $request->get('siresColorQty'),
                'siresQty' => $siresQty,
                'quantity' => 0,
                'reservedQuantity' => $request->get('reservedQuantity'),
                'receivedQty' =>0,
                'fabricFormula' => $request->get('fabricFormula'),
                //'siresNumber'  => $request->get('siresNumber'),
                //'itemsNumber'  => $request->get('itemsNumber'),
                'orderDate'  => Carbon::now()->format('Y-m-d'),
                //'reservedDate'  => Carbon::create($request->get('reservedDate'))->format('Y-m-d'),
                'fabricDate' => Carbon::create($request->get('fabricDate'))->format('Y-m-d'),
                'done'  => 0,
                'notes'  => $request->get('notes'),
                'image'  =>  $request->hasFile('image') ? $saved_file->getFilename() : null,
                'image2'  =>  $request->hasFile('image2') ? $saved_file2->getFilename() : null,
                'image3'  =>  $request->hasFile('image3') ? $saved_file3->getFilename() : null,


                'brand_id' => $request->get('brand_id'),
                'fabric_id'=> $request->get('fabric_id'),
                'type_id' => $request->get('type_id'),
                'group_id' => $request->get('group_id'),
                'subgroup_id' => $request->get('subgroup_id'),
                'season_id' => $request->get('season_id'),
                'year_id' => $request->get('year_id'),
                'supplier_id' => $request->get('supplier_id'),
                'fabric_source_id' => $request->get('fabricSource_id'),

            ]);


            $colors = $request->get('colors');
            foreach ($colors as $color){
                $newOrder->colors()->attach($color);
            }

            $sizes = $request->get('sizes');
            foreach ($sizes as $size){
                $newOrder->sizes()->attach($size);
            }



            DB::commit();

            return redirect()->route('order.show',$newOrder->id)
                ->with('success','تم حفظ الطلب الجديد بنجاح');

        }catch (Exception $e){
            File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $saved_files_for_roleBack);
            DB::rollBack();

            return redirect()->route('order.index')
                ->with('error','لم يتم حفظ الطلب');
        }




    }

    /**
     * Display the specified resource.
     *
     * @param order $order
     * @return Response
     */
    public function show(order $order)
    {
        $order->load([
            'brand',
            'fabric',
            'type',
            'group',
            'subgroup',
            'season',
            'year',
            'supplier',
            'fabricSource',
        ]);

        return view('order.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param order $order
     * @return Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param order $order
     * @return Response
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param order $order
     * @return Response
     */
    public function destroy(order $order)
    {
        $order->delete();

        return redirect()->route('order.index')
            ->with('success','تم حذف الطلب بنجاح');
    }

    public function searchOrder(Request $request){


        if (!$request->has('barcode')){
            return redirect()->route('order.index');
        }
        $barcode = $request->get('barcode');

        $order = order::where('barcode','=',$barcode)->with([
            'brand',
            'fabric',
            'type',
            'group',
            'subgroup',
            'season',
            'year',
            'supplier',
            'fabricSource',
        ])->first();

        if (!$order){
            return redirect()->route('order.index')
                ->with('search','لا يوجد نتيجة');
        }





        return view('order.show',compact('order'));


    }


    public function report(Request $request){

            $orders = order::FilterData($request)->paginate();
            $report = true;
        $years = Years::all();
        $brands = brand::all()->sortBy('name');
        $types = type::all()->sortBy('name');
        $groups = group::all()->sortBy('name');
        $subgroups = subgroup::all()->sortBy('name');
        $seasons = season::all();
        $suppliers = supplier::all()->sortBy('name');
        $colors = color::all()->sortBy('name');
        $sizes = size::all()->sortBy('name');
        $fabricSources = FabricSource::all();
        $fabrics = fabric::all()->sortBy('name');
        return view('home',compact([ 'orders',
            'years','brands','types','groups','subgroups',
            'seasons','suppliers','colors','sizes','fabricSources','fabrics','report']));


    }

    public function done(DoneRequest $request){



        $order = order::where('id','=',$request->get('order'))
        ->where('done','=',0)->first();

        $receivedQty = $request->get('receivedQty');
        if ($receivedQty < $order->reservedQuantity){
            $order->fill([
                'done' => 0,
                'receivedQty' => $receivedQty,
                'reservedDate' => Carbon::now()->format('Y-m-d'),
            ]);
        }elseif($receivedQty == $order->reservedQuantity){
            $order->fill([
                'done' => 1,
                'receivedQty' => $receivedQty,
                'reservedDate' => Carbon::now()->format('Y-m-d'),
            ]);
        }else{
            return redirect()->route('order.index');
        }
        //$order->done = 1;


        $order->update();

        return redirect()->route('order.index')
            ->with('success','تم استلام الطلب :  ' );
    }

}
