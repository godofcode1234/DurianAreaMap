@extends('layouts.admin.master')
@section('title')
    Quản lý địa điểm sạt lở
@endsection
@section('content')
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <p>Bản Đồ</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ url('/admin/map') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <p>Tài Khoản</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-person" style="font-size: 70px"></i>
            </div>
            <a href="{{ url('/admin') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <p>Huyện</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ url('/admin/district') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <p>Xã</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-person" style="font-size: 70px"></i>
            </div>
            <a href="{{ url('/admin/commune') }}" class="small-box-footer"><i
                    class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <p>Địa Điểm Sạt Lở</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ url('/location') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endsection
