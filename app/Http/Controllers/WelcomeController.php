<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $getData = DB::table('diadiemsatlo')->join('hinhanh', 'diadiemsatlo.madiadiem', '=', 'hinhanh.madiadiem')
        ->join('video', 'diadiemsatlo.madiadiem', '=', 'video.madiadiem')
        ->select('diadiemsatlo.*', 'hinhanh', 'video')->get(); 
        return view('/welcome')->with('diadanh', $getData);
    }
}
