<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\HinhAnh;
use App\Video;
use App\Diadiemsatlo;
use Illuminate\Support\Facades\Storage;

class QuanLySatLoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function location()
    {

        $getData = DB::table('diadiemsatlo')->join('xa', 'diadiemsatlo.maxa', '=', 'xa.maxa')
            ->join('huyen', 'xa.mahuyen', '=', 'huyen.mahuyen')
            ->select('huyen.tenhuyen', 'xa.tenxa', 'diadiemsatlo.mota', 'diadiemsatlo.madiadiem')->get();
        return view('admin.qlsl.location')->with('lc', $getData);
    }

    public function shape()
    {

        return view('admin.qlsl.addlocation');
    }

    public function insertlocation(Request $request)
    {
        $maxa = $request->maxa;
        $diemcanhbao = $request->diemcanhbao;
        $dodai = $request->dodai;
        $mota = $request->mota;
        $ghichu = $request->ghichu;
        $shape = $request->shape;
        $hinhanh = $request->file('hinhanh')->getClientOriginalName();
        $request->file('hinhanh')->move(public_path('hinhqlsl'), $hinhanh);
        $video = $request->video;

        $id = rand(1, 10000);
        $madiadiem = rand(1, 10000);
        $id_video = rand(1, 1000);
        $id_hinhanh = rand(1, 1000);
        // Kiểm tra xem id đã tồn tại trong cơ sở dữ liệu chưa
        while (DB::table('diadiemsatlo')->where('id', $id)->exists()) {
            $id = rand(1, 10000);
        }

        // Kiểm tra xem madiadiem đã tồn tại trong cơ sở dữ liệu chưa
        while (DB::table('diadiemsatlo')->where('madiadiem', $madiadiem)->exists()) {
            $madiadiem = rand(1, 10000);
        }

        $Diadiemsatlo = new Diadiemsatlo();
        $Diadiemsatlo->maxa = $maxa;
        $Diadiemsatlo->diemcanhbao = $diemcanhbao;
        $Diadiemsatlo->dodai = $dodai;
        $Diadiemsatlo->mota = $mota;
        $Diadiemsatlo->ghichu = $ghichu;
        $Diadiemsatlo->shape = $shape;
        $Diadiemsatlo->id = $id;
        $Diadiemsatlo->madiadiem = $madiadiem;
        $Diadiemsatlo->save();

        $Hinhanh = new HinhAnh();
        $Hinhanh->hinhanh = $hinhanh;
        $Hinhanh->madiadiem = $madiadiem;
        $Hinhanh->id = $id_hinhanh;
        $Hinhanh->save();

        $Video = new Video();
        $Video->video = $video;
        $Video->madiadiem = $madiadiem;
        $Video->id = $id_video;
        $Video->save();

        // $insert = DB::table('diadiemsatlo')->insert([
        //     'maxa' => $maxa,
        //     'diemcanhbao' => $diemcanhbao,
        //     'dodai' => $dodai,
        //     'mota' => $mota,
        //     'ghichu' => $ghichu,
        //     'shape' => $shape,
        //     'id' => $id,
        //     'madiadiem' => $madiadiem
        // ]);


        //Kiểm tra lệnh để trả về một thông báo
        if ($Diadiemsatlo && $Hinhanh && $Video) {
            Toastr::success('Đã thêm địa điểm sạt lở', 'Thành công');
        } else {
            Toastr::error('Thêm không thành công', 'Thất bại');
        }

        //Thực hiện chuyển trang
        return redirect('location');
    }

    public function editLocation($madiadiem)
    {
        $getData = DB::table('diadiemsatlo')->join('xa', 'diadiemsatlo.maxa', '=', 'xa.maxa')
            ->select('diadiemsatlo.maxa', 'xa.tenxa', 'diemcanhbao', 'mota', 'ghichu', 'dodai', 'shape', 'madiadiem')->where('madiadiem', $madiadiem)->get();
        return view('admin.qlsl.editlocation')->with('edit', $getData);
    }

    public function updateLocation(Request $request)
    {
        $madiadiem = $request->madiadiem;
        $maxa = $request->maxa;
        $diemcanhbao = $request->diemcanhbao;
        $dodai = $request->dodai;
        $mota = $request->mota;
        $ghichu = $request->ghichu;
        $shape = $request->shape;

        $updateData = DB::table('diadiemsatlo')->where('madiadiem', $madiadiem)->update([
            'maxa' => $maxa,
            'diemcanhbao' => $diemcanhbao,
            'mota' => $mota,
            'ghichu' => $ghichu,
            'dodai' => $dodai,
            'shape' => $shape
        ]);


        if ($updateData) {
            Toastr::success('Đã cập nhật', 'Thành công');
        } else {
            Toastr::error('Cập nhật không thành công', 'Thất bại');
        }

        //Thực hiện chuyển trang
        return redirect('/location');
    }

    public function destroy($madiadiem)
    {
        $tenhinh = HinhAnh::where('madiadiem', $madiadiem)->value('hinhanh');
        // dd($tenhinh);
        // Xóa file
        Storage::delete("hinhqlsl/$tenhinh");
        
        $diadiem = Diadiemsatlo::find($madiadiem)->delete();
        $hinhanh = HinhAnh::find($madiadiem)->delete();
        $video = Video::find($madiadiem)->delete();


        //Kiểm tra lệnh delete để trả về một thông báo
        if ($diadiem && $hinhanh && $video) {
            Toastr::success('Đã xoá', 'Thành công');
        } else {
            Toastr::error('Xoá không thành công', 'Thất bại');
        }

        //Thực hiện chuyển trang
        return redirect('/location');
    }
}
