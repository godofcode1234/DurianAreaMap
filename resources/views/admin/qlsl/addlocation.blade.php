@extends('layouts.admin.master')
@section('title')
    Quản lý địa điểm sạt lở
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render('diadiemsatlo_add') }}
@endsection
@section('qlsl')
    <link rel="stylesheet" href="{{ asset('css/location.css') }}">

    <section class="col-lg connectedSortable ui-sortable">
        <div class="element">
            <div class="card card-primary">
                <form id="myForm" action="{{ url('/admin/qlsl/addlocation') }}" method="POST"  enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}" />
                        <input style="display: none;" id="maxa" name="maxa" type="text" class="form-control"
                            placeholder=" " required>
                        <div class="form-group">
                            <label for="exampleInputtext1">Xã</label>
                            <input type="text" id="tenxa" name="tenxa" class="form-control" placeholder=" "
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Điểm cảnh báo</label>
                            <textarea name="diemcanhbao" class="form-control" rows="3" placeholder="Nhập ..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Mô tả</label>
                            <textarea name="mota" class="form-control" rows="3" placeholder="Nhập ..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Ghi chú</label>
                            <textarea name="ghichu" class="form-control" rows="3" placeholder="Nhập ..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Độ dài</label>
                            <input name="dodai" type="text" class="form-control" id="exampleInputtext1" placeholder=" "
                                required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Shape</label>

                            <input id="shapeInput" name="shape" type="text" class="form-control" id="exampleInputtext1"
                                value="" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputtext1">Đường link video</label>

                            <input id="video" name="video" type="text" class="form-control" id="exampleInputtext1"
                                value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputtext1">Hình ảnh</label>

                        <input id="hinhanh" name="hinhanh" type="file" class="form-control" id="exampleInputtext1" value=""
                        multiple required>
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
    <script src="{{ asset('js/location.js') }}"></script>
@endsection
