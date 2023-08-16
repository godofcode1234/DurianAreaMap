@extends('layouts.admin.master')
@section('title')
    Quản lý địa điểm sạt lở
@endsection
@section('breadcrumbs')
{{ Breadcrumbs::render('diadiemsatlo_edit') }}
@endsection
@php
  use Illuminate\Support\Facades\Storage; 
@endphp
@section('qlsl')
<link rel="stylesheet" href="{{ asset('css/location.css') }}">

    <section class="col-lg connectedSortable ui-sortable">
        <div class="element">
            <div class="card card-primary">
                <form id="myForm" action="{{ url('/admin/qlsl/updatelocation') }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}" />
                        <input style="display: none;" id="maxa" name="maxa" type="text" class="form-control"
                        placeholder=" " value="{{ $edit[0]->maxa}}" required>
                        <input style="display: none;" id="madiadiem" name="madiadiem" type="text" class="form-control"
                        placeholder=" " value="{{ $edit[0]->madiadiem}}" required>
                        <div class="form-group">
                            <label for="exampleInputtext1">Xã</label>
                            <input type="text" id="tenxa" name="tenxa" class="form-control" 
                            placeholder=" " value="{{ $edit[0]->tenxa}}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Điểm cảnh báo</label>
                            <textarea name="diemcanhbao" class="form-control" rows="3" placeholder="Nhập ..." required>{{ $edit[0]->diemcanhbao}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Mô tả</label>
                            <textarea name="mota" class="form-control" rows="3" placeholder="Nhập ..." required>{{ $edit[0]->mota}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Ghi chú</label>
                            <textarea name="ghichu" class="form-control" rows="3" placeholder="Nhập ..." required>{{ $edit[0]->ghichu}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Độ dài</label>
                            <input name="dodai" type="text" class="form-control" id="exampleInputtext1"
                                placeholder=" " value="{{ $edit[0]->dodai }}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Shape</label>

                            <input id="shapeInput" name="shape" type="text" class="form-control" id="exampleInputtext1"
                                value="{{ $edit[0]->shape}}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Đường link video</label>
                            <input id="video" name="video" type="text" class="form-control" id="exampleInputtext1"
                                value="{{ $hinh_video[0]->video ?? ''}}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputtext1">Hình ảnh</label>
                        @foreach ($hinh_video as $hinh)
                        <img src="{{ url('storage/hinhqlsl/'.$hinh->hinhanh) }}" style="width: 250px;height: auto">
                        @endforeach
                        <input id="hinhanh" name="hinhanh[]" type="file" class="form-control" id="exampleInputtext1" value=""
                        multiple >
                    </div>
                    </div>
                    <div id="map"></div>
                    <label class="switch">
                        <input id="choosepoint" onclick="switched()" type="checkbox">
                        <span class="slider"></span>
                    </label>
                </form>
                <div class="card-footer ">
                    <div class="group-button">
                        <button id="back" class="btn btn-back">Quay lại</button>
                        <button form="myForm" type="submit" class="btn btn-success">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script src="{{ asset('js/location.js')}}"></script>
<script>
    @foreach ($edit as $polyline)
        var coordinates = {{ $polyline->shape }};
        L.polyline(coordinates, {
            color: 'red'
        }).addTo(map);
    @endforeach
</script>
@endsection
