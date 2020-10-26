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
    @auth
        
    @if ( auth()->user()->hasRole('admin') )
    <nav class="navbar navbar-expand-lg bg-blue">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Dornika <h6 class="d-inline-block"><span class="badge badge-info">ADMIN</span></h6></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">صفحه اصلی </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">دسته ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">مشتری ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">محصولات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('visitors.index') }}">ویزیتور ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">سفارشات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('messages.index') }}">پیام ها</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">خروج</a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </nav>
    <main roll="main">
        <div class="content">
            @yield('content')
        </div>
    </main>
    @else
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
                        <i class="nav-top-button float-right fas fa-cog menu-visitor-settings"></i>
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
                <li><a href="{{ route('orders') }}"><i class="fas fa-history"></i>سفارشات فعال</a></li>
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
                // $has_menu_cart = auth()->user()->carts()->orderBy('created_at', 'desc')->first();
                $has_menu_cart = auth()->user()->carts()->where('status', 0)->first();
                if ( $has_menu_cart && $has_menu_cart->status == 0 && $has_menu_cart->price > 0 ) {
                    $menu_cart = $has_menu_cart;
                } else {
                    $menu_cart = false;
                }
                ?>
                @if ( $menu_cart )
                @foreach ($menu_cart->items as $item)
                <div class="stuff h-auto" data-cart="{{ $menu_cart->id }}" data-item="{{ $item->id }}">
                    <div class="clearfix">
                        <div class="float-left px-2 py-4 w-50 d-flex justify-content-start">
                            <div class="mr-2 align-self-center">
                                <button class="btn btn-default btn-sm p-0 text-danger deleteItemCart" data-item="{{ $item->id }}"><span class="fa fa-times"></span></button>
                            </div>
                            <div>
                                <div class="stuff-name"> {{ $item->product->title }}</div>
                                <div class="stuff-price"> {{ number_format($item->calculatePrice()) }} تومان</div>
                            </div>
                        </div>
                        <div class="float-right p-1 px-2 w-50 d-flex justify-content-end">
                            <div class="form-group text-center m-0 p-0 mr-1">
                            <div class="input-group box-spinner-ajax">
                                <span class="input-group-btn d-block w-100">
                                    <button class="btn btn-default btn-sm p-0" data-dir="up"><span class="fa fa-plus"></span></button>
                                </span>
                                <span class="cart-input-label bg-secondary">کارتن</span>
                                <input type="text" class="form-control text-center form-control-sm d-block w-100" name="box" disabled id="box" aria-describedby="help-box" value="{{ $item->calculateQuantity('box') }}">
                                <span class="input-group-btn d-block w-100">
                                    <button class="btn btn-default btn-sm p-0" data-dir="dwn"><span class="fa fa-minus"></span></button>
                                </span>
                            </div>
                            </div>
                            <div class="form-group text-center m-0 p-0 ml-1">
                            <div class="input-group number-spinner-ajax">
                                <span class="input-group-btn d-block w-100">
                                    <button class="btn btn-default btn-sm p-0" data-dir="up"><span class="fa fa-plus"></span></button>
                                </span>
                                <span class="cart-input-label">ظرف</span>
                                <input type="text" class="form-control text-center form-control-sm d-block w-100" name="number" disabled id="number" aria-describedby="help-number" value="{{ $item->calculateQuantity('num') }}">
                                <span class="input-group-btn d-block w-100">
                                    <button class="btn btn-default btn-sm p-0" data-dir="dwn"><span class="fa fa-minus"></span></button>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="nav-left-footer">
                    <div class="client-name">{{ $menu_cart->client->name }}</div>
                    <div class="client-address">{{ $menu_cart->client->address }}</div>

                    <a href="{{ route('cart') }}" class="btn btn-white w-100 mt-2 ">مشاهده سبد خرید</a>
                    <table class="nav-left-table table table-borderless mt-2">
                        <tr>
                            <td>قیمت کل</td>
                            <td><span class="total-cart">{{ number_format($menu_cart->price) }}</span> تومان</strong></td>
                        </tr>
                        <tr>
                            <td>کمیسیون</td>
                            <td><span class="commission-cart">{{ number_format($menu_cart->commission) }}</span> تومان</strong></td>
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
    <div class="modal fade" id="visitor-settings" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">تنظیمات</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('saveSettings') }}" method="post" class="saveSettingsForm">
            @csrf
            <div class="clearfix mb-4">
                <div class="float-left">
                    نمایش کمیسیون 
                </div>
                <div class="float-right">
                    <div class="material-switch float-left">
                        <input id="show-commission" name="commission" type="checkbox"{{ auth()->user()->setting('commission') ? ' checked="checked"' : '' }}/>
                        <label for="show-commission" class="btn-info"></label>
                    </div>
                </div>
            </div>
            <div class="clearfix mb-4">
                <div class="float-left">
                    نمایش قیمت تقلبی 
                </div>
                <div class="float-right">
                    <div class="material-switch float-left">
                    <input id="fake-price" name="fake_price" type="checkbox"{{ auth()->user()->setting('fake_price') ? ' checked="checked"' : '' }}/>
                        <label for="fake-price" class="btn-info"></label>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
            <button type="button" class="btn btn-primary saveSettings">ذخیره تنظیمات</button>
        </div>
        </div>
    </div>
    </div>
    @endif
    @endauth

    @guest
    <main roll="main">
        <nav class="nav-top">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <a href="{{ route('login') }}"><i class="nav-top-button fas fa-sign-in-alt"></i></a>
                    </div>
                    <div class="col-4">
                        <h2 class="nav-top-logo"><a href="{{ route('home') }}" class="text-white">Dornika</a></h2>
                    </div>
                    <div class="col-4">
                    </div>
                </div>
            </div>
        </nav>
        <div class="content">
            @yield('content')
        </div>
    </main>
    @endguest
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-imageupload.min.js') }}"></script>
    <script src="{{ asset('js/flex-tree.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>
