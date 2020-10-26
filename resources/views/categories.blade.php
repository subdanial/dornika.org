@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 p-0 d-none d-lg-block">
            <nav class="dashbord-right-nav shadow-lg">
                @if ( $categories )
                <ul class="nav-right-list">
                    <li{!! $category == null ? ' class="bg-info"' : '' !!}><a href="{{ route('categories') }}"{!! $category == null ? ' class="text-white"' : ' class="text-muted"' !!}><i class="fas fa-grip-lines mr-2"></i>همه دسته بندی ها</a></li>
                    @foreach ($categories as $c)
                    <li{!! $c->id == $category ? ' class="bg-info"' : '' !!}><a href="{{ route('categories', $c->id) }}"{!! $c->id == $category ? ' class="text-white"' : ' class="text-muted"' !!}><i class="fas fa-grip-lines mr-2"></i>{{ $c->title }}</a></li>
                    @endforeach
                </ul>
                @else
                <p class="m-0 py-2 text-muted">دسته بندی وجود ندارد.</p>
                @endif
            </nav>
        </div>
        <div class="col-12 col-lg-10 p-0">
            <nav class="dashbord-top-sub-nav shadow-sm bg-light">
                @if ( $sub_categories && $sub_categories->isNotEmpty() )
                <ul>
                    @foreach ($sub_categories as $sc)
                    <li{!! $sc->id == $sub_category ? ' class="bg-info"' : '' !!}><a href="{{ route('categories', [$category, $sc->id]) }}"{!! $sc->id == $sub_category ? ' class="text-white mx-3"' : ' class="text-muted mx-3"' !!}>{{ $sc->title }}</a></li>
                    @endforeach
                </ul>
                @else
                <p class="m-0 px-3 text-muted">یک دسته بندی از منو سمت راست انتخاب کنید.</p>
                @endif
            </nav>
            <div class="container dashbord-edit-products">
                <div class="py-3">
                <h3 class="m-0">
                    محصولات
                </h3>
                <small class="m-0 mb-3 text-muted">نمایش {{ $products->count() }} از {{ $products->total() }} محصول</small>
                </div>
                @if ( $products->isNotEmpty() )
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3 col-xs-6">
                        <div class="stuff shadow bg-white rounded">
                            <img src="{{ asset( $product->image ) }}" class="rounded">
                            <h5><a href="{{ route('products.single', $product->slug) }}">{{ $product->title }}</a></h5>
                            <h6>{{ $product->description }}</h6>
                            @auth
                            @if ( auth()->user()->hasRole('admin') )
                            <div class="stuff-edit">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info">ویرایش</a>
                            <a href="#" class="btn btn-danger">حذف</a>
                            </div>
                            @else
                            <div class="text-center">
                                <a href="{{ route('products.single', $product->slug) }}" class="btn btn-info">مشاهده</a>
                            </div>
                            @endif
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-default btn-sm btn-block text-muted border">برای نمایش محصول وارد شوید</a>
                            @endguest
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-danger" role="alert">
                    <p class="m-0">محصولی یافت نشد!</p>
                </div>
                @endif
                <div class="mt-2">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection