<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function map()
    {
        return view('admin.qlsl.map');
    }

    public function loadPolyline()
    {

        $getData = DB::table('diadiemsatlo')->get(); 

        return view('admin.qlsl.map')->with('poly',$getData);
    }
}
