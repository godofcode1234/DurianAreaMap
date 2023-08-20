@extends('layouts.admin.master')
@section('title')
Thêm Huyện
@endsection
@section('active2')
    active
@endsection
@section('breadcrumbs')
{{ Breadcrumbs::render('district_add') }}
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Thêm Huyện') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/admin/district/create') }}">
						<input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}" />
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Mã Huyện') }}</label>

                            <div class="col-md-6">
                                <input id="mahuyen" type="text" class="form-control{{ $errors->has('mahuyen') ? ' is-invalid' : '' }}" name="mahuyen" placeholder="Nhập mã huyện..." required autofocus>

                                @if ($errors->has('mahuyen'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mahuyen') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên Huyện') }}</label>

                            <div class="col-md-6">
                                <input id="tenhuyen" type="text" class="form-control{{ $errors->has('tenhuyen') ? ' is-invalid' : '' }}" name="tenhuyen" placeholder="Nhập tên huyện..." required>

                                @if ($errors->has('tenhuyen'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tenhuyen') }}</strong>
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
                            <p><a class="btn btn-back" href="{{ url('/admin/district') }}">Quay lại</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

