<?php

namespace App\Http\Controllers;

use App\Models\VungTrong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class VungtrongController extends Controller
{
  public function index(Request $request)
  {
    $vungtrong = DB::table('sde.vung_trong')
      ->get();
    // ->pluck('shape');
    return view('pagestest.vungtrong', ['vungtrong' => $vungtrong]);
  }
  // public function create()
  // {
  //   $shape = DB::table('sde.vung_trong')
  //     ->get();
  //   return view('welcome', ['shape' => $shape]);
  // }
  public function insert(Request $request)
  {
    $shape = $request->input('shape');
    $shape = $this->removeBrackets($shape);
    $dataJson = json_encode($shape);
    $data = [
      'iddiachinh' => $request->input('iddiachinh'),

      'dientichtrong' => $request->input('dientichtrong'),
      'giongcay' => $request->input('giongcay'),
      'tuoicay' => $request->input('tuoicay'),
      'giaidoansinhtruong' => $request->input('giaidoansinhtruong'),
      'ngaytrong' => $request->input('ngaytrong'),
      'loaidat' => $request->input('loaidat'),
    ];

    $insert = DB::table('sde.vung_trong')->insert(array_merge(
      $data,
      ['shape' => $dataJson]
    ));
    return redirect()->back()->with('success', 'Cập nhật thành công');
  }


  public function removeBrackets($input)
  {
    $data = json_decode($input, true);
    return $data[0];
  }
  public function delete($id)
  {
    VungTrong::where('idvungtrong', $id)->delete();
    return response()->json(['success' => true]);
  }
  public function update(Request $request)
  {

    // $updated = DB::table('sde.vung_trong')
    //             ->where('id', $id)
    //             ->update(['name' => $request->name, 
    //                       'description' => $request->description]);

    // if($updated) {
    //   return redirect()->back()->with('success', 'Cập nhật thành công');
    // }


  }
  public function edit($id)
  {
    $vungtrong = DB::table('sde.vung_trong')->where('idvungtrong', $id)->get();
    return view('pagestest.vungtrong')->with('vungtrong', $vungtrong);
  }
  public function getId(Request $request)
  {
    $shapes = $request->input('shapes');

    // Sử dụng câu truy vấn DB để tìm kiếm một bản ghi trong bảng 'sde.vung_trong'
    // có trường 'shape' có giá trị bằng biến $shapes
    $record = DB::table('sde.vung_trong')->where('shape', $shapes)->first();

    // Nếu không tìm thấy bản ghi nào, trả về một thông báo lỗi
    if (!$record) {
      return response()->json('Không tìm thấy bản ghi phù hợp', 404);
    }
    $dientichtrong = $record->dientichtrong;
    $giongcay = $record->giongcay;
    $tuoicay = $record->tuoicay;
    $giaidoansinhtruong = $record->giaidoansinhtruong;
    $ngaytrong = $record->ngaytrong;
    $loaidat = $record->loaidat;
    $shape = $record->shape;
    $tenvungtrong = $record->tenvungtrong;
    // Lấy giá trị của trường 'idvungtrong' từ bản ghi tìm được
    $idvungtrong = $record->idvungtrong;

    // Trả về giá trị này dưới dạng JSON
    return response()->json([
      'idvungtrong' => $idvungtrong,
      'dientichtrong' => $dientichtrong,
      'giongcay' => $giongcay,
      'giaidoansinhtruong' => $giaidoansinhtruong,
      'tenvungtrong' => $tenvungtrong,
      'loaidat' => $loaidat,
      'tuoicay' => $tuoicay,
    ]);
    //   return response()->json([
    //     'idsaubenh' => $idsaubenh,
    //     'hinhanh' => $hinhanhsaubenh,
    //     'tensaubenh' => $tensaubenh,

    //     'thoigianphathien' => $thoigianphathien,
    //     'mota' => $mota,
    //     'phuongphap' => $phuongphap,

    // ]);
  }
  public function addvungtrong()
  {
    $vungtrong = DB::table('sde.vung_trong')
      ->get();

    return view('vungtrong.addvungtrong', ['vungtrong' => $vungtrong]);
  }
}
