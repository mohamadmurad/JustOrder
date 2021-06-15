<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\FabricSourceController;
use App\Http\Controllers\YearsController;
use App\Http\Middleware\CheckLicence;
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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => []], function () {
    Route::get('login',[LoginController::class,'create'])->name('login');
    Route::post('login',[LoginController::class,'store'])->name('loginStore');
    Route::get('/', function () {

        if (Auth::user()){
            if ( Auth::user()->isAdmin) {
                //dd(Auth::user()->department()->first()->users()->get()->pluck('id'));


                $orders = order::with('user')->orderBy('id', 'desc')->take(5)->get();
                $totalOrderQty = order::all()->sum('quantity');
                $totalOrderreceivedQty = order::all()->sum('receivedQty');

                $notReceivedOrderQty = order::where('receivedQty',0)->count();
                $reOrderCount = \App\Models\reOrder::all()->count();
            } else {

                $users_in_dep = Auth::user()->department()->first()->users()->get()->pluck('id');
                $orders = order::whereIn('user_id', $users_in_dep)->orderBy('id', 'desc')->take(5)->get();
                $totalOrderQty = order::whereIn('user_id', $users_in_dep)->sum('quantity');
                $totalOrderreceivedQty = order::whereIn('user_id', $users_in_dep)->sum('receivedQty');
                $notReceivedOrderQty = order::whereIn('user_id', $users_in_dep)->where('receivedQty',0)->count();


                $reOrderCount = reOrder::whereHas('order', function($q) use ($users_in_dep){
                    $q->whereIn('orders.user_id', $users_in_dep);

                })->count();
            }

            return view('home', compact(['orders',
                'totalOrderQty','totalOrderreceivedQty','notReceivedOrderQty','reOrderCount']));
        }

        return view('home');




    })->name('home');


    Route::get('report',function (){


        return view('report');

    })->name('report');
});



Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('order', \App\Http\Controllers\OrderController::class);
    Route::post('/searchOrder', [\App\Http\Controllers\OrderController::class, 'searchOrder'])->name('searchOrderPost');
    Route::get('/searchOrder', [\App\Http\Controllers\OrderController::class, 'searchOrder'])->name('searchOrder');
    Route::post('/', [\App\Http\Controllers\OrderController::class, 'report'])->name('orderReport');
    Route::post('/orderDone', [\App\Http\Controllers\OrderController::class, 'done'])->name('orderDone');
    Route::post('/reOrderDone', [\App\Http\Controllers\ReOrderController::class, 'done'])->name('reOrderDone');
    Route::resource('fabric', \App\Http\Controllers\FabricController::class);

    Route::resource('reOrder', \App\Http\Controllers\ReOrderController::class);
    // Route::post('/reOrder',[\App\Http\Controllers\OrderController::class,'reOrder'])->name('reorder');
    //  Route::get('/reOrder/{order}',[\App\Http\Controllers\OrderController::class,'createReOrder'])->name('createReOrder');
    //   Route::get('/reOrderShow/{order}',[\App\Http\Controllers\OrderController::class,'reOrderShow'])->name('reOrderShow');
    Route::resource('supplier', \App\Http\Controllers\SupplierController::class);
    Route::resource('color', ColorController::class);
});

Route::group(['middleware' => ['auth:sanctum', 'isAdminMiddleware']], function () {

    Route::resource('FabricSource', FabricSourceController::class);
    //Route::resource('fabric',\App\Http\Controllers\FabricController::class);
    Route::resource('years', YearsController::class);

    Route::resource('brand', \App\Http\Controllers\BrandController::class);
    Route::resource('type', \App\Http\Controllers\TypeController::class);
    Route::resource('size', \App\Http\Controllers\SizeController::class);
    Route::resource('group', \App\Http\Controllers\GroupController::class);
    Route::resource('subgroup', \App\Http\Controllers\SubgroupController::class);
    Route::resource('season', \App\Http\Controllers\SeasonController::class);
    Route::resource('users', \App\Http\Controllers\UsersController::class);

    Route::resource('departments', \App\Http\Controllers\DepartmentsController::class);


    Route::get('li',[\App\Http\Controllers\LicenceController::class,'index']);

    Route::post('li', [\App\Http\Controllers\LicenceController::class,'registerLicence'])->name('licenceMake');

    Route::get('/import_excel',[\App\Http\Controllers\ImportController::class,'index'])->name('import.index');

    Route::post('/import_excel',[\App\Http\Controllers\ImportController::class,'import'])->name('import.import');


    Route::get('/git_pull',[\App\Http\Controllers\LicenceController::class,'gitPull'])->name('git.pull');


});

Route::get('/down',[\App\Http\Controllers\LicenceController::class,'down']);
Route::get('/up',[\App\Http\Controllers\LicenceController::class,'up']);
