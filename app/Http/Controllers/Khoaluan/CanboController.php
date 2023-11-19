<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CanboController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {
    // Lấy danh sách từ bảng sde.can_bo_quan_ly
    $canbos = DB::table('sde.can_bo_quan_ly')->get();

    return view('canbo.canbo', ['banguser' => $canbos]);
  }
  public function show()
  {
    $userId = Auth::id();
    $getData = DB::table('sde.can_bo_quan_ly')->where('id', $userId)->get();
    return view('admin.account.profile')->with('getUserById', $getData);
  }
  public function create()
  {
    // Hiển thị form thêm mới
    return view('admin.account.create');
  }

  public function add(Request $request)
  {
    // Kiểm tra trùng username
    $existingUser = DB::table('sde.can_bo_quan_ly')->where('username', $request->username)->first();

    if ($existingUser) {
      Toastr::error('Username đã tồn tại');
      return redirect()->back();
    }

    // Insert dữ liệu vào bảng
    $insertData = DB::table('sde.can_bo_quan_ly')->insert([
      'tencanbo' => $request->tencanbo,
      'username' => $request->username,
      'sdt' => $request->sdt,
      'password' => $request->password,
      'chucvu' => $request->chucvu
    ]);

    if ($insertData) {
      Toastr::success('Thêm thành công');
    } else {
      Toastr::error('Thêm không thành công');
    }

    return redirect('admin');
  }

  public function edit($id)
  {
    // Lấy dữ liệu cần sửa 
    $getData = DB::table('sde.can_bo_quan_ly')->where('idcanbo', $id)->get();

    // Trả về view edit
    return view('canbo.canbo')->with('banguser', $getData);
  }

  public function update(Request $request)
  {
    // Kiểm tra trùng username
    $existingUser = DB::table('sde.can_bo_quan_ly')
      ->where('username', $request->username)
      ->where('idcanbo', '!=', $request->idcanbo)
      ->first();

    if ($existingUser) {
      Toastr::error('Username đã tồn tại');
      return redirect()->route('canbo.index');
    }

    // Cập nhật dữ liệu
    $updateData = DB::table('sde.can_bo_quan_ly')->where('idcanbo', $request->idcanbo)->update([
      'tencanbo' => $request->tencanbo,
      'username' => $request->username,
      'sdt' => $request->sdt
    ]);

    if ($updateData) {
      Toastr::success('Cập nhật thành công');
    } else {
      Toastr::error('Cập nhật không thành công');
    }

    return redirect('admin');
  }

  public function destroy($id)
  {
    // Xóa dữ liệu
    $deleteData = DB::table('sde.can_bo_quan_ly')->where('idcanbo', $id)->delete();

    if ($deleteData) {
      Toastr::success('Xóa thành công');
    } else {
      Toastr::error('Xóa không thành công');
    }

    return redirect('admin');
  }
}
