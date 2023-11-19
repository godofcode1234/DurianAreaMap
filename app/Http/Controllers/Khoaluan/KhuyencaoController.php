<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BangKhuyenCao;
use Brian2694\Toastr\Facades\Toastr;

class KhuyencaoController extends Controller
{
    public function index()
    {
        $khuyencao = BangKhuyenCao::all();
        return view('pagestest.khuyencao', ['khuyencao' => $khuyencao]);
    }

    public function create()
    {
        return view('khuyencao.create');
    }

    public function store(Request $request)
    {
        BangKhuyenCao::create($request->all());
        return response(['success' => 'Employee created successfully.']);
    }

    public function edit($idkhuyencao, $idcanbo)
    {
        $khuyencao = BangKhuyenCao::findOrFail(['idkhuyencao' => $idkhuyencao, 'idcanbo' => $idcanbo]);
        return view('khuyencao.edit', compact('khuyencao'));
    }

    public function update(Request $request, $idkhuyencao, $idcanbo)
    {
        $khuyencao = BangKhuyenCao::findOrFail(['idkhuyencao' => $idkhuyencao, 'idcanbo' => $idcanbo]);
        $khuyencao->noidung = $request->input('noidung');
        $khuyencao->thoigian = $request->input('thoigian');
        $khuyencao->save();

        return redirect()->route('khuyencao.index');
    }

    public function destroy($idkhuyencao, $idcanbo)
    {
        BangKhuyenCao::where('idkhuyencao', $idkhuyencao)->where('idcanbo', $idcanbo)->delete();
        return response()->json(['success' => true]);
    }
}
