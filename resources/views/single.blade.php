@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-3">
            <img src="{{ asset($product->image) }}" class="rounded w-100 shadow-lg" alt="{{$product->title}}">
            @if ( auth()->user()->setting('fake_price') )
            <div class="bg-light rounded p-4 shadow-sm mt-4 mb-4">
                <h6>ثبت قیمت</h6>
                <form action="{{ route('products.fake_price', $product->slug) }}" method="post">
                    @csrf
                    <div class="form-group w-100"><?php
                        $fprice = auth()->user()->f_prices()->where('product_id', $product->id)->first();
                        ?><input type="text" class="form-control form-control-sm" name="fake_price" id="fake_price" value="{{ $fprice ? $fprice->price : 0 }}">
                        @error('fake_price')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <small id="help-box" class="form-text text-muted">قیمت شخصی (تقلبی)</small>
                    </div>
                    <div class="mt-2 clearfix">
                        <button type="submit" class="btn btn-sm btn-info float-right w-100">به روزرسانی قیمت ها</button>
                    </div>
                    <div class="mt-2 clearfix">
                        <a href="{{ route('products.reset', $product->slug) }}" class="btn btn-sm btn-light float-right w-100">ریست قیمت</a>
                    </div>
                </form>
            </div>
            @endif
        </div>
        <div class="col-md-9">
            <div class="bg-light rounded p-3 shadow-sm">
                <h3 class="mb-0">{{$product->title}}</h3>
                <small>{{$product->description}}</small>
            </div>
            <div class="commodity-info">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>موجودی انبار</td>
                            <td>{{ $product->available }}</td>
                        </tr>
                        <tr>
                            <td>قیمت مصرف کننده</td>
                            <td>{{ number_format($product->consumer) }} تومان</td>
                        </tr>
                        <tr>
                            <td>قیمت پایه</td>
                            <td>{{ number_format($product->price_one) }} تومان</td>
                        </tr>
                        <tr>
                            <td>قیمت یک </td>
                            <td>{{ number_format($product->price_two) }} تومان</td>
                        </tr>
                        <tr>
                            <td>قیمت دو </td>
                            <td>{{ number_format($product->price_three) }} تومان</td>
                        </tr>
                        <tr>
                            <td>قیمت سه </td>
                            <td>{{ number_format($product->price_four) }} تومان</td>
                            {{-- @if ( auth()->user()->setting('fake_price') && $fprice )
                            <td>{{ number_format($fprice->price) }} تومان</td>
                            @else
                            <td>{{ number_format($product->price_4) }} تومان</td>
                            @endif --}}
                        </tr>
                        <tr>
                            <td>تعداد در کارتن</td>
                            <td>{{ $product->number_in_box }}</td>
                        </tr>
                        @if ( auth()->user()->setting('commission') )
                        <tr>
                            <td>پورسانت</td>
                            <td>{{ $product->commission }}%</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="bg-light rounded p-4 shadow">
                <h4>ثبت سفارش</h4>
                <hr>
                <form action="{{ route('products.order', $product->slug) }}" method="post">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <div class="form-group w-100 p-2">
                            <label for="client">مشتری</label>
                            <select class="form-control client-selector @error('client') is-invalid @enderror" name="client" value="{{ old('client') }}" id="client">
                            @foreach (auth()->user()->clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                            </select>
                            @error('client')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group w-50 p-2 text-center">
                        <label for="box">کارتن</label>
                        <div class="input-group number-spinner">
                            <span class="input-group-btn">
                                <button class="btn btn- " data-dir="dwn"><span class="fa fa-minus"></span></button>
                            </span>
                            <input type="text" class="form-control text-center @error('box') is-invalid @enderror" name="box" value="{{ old('box') ? old('box') : 0 }}" id="box" aria-describedby="help-box" placeholder="کارتن">
                            <span class="input-group-btn">
                                <button class="btn btn-default" data-dir="up"><span class="fa fa-plus"></span></button>
                            </span>
                        </div>
                        <small id="help-box" class="form-text text-muted">تعداد کارتن</small>
                        @error('box')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group w-50 p-2 text-center">
                        <label for="number">ظرف</label>
                        <div class="input-group number-spinner">
                            <span class="input-group-btn">
                                <button class="btn btn-default" data-dir="dwn"><span class="fa fa-minus"></span></button>
                            </span>
                            <input type="text" class="form-control text-center @error('number') is-invalid @enderror" name="number" value="{{ old('number') ? old('number') : 0 }}" id="number" aria-describedby="help-number" placeholder="تعداد">
                            <span class="input-group-btn">
                                <button class="btn btn-default" data-dir="up"><span class="fa fa-plus"></span></button>
                            </span>
                        </div>
                        <small id="help-number" class="form-text text-muted">تعداد ظرف محصول</small>
                        @error('number')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>
                    <div class="mt-2 clearfix">
                        <button type="submit" class="btn btn-info float-right">ثبت سفارش</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('js')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
$( ".client-selector" ).select2( {
    theme: "bootstrap",
    placeholder: "انتخاب مشتری",
    dir: "rtl",
    language: {
       "noResults": function(){
           return "یافت نشد.";
       }
    },
} );
</script>
@endsection