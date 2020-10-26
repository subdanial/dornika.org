<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/landing/vendor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('/landing/css/style.css') }}">
    <title>درنیکا</title>
</head>

<body>
    <nav class="dornika-navbar navbar navbar-expand-md navbar-dark fixed-top ">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{ asset('/landing/img/logo.png') }}" alt=""></a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0 dornika-ul">
                    <li class="nav-item ">
                        <a class="nav-link active" href="#home">خانه </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#about">درباره ما </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#goodnews">خبر های خوب </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#properties">ویژگی </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#avantages">مزایای همکاری </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#contact">تماس باما </a>
                    </li>


                </ul>

            </div>
        </div>

    </nav>

    <div class="hero" id="home">
        <div class="container">
            <div class="hero-data">
                <div class="row hero-image">
                    <img src="{{ asset('/landing/img/hero-picture.png') }}" alt="hero-dornika">
                </div>

                <div class="row hero-buttons">
                    <div class="col-md-6 col-sm-12"><button class="btn float-md-right d-block d-lg-inline-block ">لینک
                            مستقیم
                            اندروید <span class="direct"></span></button></div>
                    <div class="col-md-6 col-sm-12"><a href="{{ asset('/download/dornika.apk') }}" class="btn d-md-block d-block d-lg-inline-block">دانلود از
                            کافه
                            بازار<span class="bazaar"></span></a></div>
                </div>

            </div>
        </div>
    </div>
    <!-- about -->
    <div class="about article" id="about">
        <div class="container">
            <div class="title">درباره ی ما</div>
            <div class="describe">
                مجموعه‌ی درنیکا در سال 1398 به عنوان اولین مجموعه‌ی خرید و فروش هوشمند کالا و بارهای حجمی با بررسی
                نیازهای بازار و با هدف حرکت به سمت بازاری هوشمند، سریع و مطمئن با دسترسی آسان آغاز کرد.
                این مجموعه تلاش می‌کند تا با بالا بردن سطح فرهنگ عمومی بازار بازده و کیفیت خرید و فروش را به حد اکثر
                برساند.
                درنیکا با اتصال بازاریابان با تجربه و کارآموخته به فروشندگان موجب میشود کالای حجمی مورد نظر باسود دلخواه
                و در کوتاه ترین بازه زمانی به فروش برسد.

            </div>
        </div>
    </div>
    <!-- news -->
    <div class="news article" id="goodnews">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="title title-black">خبر خوب برای فروشنده</div>
                    <div class="describe">همکاری با تیم جوان و پویای درنیکا نوید بخش شروع حرکتی بزرگ در خدمت رسانی خرید
                        و فروش هوشمند کالا می‌باشد که به کمک شما می آید تا توسط بازاریابان شبکه‌ای درنیکا بارهای حجمی
                        خود را در کمترین زمان با قیمت دلخواه خودتان بفروشید</div>
                </div>
                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="image"><img src="{{ asset('/landing/img/sell.png') }}" alt="seller"></div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-8 order-lg-12">
                    <div class="title title-black">خبر خوب برای خریدار</div>
                    <div class="describe">تیم جوان و پویای درنیکا به کمک شما می آیند تا بهترین‌ها را به شما پیشنهاد دهند
                        و شما را به خریدی مطمئن و با کیفیت دعوت کنند تا کالاهای مورد نیاز خود را با قیمتی مناسب در
                        سریع‌ترین مان ممکن درب مغازه تحویل بگیرید.
                    </div>
                </div>
                <div class="col-lg-4 order-lg-1">
                    <div class="image"><img src="{{ asset('/landing/img/buy.png') }}" alt="buyer"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- property -->
    <div class="property article" id="properties">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="title title-white">
                        ویژگی های کار در درنیکا
                    </div>
                    <div class="describe">
                        ممجموعه درنیکا به عنوان اولین سامانه‌ی خرید و فروش هوشمند کالای حجمی در ایران 
