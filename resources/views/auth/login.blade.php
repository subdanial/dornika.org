@extends('layouts.simple')

@section('content')

    <form class="login-form" method="POST" action="{{ route('login') }}">
        @csrf
        <h2><b>D</b>ornika</h2>
        <input type="text" name="username" class="form-control" placeholder="کد کاربری">
        @error('username')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="password" name="password" class="form-control" placeholder="رمز عبور">
        @error('password')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <button class="btn btn-orange mt-2">ورود به سامانه</button>
        <a href="{{ route('categories') }}" class="btn btn-info mt-2"> کاتالوگ</a>
        <a href="http://dornika.org/" class="btn btn-info mt-2">درباره ما</a>
     
    </form>
@endsection
