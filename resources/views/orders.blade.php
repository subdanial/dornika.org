@extends('layouts.app')

@section('content')
<div class="container">
    <div class="bg-light rounded p-3 shadow-sm my-3">
        <h3 class="mb-0">سفارشات فعال</h3>
    </div>
    <div class="actives">
        @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">{{ $error }}</div>
            @endforeach
        @endif
        @if ( $orders->isEmpty() )
            <div class="alert alert-primary" role="alert">
                سفارش فعالی یافت نشد.
            </div>
        @else
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>قیمت</th>
                    <th>کمیسیون</th>
                    <th>تعداد</th>
                    <th>مشتری</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order) 
                <tr>
                    <td>{{ number_format($order->price) }} <sup>تومان</sup></td>
                    <td>{{ number_format($order->commission) }} <sup>تومان</sup></td>
                    <td>{{ number_format($order->items()->count()) }} کالا</td>
                    <td>{{ $order->client->name }}</td>
                    <td>
                        @if ( $order->delivery == 1 )
                            <span class="text-success">تکمیل شد</span>
                        @else
                            <span class="text-danger">ارسال نشده</span>
                        @endif
                    </td>
                    <td>
                  
                        <form action="{{ route('orders_cancel') }}" method="post" class="cancel-order">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $order->id }}">
                            <button type="submit" class="btn btn-danger btn-sm w-100">لغو</button>
                        </form>
                     
                      
                        <form action="{{ route('orders_return') }}" method="post" class="return-order">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $order->id }}">
                            <button type="submit" class="btn btn-warning btn-sm w-100">برگشت </button>
                        </form>
                       
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
        @endif
    </div>   
</div>
@endsection
@section('js')
<script>
$(function() {
    $('.cancel-order').submit(function() {
        var c = confirm("آیا مطمئن هستید؟");
        return c;
    });
});
</script>
@endsection