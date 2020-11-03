<?php

namespace App\Http\Controllers;

use App\Models\order;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

        $today10 = Carbon::now()->subDays(10)->format('Y-m-d');
        $today20 = Carbon::now()->subDays(20)->format('Y-m-d');
        $notification = order::where('done','=',0)->where(function ($query) use ($today10,$today20){
            $query->whereDate('orderDate', '>', $today10);
                //->orWhereDate('orderDate', '=', $today20);
        })->get(['barcode','image','orderDate','id']);
        View::share('notification',$notification);

    }
}
