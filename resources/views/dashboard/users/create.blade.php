@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="clearfix">
        <h5 class="mb-3 float-left">افزودن ویزیتور جدید</h5>
        <a class="btn btn-info float-right" href="{{ url()->previous() }}" role="button">بازگشت</a>
    </div>
    <form action="{{ route('visitors.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <table class="table table-striped mt-4">
        <tr>
            <td>نام و نام خانوادگی</td>
            <td>
            <div class="form-group">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="نام و نام خانوادگی" value="{{ old('name') }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>نام کاربری</td>
            <td>
            <div class="form-group">
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="نام کاربری" value="{{ old('username') }}">
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>ایمیل</td>
            <td>
            <div class="form-group">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="ایمیل" value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>موبایل</td>
            <td>
            <div class="form-group">
                <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="موبایل" value="{{ old('mobile') }}">
                @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>رمزعبور</td>
            <td>
            <div class="form-group">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="رمزعبور" value="{{ old('password') }}">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>تکرار رمزعبور</td>
            <td>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="رمزعبور" value="{{ old('password_confirmation') }}">
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>تصویر</td>
            <td>
            <div class="form-group">
            <input type="file" name="avatar" class="form-control-file @error('avatar') is-invalid @enderror">
            @error('avatar')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            </td>
        </tr>
    </table>
    <button class="btn btn-orange mb-4">ثبت ویزیتور</button>    
    </form>    
</div>

@endsection
@section('js')
<script>

</script>
@endsection