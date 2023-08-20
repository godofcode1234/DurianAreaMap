@extends('layouts.admin.master')
@section('title')
    Quản lý địa điểm sạt lở
@endsection
@section('active5')
    active
@endsection
@section('breadcrumbs')
{{ Breadcrumbs::render('diadiemsatlo_list') }}
@endsection
@section('qlsl')
<a class="btn btn-app" href="{{ url()->previous() }}"><i class="fa-solid fa-rotate-left" style="display: block; font-size: 20px;"></i>Quay lại</a>
    </div>

    <!-- Main row -->
    <div class="row">
        <section class="col-lg connectedSortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ảnh địa điểm sạt lở</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Huyện</th>
                                <th>Tên Xã</th>
                                <th>Mô tả</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hinh as $key => $list)
                                @if($list->hinhanh == '')
                                <tr>
                                    <td colspan="5" style="text-align-last: center;">Không có ảnh</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @else
                            <tr>
                                <td>{{ $key + 1}}</td>

                                <td>{{ $list->tenhuyen}}</td>

                                <td>{{ $list->tenxa }}</td>

                                <td><img src="{{ url('storage/hinhqlsl/' . $list->hinhanh) }}" style="width: 250px;height: auto"></td>

                                <td>
                                    <a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px"
                                        class="btn btn-app" onclick="return confirmDelete()" href="/admin/qlsl/{{ $list->id}}/imagedelete">
                                        <i class="fa-solid fa-user-xmark" style="display: block; font-size: 17px;"></i>Xoá
                                    </a>
                                </td>
                            </tr>
                        @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        function confirmDelete() {
            return confirm("Bạn có chắc muốn xoá địa điểm này chứ?");
        }

        // $(document).ready(function() {
        //     // Thêm nút "Thêm mới" vào trước bảng
        //     var addButton =
        //         '<a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" href="/admin/qlsl/addlocation"><i class="fa-solid fa-plus" style="display: block; font-size: 20px;"></i> Thêm</a>';
        //     $('#myTable_wrapper .dataTables_filter').before(addButton);
        // });
    </script>
@endsection
