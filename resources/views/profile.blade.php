@extends('layouts.app')

@section('content')
<div class="container">
    <div class="profile">
        <img src="{{ asset( $user->avatar ) }}" class="rounded-circle" width="250">
        <h4>{{ $user->name }}</h4>
        <h6>کد ویزیتور : {{ $user->id }}</h6>
    </div>
    <div class="resume">
        <table class="table">
            <tbody>
                <tr>
                    <td>تعداد فروش</td>
                    <td>{{ $sales_number }}</td>
                </tr>
                <tr>
                    <td>مبلغ آخرین فروش
                    </td>
                    <td>{{ number_format( $last_sale ) }} تومان</td>
                </tr>
                <tr>
                    <td>پورسانت آخرین فروش </td>
                    <td>{{ number_format($last_com) }} تومان</td>
                </tr>
                <tr>
                    <td>مبلغ فروش کل </td>
                    <td>{{ number_format( $sales ) }} تومان</td>
                </tr>
                <tr>
                    <td>مبلغ پورسانت کل </td>
                    <td>{{ number_format($total_com) }} تومان</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>

</script>
@endsection