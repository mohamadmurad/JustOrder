<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoneRequest;
use App\Http\Requests\ReDoneRequest;
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

class ReOrderController extends Controller
{

    use UploadAble;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {


        $season_id = request()->has('season_id') ? request()->get('season_id') : null;
        if (Auth::user()->isAdmin) {
            //dd(Auth::user()->department()->first()->users()->get()->pluck('id'));


            $orders = reOrder::whereHas('order', function($q) use ($season_id){
                if ($season_id !== null)  $q->where('season_id', $season_id);
            })->paginate();

        } else {

            $users_in_dep = Auth::user()->department()->first()->users()->get()->pluck('id');


            $orders = reOrder::whereHas('order', function($q) use ($users_in_dep,$season_id){
                $q->whereIn('orders.user_id', $users_in_dep);
                if ($season_id !== null)  $q->where('season_id', $season_id);
            })->paginate();
//dd($orders);
        }
        //Log::stack(['justorderReOrder'])->info('index Re order  from user (' . Auth::user()->name . ' )');

        $seasons =season::all();
        return view('reOrder.index', compact(['orders']),compact('seasons'),compact('season_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create(Request $request)
    {
        $colors = color::all()->sortBy('name');
        $sizes = size::all()->sortBy('name');
        //Log::stack(['justorderReOrder'])->info('open Re order create  from user (' . Auth::user()->name . ' )');


        if ($request->has('order')){
            $order = order::findOrFail($request->get('order'));
            return view('reOrder.create', compact([

                'colors', 'sizes', 'order' ]));
        }

        return redirect()->route('reOrder.index');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(reOrderrequest $request)
    {
// dd($request);

        $fabricDate = $request->get('fabricDate');
        $orderDate = $request->get('orderDate');
        $order_id = $request->get('order_id');


        $order = order::findOrFail($order_id);


        $siresQty = $request->get('siresQty');
        $siresItemNumber = $request->get('siresSizeQty') * $request->get('siresColorQty');
        $quantity = $siresQty * $siresItemNumber;
        $saved_files_for_roleBack = [];
        DB::beginTransaction();
        try {

//
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();

                $fileName = Str::slug(now()->format('Y-m-d') . "_reOrder_" . $order->barCode . '_1') . '.' .$extension;
                $dd= Storage::disk('img')->put($fileName,  File::get($image));

                //$saved_file = $this->upload($image, $barCode . '_1', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
                $saved_files_for_roleBack += [$fileName];

               // $saved_files_for_roleBack += [$saved_file->getFilename()];

            }
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

            $reOrderCount = reOrder::where('order_id','=',$order_id)->get()->count();

            $newOrder = reOrder::create([

                'order_id' => $order_id,
                're_order_number' => $reOrderCount + 1,
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


                'image' => $request->hasFile('image') ? $fileName : null,

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




            DB::commit();
           // $newOrder->load('order');
           // Log::stack(['justorderReOrder'])->info(' Re order created success  from user (' . Auth::user()->name . ' )');

            return redirect()->route('reOrder.show', $newOrder->id)
                ->with('success', 'تم حفظ الطلب الجديد بنجاح');

        } catch (Exception $e) {
            DB::rollBack();
            foreach ($saved_files_for_roleBack as $file) {
                if ( Storage::disk('img')->exists($file)){
                    Storage::disk('img')->delete($file);
                }

               // File::delete(public_path(config('app.PRODUCTS_FILES_PATH', 'files/products/') . str_replace(' ', '', $branch->name)) . '/' . $file);
            }
           // Log::stack(['justorderReOrder'])->error(' Re order created failed  from user (' . Auth::user()->name . ' )');


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
    public function show(reOrder $reOrder)
    {


        $reOrder->load([
            'order',
        ]);
       // Log::stack(['justorderReOrder'])->info('show Re order ( '. $reOrder->order-barcode .' ) from user (' . Auth::user()->name . ' )');


        return view('reOrder.show', compact('reOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param order $order
     * @return Response
     */
    public function edit(reOrder $reOrder)
    {
        $reOrder->load(['colors', 'sizes']);

        $years = Years::all();
        $brands = brand::all()->sortBy('name');
        $types = type::all()->sortBy('name');
        $groups = group::all()->sortBy('name');
        $subgroups = subgroup::where('group_id', '=', $reOrder->group_id)->get()->sortBy('name');
        $seasons = season::all();
        $suppliers = supplier::all()->sortBy('name');
        $colors = color::all()->sortBy('name');
        $sizes = size::all()->sortBy('name');
        $fabricSources = FabricSource::all();
        $fabrics = fabric::all()->sortBy('name');

       // Log::stack(['justorderReOrder'])->info('open edit Re order ( '. $reOrder->order-barcode .' ) from user (' . Auth::user()->name . ' )');

        return view('reOrder.edit', compact([
            'years', 'brands', 'types', 'groups', 'subgroups',
            'seasons', 'suppliers', 'colors', 'sizes', 'fabricSources', 'fabrics', 'reOrder']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param order $order
     * @return Response
     */
    public function update(Request $request, reOrder $reOrder)
    {

        $siresQty = $request->get('siresQty');
        $siresItemNumber = $request->get('siresSizeQty') * $request->get('siresColorQty');
        $quantity = $siresQty * $siresItemNumber;
        $saved_files_for_roleBack = [];
        DB::beginTransaction();
        try {


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $fileName = Str::slug(now()->format('Y-m-d') . "_reOrder_" . $reOrder->order->barCode . '_1') . '.' .$extension;
                $dd= Storage::disk('img')->put($fileName,  File::get($image));


               // File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/') . $reOrder->image));
             //   $saved_file = $this->upload($image, $barCode . '_1', public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')));
               $saved_files_for_roleBack = $fileName;

            }

            $orderDate = $request->get('orderDate');
            $fabricDate = $request->get('fabricDate');

            $reOrder->fill([


                'siresSizeQty' => $request->get('siresSizeQty'),
                'siresColorQty' => $request->get('siresColorQty'),
                'siresQty' => $siresQty,
                'siresItemNumber' => $siresItemNumber,
                'quantity' => $quantity,

                'orderDate' => $orderDate != null ? Carbon::create($orderDate)->format('Y-m-d') : $reOrder->orderDate,
                'receivedDate' => $reOrder->receivedDate,
                'fabricDate' => $fabricDate != null ? Carbon::create($request->get('fabricDate'))->format('Y-m-d') : $reOrder->fabricDate,

                'notes' => $request->get('notes'),
                'image' => $request->hasFile('image') ? $fileName : $reOrder->image,


            ]);

            $reOrder->save();

            if ($request->has('colors')) {
                $colors = $request->get('colors');
                $reOrder->colors()->sync($colors);

            }

            if ($request->has('sizes')) {
                $sizes = $request->get('sizes');
                $reOrder->sizes()->sync($sizes);


            }


            DB::commit();

        //    Log::stack(['justorderReOrder'])->info('update  Re order ( '. $reOrder->order-barcode .' ) from user (' . Auth::user()->name . ' )');

            return redirect()->route('reOrder.show', $reOrder->id)
                ->with('success', 'تم حفظ الطلب الجديد بنجاح');

        } catch (Exception $e) {
            File::delete(public_path(config('app.ORDER_FILES_PATH', 'files/Orders/')) . '/' . $saved_files_for_roleBack);
            DB::rollBack();
          //  Log::stack(['justorderReOrder'])->error('update  Re order failed from user (' . Auth::user()->name . ' )');

            return redirect()->route('reOrder.index')
                ->with('error', 'لم يتم حفظ الطلب');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param order $order
     * @return Response
     */
    public function destroy(reOrder $reOrder)
    {
       // dd($reOrder);
        $reOrder->delete();
        //Log::stack(['justorderReOrder'])->alert('delete  Re order ( '. $reOrder->order-barcode .' ) from user (' . Auth::user()->name . ' )');

        return redirect()->route('reOrder.index')
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


    public function report(Request $request)
    {

        if (Auth::user()->isAdmin) {
            $orders = order::FilterData($request)->get();
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

    public function done(ReDoneRequest $request)
    {
         //   dd('sds');

        $order = reOrder::where('id', '=', $request->get('order'))
            /*->where('done', '=', 0)*/->first();

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
       // Log::stack(['justorderReOrder'])->info('received  Re order ( '. $order->order-barcode .' ) from user (' . Auth::user()->name . ' )');

        return redirect()->route('reOrder.show',$order->id)
            ->with('success', 'تم استلام الطلب :  ');
    }




}
