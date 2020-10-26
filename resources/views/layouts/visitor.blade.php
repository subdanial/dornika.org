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
    @yield('css')
</head>

<body>
    <div class="cover"></div>
    <main roll="main">
        <nav class="nav-top">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <i class="nav-top-button fas fa-bars menu-setting"></i>
                        <i class="nav-top-button fas fa-boxes menu-catalog"></i>
                    </div>
                    <div class="col-4">
                        <h2 class="nav-top-logo"><a href="{{ route('home') }}" class="text-white">Dornika</a></h2>
                    </div>
                    <div class="col-4">
                        <i class="nav-top-button float-right fas fa-shopping-cart menu-stuff"></i>
                    </div>
                </div>
            </div>
        </nav>
        <nav class="nav-right nav-right-setting">
            <div class="nav-right-header">
                <div class="nav-right-logo">
                    <h2>Dornika</h2>
                </div>
            </div>
            <ul class="nav-right-list">
                <li><a href="{{ route('index') }}"><i class="far fa-circle"></i> صفحه اصلی </a></li>
                <li><a href="{{ route('profile', auth()->user()->username) }}"><i class="far fa-user"></i> پروفایل </a></li>
                <li><a href="{{ route('categories') }}"><i class="fas fa-boxes"></i> کاتالوگ</a></li>
                <li><a href="{{ route('clients') }}"><i class="fas fa-users"></i>مشتری ها</a></li>
                <li><a href="#"><i class="fas fa-history"></i>سفارشات فعال</a></li>
                <li><a href="{{ route('messages') }}"><i class="fas fa-cog"></i> پیام ها</a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i> خروج</a></li>
            </ul>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <nav class="nav-right nav-right-catalog">
            <div class="nav-right-header">
                <div class="nav-right-logo">
                    <h2><i class="fas fa-boxes"></i>کاتالوگ</h2>
                </div>
            </div>
            <ul class="nav-right-list">
                @foreach ($catalogs as $cat)
                <li><a href="{{ route('categories', [$cat]) }}"><i class="fas fa-grip-lines"></i> {{ $cat->title }} </a></li>
                @endforeach
            </ul>
        </nav>
        <nav class="nav-left">
            <div class="nav-left-header">
                <div class="row">
                    <div class="col"><i class="fas fa-shopping-cart"></i></div>
                    {{-- <div class="col">
                        <div class="float-right">حذف همه<i class="fas fa-trash-alt"></i></div>
                    </div> --}}
                </div>
            </div>
            <div class="nav-left-stuffs">
                <?php 
                $has_menu_cart = auth()->user()->carts()->orderBy('created_at', 'desc')->first();
                if ( $has_menu_cart && $has_menu_cart->status == 0 && $has_menu_cart->price > 0 ) {
                    $menu_cart = $has_menu_cart;
                } else {
                    $menu_cart = false;
                }
                ?>
                @if ( $menu_cart )
                <div class="stuff p-4">
                    <div class="row">
                        {{-- <div class="col-3 nav-left-counter">
                            <div class="d-inline-block negative">+</div>
                            <div class="d-inline-block count">1</div>
                            <div class="d-inline-block posetinve">-</div>
                        </div> --}}
                        @foreach ($menu_cart->items as $item)
                        <div class="col-xs-12">
                            <div class="stuff-name"> {{ $item->product->title }}</div>
                            <div class="stuff-price"> {{ number_format($item->calculatePrice()) }} تومان</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="nav-left-footer">
                    <div class="client-name">{{ $menu_cart->client->name }}</div>
                    <div class="client-address">{{ $menu_cart->client->address }}</div>

                    <a href="{{ route('cart') }}" class="btn btn-white w-100 mt-2 ">مشاهده سبد خرید</a>
                    <table class="nav-left-table table table-borderless mt-2">
                        <tr>
                            <td>قیمت کل</td>
                            <td>{{ number_format($menu_cart->price) }}</span> تومان</strong></td>
                        </tr>
                        <tr>
                            <td>کمیسیون</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                @else
                <div class="alert alert-info m-2" role="alert">
                    سبد خرید خالی میباشد.
                </div>
                @endif
            </div>
        </nav>
        <div class="content">
            @yield('content')
        </div>
    </main>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-imageupload.min.js') }}"></script>
    <script src="{{ asset('js/flex-tree.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>
