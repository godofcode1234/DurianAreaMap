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
        $getData = DB::table('huyen')->get();
        $Data = DB::table('xa')->get();
        return view('admin.qlsl.addlocation')->with('huyen', $getData)->with('xa', $Data);
    }


    public function insertlocation(Request $request)
    {
        $maxa = $request->maxa;
        $madiadiem = $request->madiadiem;
        $diemcanhbao = $request->diemcanhbao;
        $dodai = $request->dodai;
        $mota = $request->mota;
        $ghichu = $request->ghichu;
        $shape = $request->shape;
        $hinhanhs = $request->file('hinhanh');
        $video = $request->video;

        $id = rand(1, 10000);
        $id_video = rand(1, 1000);

        // Kiểm tra xem id đã tồn tại trong cơ sở dữ liệu chưa
        while (DB::table('diadiemsatlo')->where('id', $id)->exists()) {
            $id = rand(1, 10000);
        }

        $existingDiadiemsatlo = DB::table('diadiemsatlo')->where('madiadiem', $request->madiadiem)->first();
        // Kiểm tra xem madiadiem đã tồn tại trong cơ sở dữ liệu chưa
        if ($existingDiadiemsatlo) {
            Toastr::error('Mã địa điểm đã tồn tại', 'Lỗi');
            return redirect()->back();
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
            HinhAnh::where('hinhanh', null)->delete();
        }


        if ($video) {
            $Video = new Video();
            $Video->video = $video;
            $Video->madiadiem = $madiadiem;
            $Video->id = $id_video;
            $Video->save();
        } else {
            $Video = new Video();
            $Video->video = null;
            $Video->madiadiem = $madiadiem;
            $Video->id = $id_video;
            $Video->save();
            Video::where('video', null)->delete();
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
        $huyen = DB::table('huyen')->get();

        $hinhanh = DB::table('diadiemsatlo')->selectRaw('DISTINCT hinhanh.hinhanh')
            ->join('hinhanh', 'diadiemsatlo.madiadiem', '=', 'hinhanh.madiadiem')
            ->where('diadiemsatlo.madiadiem', $madiadiem)->get();

        $video = DB::table('diadiemsatlo')->join('video', 'diadiemsatlo.madiadiem', '=', 'video.madiadiem')->where('diadiemsatlo.madiadiem', $madiadiem)->get();

        $getData = DB::table('diadiemsatlo')->join('xa', 'diadiemsatlo.maxa', '=', 'xa.maxa')->join('huyen', 'xa.mahuyen', '=', 'huyen.mahuyen')
            ->select('diadiemsatlo.maxa', 'xa.tenxa', 'xa.mahuyen', 'tenhuyen', 'diemcanhbao', 'mota', 'ghichu', 'dodai', 'shape', 'madiadiem', 'diadiemsatlo.id')->where('madiadiem', $madiadiem)->get();

        $xacu = DB::table('xa')->where('mahuyen', $getData[0]->mahuyen)->get();

        return view('admin.qlsl.editlocation')->with('edit', $getData)->with('hinh', $hinhanh)->with('video', $video)->with('huyen', $huyen)->with('xa', $xacu);
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


        if ($request->hasFile('hinhanh')) {
            foreach ($hinhanhs as $hinhanh) {
                $id_hinhanh = rand(1, 1000);
                $ten_hinh = $hinhanh->getClientOriginalName();
                if (Storage::exists('hinhqlsl/' . $ten_hinh)) {
                    Toastr::error('Ảnh đã tồn tại');
                    continue;
                }

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
            HinhAnh::where('hinhanh', null)->delete();
        }

        $id = rand(1, 10000);
        // Kiểm tra xem id đã tồn tại trong cơ sở dữ liệu chưa
        while (DB::table('video')->where('id', $id)->exists()) {
            $id = rand(1, 10000);
        }


        if ($request->video) {
            $Video = Video::where('madiadiem', $madiadiem)->first();
            $Video->video = $videos;
            $Video->madiadiem = $madiadiem;
            $Video->id = $id;
            $Video->save();
        } else {
            $Video = new Video();
            $Video->video = null;
            $Video->madiadiem = $madiadiem;
            $Video->id = $id;
            $Video->save();
        }

        $Diadiemsatlo = Diadiemsatlo::where('madiadiem', $madiadiem)->first();
        $Diadiemsatlo->maxa = $maxa;
        $Diadiemsatlo->diemcanhbao = $diemcanhbao;
        $Diadiemsatlo->dodai = $dodai;
        $Diadiemsatlo->mota = $mota;
        $Diadiemsatlo->ghichu = $ghichu;
        $Diadiemsatlo->shape = $shape;
        $Diadiemsatlo->save();

        //Kiểm tra lệnh để trả về một thông báo
        if ($Diadiemsatlo && !empty($Hinhanh) && $Video) {
            Toastr::success('Đã cập nhật địa điểm sạt lở', 'Thành công');
        } else {
            Toastr::error('Cập nhật không thành công', 'Thất bại');
        }
        return redirect()->back();
    }

    public function destroy($madiadiem)
    {
        $hinhAnhs = HinhAnh::where('madiadiem', $madiadiem)->get();
        $videos = Video::where('madiadiem', $madiadiem)->get();

        if (count($hinhAnhs) > 0) {
            foreach ($hinhAnhs as $hinhAnh) {
                $tenHinh = $hinhAnh->hinhanh;
                Storage::delete('hinhqlsl/' . $tenHinh);
            }
            $hinhanh = HinhAnh::find($madiadiem)->delete();
        }

        if (count($videos) > 0) {
            $video = Video::find($madiadiem)->delete();
        }

        $diadiem = Diadiemsatlo::find($madiadiem)->delete();
        //Kiểm tra lệnh delete để trả về một thông báo
        if ($diadiem) {
            Toastr::success('Đã xoá', 'Thành công');
        } elseif ($diadiem && $hinhanh) {
            Toastr::success('Đã xoá', 'Thành công');
        } elseif ($diadiem && $video) {
            Toastr::success('Đã xoá', 'Thành công');
        } elseif ($diadiem && $hinhanh && $video) {
            Toastr::success('Đã xoá', 'Thành công');
        } else {
            Toastr::error('Xoá không thành công', 'Thất bại');
        }

        //Thực hiện chuyển trang
        return redirect('/location');
    }

    public function getxa($mahuyen)
    {

        $xa = DB::table('xa')->where('mahuyen', $mahuyen)->get();
        return response()->json($xa);
    }

    public function image($madiadiem)
    {
        $hinh = DB::table('hinhanh')->join('diadiemsatlo', 'hinhanh.madiadiem', '=', 'diadiemsatlo.madiadiem')
            ->join('xa', 'diadiemsatlo.maxa', '=', 'xa.maxa')->join('huyen', 'xa.mahuyen', '=', 'huyen.mahuyen')
            ->select('hinhanh.*', 'huyen.tenhuyen', 'xa.tenxa')
            ->where('hinhanh.madiadiem', $madiadiem)->get();
        return view('admin.qlsl.image')->with('hinh', $hinh);
    }

    public function imageDelete($id)
    {

        $Hinhanh = HinhAnh::where('id', $id)->get();
        foreach ($Hinhanh as $hinhAnh) {
            $tenHinh = $hinhAnh->hinhanh;
            Storage::delete('hinhqlsl/' . $tenHinh);
        }
        $hinh = HinhAnh::where('id', $id)->delete();
        if ($hinh) {
            Toastr::success('Đã xoá ảnh', 'Thành công');
        } else {
            Toastr::error('Xoá ảnh không thành công', 'Thất bại');
        }

        return redirect()->back();
    }
}
