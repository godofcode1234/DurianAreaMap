<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $get= DB::table('diadiemsatlo')->select()->get();
        return view('/welcome')->with('diadanh', $get);
    }
}
