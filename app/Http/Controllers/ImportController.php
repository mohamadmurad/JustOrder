<?php

namespace App\Http\Controllers;

use App\Imports\OrderImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function index(){

        return view('imports.index');
    }

    public function import(Request $request){

        if ($request->has('excel')){

            Excel::import(new OrderImport, $request->file('excel'));

            return redirect()->route('import.index')->with('success', 'All good!');



        }else{

        }



    }
}
