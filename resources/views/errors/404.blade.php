
@extends('errors::illustrated-layout')

@section('code', '404')
@section('title', __('صفحه مورد نظر یافت نشد'))

@section('image')
<div style="background-image: url('/svg/404.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('2با عرض پوزش، صفحه مورد نظر شما پیدا نشد.'))

