

@extends('layouts.admin.master')
@section('title')
Sửa thông tin
@endsection
@section('active3')
    active
@endsection
@section('breadcrumbs')
{{ Breadcrumbs::render('commune_edit') }}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Sửa thông tin') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/admin/district/update') }}">
						<input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}" />
						<input type="hidden" id="id" name="maxa" value="{!! $getUserById[0]->maxa !!}" />
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Mã Xã') }}</label>

                            <div class="col-md-6">
                                <input id="maxa" type="text" class="form-control{{ $errors->has('maxa') ? ' is-invalid' : '' }}" name="maxa" value="{{ $getUserById[0]->maxa }}" readonly>

                                @if ($errors->has('maxa'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('maxa') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên Xã') }}</label>

                            <div class="col-md-6">
                                <input id="tenxa" type="text" class="form-control{{ $errors->has('tenxa') ? ' is-invalid' : '' }}" name="tenxa" value="{{ $getUserById[0]->tenxa }}" required>

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
                            <p><a class="btn btn-back" href="{{ url('/admin/commune') }}">Quay lại</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

