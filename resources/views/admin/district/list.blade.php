@extends('layouts.admin.master')
@section('title')
    Quản lý Huyện
@endsection
@section('active2')
    active
@endsection
@section('breadcrumbs')
{{ Breadcrumbs::render('district_list') }}
@endsection
@section('content')

    </div>


    <!-- Main row -->
    <div class="row">
        <section class="col-lg connectedSortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách Thành phố, Huyện</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã Huyện</th>
                                <th>Tên Huyện</th>
                                <th>Công cụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($huyen as $key => $hn)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $hn->mahuyen }}</td>
                                    <td> {{ $hn->tenhuyen }} </td>
                                    <td>
                                        <a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" href="/admin/district/{{ $hn->mahuyen }}/edit">
                                            <i class="fas fa-edit" style="display: block; font-size: 17px;"> </i>Sửa
                                        </a>
                                        <a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" onclick="return confirmDelete()" href="/admin/district/{{ $hn->mahuyen }}/delete">
                                            <i class="fa-solid fa-user-xmark" style="display: block; font-size: 17px;"></i> Xoá 
                                        </a>
                                        <a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" href="/admin/{{ $hn->mahuyen }}/commune">
                                            <i class="fa-solid fa-circle-info" style="display: block; font-size: 17px;"></i> Chi Tiết 
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
            return confirm("Bạn có chắc muốn xoá Huyện này chứ?");
        }

        $(document).ready(function() {
            // Thêm nút "Thêm mới" vào trước bảng
            var addButton = '<a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" href="/admin/district/create"><i class="fa-solid fa-plus" style="display: block; font-size: 20px;"></i> Thêm</a>';
            $('#myTable_wrapper .dataTables_filter').before(addButton);
        });
    </script>
@endsection
