@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>سبد خرید</h3>
    @if ( session()->has('message') )
        <div class="alert alert-success">
            <p class="m-0">{{ session()->get('message') }}</p>
        </div>
    @endif
    <div class="row mb-4">
        <div class="col-12 mb-3">
            @if ( $cart )
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">محصول</th>
                            <th scope="col">موجودی</th>
                            <th scope="col">تعداد کارتن</th>
                            <th scope="col">تعداد ظرف</th>
                            <th scope="col">قیمت</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart->items as $item)
                        <tr class="row-{{ $item->id }}">
                            <td class="align-middle"><img src="{{ asset( $item->product->image ) }}" class="img-thumbnail rounded" width="64"/> </td>
                            <td class="align-middle"><a href="{{ route('products.single', $item->product->slug) }}" target="_blank">{{ $item->product->title }}</a></td>
                            <td class="align-middle">{{ $item->product->available }}</td>
                            <td class="align-middle">{{ $item->calculateQuantity('box') }}</td>
                            <td class="align-middle">{{ $item->calculateQuantity('num') }}</td>
                            <td class="align-middle">{{ number_format($item->calculatePrice()) }} تومان</td>
                            <td class="text-right align-middle"><button class="btn btn-sm btn-danger deleteItem" data-loading-text='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' data-item-id="{{ $item->id }}"><i class="fa fa-trash"></i> </button> </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>کمیسیون</td>
                            <td class="text-right"><span class="cart-price">{{ number_format($cart->commission) }}</span> تومان</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>قیمت کل</strong></td>
                            <td class="text-right"><strong><span class="cart-price">{{ number_format($cart->price) }}</span> تومان</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mb-2">
            {{ $cart->client->name }}<br>
            <small>{{ $cart->client->address }}</small>
        </div>
        <div class="col mb-2">
            <a href="{{ route('categories') }}" class="btn btn-block btn-light">بازگشت به محصولات</a>
            <button class="btn btn-lg btn-block btn-success saveCart" data-loading-text='<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'>ثبت فاکتور</button>
        </div>
        @else
        <div class="alert alert-info" role="alert">
            <p class="m-0">سبد خرید خالی می باشد.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('js')
<script>
$(function () { 

$('.deleteItem').on('click', function () {
    var id = $(this).data('item-id');
    if ( id ) {
        $(this).button('loading');
        axios.post('{{ route('removeItem') }}', {
            id: id
        })
        .then(res => {
            if ( res.data.reload ) {
                location.reload();
            }

            $(this).button('reset');
            $('.cart-price').html(res.data.price);
            $('.row-'+id).fadeOut();
        })
        .catch(err => {
            $(this).button('reset');
            console.error(err); 
        })
    }
});

$('.saveCart').on('click', function () {
    $(this).button('loading');
    axios.post('{{ route('saveCart') }}')
    .then(res => {
        $(this).button('reset');
        alert('فاکتور با موفقیت ثبت شد.');
        window.location.href = res.data.redirect;
    })
    .catch(err => {
        $(this).button('reset');
        alert(err.response.data.message);
    })
});

});
</script>
@endsection