@extends('layouts.admin.master')
@section('title')
    Thông tin cá nhân
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Thông tin cá nhân') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('/update-profile') }}">
                            <input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}" />
                            <input type="hidden" id="id" name="id" value="{!! $getUserById[0]->id !!}" />

                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tên Đăng Nhập') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                        value="{{ $getUserById[0]->name }}" readonly>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username"
                                    class="col-md-4 col-form-label text-md-right">{{ __('username') }}</label>
                                <div class="col-md-6">
                                    <input id="username" type="username"
                                        class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username"
                                        value="{{ $getUserById[0]->username }}" readonly>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
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
                                        name="brithday" value="{{ $getUserById[0]->ngaysinh }}" required>

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
                                        name="address" value="{{ $getUserById[0]->diachi }}" required>

                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <a class="btn btn-link" href="{{ url('/reset-password') }}">
                                {{ __('Đổi mật khẩu') }}
                            </a>

                            <div class="form-group row mb-0" style="display: flex;flex-direction: row-reverse;">
                                <div class="" style="margin-left: 20px">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Lưu') }}
                                    </button>
                                </div>
                                <p><a class="btn btn-back" href="{{ url('/home') }}">Quay lại</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
