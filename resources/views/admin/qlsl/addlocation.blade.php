@extends('layouts.admin.master')
@section('title')
    Quản lý địa điểm sạt lở
@endsection
@section('active5')
    active
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render('diadiemsatlo_add') }}
@endsection
@section('qlsl')
    <link rel="stylesheet" href="{{ asset('css/location.css') }}">

    <section class="col-lg connectedSortable ui-sortable">
        <div class="element">
            <div class="card card-primary">
                <form id="myForm" action="{{ url('/admin/qlsl/addlocation') }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}" />
                        <div class="form-group">
                            <label for="exampleInputtext1">Huyện <span style="color: red">*</span></label>
                            <select id="huyen" class="form-control" name="huyen" required>
                                <option value="">Chọn huyện</option>
                                @foreach ($huyen as $huyen)
                                    <option value="{{ $huyen->mahuyen }}">{{ $huyen->tenhuyen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Xã <span style="color: red">*</span></label>
                            <select id="xa" class="form-control" name="maxa" required>
                                <option value="">Chọn xã</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Mã địa điểm <span style="color: red">*</span></label>
                            <input name="madiadiem" type="number" class="form-control" id="exampleInputtext1"
                                value="" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Điểm cảnh báo <span style="color: red">*</span></label>
                            <textarea name="diemcanhbao" class="form-control" rows="3" placeholder="Nhập ..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Mô tả <span style="color: red">*</span></label>
                            <textarea name="mota" class="form-control" rows="3" placeholder="Nhập ..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Ghi chú</label>
                            <textarea name="ghichu" class="form-control" rows="3" placeholder="Nhập ..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Độ dài</label>
                            <input name="dodai" type="number" class="form-control" id="exampleInputtext1" placeholder=" "
                                value="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Hình thể</label>

                            <input id="shapeInput" name="shape" type="text" class="form-control" id="exampleInputtext1"
                                value="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputtext1">Đường dẫn video</label>

                            <input id="video" name="video" type="url" class="form-control" id="exampleInputtext1"
                                value="">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputtext1">Hình ảnh</label>

                            <input id="hinhanh" name="hinhanh[]" type="file" class="form-control" id="exampleInputtext1" value="" multiple>
                        </div>

                        <div class="form-group">
                            <label for="">Nhấn để vẽ</label><br>
                            <label class="switch">
                                <input id="choosepoint" onclick="switched()" type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>

            </div>

            <div id="map"></div>

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
    <script>
        $('#huyen').on('change', function() {

            let mahuyen = $(this).val();

            $.get('/admin/qlsl/addlocation/' + mahuyen, function(data) {

                let html = '<option value="">Chọn xã</option>';

                data.forEach(function(xa) {
                    
                    html += `<option value="${xa.maxa}">${xa.tenxa}</option>`
                });

                $('#xa').html(html);

            })

        })
    </script>
@endsection
