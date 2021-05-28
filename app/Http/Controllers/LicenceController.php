<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;

class LicenceController extends Controller
{

    public function index(){


        $f = null;
       // $localDir = dirname(sys_get_temp_dir());
        //$MeroSoftDir = $localDir . '\\Mero Soft';
        //$ProjectDir = $MeroSoftDir . '\\' . config('app.name');


        /*if (file_exists($ProjectDir . '\\' . config('app.name') . '.li') && !Auth::user()->isAdmin){
                return redirect('/');
        }


        if (file_exists($ProjectDir . '\\' . config('app.name') . '.li')){
            $file = fopen($ProjectDir . '\\' . config('app.name') . '.li', 'r');
            $f = fread($file, 200);

            fclose($file);

        }*/

        if (file_exists( config('app.name') . '.li') && !Auth::user()->isAdmin){
                return redirect('/');
        }


        if (file_exists(config('app.name') . '.li')){
            $file = fopen( config('app.name') . '.li', 'r');
            $f = fread($file, 200);

            fclose($file);

        }




        return view('licence.make',compact('f'));
    }

    public function registerLicence(Request $request){

        $localDir = dirname(sys_get_temp_dir());
        $MeroSoftDir = $localDir . '\\Mero Soft';
        $ProjectDir = $MeroSoftDir . '\\' . config('app.name');

       /* if (!file_exists($MeroSoftDir)) {
            mkdir($MeroSoftDir);
        }

        if (!file_exists($ProjectDir)) {
            mkdir($ProjectDir);
        }*/

        if ($request->has('date')){
            $data =  Carbon::make(  $request->get('date') );
        }else{
            $data =  Carbon::now();
        }

        if (!file_exists( config('app.name') . '.li')){
            $file = fopen( config('app.name') . '.li', 'w');
            $f = fwrite($file, $data, 200);
            fclose($file);
        }



        return redirect('/');
    }

    public function down(){

        Artisan::call('down --secret="153759"');
        return redirect()->route('login');
    }

    public function up(){

        Artisan::call('up');
        return redirect()->route('login');


    }

    public function gitPull(){


    }

}
