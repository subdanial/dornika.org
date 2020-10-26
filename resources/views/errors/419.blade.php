@extends('errors::illustrated-layout')

@section('code', '419')
@section('title', __('خطای 419'))

@section('image')
<div style="background-image: url('/svg/403.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('متاسفانه Session شما تمام شده است. لطفا صفحه را مجددا بارگذاری کنید.'))
