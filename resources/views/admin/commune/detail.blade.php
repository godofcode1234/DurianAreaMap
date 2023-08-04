@extends('layouts.admin.master')
@section('title')
    Quản lý Xã
@endsection
@section('active2')
    active
@endsection
@section('breadcrumbs')
{{ Breadcrumbs::render('commune_list') }}
@endsection
@section('content')
    
    <a class="btn btn-app" href="{{ url('/admin/district') }}"><i class="fa-solid fa-rotate-left" style="display: block; font-size: 20px;"></i>Quay lại</a>
    </div>


    <!-- Main row -->
    <div class="row">
        <section class="col-lg connectedSortable">
            <div class="card">
                <div class="card-header">
                    @foreach ( $huyen as $key => $hn )
                    <h3 class="card-title">Danh sách Phường, Xã thuộc {{$hn->tenhuyen}}</h3>
                    @endforeach
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã Xã</th>
                                <th>Tên Xã</th>
                                <th>Công cụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //Khởi tạo vòng lập foreach lấy giá vào bảng
                            ?>
                            @foreach ($xa as $key => $xa)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $xa->maxa }}</td>
                                    <td>{{ $xa->tenxa }}</td>
                                    <td>
                                        <a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" href="/admin/commune/{{ $xa->maxa }}/edit">
                                            <i class="fas fa-edit" style="display: block; font-size: 17px;"></i> Sửa
                                        </a>
                                        <a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" onclick="return confirmDelete()" href="/admin/commune/{{ $xa->maxa }}/delete">
                                            <i class="fa-solid fa-user-xmark" style="display: block; font-size: 17px;"></i> Xoá 
                                        </a>
                                    </td>
                                </tr>
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
            return confirm("Bạn có chắc muốn xoá tài khoản này chứ?");
        }

        $(document).ready(function() {
            // Thêm nút "Thêm mới" vào trước bảng
            var addButton = '<a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" href="/admin/commune/create"> <i class="fa-solid fa-plus" style="display: block; font-size: 20px;"></i> Thêm</a>';
            $('#myTable_wrapper .dataTables_filter').before(addButton);
        });
    </script>
@endsection
