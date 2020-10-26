@extends('errors::illustrated-layout')

@section('code', '401')
@section('title', __('خطای 401'))

@section('image')
<div style="background-image: url('/svg/403.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('متاسفانه شما مجوز لازم برایی دسترسی به این صفحه را ندارید.'))
