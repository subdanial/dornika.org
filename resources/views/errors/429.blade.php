@extends('errors::illustrated-layout')

@section('code', '429')
@section('title', __('خطای 429'))

@section('image')
<div style="background-image: url('/svg/403.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('با عرض پوزش، شما درخواست های زیادی را به سرور ما ارسال کرده اید.'))
