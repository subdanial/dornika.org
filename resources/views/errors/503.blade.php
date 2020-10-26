@extends('errors::illustrated-layout')

@section('code', '503')
@section('title', __('خطای 503'))

@section('image')
<div style="background-image: url('/svg/503.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __($exception->getMessage() ?: 'با عرض پوزش، ما درحال حاضر تغییراتی روی سرور اعمال می کنیم لطفا تا پایان تغییرات صبور باشید.'))
