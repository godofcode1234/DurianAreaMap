
@extends('layouts.admin.master')
@section('title')
Sửa thông tin tài khoản
@endsection
@section('breadcrumbs')
{{ Breadcrumbs::render('acount_edit') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cập nhật thông tin tài khoản') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/admin/account/update') }}">
						<input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}" />
						<input type="hidden" id="id" name="id" value="{!! $getUserById[0]->id !!}" />
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên Đăng Nhập') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $getUserById[0]->name }}" readonly>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $getUserById[0]->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hoten"
                                class="col-md-4 col-form-label text-md-right">{{ __('Họ và tên') }}</label>
                            <div class="col-md-6">
                                <input id="hoten" type="text"
                                    class="form-control{{ $errors->has('hoten') ? ' is-invalid' : '' }}" name="hoten"
                                    value="{{ $getUserById[0]->hoten }}" required autofocus>

                                @if ($errors->has('hoten'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('hoten') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex"
                                class="col-md-4 col-form-label text-md-right">{{ __('Giới tính') }}</label>
                            <div class="col-md-6">

                                <div class="form-check-inline">
                                    <label class="form-check-label" for="nam">
                                        <input type="radio" class="form-check-input" id="radio1" name="sex"
                                            value="0" 
                                            @if ($getUserById[0]->gioitinh == 0) checked="checked" @endif>Nam
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <label class="form-check-label" for="nu">
                                        <input type="radio" class="form-check-input" id="radio2" name="sex"
                                            value="1" @if ($getUserById[0]->gioitinh == 1) checked="checked" @endif>Nữ
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="brithday"
                                class="col-md-4 col-form-label text-md-right">{{ __('Ngày sinh') }}</label>
                            <div class="col-md-6">
                                <input id="brithday" type="date"
                                    class="form-control{{ $errors->has('brithday') ? ' is-invalid' : '' }}"
                                    name="brithday" value="{{ $getUserById[0]->ngaysinh }}" >

                                @if ($errors->has('brithday'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('brithday') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address"
                                class="col-md-4 col-form-label text-md-right">{{ __('Địa chỉ') }}</label>
                            <div class="col-md-6">
                                <input id="address" type="text"
                                    class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                    name="address" value="{{ $getUserById[0]->diachi }}" >

                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0" style="display: flex;flex-direction: row-reverse;">
                            <div class="" style="margin-left: 20px">
                                <button type="submit" class="btn btn-success">  
                                    {{ __('Lưu') }}
                                </button>
                            </div>
                            <p><a class="btn btn-back" href="{{ url()->previous() }}">Quay lại</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

