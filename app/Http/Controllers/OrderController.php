<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoneRequest;
use App\Http\Requests\reOrderrequest;
use App\Http\Requests\StoreOrderRequest;
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
use App\Models\User;
use App\Models\Years;
use App\Traits\UploadAble;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderController extends Controller
{

    use UploadAble;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {

        Log::stack(['justorder'])->info('index order from user ( ' . Auth::user()->name . ' )');

        if (Auth::user()->isAdmin) {
            //dd(Auth::user()->department()->first()->users()->get()->pluck('id'));


            $orders = order::with('user')->paginate();
            $totalOrderQty = order::all()->sum('quantity');
            $totalOrderreceivedQty = order::all()->sum('receivedQty');
        } else {

            $users_in_dep = Auth::user()->department()->first()->users()->get()->pluck('id');
            $orders = order::whereIn('user_id', $users_in_dep)->paginate();
            $totalOrderQty = order::whereIn('user_id', $users_in_dep)->sum('quantity');
            $totalOrderreceivedQty = order::whereIn('user_id', $users_in_dep)->sum('receivedQty');

        }

        //


        //  dd($today10);
        // dd($notification);
        return view('order.index', compact(['orders', 'totalOrderQty', 'totalOrderreceivedQty']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {

        Log::stack(['justorder'])->info('open create order from user ( ' . Auth::user()->name . ' )');

        $years = Years::all();
        $brands = brand::all()->sortBy('name');
        $types = type::all()->sortBy('name');
        $groups = group::all()->sortBy('name');

        $subgroups = subgroup::where('group_id', '=', $groups->first()->id)->get()->sortBy('name');
        $seasons = season::all();
        $suppliers = supplier::all()->sortBy('name');
        $colors = color::all()->sortBy('name');
        $sizes = size::all()->sortBy('name');
        $fabricSources = FabricSource::all();
        $fabrics = fabric::all()->sortBy('name');
        return view('order.create', compact([
            'years', 'brands', 'types', 'groups', 'subgroups',
            'seasons', 'suppliers', 'colors', 'sizes', 'fabricSources', 'fabrics']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreOrderRequest $request)
    {

       // dd($request['fabric_id']);

        // dd($request);
        $year = Years::findOrFail($request->get('year_id'));
        $yearCode = Carbon::create($year->name)->format('y');
        $orderDate = $request->get('orderDate');
        $season = season::findOrFail($request->get('season_id'));
        $supplier = supplier::findOrFail($request->get('supplier_id'));
        $subGroup = subgroup::findOrFail($request->get('subgroup_id'));
        $group = group::findOrFail($request->get('group_id'));
        $brand = brand::findOrFail($request->get('brand_id'));
        $brandCode = substr($brand->name, 0, 1);
        $type = type::findOrFail($request->get('type_id'));
        $typeCode = substr($type->name, 0, 1); //////////
        $fabricDate = $request->get('fabricDate');

        $sequenceNumber = 1;
        $exitsNumberOfSubGroup = order::where('subgroup_id', '=', $subGroup->id)
            ->where('brand_id', '=', $brand->id)
            ->where('year_id', '=', $year->id)
            ->where('season_id', '=', $season->id)
            ->where('type_id', '=', $type->id)
            ->where('group_id', '=', $group->id)
            ->orderBy('barcode', 'desc')->get();

        if (count($exitsNumberOfSubGroup) == 0) {
            $sequenceNumber = 1;
        } else {
            $oldBarcode = $exitsNumberOfSubGroup->first()->barcode;
            $lastNumber = intval(substr($oldBarcode, 7, 3));
            $sequenceNumber = $lastNumber + 1;
        }

        if($sequenceNumber > (count($exitsNumberOfSubGroup)+1)){
            $ss = 1;
            $mm = $exitsNumberOfSubGroup->sortBy('barcode');

            foreach ($mm as $temp_order){
                $oldBarcode = $temp_order->barcode;
                $lastNumber = intval(substr($oldBarcode, 7, 3));

                if($ss < $lastNumber){

                    break;

                }
                $ss++;
            }

            $sequenceNumber = $ss;
        }

        $sequenceNumber = sprintf('%03u', $sequenceNumber);

        $barCode = $yearCode . $season->id . $typeCode . $brandCode . $group->id . $subGroup->idNum . $sequenceNumber . $supplier->code;



        $siresQty = $request->get('siresQty');
        $siresItemNumber = $request->get('siresSizeQty') * $request->get('siresColorQty');
        $quantity = $siresQty * $siresItemNumber;
        $saved_files_for_roleBack = [];
        DB::beginTransaction();
        try {


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::slug(now()->format('Y-m-d') . "_" . $barCode . '_1') . '.' . $extension;
                $dd = Storage::disk('img')->put($fileName, File::get($image));

                //$saved_file = $this->upload($image, $barCode . '_1', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                // $saved_files_for_roleBack += [$saved_file->getFilename()];

                $saved_files_for_roleBack += [$fileName];

            }

            if ($request->hasFile('image2')) {
                $image = $request->file('image2');
                $extension = $image->getClientOriginalExtension();
                $fileName1 = Str::slug(now()->format('Y-m-d') . "_" . $barCode . '_2') . '.' . $extension;
                $dd = Storage::disk('img')->put($fileName1, File::get($image));

                //$saved_file2 = $this->upload($image, $barCode . '_2', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                // $saved_files_for_roleBack += [$saved_file2->getFilename()];
                $saved_files_for_roleBack += [$fileName1];
            }

            if ($request->hasFile('image3')) {
                $image = $request->file('image3');
                $extension = $image->getClientOriginalExtension();
                $fileName2 = Str::slug(now()->format('Y-m-d') . "_" . $barCode . '_3') . '.' . $extension;
                $dd = Storage::disk('img')->put($fileName2, File::get($image));

                // $saved_file3 = $this->upload($image, $barCode . '_3', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                //$saved_files_for_roleBack += [$saved_file3->getFilename()];
                $saved_files_for_roleBack += [$fileName2];
            }


            $newOrder = order::create([

                'barcode' => $barCode,
                'modelName' => $request->get('modelName'),
                'modelDesc' => $request->get('modelDesc'),
                'siresSizeQty' => $request->get('siresSizeQty'),
                'siresColorQty' => $request->get('siresColorQty'),
                'siresQty' => $siresQty,
                'siresItemNumber' => $siresItemNumber,
                'quantity' => $quantity,
                //'reservedQuantity' => 0,
                'receivedQty' => 0,
                'fabricFormula' => $request->get('fabricFormula'),
                //'siresNumber'  => $request->get('siresNumber'),
                //'itemsNumber'  => $request->get('itemsNumber'),
                //'orderDate'  => Carbon::now()->format('Y-m-d'),//////
                'orderDate' => $orderDate != null ? Carbon::create($orderDate)->format('Y-m-d') : Carbon::now()->format('Y-m-d'),

                'fabricDate' => $fabricDate != null ? Carbon::create($request->get('fabricDate'))->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
                'done' => 0,
                'notes' => $request->get('notes'),
                'PrintNotes' => $request->get('PrintNotes'),
                //'image' => $request->hasFile('image') ? $saved_file->getFilename() : null,
                'image' => $request->hasFile('image') ? $fileName : null,
                //'image2' => $request->hasFile('image2') ? $saved_file2->getFilename() : null,
                'image2' => $request->hasFile('image2') ? $fileName1 : null,
                // 'image3' => $request->hasFile('image3') ? $saved_file3->getFilename() : null,
                'image3' => $request->hasFile('image3') ? $fileName2 : null,


                'brand_id' => $request->get('brand_id'),
                //'fabric_id'=> $request->get('fabric_id')[0],
                'type_id' => $request->get('type_id'),
                'group_id' => $request->get('group_id'),
                'subgroup_id' => $subGroup->id,
                'season_id' => $request->get('season_id'),
                'year_id' => $request->get('year_id'),
                'supplier_id' => $request->get('supplier_id'),
                'fabric_source_id' => $request->get('fabricSource_id'),
                'user_id' => Auth::id(),

            ]);


            if ($request->has('colors')) {
                $colors = $request->get('colors');

                foreach ($colors as $color) {
                    $newOrder->colors()->attach($color);
                }
            }

            if ($request->has('sizes')) {
                $sizes = $request->get('sizes');
                foreach ($sizes as $size) {
                    $newOrder->sizes()->attach($size);
                }

            }


            if ($request->has('fabric_id')) {
                $fabrics = $request->get('fabric_id');

                foreach ($fabrics as $fabric) {
                    $newOrder->fabrics()->attach($fabric);
                }
            }


            DB::commit();

            Log::stack(['justorder'])->info('create order ( ' . $newOrder->barcode . ' ) success from user ( ' . Auth::user()->name . ' )');

            return redirect()->route('order.show', $newOrder->id)
                ->with('success', 'تم حفظ الطلب الجديد بنجاح');

        } catch (Exception $e) {
            foreach ($saved_files_for_roleBack as $file) {
                if (Storage::disk('img')->exists($file)) {

                    Storage::disk('img')->delete($file);

                }

                // File::delete(public_path(config('app.PRODUCTS_FILES_PATH', 'files/products/') . str_replace(' ', '', $branch->name)) . '/' . $file);
            }
            // File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $saved_files_for_roleBack);
            DB::rollBack();
            Log::stack(['justorder'])->error('order not created from user ( ' . Auth::user()->name . ' )');

            return redirect()->route('order.index')
                ->with('error', 'لم يتم حفظ الطلب');
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
            'fabrics',
        ]);

        Log::stack(['justorder'])->info('showing order ( '. $order->barcode .' ) from user ( ' . Auth::user()->name . ' )');

        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param order $order
     * @return Response
     */
    public function edit(order $order)
    {
        $order->load(['colors', 'sizes','fabrics']);

        $years = Years::all();
        $brands = brand::all()->sortBy('name');
        $types = type::all()->sortBy('name');
        $groups = group::all()->sortBy('name');
        $subgroups = subgroup::where('group_id', '=', $order->group_id)->get()->sortBy('name');
        $seasons = season::all();
        $suppliers = supplier::all()->sortBy('name');
        $colors = color::all()->sortBy('name');
        $sizes = size::all()->sortBy('name');
        $fabricSources = FabricSource::all();
        $fabrics = fabric::all()->sortBy('name');

        Log::stack(['justorder'])->info('open edit order ( '. $order->barcode .' ) from user ( ' . Auth::user()->name . ' )');

       // dd($order);
        return view('order.edit', compact([
            'years', 'brands', 'types', 'groups', 'subgroups',
            'seasons', 'suppliers', 'colors', 'sizes', 'fabricSources', 'fabrics', 'order']));
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

        $year = Years::findOrFail($request->get('year_id'));
        $yearCode = Carbon::create($year->name)->format('y');
        $orderDate = $request->get('orderDate');
        $season = season::findOrFail($request->get('season_id'));
        $supplier = supplier::findOrFail($request->get('supplier_id'));
        $subGroup = subgroup::findOrFail($request->get('subgroup_id'));
        $group = group::findOrFail($request->get('group_id'));
        $brand = brand::findOrFail($request->get('brand_id'));
        $brandCode = substr($brand->name, 0, 1);
        $type = type::findOrFail($request->get('type_id'));
        $typeCode = substr($type->name, 0, 1); //////////
        $fabricDate = $request->get('fabricDate');


        $sequenceNumber = 1;
        $order->fill([
            'brand_id' => $request->get('brand_id'),
            'type_id' => $request->get('type_id'),
            'group_id' => $request->get('group_id'),
            'subgroup_id' => $subGroup->id,
            'season_id' => $request->get('season_id'),
            'year_id' => $request->get('year_id'),

        ]);
        $barCode = null;

        if (!$order->isClean()) {
            $exitsNumberOfSubGroup = order::where('id', '!=', $order->id)
                ->where('subgroup_id', '=', $subGroup->id)
                ->where('brand_id', '=', $brand->id)
                ->where('year_id', '=', $year->id)
                ->where('season_id', '=', $season->id)
                ->where('type_id', '=', $type->id)
                ->where('group_id', '=', $group->id)
                ->orderBy('barcode', 'desc')->get();
            // dd($exitsNumberOfSubGroup);
            if (count($exitsNumberOfSubGroup) == 0) {
                $sequenceNumber = 1;
            } else {
                $oldBarcode = $exitsNumberOfSubGroup->first()->barcode;
                $lastNumber = intval(substr($oldBarcode, 7, 3));
                $sequenceNumber = $lastNumber + 1;
            }

            if($sequenceNumber > (count($exitsNumberOfSubGroup)+1)){
                $ss = 1;
                $mm = $exitsNumberOfSubGroup->sortBy('barcode');

                foreach ($mm as $temp_order){
                    $oldBarcode = $temp_order->barcode;
                    $lastNumber = intval(substr($oldBarcode, 7, 3));
                    //  dump($lastNumber);
                    if($ss < $lastNumber){
                        // dump('break');
                        break;

                    }
                    $ss++;
                }

                $sequenceNumber = $ss;
            }


            $sequenceNumber = sprintf('%03u', $sequenceNumber);

            $barCode = $yearCode . $season->id . $typeCode . $brandCode . $group->id . $subGroup->idNum . $sequenceNumber;

            $barCode .= $supplier->code;


        }

        if ($order->isClean() && $order->supplier_id != $supplier->id) {

            $barCode = substr($order->barcode, 0, -3);

            $barCode .= $supplier->code;

        }

        if ($barCode === null) {
            $barCode = $order->barcode;
        }
        $siresQty = $request->get('siresQty');
        $siresItemNumber = $request->get('siresSizeQty') * $request->get('siresColorQty');
        $quantity = $siresQty * $siresItemNumber;
        $saved_files_for_roleBack = [];
        DB::beginTransaction();
        try {


            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $dd = Storage::disk('img')->delete($order->image);
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::slug(now()->format('Y-m-d') . "_" . $barCode . '_1') . '.' . $extension;
                $dd = Storage::disk('img')->put($fileName, File::get($image));


                // File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/') . $order->image));
                // $saved_file = $this->upload($image, $barCode . '_1', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                // $saved_files_for_roleBack += [$saved_file->getFilename()];

                $saved_files_for_roleBack += [$fileName];

            }

            if ($request->hasFile('image2')) {
                $image = $request->file('image2');
                $dd = Storage::disk('img')->delete($order->image2);
                $extension = $image->getClientOriginalExtension();
                $fileName1 = Str::slug(now()->format('Y-m-d') . "_" . $barCode . '_2') . '.' . $extension;
                $dd = Storage::disk('img')->put($fileName1, File::get($image));
                // File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/') . $order->image2));

                // $saved_file2 = $this->upload($image, $barCode . '_2', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                // $saved_files_for_roleBack += [$saved_file2->getFilename()];

                $saved_files_for_roleBack += [$fileName1];
            }

            if ($request->hasFile('image3')) {
                $image = $request->file('image3');

                $dd = Storage::disk('img')->delete($order->image2);
                $extension = $image->getClientOriginalExtension();
                $fileName2 = Str::slug(now()->format('Y-m-d') . "_" . $barCode . '_3') . '.' . $extension;
                $dd = Storage::disk('img')->put($fileName2, File::get($image));

                //File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/') . $order->image3));
                // $saved_file3 = $this->upload($image, $barCode . '_3', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                //$saved_files_for_roleBack += [$saved_file3->getFilename()];

                $saved_files_for_roleBack += [$fileName2];
            }


            $order->fill([

                'barcode' => $barCode ? $barCode : $order->barcode,
                'modelName' => $request->get('modelName'),
                'modelDesc' => $request->get('modelDesc'),
                'siresSizeQty' => $request->get('siresSizeQty'),
                'siresColorQty' => $request->get('siresColorQty'),
                'siresQty' => $siresQty,
                'siresItemNumber' => $siresItemNumber,
                'quantity' => $quantity,
                //'reservedQuantity' =>0,
                'receivedQty' => $order->receivedQty,
                'fabricFormula' => $request->get('fabricFormula'),
                //'siresNumber'  => $request->get('siresNumber'),
                //'itemsNumber'  => $request->get('itemsNumber'),
                //'orderDate'  => Carbon::now()->format('Y-m-d'),
                'orderDate' => $orderDate != null ? Carbon::create($orderDate)->format('Y-m-d') : $order->orderDate,
                'receivedDate' => $order->receivedDate,
                'fabricDate' => $fabricDate != null ? Carbon::create($request->get('fabricDate'))->format('Y-m-d') : $order->fabricDate,
                'done' => $order->done,
                'notes' => $request->get('notes'),
                'PrintNotes' => $request->get('PrintNotes'),
                //'image' => $request->hasFile('image') ? $saved_file->getFilename() : $order->image,
                'image' => $request->hasFile('image') ? $fileName : $order->image,
                //'image2' => $request->hasFile('image2') ? $saved_file2->getFilename() : $order->image2,
                'image2' => $request->hasFile('image2') ? $fileName1 : $order->image2,
                //'image3' => $request->hasFile('image3') ? $saved_file3->getFilename() : $order->image3,
                'image3' => $request->hasFile('image3') ? $fileName2 : $order->image3,


                'supplier_id' => $request->get('supplier_id'),
                //'fabric_id'=> $request->get('fabric_id'),

                'fabric_source_id' => $request->get('fabricSource_id'),

            ]);

            $order->save();

            if ($request->has('colors')) {
                $colors = $request->get('colors');
                $order->colors()->sync($colors);

            }

            if ($request->has('sizes')) {
                $sizes = $request->get('sizes');
                $order->sizes()->sync($sizes);


            }

            if ($request->has('fabric_id')) {
                $fabrics = $request->get('fabric_id');
                $order->fabrics()->sync($fabrics);

            }


            DB::commit();
            Log::stack(['justorder'])->info('update order ( '. $order->barcode .' ) from user ( ' . Auth::user()->name . ' )');

            return redirect()->route('order.show', $order->id)
                ->with('success', 'تم حفظ الطلب الجديد بنجاح');

        } catch (Exception $e) {
            File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $saved_files_for_roleBack);
            DB::rollBack();

            Log::stack(['justorder'])->error('update  order  ( '. $order->barcode .' ) failed from user ( ' . Auth::user()->name . ' )');

            return redirect()->route('order.index')
                ->with('error', 'لم يتم حفظ الطلب');
        }

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
        Log::stack(['justorder'])->alert('delete  order  ( '. $order->barcode .' )  from user ( ' . Auth::user()->name . ' )');

        return redirect()->route('order.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }

    public function searchOrder(Request $request)
    {


        if (!$request->has('barcode')) {
            return redirect()->route('order.index');
        }
        $barcode = $request->get('barcode');

        if (Auth::user()->isAdmin) {
            //dd(Auth::user()->department()->first()->users()->get()->pluck('id'));

            $order = order::where('barcode', '=', $barcode)->with([
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


        } else {
            $users_in_dep = Auth::user()->department()->first()->users()->get()->pluck('id');
            $order = order::whereIn('user_id', $users_in_dep)->where('barcode', '=', $barcode)->with([
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
        }


        if (!$order) {
            return redirect()->route('order.index')
                ->with('search', 'لا يوجد نتيجة');
        }


        return view('order.show', compact('order'));


    }

    public function reportApi(Request $request)
    {

        //dd($request->all());
        $user = User::findOrFail($request->get('Auth_id'))->first();

        if ($user->isAdmin) {

            $orders = order::FilterData($request)->with(['group','type','subgroup']);
            $reOrders = reOrder::with(['order' => function ($q) use($request){
                $q->FilterData($request);
            },'order.group','order.type','order.subgroup'])->get()->where('order','!=',null)->values();
            if ($request->has('done')) {

                $done = $request->get('done');

                if ($done !== 'all') {
                    $orders = $orders->where('done', '=', intval($done));
                    $reOrders = $reOrders->where('done', '=', intval($done));
                }
            }

            //  $reOrders = reOrder::with('order')->whereIn('order_id',$orders->pluck('id'));



            //$reOrders = $reOrders->get();
            $orders = $orders->get();
            //  dd($orders);

        } else {
            $users_in_dep = $user->department()->first()->users()->get()->pluck('id');
            $orders = order::whereIn('user_id', $users_in_dep)->FilterData($request)->with(['group','type','subgroup']);

            $reOrders = reOrder::with(['order' => function ($q) use($request){
                $q->FilterData($request);
            },'order.group','order.type','order.subgroup'])->get()->where('order','!=',null)->values();;


            //$reOrders = reOrder::with('order')->whereIn('order_id', $orders->pluck('id'));

            if ($request->has('done')) {
                $done = $request->get('done');
                if ($done !== 'all') {
                    $orders = $orders->where('done', '=', intval($done));
                    $reOrders = $reOrders->where('done', '=', intval($done));
                }
            }
            $orders = $orders->get();
           // $reOrders = $reOrders->get();
        }


        return \response()->json(
            [
                'data' => [
                    'orders' => $orders,
                    'reOrders' => $reOrders,
                ],
            ]
        );
    }

    public function report(Request $request)
    {

        if (Auth::user()->isAdmin) {

            $orders = order::FilterData($request)->get();
            //  dd($orders);

        } else {
            $users_in_dep = Auth::user()->department()->first()->users()->get()->pluck('id');
            $orders = order::whereIn('user_id', $users_in_dep)->FilterData($request)->get();
        }

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
        return view('home', compact(['orders',
            'years', 'brands', 'types', 'groups', 'subgroups',
            'seasons', 'suppliers', 'colors', 'sizes', 'fabricSources', 'fabrics', 'report']));


    }

    public function done(DoneRequest $request)
    {


        $order = order::where('id', '=', $request->get('order'))
            /*->where('done', '=', 0)*/ ->first();

        $receivedQty = $request->get('receivedQty');
        /*if ($receivedQty < $order->quantity) {
            $order->fill([
                'done' => 0,
                'receivedQty' => $receivedQty,
                'receivedDate' => Carbon::now()->format('Y-m-d'),
            ]);
        } else {
            $order->fill([
                'done' => 1,
                'receivedQty' => $receivedQty,
                'receivedDate' => Carbon::now()->format('Y-m-d'),
            ]);
        }*/


        $order->fill([
            'done' => 1,
            'receivedQty' => $receivedQty + $order->receivedQty,
            'receivedDate' => Carbon::now()->format('Y-m-d'),
        ]);

        $order->update();

        Log::stack(['justorder'])->info('receive order Barcode ( ' . $order->barcode . ' ) with QTY ( ' . $order->receivedQty . ' ) from user ( ' . Auth::user()->name . ' )');

        return redirect()->route('order.show',$order->id)
            ->with('success', 'تم استلام الطلب :  ');
    }


    public function createReOrder(Request $request, order $order)
    {

        $colors = color::all()->sortBy('name');
        $sizes = size::all()->sortBy('name');
        Log::stack(['justorder'])->info('open re  order  ( '. $order->barcode .' )  from user ( ' . Auth::user()->name . ' )');

        return view('order.reCreate', compact([

            'colors', 'sizes', 'order']));


    }

    public function reOrderShow(Request $request, reOrder $order)
    {
        $order->load([
            'order',
        ]);


        return view('order.reShow', compact('order'));

    }


    public function reOrder(reOrderrequest $request)
    {

        // dd($request);

        $fabricDate = $request->get('fabricDate');
        $orderDate = $request->get('orderDate');
        $order_id = $request->get('order_id');

        $siresQty = $request->get('siresQty');
        $siresItemNumber = $request->get('siresSizeQty') * $request->get('siresColorQty');
        $quantity = $siresQty * $siresItemNumber;
        // $saved_files_for_roleBack = [];
        DB::beginTransaction();
        try {

//
//            if ($request->hasFile('image')) {
//                $image = $request->file('image');
//                $saved_file = $this->upload($image, $barCode . '_1', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
//                $saved_files_for_roleBack += [$saved_file->getFilename()];
//
//            }
//
//            if ($request->hasFile('image2')) {
//                $image = $request->file('image2');
//                $saved_file2 = $this->upload($image, $barCode . '_2', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
//                $saved_files_for_roleBack += [$saved_file2->getFilename()];
//            }
//
//            if ($request->hasFile('image3')) {
//                $image = $request->file('image3');
//                $saved_file3 = $this->upload($image, $barCode . '_3', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
//                $saved_files_for_roleBack += [$saved_file3->getFilename()];
//            }


            $newOrder = reOrder::create([

                'order_id' => $order_id,
                'siresSizeQty' => $request->get('siresSizeQty'),
                'siresColorQty' => $request->get('siresColorQty'),
                'siresQty' => $siresQty,
                'siresItemNumber' => $siresItemNumber,
                'quantity' => $quantity,

                'receivedQty' => 0,

                'orderDate' => $orderDate != null ? Carbon::create($orderDate)->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
                'fabricDate' => $fabricDate != null ? Carbon::create($request->get('fabricDate'))->format('Y-m-d') : Carbon::now()->format('Y-m-d'),

                'done' => 0,
                'notes' => $request->get('notes'),


            ]);


            if ($request->has('colors')) {
                $colors = $request->get('colors');

                foreach ($colors as $color) {
                    $newOrder->colors()->attach($color);
                }
            }

            if ($request->has('sizes')) {
                $sizes = $request->get('sizes');
                foreach ($sizes as $size) {
                    $newOrder->sizes()->attach($size);
                }

            }

            Log::stack(['justorderReOrder'])->info('Re order  ( ' . $newOrder->order->barcode . ' ) from user (' . Auth::user()->name . ' )');


            DB::commit();
            $newOrder->load('order');
            return redirect()->route('reOrderShow', $newOrder->id)
                ->with('success', 'تم حفظ الطلب الجديد بنجاح');

        } catch (Exception $e) {
            DB::rollBack();
            Log::stack(['justorderReOrder'])->error('Re order failed ( ' . $newOrder->order->barcode . ' ) from user (' . Auth::user()->name . ' )');


            return redirect()->route('order.index')
                ->with('error', 'لم يتم حفظ الطلب');
        }


    }

}
