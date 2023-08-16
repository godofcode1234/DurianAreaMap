<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\HinhAnh;
use App\Video;
use App\Diadiemsatlo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

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
        $hinhanhs = $request->file('hinhanh');
        $video = $request->video;

        $id = rand(1, 10000);
        $madiadiem = rand(1, 10000);
        $id_video = rand(1, 1000);

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

        if ($hinhanhs) {
            foreach ($hinhanhs as $hinhanh) {
                $id_hinhanh = rand(1, 1000);
                $ten_hinh = $hinhanh->getClientOriginalName();

                $hinhanh->storeAs('hinhqlsl', $ten_hinh);

                $Hinhanh = new HinhAnh;
                $Hinhanh->hinhanh = $ten_hinh;
                $Hinhanh->madiadiem = $madiadiem;
                $Hinhanh->id = $id_hinhanh;
                $Hinhanh->save();
            }
        } else {
            $id_hinhanh = rand(1, 1000);
            $Hinhanh = new HinhAnh;
            $Hinhanh->hinhanh = null;
            $Hinhanh->madiadiem = $madiadiem;
            $Hinhanh->id = $id_hinhanh;
            $Hinhanh->save();
        }


        if ($video) {
            $Video = new Video();
            $Video->video = $video;
            $Video->madiadiem = $madiadiem;
            $Video->id = $id_video;
            $Video->save();
        }else{
            $Video = new Video();
            $Video->video = null;
            $Video->madiadiem = $madiadiem;
            $Video->id = $id_video;
            $Video->save();
        }



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

        $hinhanhvideo = DB::table('diadiemsatlo')->selectRaw('DISTINCT hinhanh.hinhanh, video.video')->join('hinhanh', 'diadiemsatlo.madiadiem', '=', 'hinhanh.madiadiem')
            ->join('video', 'diadiemsatlo.madiadiem', '=', 'video.madiadiem')
            ->where('diadiemsatlo.madiadiem', $madiadiem)->get();
        $getData = DB::table('diadiemsatlo')->join('xa', 'diadiemsatlo.maxa', '=', 'xa.maxa')
            ->select('diadiemsatlo.maxa', 'xa.tenxa', 'diemcanhbao', 'mota', 'ghichu', 'dodai', 'shape', 'madiadiem')->where('madiadiem', $madiadiem)->get();
        return view('admin.qlsl.editlocation')->with('edit', $getData)->with('hinh_video', $hinhanhvideo);
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
        $hinhanhs = $request->file('hinhanh');
        $videos = $request->video;

        $Diadiemsatlo = Diadiemsatlo::where('madiadiem', $madiadiem)->first();
        $Diadiemsatlo->maxa = $maxa;
        $Diadiemsatlo->diemcanhbao = $diemcanhbao;
        $Diadiemsatlo->dodai = $dodai;
        $Diadiemsatlo->mota = $mota;
        $Diadiemsatlo->ghichu = $ghichu;
        $Diadiemsatlo->shape = $shape;
        $Diadiemsatlo->save();

        
       
        
        if($request->hasFile('hinhanh')){
            $Hinhanh = HinhAnh::where('madiadiem', $madiadiem)->get();
            foreach ($Hinhanh as $hinhAnh) {
                $tenHinh = $hinhAnh->hinhanh;
                Storage::delete('hinhqlsl/' . $tenHinh);
            }
    
            HinhAnh::where('madiadiem', $madiadiem)->delete();
    
            foreach ($hinhanhs as $hinhanh) {
                $id_hinhanh = rand(1, 1000);
                $ten_hinh = $hinhanh->getClientOriginalName();
    
                $hinhanh->storeAs('hinhqlsl', $ten_hinh);
                $hinhAnh = new HinhAnh;
                $hinhAnh->hinhanh = $ten_hinh;
                $hinhAnh->madiadiem = $madiadiem;
                $hinhAnh->id = $id_hinhanh;
                $hinhAnh->save();
            }
    
        }else{
            $id_hinhanh = rand(1, 1000);
            $Hinhanh = new HinhAnh;
            $Hinhanh->hinhanh = null;
            $Hinhanh->madiadiem = $madiadiem;
            $Hinhanh->id = $id_hinhanh;
            $Hinhanh->save();
        }
        
        if($request->video) {
            $Video = Video::where('madiadiem', $madiadiem)->first();
            $Video->video = $videos;
            $Video->madiadiem = $madiadiem;
            $Video->id = rand(1, 1000);
            $Video->save();
        }else{
            $Video = new Video();
            $Video->video = null;
            $Video->madiadiem = $madiadiem;
            $Video->id =  rand(1, 1000);
            $Video->save();
        }
        

        //Kiểm tra lệnh để trả về một thông báo
        if ($Diadiemsatlo && !empty($Hinhanh) && $Video) {
            Toastr::success('Đã cập nhật địa điểm sạt lở', 'Thành công');
        } else {
            Toastr::error('Cập nhật không thành công', 'Thất bại');
        }
        return redirect('location');
    }

    public function destroy($madiadiem)
    {
        $hinhAnhs = HinhAnh::where('madiadiem', $madiadiem)->get();
        $videos = Video::where('madiadiem',$madiadiem)->get();
        $diadiem = Diadiemsatlo::find($madiadiem)->delete();
        if($hinhAnhs && $videos){
            foreach ($hinhAnhs as $hinhAnh) {
                $tenHinh = $hinhAnh->hinhanh;
                Storage::delete('hinhqlsl/' . $tenHinh);
            }
            $hinhanh = HinhAnh::find($madiadiem)->delete();
            $video = Video::find($madiadiem)->delete();
        }
        
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
