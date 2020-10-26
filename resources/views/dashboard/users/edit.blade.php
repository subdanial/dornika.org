@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="clearfix">
        <h5 class="mb-3 float-left">ویرایش ویزیتور</h5>
        <a class="btn btn-info float-right" href="{{ url()->previous() }}" role="button">بازگشت</a>
    </div>
    <form action="{{ route('visitors.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <table class="table table-striped mt-4">
        <tr>
            <td>نام و نام خانوادگی</td>
            <td>
            <div class="form-group">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="نام و نام خانوادگی" value="{{ $user->name }}">
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
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="نام کاربری" value="{{ $user->username }}">
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
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="ایمیل" value="{{ $user->email }}">
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
                <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="موبایل" value="{{ $user->mobile }}">
                @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>رمزعبور جدید</td>
            <td>
            <div class="form-group">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="رمزعبور جدید">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </td>
        </tr>
        <tr>
            <td>تکرار رمزعبور جدید</td>
            <td>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="رمزعبور">
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
            <img src="{{ asset($user->avatar) }}" class="img-fluid rounded" alt="" width="128">
            <hr>
            <b>تصویر جدید:</b>
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
    <button class="btn btn-orange mb-4">به روزرسانی ویزیتور</button>    
    </form>    
</div>

@endsection
@section('js')
<script>

</script>
@endsection