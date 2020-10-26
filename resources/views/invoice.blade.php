<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting('site_name', 'Dornika') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-imageupload.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flex-tree.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container">
        <h6 class="text-center mt-2">بسم الله رحمن رحیم</h6>
        <div class="card">
            <div class="card-header">

                <div class="row">
                    <div class="col">
                        <img src="{{ asset('/img/logo-factor.png') }}" height="80px">
                    </div>

                    <div class="col">
                        <p class="text-right">تاریخ : {{ verta($cart->updated_at)->formatJalaliDate() }}<br> فاکتور #{{ $cart->id }}</p>
                    </div>

                </div>

            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <h5 class="mb-2"><b>اطلاعات فروشنده</b></h5>
                        <div class="d-inline font-weight-bold">شمارثابت: <small>55895460-021</small></div>
                        <div class="d-inline font-weight-bold ml-5">شماره همراه: <small>6905331-0912</small></div>
                        <div class="d-inline font-weight-bold ml-5">نشانی: <small>تهران، میدان محمدیه، ضلع شمال شرقی
                                میدان، جنب مترو، پلاک 15 و 16</small></div><br>
                        <div class="d-inline font-weight-bold ">کد پستی: <small>1164719816</small></div>
                        <div class="d-inline font-weight-bold  ml-5 ">کد ملی : </div>
                        <div class="d-inline font-weight-bold ml-5"> کد اقتصادی : </div>
                        <div class="d-inline font-weight-bold ml-5">نام ویزیتور: <small>{{ $cart->user->name }}</small></div>
                        <hr>
                        <h5 class="mb-2 mt-3"><b>اطلاعات خریدار</b></h5>
                        <div class="d-inline font-weight-bold ">نام مشتری: <small>{{ $cart->client->name }}</small></div>
                        <div class="d-inline font-weight-bold ml-5">نشانی مشتری: <small>{{ $cart->client->address }}</small></div><br>
                        <div class="d-inline font-weight-bold ">تلفتن مشتری: <small>{{ $cart->client->phone }}</small></div>
                        <div class="d-inline font-weight-bold ml-5">کد ملی مشتری: <b></b></div>
                        <div class="d-inline font-weight-bold ml-5">کد پستی مشتری: <b></b></div>
                        <div class="d-inline font-weight-bold ml-5">شهر: <b></b></div>
                    </div>
                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام کالا</th>
                                <th>قیمت مصرف کننده</th>
                                <th>قیمت کالا</th>
                                <th>تعداد در کارتن</th>
                                <th> کارتن</th>
                                <th> ظرف</th>
                                <th>قیمت کل</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $count = 1; ?>
                        @foreach ($cart->items as $item)
                        <tr>
                            <td>{{ $count }}<?php $count++; ?></td>
                            <td>{{ $item->product->title }}</td>
                            <td>{{ $item->product->consumer }}</td>
                            <td>{{ $item->pp ? $item->pp : $item->singlePrice() }}</td>
                            <td>{{ $item->product->number_in_box }}</td>
                            <td>{{ $item->calculateQuantity('box') }}</td>
                            <td>{{ $item->calculateQuantity('num') }}</td>
                            <td>{{ number_format( $item->cp ? $item->cp : $item->calculatePrice()) }} تومان</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>مجموع</strong></td>
                            <td><span class="cart-price">{{ number_format($cart->price) }}</span> تومان</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <p>اینجانب مالک / نماینده فروشگاه بدین وسیله تایید مینمایم که کالای مشروح فوق را سالم و بدون کسری تحویل
                    گرفتم.</p>
                    <hr>
                <p>شماره کارت بانک سامان به نام امیر حسین معینی: 6219861031249161<br>  شماره کارت بانک صادرات به نام امیر حسین معینی :  6037697541517139</p>
              
            </div>

        </div>


    </div>
</body>
