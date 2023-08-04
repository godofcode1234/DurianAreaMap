<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class CommuneController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index($mahuyen)
	{
		//Lấy danh sách huyen từ database
		$getData = DB::table('xa')->select()->where('mahuyen', $mahuyen)->get();
		$data = DB::table('huyen')->select('tenhuyen')->where('mahuyen', $mahuyen)->get();
		//Gọi đến file district.blade.php trong thư mục "resources/views/admin" với giá trị gửi đi tên huyen = $getData
		return view('admin.commune.detail')->with('xa', $getData)->with('huyen', $data);
	}

	public function list()
	{
		$getData = DB::table('xa')
			->join('huyen', 'xa.mahuyen', '=', 'huyen.mahuyen')
			->select('xa.mahuyen', 'huyen.tenhuyen', 'xa.maxa', 'xa.tenxa')
			->get();
		return view('admin.commune.list')->with('xa', $getData);
	}

	public function create()
	{
		//Hiển thị trang thêm 
		$getData = DB::table('huyen')->select()->get();
		return view('admin.commune.create')->with('huyen',$getData);
	}

	public function add(Request $request)
	{
		$lateId = DB::table('xa')->select('id')->orderBy('id', 'desc')->limit(1)->first();
		$id = $lateId->id;
		$id += 1;

		//Thực hiện câu lệnh insert
		$insertData = DB::table('xa')->insert([
			'id' => $id,
			'maxa' => $request->maxa,
			'tenxa' => $request->tenxa,
			'mahuyen' => $request->mahuyen
		]);

		//Kiểm tra lệnh insert để trả về một thông báo
		if ($insertData) {
			Toastr::success('Đã thêm ', 'Thành công');
		} else {
			Toastr::error('Thêm không thành công', 'Thất bại');
		}


		//Thực hiện chuyển trang
		return redirect('/admin/commune');
	}

	public function edit($maxa)
	{
		//Lấy dữ liệu từ Database với các trường được lấy và với điều kiện mahuyen = $id
		$getData = DB::table('xa')->select('maxa', 'tenxa')->where('maxa', $maxa)->get();

		//Gọi đến file edit.blade.php trong thư mục "resources/views/admin/district" với giá trị gửi đi tên getUserById = $getData
		return view('admin.commune.edit')->with('getUserById', $getData);
	}

	public function update(Request $request)
	{
		//Cap nhat 

		//Thực hiện câu lệnh update với các giá trị $request trả về
		$updateData = DB::table('xa')->where('maxa', $request->maxa)->update([
			'maxa' => $request->maxa,
			'tenxa' => $request->tenxa
		]);

		//Kiểm tra lệnh update để trả về một thông báo
		if ($updateData) {
			Toastr::success('Đã cập nhật', 'Thành công');
		} else {
			Toastr::error('Cập nhật không thành công', 'Thất bại');
		}

		//Thực hiện chuyển trang
		return redirect('/admin/commune');
	}

	public function destroy($maxa)
	{
		//Thực hiện câu lệnh xóa với giá trị mahuyen = $id trả về
		$deleteData = DB::table('xa')->where('maxa', '=', $maxa)->delete();

		//Kiểm tra lệnh delete để trả về một thông báo
		if ($deleteData) {
			Toastr::success('Đã xoá', 'Thành công');
		} else {
			Toastr::error('Xoá không thành công', 'Thất bại');
		}

		//Thực hiện chuyển trang
		return redirect('/admin/commune');
	}
}
