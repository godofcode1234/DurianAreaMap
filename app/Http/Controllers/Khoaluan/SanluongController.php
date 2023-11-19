<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Brian2694\Toastr\Facades\Toastr;
class SanluongController extends Controller
{
    // Lấy danh sách 
public function getList() {
    return DB::table('san_luong')->get();
  }
  
  // Thêm mới  
  public function create($vungTrongId, $thoiGianThuHoach, $soLuong, $donGia, $chiPhi, $loiNhuan) {
    return DB::table('san_luong')->insert([
      'idvungtrong' => $vungTrongId,
      'thoigianthuhoach' => $thoiGianThuHoach, 
      'soluong' => $soLuong,
      'dongia' => $donGia,
      'chiphi' => $chiPhi,
      'loinhuan' => $loiNhuan
    ]);
  }
  
  // Cập nhật  
  public function update($id, $data) {
    return DB::table('san_luong')
            ->where('idsanluong', $id)
            ->update($data);
  }
  
  // Xóa
  public function delete($id) {
    return DB::table('san_luong')
           ->where('idsanluong', $id)
           ->delete(); 
  }
}
