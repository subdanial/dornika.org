@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="container dashbord-edit-products">
        <div class="py-3">
        <h3 class="m-0">
            پربازدید ترین محصولات
        </h3>
        <small class="m-0 mb-3 text-muted">نمایش {{ $products->count() }} از {{ $products->total() }} محصول</small>
        </div>
        @if ( $products->isNotEmpty() )
        <div class="row">
            @foreach ($products as $p)
            <div class="col-6 col-md-4 col-lg-3 col-xs-6">
                <div class="stuff shadow bg-white rounded">
                    <img src="{{ asset( $p->product->image ) }}" class="rounded">
                    <h5><a href="{{ route('products.single', $p->product->slug) }}">{{ $p->product->title }}</a></h5>
                    <h6>{{ $p->product->description }}</h6>
                    @if ( auth()->user()->hasRole('admin') )
                    <div class="stuff-edit">
                    <a href="{{ route('products.edit', $p->product->id) }}" class="btn btn-info">ویرایش</a>
                    <a href="#" class="btn btn-danger">حذف</a>
                    </div>
                    @else
                    <div class="text-center">
                        <a href="{{ route('products.single', $p->product->slug) }}" class="btn btn-info">مشاهده</a>
                    </div>
                    @endif
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
@endsection