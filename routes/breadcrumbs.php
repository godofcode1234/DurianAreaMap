<?php  
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
/** Account */
Breadcrumbs::for('acount_list', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Quản lý tài khoản', route('admin'));
});

Breadcrumbs::for('acount_add', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Quản lý tài khoản', route('admin'));
    $trail->push('Thêm tài khoản');
});

Breadcrumbs::for('acount_edit', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Quản lý tài khoản', route('admin'));
    $trail->push('Sửa thông tin tài khoản');
});
/** End-Account */


/** District */
Breadcrumbs::for('district_list', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Quản lý Huyện');
});

Breadcrumbs::for('district_add', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Quản lý Huyện',route('district'));
    $trail->push('Thêm Huyện');
});

Breadcrumbs::for('district_edit', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Quản lý Huyện',route('district'));
    $trail->push('Sửa Huyện');
});
/** End-District */

/** Commune */
Breadcrumbs::for('commune_list', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Quản lý Huyện',route('district'));
    $trail->push('Quản lý Xã');
});

Breadcrumbs::for('commune_add', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Quản lý Huyện',route('district'));
    $trail->push('Quản lý Xã');
    $trail->push('Thêm Xã Mới');
});

Breadcrumbs::for('commune_edit', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Quản lý Huyện',route('district'));
    $trail->push('Quản lý Xã');
    $trail->push('Sửa Tên Xã');
});
/** End-Commune */


/** Địa điểm sạt lở */
Breadcrumbs::for('diadiemsatlo_list', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Địa điểm sạt lở',route('location'));
});

Breadcrumbs::for('diadiemsatlo_add', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Địa điểm sạt lở',route('location'));
    $trail->push('Thêm địa điểm sạt lở');
});

Breadcrumbs::for('diadiemsatlo_edit', function ($trail){
    $trail->push('Home', route('home'));
    $trail->push('Địa điểm sạt lở',route('location'));
    $trail->push('Chỉnh sửa địa diểm sạt lở');
});
/** End Địa điểm sạt lở */
?>