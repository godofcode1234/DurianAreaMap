@extends('layouts.admin.master')
@section('title')
    Quản lý địa điểm sạt lở
@endsection
@section('active5')
    active
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
                <form id="myForm" action="{{ url('/admin/qlsl/updatelocation') }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}" />
                        <input style="display: none;" id="id" name="id" type="text" class="form-control"
                            placeholder=" " value="{{ $edit[0]->id }}" required>
                        @php
                            $x = $xa[0];
                            $h = $huyen[0];
                        @endphp
                        <div class="form-group">
                            <label for="exampleInputtext1">Huyện <span style="color: red">*</span></label>
                            <select id="huyen" class="form-control" name="huyen" required>
                                @foreach ($huyen as $huyen)
                                    <option value="{{ $huyen->mahuyen }}" @if ($huyen->mahuyen == $edit[0]->mahuyen) selected @endif>
                                        {{ $huyen->tenhuyen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Xã <span style="color: red">*</span></label>
                            <select id="xa" class="form-control" name="maxa" required>
                                @foreach ($xa as $xa)
                                    <option value="{{ $xa->maxa }}" @if ($edit[0]->maxa == $xa->maxa) selected @endif>{{ $xa->tenxa}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Mã địa điểm <span style="color: red">*</span></label>
                            <input name="madiadiem" type="number" class="form-control" id="exampleInputtext1"
                                value="{{ $edit[0]->madiadiem }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Điểm cảnh báo <span style="color: red">*</span></label>
                            <textarea name="diemcanhbao" class="form-control" rows="3" placeholder="Nhập ..." required>{{ $edit[0]->diemcanhbao }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Mô tả <span style="color: red">*</span></label>
                            <textarea name="mota" class="form-control" rows="3" placeholder="Nhập ..." required>{{ $edit[0]->mota }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Ghi chú </label>
                            <textarea name="ghichu" class="form-control" rows="3" placeholder="Nhập ..." >{{ $edit[0]->ghichu }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Độ dài </label>
                            <input name="dodai" type="number" class="form-control" id="exampleInputtext1" placeholder=" "
                                value="{{ $edit[0]->dodai }}" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Hình thể </label>

                            <input id="shapeInput" name="shape" type="text" class="form-control" id="exampleInputtext1"
                                value="{{ $edit[0]->shape }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtext1">Đường dẫn video</label>
                            <input id="video" name="video" type="text" class="form-control" id="exampleInputtext1"
                                value="{{ $video[0]->video ?? '' }}">
                        </div>
                    
                    <div class="form-group">
                        <label for="exampleInputtext1">Hình ảnh</label>
                        @foreach ($hinh as $hinh)
                           
                            <img src="{{ url('storage/hinhqlsl/' . $hinh->hinhanh) }}" style="width: 250px;height: auto">
                            
                        @endforeach
                        <input id="hinhanh" name="hinhanh[]" type="file" class="form-control" id="exampleInputtext1"
                            value="" multiple>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputtext1">Chỉnh sửa ảnh</label><br>
                        <a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px"
                        class="btn btn-app" href="/admin/qlsl/{{ $edit[0]->madiadiem}}/image">
                        <i class="fa-solid fa-image" style="display: block; font-size: 17px;"></i>Hình ảnh
                        </a>
                    </div>

                    <div class="form-group">
                        <label for="">Nhấn để vẽ <span style="color: red">*nhấn 2 lần để xoá shape</span></label><br>
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

                let html = '';

                data.forEach(function(xa) {
                    html += `<option value="${xa.maxa}">${xa.tenxa}</option>`
                });

                $('#xa').html(html);

            })

        })

        @foreach ($edit as $polyline)
            var coordinates = {{ $polyline->shape }};
            L.polyline(coordinates, {
                color: 'red'
            }).addTo(map);
        @endforeach
    </script>
@endsection
