@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div id="flex-tree-container"></div>

    <div class="buttons clearfix">
        <h2 class="float-left mb-0">سفارش شماره #{{ $order->id }}</h2>
        <a href="{{ route('invoice', $order->id) }}" class="btn btn-info float-right"><i class="fa fa-file-invoice mr-2"></i>نمایش فاکتور</a>
    </div>
    <hr>
    <div class="row mb-4">
        <div class="col-12 mb-3">
            @if ( $order )
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
                        @foreach ($order->items as $item)
                        <tr class="row-{{ $item->id }}">
                            <td class="align-middle"><img src="{{ asset( $item->product->image ) }}" class="img-thumbnail rounded" width="64"/> </td>
                            <td class="align-middle"><a href="{{ route('products.single', $item->product->slug) }}" target="_blank">{{ $item->product->title }}</a></td>
                            <td class="align-middle">{{ $item->product->available }}</td>
                            <td class="align-middle">{{ $item->calculateQuantity('box') }}</td>
                            <td class="align-middle">{{ $item->calculateQuantity('num') }}</td>
                            <td class="align-middle">{{ number_format( $item->cp ? $item->cp : $item->calculatePrice()) }} تومان <p class="m-0"><small><b>تعداد کلی:</b> {{ $item->number }} عدد</small></p></td>
                            <td></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>کمیسیون</td>
                            <td class="text-right"><span class="cart-price">{{ number_format($order->commission) }}</span> تومان</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>قیمت کل</strong></td>
                            <td class="text-right"><strong><span class="cart-price">{{ number_format($order->price) }}</span> تومان</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mb-2">
            <h4>مشتری</h4>
            {{ $order->client->name }}<br>
            <small>{{ $order->client->address }}</small>
        </div>
        <div class="col mb-2">
            <h4>ویزیتور</h4>
            <p>
                <img src="{{ asset( $order->user->avatar ) }}" class="mr-2" alt="" width="45">
                {{$order->user->name}}
            </p>
        </div>
        @else
        <div class="alert alert-info" role="alert">
            <p class="m-0">فاکتور خالی می باشد.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('js')
<script>

</script>
@endsection