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

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		//Lấy danh sách User từ database
		$getData = DB::table('users')->select('id', 'name', 'email')->get();

		//Gọi đến file list.blade.php trong thư mục "resources/views/user" với giá trị gửi đi tên listuser = $getData
		return view('admin.account.list')->with('listuser', $getData);
	}

	public function create()
	{
		//Hiển thị trang thêm user
		return view('admin.account.create');
	}

	public function add(Request $request)
	{
		// Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
		$existingUser = DB::table('users')->where('email', $request->email)->first();

		if ($existingUser) {
			Toastr::error('Email đã tồn tại', 'Lỗi');
			return redirect()->back();
		}

		$validatedData = $request->validate([
            'password' => 'required|confirmed',
            'password_confirmation' => ['required', 'password_match:password'],
          ]);

		//Thực hiện câu lệnh insert
		$insertData = DB::table('users')->insert([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password)
		]);

		//Kiểm tra lệnh insert để trả về một thông báo
		if ($insertData) {
			Toastr::success('Đã thêm tài khoản', 'Thành công');
		} else {
			Toastr::error('Thêm không thành công', 'Thất bại');
		}

		//Thực hiện chuyển trang
		return redirect('admin');
	}

	public function edit($id)
	{
		//Lấy dữ liệu từ Database với các trường được lấy và với điều kiện id = $id
		$getData = DB::table('users')->select('id', 'name', 'email','hoten','ngaysinh','gioitinh','diachi')->where('id', $id)->get();

		//Gọi đến file edit.blade.php trong thư mục "resources/views/user" với giá trị gửi đi tên getUserById = $getData
		return view('admin.account.edit')->with('getUserById', $getData);
	}

	public function update(Request $request)
	{
		$existingUser = DB::table('users')->where('email', $request->email)->where('id', '!=', $request->id)->first();

		if ($existingUser) {
			Toastr::error('Email đã tồn tại', 'Lỗi');
			return redirect()->back();
		}

		//Thực hiện câu lệnh update với các giá trị $request trả về
		$updateData = DB::table('users')->where('id', $request->id)->update([
			'name' => $request->name,
			'email' => $request->email,
			'hoten' => $request->hoten,
			'ngaysinh' => $request->brithday,
			'diachi' => $request->address,
			'gioitinh' => $request->sex
		]);

		//Kiểm tra lệnh update để trả về một thông báo
		if ($updateData) {
			Toastr::success('Đã cập nhật', 'Thành công');
		} else {
			Toastr::error('Cập nhật không thành công', 'Thất bại');
		}

		//Thực hiện chuyển trang
		return redirect('admin');
	}

	public function destroy($id)
	{
		//Thực hiện câu lệnh xóa với giá trị id = $id trả về
		$deleteData = DB::table('users')->where('id', '=', $id)->delete();

		//Kiểm tra lệnh delete để trả về một thông báo
		if ($deleteData) {
			Toastr::success('Đã xoá tài khoản', 'Thành công');
		} else {
			Toastr::error('Xoá không thành công', 'Thất bại');
		}

		//Thực hiện chuyển trang
		return redirect('admin');
	}

	public function show()
	{
		$userId = Auth::id();
		$getData = DB::table('users')->select('id', 'name', 'email', 'hoten', 'ngaysinh', 'diachi', 'gioitinh')->where('id', $userId)->get();
		return view('admin.account.profile')->with('getUserById', $getData);
	}

	public function update_profile(Request $request)
	{
		$userId = Auth::id();
		$updateData = DB::table('users')->where('id', $userId)->update([
			'hoten' => $request->hoten,
			'ngaysinh' => $request->brithday,
			'diachi' => $request->address,
			'gioitinh' => $request->sex
		]);
		if ($updateData) {
			Toastr::success('Đã lưu', 'Thành công');
		} else {
			Toastr::error('Lưu không thành công', 'Thất bại');
		}
		return redirect()->route('profile');
	}

	public function create_password(){
		return view('admin.account.reset');
	}

	public function reset_password(Request $request){
		$old_password = $request->input('old-password');
		$new_password = $request->input('password');
		$password_confirm = $request->input('password_confirmation');
		$user = Auth::user();
		$userId = Auth::id();
		if(Hash::check($old_password, $user->password) && $new_password === $password_confirm ){
			$updateData = DB::table('users')->where('id', $userId)->update([
				'password' => Hash::make($request->password)
			]);
			if ($updateData) {
				Toastr::success('Đã lưu', 'Thành công');
			} else {
				Toastr::error('Lưu không thành công', 'Thất bại');
			}
		}elseif($new_password != $password_confirm){
			Toastr::error('Mật khẩu không trùng khớp', 'Thất bại');
			return redirect()->refresh();
		}else{
			Toastr::error('Mật khẩu cũ không đúng', 'Thất bại');
			return redirect()->refresh();
		}
		return redirect()->route('profile');
	}
}
