<?php

use App\Http\Controllers\ColorController;
use App\Http\Controllers\FabricSourceController;
use App\Http\Controllers\YearsController;
use App\Models\brand;
use App\Models\color;
use App\Models\fabric;
use App\Models\FabricSource;
use App\Models\group;
use App\Models\season;
use App\Models\size;
use App\Models\subgroup;
use App\Models\supplier;
use App\Models\type;
use App\Models\Years;
use Illuminate\Support\Carbon;
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

Route::get('/', function () {
    $years = Years::all();
    $brands = brand::all()->sortBy('name');;
    $types = type::all()->sortBy('name');;
    $groups = group::all()->sortBy('name');;
    $subgroups = subgroup::all()->sortBy('name');;
    $seasons = season::all();
    $suppliers = supplier::all()->sortBy('name');;
    $colors = color::all()->sortBy('name');;
    $sizes = size::all()->sortBy('name');
    $fabricSources = FabricSource::all();
    $fabrics = fabric::all()->sortBy('name');;
    return view('home',compact([
        'years','brands','types','groups','subgroups',
        'seasons','suppliers','colors','sizes','fabricSources','fabrics']));

})->name('home');








Route::group(['middleware' => ['auth:sanctum']],function (){
    Route::resource('order',\App\Http\Controllers\OrderController::class);
    Route::post('/searchOrder',[\App\Http\Controllers\OrderController::class,'searchOrder'])->name('searchOrder');
    Route::get('/searchOrder',[\App\Http\Controllers\OrderController::class,'searchOrder'])->name('searchOrder');
    Route::post('/',[\App\Http\Controllers\OrderController::class,'report'])->name('orderReport');
    Route::post('/orderDone',[\App\Http\Controllers\OrderController::class,'done'])->name('orderDone');
    Route::post('/reOrderDone',[\App\Http\Controllers\ReOrderController::class,'done'])->name('reOrderDone');
    Route::resource('fabric',\App\Http\Controllers\FabricController::class);

    Route::resource('reOrder',\App\Http\Controllers\ReOrderController::class);
   // Route::post('/reOrder',[\App\Http\Controllers\OrderController::class,'reOrder'])->name('reorder');
  //  Route::get('/reOrder/{order}',[\App\Http\Controllers\OrderController::class,'createReOrder'])->name('createReOrder');
 //   Route::get('/reOrderShow/{order}',[\App\Http\Controllers\OrderController::class,'reOrderShow'])->name('reOrderShow');



});

Route::group(['middleware' => ['auth:sanctum','isAdminMiddleware']],function (){
    Route::resource('color',ColorController::class);
    Route::resource('FabricSource',FabricSourceController::class);
    //Route::resource('fabric',\App\Http\Controllers\FabricController::class);
    Route::resource('years',YearsController::class);
    Route::resource('supplier',\App\Http\Controllers\SupplierController::class);
    Route::resource('brand',\App\Http\Controllers\BrandController::class);
    Route::resource('type',\App\Http\Controllers\TypeController::class);
    Route::resource('size',\App\Http\Controllers\SizeController::class);
    Route::resource('group',\App\Http\Controllers\GroupController::class);
    Route::resource('subgroup',\App\Http\Controllers\SubgroupController::class);
    Route::resource('season',\App\Http\Controllers\SeasonController::class);
    Route::resource('users',\App\Http\Controllers\UsersController::class);

    Route::resource('departments',\App\Http\Controllers\DepartmentsController::class);


    Route::get('li',function (){

       return view('licence.make');

    });

    Route::post('li',function (\Illuminate\Http\Request $request){
       // dd($request->get('date'));
        if (!file_exists(env('Licence_dir','E:\Mhd'))){
            mkdir(env('Licence_dir','E:\Mhd'));
        }
       // dd(is_dir(env('Licence_dir','E:\Mhd')));
        $data = Carbon::make($request->get('date'));

            $file = fopen(env('Licence_dir','E:\Mhd') . '\\' .env('Licence_file','Mhd2021.li'),'wr');
            $f = fwrite($file,$data,200);
            fclose($file);

            return redirect('/');
    })->name('licenceMake');
});
