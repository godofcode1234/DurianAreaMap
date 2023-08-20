<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;


class DistrictController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    public function index()
    {
        //dd($dataxa);

        //Lấy danh sách huyen từ database
        $getData = DB::table('huyen')->select()->get();

        //Gọi đến file district.blade.php trong thư mục "resources/views/admin" với giá trị gửi đi tên huyen = $getData
        return view('admin.district.list')->with('huyen', $getData);
    }

    public function create()
    {
        //Hiển thị trang thêm user
        return view('admin.district.create');
    }

    public function add(Request $request)
    {
        $lateId = DB::table('huyen')->select('id')->orderBy('id', 'desc')->limit(1)->first();
		$id = $lateId->id;
        $id += 1;
		
		$existingHuyen = DB::table('huyen')->where('mahuyen', $request->mahuyen)->first();

		if ($existingHuyen) {
			Toastr::error('Mã huyện đã tồn tại', 'Lỗi');
			return redirect()->back();
		}
            //Thực hiện câu lệnh insert
            $insertData = DB::table('huyen')->insert([
				'id' => $id,
                'mahuyen' => $request->mahuyen,
                'tenhuyen' => $request->tenhuyen
            ]);

            //Kiểm tra lệnh insert để trả về một thông báo
            if ($insertData) {
                Toastr::success('Đã thêm ', 'Thành công');
            } else {
                Toastr::error('Thêm không thành công', 'Thất bại');
            }


        //Thực hiện chuyển trang
        return redirect('/admin/district');
    }

	public function edit($mahuyen)
	{
		//Lấy dữ liệu từ Database với các trường được lấy và với điều kiện mahuyen = $id
		$getData = DB::table('huyen')->select('mahuyen','tenhuyen')->where('mahuyen',$mahuyen)->get();
		
		//Gọi đến file edit.blade.php trong thư mục "resources/views/admin/district" với giá trị gửi đi tên getUserById = $getData
		return view('admin.district.edit')->with('getUserById',$getData);
	}

    public function update(Request $request)
	{
		//Cap nhat 
	
		//Thực hiện câu lệnh update với các giá trị $request trả về
		$updateData = DB::table('huyen')->where('mahuyen', $request->mahuyen)->update([
            'mahuyen' => $request->mahuyen,
			'tenhuyen' => $request->tenhuyen
		]);
		
		//Kiểm tra lệnh update để trả về một thông báo
		if ($updateData) {
			Toastr::success('Đã cập nhật','Thành công');
		}else {                        
			Toastr::error('Cập nhật không thành công','Thất bại');
		}
		
		//Thực hiện chuyển trang
		return redirect()->back(); 
	}

    public function destroy($mahuyen)
	{
		//Thực hiện câu lệnh xóa với giá trị mahuyen = $id trả về
		$deleteData = DB::table('huyen')->where('mahuyen', '=', $mahuyen)->delete();
		
		//Kiểm tra lệnh delete để trả về một thông báo
		if ($deleteData) {
			Toastr::success('Đã xoá','Thành công');
		}else {                        
			Toastr::error('Xoá không thành công','Thất bại');
		}
		
		//Thực hiện chuyển trang
		return redirect()->back(); 
	}
}