با ارائه خدماتی سریع، مطمئن و با کیفیت به مشتریان و فروشندگان مسیر جدیدی را در جهت اتصال مستقیم این دو فراهم میسازد.
درنیکا با ایجاد مزایای مثبتی از جمله حق سود 1 تا 10 درصدی و همچنین فراهم کردن موقعیت شراکت در فروش فضای ارزش مندی برای بازاریاب ارائه داده که به این واسطه فرصت مناسبی برای جذب بازاریابان با تجربه فراهم میسازد.
همچنین درنیکا محیط آموزشی رایگانی را برای افزایش مهارت بازاریابان تازه کار در کنار متجربین این عرصه فراهم کرده تا اهرم تسریعی برای هرچه زودتر موفق شدن نو کاران این عرصه باشد.
همچنین درنیکا با در نظر گرفتن هوشیارانه نیاز های فردی اعضای جدید با ارائه دادن خدمات کاربردی مسیر تامین هزینه های مالی نوکاران را سهولت می بخشد  
<br>
                        <a class="btn" href="{{ route('home') }}">ورود به سامانه <span></span></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="phone d-none d-lg-block"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- advantages -->
    <div class="avantages article" id="avantages">
        <div class="container">
            <div class="title">مزایای کار در رنیکا</div>
            <div class="describe">همکاری با تیم جوان و پویای درنیکا نوید بخش شروع حرکتی بزرگ </div>
            <div class="item">
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-lg-3">
                        <div class="image"><img src="{{ asset('/landing/img/tree.png') }}" alt=""></div>
                        <div class="subtitle">بینش عمل گرا</div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-lg-3">
                        <div class="image"><img src="{{ asset('/landing/img/smile.png') }}" alt=""></div>
                        <div class="subtitle">محیط صمیمی و پویا</div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-lg-3">
                        <div class="image"><img src="{{ asset('/landing/img/punch.png') }}" alt=""></div>
                        <div class="subtitle"> سریع ، متمرکز و هدفمند</div>
                    </div>
                    <div class="col-md-6 col-xs-12 col-lg-3">
                        <div class="image"><img src="{{ asset('/landing/img/user.png') }}" alt=""></div>
                        <div class="subtitle">فرصت یادگیری و ارتقا</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact -->
    <div class="contact article" id="contact">
        <div class="container-fluid p-0 ">
            <div class="row">

                <div class="col-md-6 order-lg-2">
                <div class="map">
                <img src="{{ asset('/landing/img/map.jpg') }}" height="100%" alt="">
                </div>
                </div>

                <div class="col-md-6">
                    <div class="address">
                        <div class="title">
                            تماس با درنیکا
                        </div>
                        <div class="discribe">از مسیر های زیر میتوانید با درنیکا در ارتباط باشید.</div>
                        <hr>
                        <p><span><i class="fas fa-map-marker-alt"></i>آدرس : </span>تهران، میدان محمدیه، ضلع شمال شرقی
                            میدان، جنب
                            مترو، پلاک 15 و 16</p>
                        <p><span><i class="fas fa-map"></i>کد پستی : </span>1164719816</p>
                        <p><span><i class="fas fa-phone"></i>تماس ثابت : </span>55895460-021</p>
                        <p><span><i class="fas fa-mobile"></i>تماس همراه : </span> 6905331-0912</p>
                        <p><span><i class="fas fa-envelope"></i>ایمیل : </span>info@dornika.org</p>
                        <p><span><i class="fas fa-clock"></i>ساعات پاسخگویی : </span>8 صبح تا 12 شب </p>

                    </div>
                </div>


            </div>
        </div>
    </div>

    <script src="{{ asset('/landing/vendor/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('/landing/vendor/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/landing/vendor/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).scroll(function () {
            var n = $(window).scrollTop();
            if (n <= 100 && $(document).width() >= 1200) {

                $(".navbar-brand img").css("height", "80px");
                $(".dornika-navbar").css("background", "none");
                $(".navbar-dark .navbar-nav .nav-link").css("font-size", "22px");
                $(".navbar-brand img").attr("src", "{{ asset('/landing/img/logo.png') }}");

            } else {
                $(".navbar-brand img").css("height", "50px");
                $(".dornika-navbar").css("background", "var(--dornika-blue)");
                $('.navbar-nav').attr('style', 'margin-top: 18px !important');
                $(".navbar-dark .navbar-nav .nav-link").css("font-size", "18px");
                $(".navbar-brand img").attr("src", "{{ asset('/landing/img/logo-white.png') }}");
            }
        });

        if ($(document).width() <= 1200) {
            $(".navbar-brand img").css("height", "50px");
            $(".dornika-navbar").css("background", "var(--dornika-blue)");
            $('.navbar-nav').attr('style', 'margin-top: 18px !important');
            $(".navbar-dark .navbar-nav .nav-link").css("font-size", "18px");
            $(".navbar-brand img").attr("src", "{{ asset('/landing/img/logo-white.png') }}");
        }

        $(document).ready(function () {
            $('ul li a').on('click', function () {
                var clicked = $(this);
                $('ul li a').each(function () {
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                    }
                });
                $(this).addClass('active');
            });
        });

    </script>
</body>

</html>
