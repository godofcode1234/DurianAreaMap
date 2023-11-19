@extends('layouts.admin.master')
@section('title')
    Quản lý tài khoản
@endsection
@section('active1')
    active
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render('acount_list') }}
@endsection
@section('content')

    </div>

    <!-- Main row -->
    <div class="row">
        <section class="col-lg connectedSortable">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách tài khoản</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="display">
                        <thead>                         
                            <tr>
                                <th>STT</th>
                                <th>Tên Đăng Nhập</th>
                                <th>username</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //Khởi tạo vòng lập foreach lấy giá vào bảng
                            ?>
                            @foreach ($listuser as $key => $user)
                                <tr>
                                    <?php //Điền số thứ tự
                                    ?>
                                    <td>{{ $key + 1 }}</td>
                                    <?php //Lấy tên user
                                    ?>
                                    <td>{{ $user->name }}</td>
                                    <?php //Lấy username
                                    ?>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        <a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" href="/admin/account/{{ $user->id }}/edit">
                                            <i class="fas fa-edit" style="display: block; font-size: 17px;"></i> Sửa
                                        </a>
                                        <a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" onclick="return confirmDelete()" href="/admin/account/{{ $user->id }}/delete">
                                            <i class="fa-solid fa-user-xmark" style="display: block; font-size: 17px;"></i>Xoá 
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
            var addButton = '<a style="font-size: 11px; height: 40px; min-width: 60px; padding:4px" class="btn btn-app" href="/admin/account/create"><i class="fa-solid fa-user-plus" style="display: block; font-size: 20px;"></i> Thêm</a>';
            $('#myTable_wrapper .dataTables_filter').before(addButton);
        });
    </script>
@endsection
