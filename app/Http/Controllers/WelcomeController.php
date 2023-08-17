<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $getData = DB::table('diadiemsatlo')->get(); 
        return view('/welcome')->with('diadanh', $getData);
    }
}
