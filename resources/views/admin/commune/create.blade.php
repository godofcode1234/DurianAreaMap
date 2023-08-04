@extends('layouts.admin.master')
@section('title')
    Thêm Xã
@endsection
@section('active3')
    active
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render('commune_add') }}
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Thêm Xã') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('/admin/commune/create') }}">
                            <input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}" />

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Huyện</label>
                                <div class="col-md-6">
                                    <select name="mahuyen" class="form-control" id="sel1">
                                        @foreach($huyen as $key => $huyen)
                                        <option value="{{ $huyen->mahuyen }}">{{ $huyen->tenhuyen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Mã Xã') }}</label>

                                <div class="col-md-6">
                                    <input id="maxa" type="text"
                                        class="form-control{{ $errors->has('maxa') ? ' is-invalid' : '' }}" name="maxa"
                                        placeholder="Nhập mã xã..." required autofocus>

                                    @if ($errors->has('maxa'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('maxa') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tên Xã') }}</label>

                                <div class="col-md-6">
                                    <input id="tenxa" type="text"
                                        class="form-control{{ $errors->has('tenxa') ? ' is-invalid' : '' }}" name="tenxa"
                                        placeholder="Nhập tên xã..." required>

                                    @if ($errors->has('tenxa'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tenxa') }}</strong>
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
