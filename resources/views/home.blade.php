@extends('layouts.app')

@section('content')
@if ( $products1->isNotEmpty() ) 
<div class="container mt-5 dashbord-tops">
    <h4 class="mb-4">پرفروش ترین ها</h4>
    <div class="row">
        @foreach ($products1 as $p1)
        <div class="col">
            <div class="stuff">
                <img src="{{ asset( $p1->product->image ) }}" class="mb-2">
                <h5><a href="{{ route('products.single', $p1->product->slug) }}">{{ $p1->product->title }}</a></h5>
                <h6>{{ $p1->product->description }}</h6>
            </div>
        </div>
        @endforeach
    </div>
    <a href="{{ route('selling') }}" class="btn btn-orange">مشاهده کامل</a>
    <hr>
</div>
@endif

@if ( $products2->isNotEmpty() )
<div class="container mt-5 dashbord-tops">
    <h4 class="mb-4">جدیدترین ها</h4>
    <div class="row">
        @foreach ($products2 as $p2)
        <div class="col">
            <div class="stuff">
                <img src="{{ asset( $p2->image ) }}" class="mb-2">
                <h5><a href="{{ route('products.single', $p2->slug) }}">{{ $p2->title }}</a></h5>
                <h6>{{ $p2->description }}</h6>
            </div>
        </div>
        @endforeach
    </div>
    <a href="{{ route('latest') }}" class="btn btn-orange">مشاهده کامل</a>
    <hr>
</div>
@endif

@if ( $products3->isNotEmpty() )
<div class="container mt-5 dashbord-tops">
    <h4 class="mb-4">پرسود ترین ها</h4>
    <div class="row">
        @foreach ($products3 as $p3)
        <div class="col">
            <div class="stuff">
                <img src="{{ asset( $p3->product->image ) }}" class="mb-2">
                <h5><a href="{{ route('products.single', $p3->product->slug) }}">{{ $p3->product->title }}</a></h5>
                <h6>{{ $p3->product->description }}</h6>
            </div>
        </div>
        @endforeach
    </div>
    <a href="{{ route('viewed') }}" class="btn btn-orange">مشاهده کامل</a>
    <hr>
</div>
@endif

@if (auth()->user()->hasRole('admin'))
<div class="container">
    <table class="table table-borderless">
        <tbody>
            <tr>
                <td>تعداد ویزیتورها</td>
                <td>{{ $visitors }} نفر</td>
            </tr>
            <tr>
                <td>تعداد مشتری های ثبت شده</td>
                <td>{{ $clients }} مشتری</td>
            </tr>
            </tr>
            <tr>
                <td>مبلغ فروش کل</td>
                <td>{{ number_format($sales) }} تومان</td>
            </tr>
            </tr>
            <tr>
                <td>مبلغ پورسانت کل</td>
                <td>{{ number_format($commissions) }} تومان</td>
            </tr>
        </tbody>
    </table>
</div>
@endif
@endsection
