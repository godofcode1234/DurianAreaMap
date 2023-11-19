<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Brian2694\Toastr\Facades\Toastr;
class TuvanController extends Controller
{
    // Lấy danh sách bản ghi
public function getList() {
    return DB::table('Bảng tư vấn')->get(); 
  }
  
  // Thêm mới bản ghi
  public function create($nongDanId, $tuVanId, $noiDung, $thoiGian, $canBoId) {
    return DB::table('Bảng tư vấn')->insert([
      'id nông dân' => $nongDanId,
      'id tư vấn' => $tuVanId, 
      'nội dung' => $noiDung,
      'thời gian' => $thoiGian,
      'id cán bộ' => $canBoId
    ]);
  } 
  
  // Cập nhật bản ghi 
  public function update($id, $data) {
    return DB::table('Bảng tư vấn')
            ->where('id', $id)
            ->update($data);
  }
  
  // Xóa bản ghi
  public function delete($id) {
    return DB::table('Bảng tư vấn')
            ->where('id', $id)
            ->delete();
  }
}
