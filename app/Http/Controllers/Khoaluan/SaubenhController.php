<?php

namespace App\Http\Controllers;

use App\Models\Hinhanhsaubenh;
use App\Models\SauBenh;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SauBenhController extends Controller
{
    public function index()
    {
        $saubenh = SauBenh::all();
        return view('pagestest.saubenh')->with('saubenh', $saubenh);
    }
    public function hinhanhsaubenhpopup($id)
    {
        $image = SauBenh::select('hinhanh')->where('idsaubenh', $id)->get();
        return view('welcome')->with('hinhanh', $image);
    }
    // public function create()
    // {
    //     $shapesaubenh =  SauBenh::all();
    //     return view('welcome', ['shapesaubenh' => $shapesaubenh]);
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tensaubenh' => 'required|max:50',

            'thoigianphathien' => 'required',
            'mota' => 'nullable',
            'phuongphap' => 'nullable'
        ]);
        $shape = $request->input('shapesaubenh');
        $shape = $this->removeBrackets($shape);
        $dataJson = json_encode($shape);

        $sauBenh = new SauBenh;

        $sauBenh->tensaubenh = $validatedData['tensaubenh'];

        $sauBenh->thoigianphathien = $validatedData['thoigianphathien'];
        $sauBenh->phuongphap = $validatedData['phuongphap'];
        $sauBenh->mota = $validatedData['mota'];
        $sauBenh->shapesaubenh = $dataJson;
        $isSaved = $sauBenh->save();
        if ($isSaved) {

            // Get the ID of the new SauBenh record
            $image = $request->file('hinhanh');
            if ($image) {
                foreach ($image as $i) {
                    $idhinhanh = rand(1, 1000);
                    $imageName = time() . rand(1, 1000) . '.' . $i->getClientOriginalExtension();
                    $path = $i->move(public_path('images'), $imageName);
                    $Hinhanh = new Hinhanhsaubenh();
                    $layidsaubenh = SauBenh::where('shapesaubenh', $dataJson)->first();
                    $idsaubenh = $layidsaubenh->idsaubenh;
                    $Hinhanh->hinhanhsaubenh = $imageName;
                    $Hinhanh->idsaubenh = $idsaubenh; // Use the ID of the new SauBenh record
                    $Hinhanh->idhinhanh = $idhinhanh;
                    $Hinhanh->save();
                }
            }
        }



        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function removeBrackets($input)
    {
        $data = json_decode($input, true);
        return $data[0];
    }

    public function show(SauBenh $sauBenh)
    {
        return view('test', compact('sauBenh'));
    }

    public function edit($id)
    {
        $saubenh = SauBenh::where('idsaubenh', $id)->get();
        return view('pagestest.saubenh')->with('saubenh', $saubenh);
    }

    public function update(Request $request, SauBenh $sauBenh)
    {
        $validatedData = $request->validate([


            'tensaubenh' => 'required|max:20',

            'thoigianphathien' => 'required',
            'hinhanh' => 'nullable|integer',
            'mota' => 'nullable',
            'phuongphap' => 'nullable'

        ]);

        $sauBenh->update($validatedData);
        return redirect()->route('test')->with('success', 'Dữ liệu đã được cập nhật thành công.');
    }

    public function destroy(SauBenh $sauBenh)
    {
        $sauBenh->delete();
        return redirect()->route('test')->with('success', 'Dữ liệu đã được xóa thành công.');
    }
    public function delete($id)
    {
        SauBenh::where('idsaubenh', $id)->delete();
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }
    public function getIdsaubenh(Request $request)
    {
        $shapes = $request->input('shapesaubenh');
        $record = SauBenh::where('shapesaubenh', $shapes)->first();
        if (!$record) {
            return response()->json('Không tìm thấy bản ghi phù hợp', 404);
        }
        $idsaubenh = $record->idsaubenh;

        $tensaubenh = $record->tensaubenh;

        $thoigianphathien = $record->thoigianphathien;
        $mota = $record->mota;
        $phuongphap = $record->phuongphap;
        $idvungtrong = $record->idvungtrong;

        $findhinh = Hinhanhsaubenh::where('idsaubenh', $idsaubenh)->get();
        if ($findhinh) {
            $hinhanhsaubenh = [];
            foreach ($findhinh as $hinh) {
                $hinhanhsaubenh[] = $hinh->hinhanhsaubenh;
            }
        } else {
            $hinhanhsaubenh[] = 'null';
        }
        return response()->json([
            'idsaubenh' => $idsaubenh,
            'hinhanh' => $hinhanhsaubenh,
            'tensaubenh' => $tensaubenh,

            'thoigianphathien' => $thoigianphathien,
            'mota' => $mota,
            'phuongphap' => $phuongphap,

        ]);
    }
}
