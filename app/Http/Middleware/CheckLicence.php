<?php

namespace App\Http\Middleware;

use Carbon\Traits\Date;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CheckLicence
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        if (!File::exists(env('Licence_dir','E:\Mhd') . '\\' .env('Licence_file','Mhd2021.li'))){
            Artisan::call('down --secret="153759"');
            return $next($request);
        }else{
            Artisan::call('up');
            return $next($request);
//            $data = Carbon::now()->addDay(5);
//          //  dump($data);
//            $file = fopen(env('Licence_file','E:\GoLicence\go2021.li'),'wr');
//            $f = fwrite($file,$data,200);
//            fclose($file);

           // dump($f);


            // licence
//            $file = fopen(env('Licence_file','E:\GoLicence\go2021.li'),'r');
//
//            $data  = fread($file,200);
//
//         //   dd($data);
//            $licence_date = Carbon::make($data);
//
//            if ($licence_date < Carbon::now()){
//                Artisan::call('down --secret="153759"');
//            }else{
//                return $next($request);
//            }
            return $next($request);
        }
        return $next($request);
    }
}
