<!DOCTYPE html>
<html>

<head>
    <!--Start of Google Analytics script-->
    @if ($bs->is_analytics == 1)
        {!! $bs->google_analytics_script !!}
    @endif
    <!--End of Google Analytics script-->

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $bs->website_title }} @yield('pagename')</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}" type="image/x-icon">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    <!-- plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/plugin.min.css') }}">

    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">

    <!-- common css -->
    <link href="/assets/front/sidebar-nav/dist/hc-offcanvas-nav.carbon.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/common-style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @yield('styles')


    @if ($bs->is_tawkto == 1 || $bex->is_whatsapp == 1)
        <style>
            .back-to-top.show {
                right: auto;
                left: 20px;
            }

            .hero__title-line-1 {
                font-weight: 500 !important;
                font-size: 2.75rem;
            }

        </style>
    @endif
    @if (count($langs) == 0)
        <style media="screen">
            .support-bar-area ul.social-links li:last-child {
                margin-right: 0px;
            }

            .support-bar-area ul.social-links::after {
                display: none;
            }

        </style>
    @endif

    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}">
    <!-- common base color change -->
    <link href="{{ url('/') }}/assets/front/css/common-base-color.php?color={{ $bs->base_color }}"
        rel="stylesheet">
    <!-- base color change -->
    <link
        href="{{ url('/') }}/assets/front/css/base-color.php?color={{ $bs->base_color }}{{ $be->theme_version != 'dark' ? '&color1=' . $bs->secondary_base_color : '' }}"
        rel="stylesheet">

    @if ($be->theme_version == 'dark')
        <!-- dark version css -->
        <link rel="stylesheet" href="{{ asset('assets/front/css/dark.css') }}">
        <!-- dark version base color change -->
        <link href="{{ url('/') }}/assets/front/css/dark-base-color.php?color={{ $bs->base_color }}"
            rel="stylesheet">
    @endif

    @if ($rtl == 1)
        <!-- RTL css -->
        <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/front/css/pb-rtl.css') }}">
    @endif
    <!-- jquery js -->
    <script src="{{ asset('assets/front/js/jquery-3.3.1.min.js') }}"></script>

    @if ($bs->is_appzi == 1)
        <!-- Start of Appzi Feedback Script -->
        <script async src="https://app.appzi.io/bootstrap/bundle.js?token={{ $bs->appzi_token }}"></script>
        <!-- End of Appzi Feedback Script -->
    @endif

    <!-- Start of Facebook Pixel Code -->
    @if ($be->is_facebook_pexel == 1)
        {!! $be->facebook_pexel_script !!}
    @endif
    <!-- End of Facebook Pixel Code -->

    <!--Start of Appzi script-->
    @if ($bs->is_appzi == 1)
        {!! $bs->appzi_script !!}
    @endif
    <!--End of Appzi script-->

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/bookworm/vendor/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bookworm/vendor/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bookworm/vendor/animate.css/animate.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/bookworm/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bookworm/vendor/slick-carousel/slick/slick.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/bookworm/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">

    <!-- CSS Bookworm Template -->
    <link rel="stylesheet" href="{{ asset('assets/bookworm/css/theme.css') }}">
    <style>
        .toast-container {
            background-color: green !important;
        }

        .toast-success {
            background-color: green !important;
        }

    </style>
    @php
        $colors = \App\WebsiteColors::all();
    @endphp

    <style>
        .height-5.form-control,
        .widget-content select,
        footer .widget select,
        .widget_search .search-field,
        .height-5.custom-select,
        .widget-content select.custom-select,
        footer .widget select.custom-select,
        .widget_search .custom-select.search-field,
        header select[id="category_id"] {
            /*height: calc( 1.5em + ( 1rem * 1.5 ) + 10px);*/
            height: 50px;
        }

        .site-branding img {
            max-height: 4rem;
        }

        @if (!empty($colors))@foreach ($colors as $color){!! $color->element !!} {
            {!! $color->attribute !!}: #{{ $color->value }};
        }

        @endforeach @endif.site-navigation>ul>li ul>li:hover .dropdown-toggle::after {
            transform: rotate(-90deg);
            transition-duration: .5s;
        }

        .site-navigation>ul>li ul>li>a:hover .dropdown-toggle::after {
            transform: rotate(-90deg);
            transition-duration: .5s;
        }

        .u-sidebar-bg-overlay {
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: 1001;
            display: none;
            width: 100%;
            height: 100%;
        }

        .u-sidebar {
            z-index: 1002;
        }

        .btn-primary-green:focus,
        .btn-primary-green.focus,
        .btn-primary-green:not(:disabled):not(.disabled):active:focus {
            box-shadow: none !important;
        }

        #site-header .btn-search {
            border: 0px solid transparent !important;
        }

        .hc-offcanvas-nav .nav-close-button span::before {
            margin-left: -6px;
        }
        #site-header :is(a, button)[data-target='#headerProductInquiryModal']{
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        #site-header .dropdown-unfold {
            padding-bottom; 0px !important;
            padding-top; 0px !important;
        }
    </style>
</head>

<body>
    @include('front.bookworm.partials.navbar')
    <div class="u-sidebar-bg-overlay" style="background-color: rgba(0, 0, 0, 0.7); display: none;"></div>
    @if (!request()->routeIs('front.index') && !request()->routeIs('front.packageorder.confirmation'))
        <div class="page-header border-bottom">
            <div class="container">
                @php
                    $name = app()->view->getSections()['breadcrumb-link'];
                    // dd($name);
                    $product = \App\Product::where('title', '=', $name)->first();
                    if (!empty($product)) {
                        $main_category = $product->category;
                        $sub_child_category = \App\Pcategory::find($product->sub_child_category_id);
                        $sub_category = \App\Pcategory::find($product->sub_category_id);
                    }

                @endphp
                <div class="d-md-flex justify-content-between align-items-center py-4">
                    <h1 class="page-title font-size-3 font-weight-medium m-0 text-lh-lg">@yield('breadcrumb-title')</h1>
                    {{-- <nav class="woocommerce-breadcrumb font-size-2">
                        <a href="{{route('front.index')}}" class="h-primary">{{__('Home')}}</a>
                        <span class="breadcrumb-separator mx-1"><i class="fas fa-angle-right"></i></span>
                        @if (!empty($main_category))
                            <span>{{ $main_category->name }}</span>
                            <span class="breadcrumb-separator mx-1"><i class="fas fa-angle-right"></i></span>
                        @endif
                        @if (!empty($sub_category))
                            @if (!empty($sub_category))
                            <span>{{ $sub_category->name }}</span>
                            <span class="breadcrumb-separator mx-1"><i class="fas fa-angle-right"></i></span>
                            @endif
                        @endif
                        @if (!empty($sub_child_category))
                            <span>{{ $sub_child_category->name }}</span>
                            <span class="breadcrumb-separator mx-1"><i class="fas fa-angle-right"></i></span>
                        @endif
                        @yield('breadcrumb-link') --}}
                    @yield('breadcrumb-links')
                    </nav>
                </div>
            </div>
        </div>
    @endif
    @yield('content')

    <!-- ========== FOOTER ========== -->
    <div class="space-1d625"></div>
    @include('front.bookworm.footer.'. $be->bookworm_footer_version )
    <!-- ========== END FOOTER ========== -->

    {{-- WhatsApp Chat Button --}}
    <div id="WAButton"></div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{-- <script src="{{ asset('assets/bookworm/vendor/jquery/dist/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('assets/bookworm/vendor/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>
    <script src="{{ asset('assets/bookworm/vendor/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/bookworm/vendor/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/bookworm/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/bookworm/vendor/slick-carousel/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/bookworm/vendor/multilevel-sliding-mobile-menu/dist/jquery.zeynep.js') }}"></script>
    <script
        src="{{ asset('assets/bookworm/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}">
    </script>


    <!-- JS HS Components -->
    <script src="{{ asset('assets/bookworm/js/hs.core.js') }}"></script>
    <script src="{{ asset('assets/bookworm/js/components/hs.unfold.js') }}"></script>
    <script src="{{ asset('assets/bookworm/js/components/hs.malihu-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/bookworm/js/components/hs.header.js') }}"></script>
    <script src="{{ asset('assets/bookworm/js/components/hs.slick-carousel.js') }}"></script>
    <script src="{{ asset('assets/bookworm/js/components/hs.selectpicker.js') }}"></script>
    <script src="{{ asset('assets/bookworm/js/components/hs.show-animation.js') }}"></script>


    <script>
        var links = $(".site-navigation ul li ul");
        for (var a = 0; a < links.length; a++) {
            var mylink = links[a];
            sortUL(mylink);
        }

        function sortUL(selector) {
            $(selector).children("li").sort(function(a, b) {
                var upA = $(a).text().toUpperCase();
                var upB = $(b).text().toUpperCase();
                return (upA < upB) ? -1 : (upA > upB) ? 1 : 0;
            }).appendTo(selector);
        }
    </script>

    <script>
        // language dropdown toggle on clicking button
        $('.language-btn').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).next('.language-dropdown').toggleClass('open');
        });
    </script>
    <!-- JS Bookworm -->
    <script>
        $(document).on('ready', function() {
            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                afterOpen: function() {
                    /* $('#sidebarNavToggler').on('click', function(){
                        $('.u-sidebar-bg-overlay').css({display : "block"});
                    }); */
                    $('#sidebarAuthToggler').on('click', function() {
                        $('.u-sidebar-bg-overlay').css({
                            display: "block"
                        });
                    });
                    /* $('#sidebarNavToggler1').on('click', function(){
                        $('.u-sidebar-bg-overlay').css({display : "block"});
                    }); */
                },
                afterClose: function() {
                    $('.u-sidebar-bg-overlay').css({
                        display: "none"
                    });
                }
            });

            // initialization of slick carousel=
            $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');

            // initialization of header
            $.HSCore.components.HSHeader.init($('#header'));

            // initialization of malihu scrollbar
            $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

            // initialization of show animations
            $.HSCore.components.HSShowAnimation.init('.js-animation-link');

            // init zeynepjs
            var zeynep = $('.zeynep').zeynep({
                onClosed: function() {
                    // enable main wrapper element clicks on any its children element
                    $("body main").attr("style", "");

                    console.log('the side menu is closed.');
                },
                onOpened: function() {
                    // disable main wrapper element clicks on any its children element
                    $("body main").attr("style", "pointer-events: none;");

                    console.log('the side menu is opened.');
                }
            });

            // handle zeynep overlay click
            $(".zeynep-overlay").click(function() {
                zeynep.close();
            });

            // open side menu if the button is clicked
            // $(".cat-menu").click(function () {
            //     if ($("html").hasClass("zeynep-opened")) {
            //         zeynep.close();
            //     } else {
            //         zeynep.open();
            //     }
            // });
        });
    </script>

    @if ($bex->is_shop == 1 && $bex->catalog_mode == 0)
        <div id="cartIconWrapper">
            <a class="d-block" id="cartIcon" href="{{ route('front.cart') }}">
                <div class="cart-length">
                    <i class="fas fa-cart-plus"></i>
                    <span class="length">{{ cartLength() }} {{ __('ITEMS') }}</span>
                </div>
                <div class="cart-total">
                    {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}
                    {{ cartTotal() }}
                    {{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}
                </div>
            </a>
        </div>
    @endif

    <!--====== PRELOADER PART START ======-->
    <!--====== PRELOADER PART ENDS ======-->

    {{-- WhatsApp Chat Button --}}
    {{-- <div id="WAButton"></div>

<!--Scroll-up-->
<a id="scroll_up" ><i class="fas fa-angle-up"></i></a> --}}


    {{-- Cookie alert dialog start --}}
    @if ($be->cookie_alert_status == 1)
        @include('cookieConsent::index')
    @endif
    {{-- Cookie alert dialog end --}}

    {{-- Popups start --}}
    @includeIf('front.partials.popups')
    {{-- Popups end --}}

    @php
        $mainbs = [];
        $mainbs = json_encode($mainbs);
    @endphp
    <script>
        var mainbs = {!! $mainbs !!};
        var mainurl = "{{ url('/') }}";
        var vap_pub_key = "{{ env('VAPID_PUBLIC_KEY') }}";

        var rtl = {{ $rtl }};
    </script>
    <!-- popper js -->
    {{-- <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script> --}}
    <!-- Plugin js -->
    <script src="{{ asset('assets/front/js/plugin.min.js') }}"></script>
    <!-- main js -->
    {{-- <script src="{{asset('assets/front/js/construction-main.js')}}"></script> --}}
    <!-- pagebuilder custom js -->
    <script src="{{ asset('assets/front/js/common-main.js') }}"></script>

    {{-- whatsapp init code --}}
    {{-- @if ($bex->is_whatsapp == 1)
<script type="text/javascript">
    var whatsapp_popup = {{$bex->whatsapp_popup}};
    var whatsappImg = "{{asset('assets/front/img/whatsapp.svg')}}";
    $(function () {
        $('#WAButton').floatingWhatsApp({
            phone: "{{$bex->whatsapp_number}}", //WhatsApp Business phone number
            headerTitle: "{{$bex->whatsapp_header_title}}", //Popup Title
            popupMessage: `{!! nl2br($bex->whatsapp_popup_message) !!}`, //Popup Message
            showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
            buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
            position: "right" //Position: left | right

        });
    });
</script>
@endif --}}
    {{-- whatsapp init code --}}
    @if ($bex->is_whatsapp == 1)
        <script type="text/javascript">
            var whatsapp_popup = {{ $bex->whatsapp_popup }};
            var whatsappImg = "{{ asset('assets/front/img/whatsapp.svg') }}";
            $(function() {
                $('#WAButton').floatingWhatsApp({
                    phone: "{{ $bex->whatsapp_number }}", //WhatsApp Business phone number
                    headerTitle: "{{ $bex->whatsapp_header_title }}", //Popup Title
                    popupMessage: `{!! nl2br($bex->whatsapp_popup_message) !!}`, //Popup Message
                    showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
                    buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
                    position: "right" //Position: left | right

                });
            });
        </script>
    @endif

    @if (session()->has('success'))
        <script>
            toastr["success"]("{{ __(session('success')) }}");
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            toastr["error"]("{{ __(session('error')) }}");
        </script>
    @endif

    <!--Start of subscribe functionality-->
    <script>
        $(document).ready(function() {
            $("#subscribeForm, #footerSubscribeForm").on('submit', function(e) {
                // console.log($(this).attr('id'));

                e.preventDefault();

                let formId = $(this).attr('id');
                let fd = new FormData(document.getElementById(formId));
                let $this = $(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // console.log(data);
                        if ((data.errors)) {
                            $this.find(".err-email").html(data.errors.email[0]);
                        } else {
                            toastr["success"]("You are subscribed successfully!");
                            $this.trigger('reset');
                            $this.find(".err-email").html('');
                        }
                    }
                });
            });

            // lory slider responsive
            $(".gjs-lory-frame").each(function() {
                let id = $(this).parent().attr('id');
                $("#" + id).attr('style', 'width: 100% !important');
            });
        });
    </script>
    <!--End of subscribe functionality-->

    <!--Start of Tawk.to script-->
    @if ($bs->is_tawkto == 1)
        {!! $bs->tawk_to_script !!}
    @endif
    <!--End of Tawk.to script-->

    <!--Start of AddThis script-->
    @if ($bs->is_addthis == 1)
        {!! $bs->addthis_script !!}
    @endif
    <!--End of AddThis script-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            @php
            $products = \App\Product::query()
                ->orderBy('title', 'ASC')
                ->get()
                ->each(function ($query) {
                    if (session()->has('product_ids')) {
                        $product_ids = (array) session('product_ids');
                        if (in_array($query->id, $product_ids)) {
                            $query->selected = true;
                            return $query;
                        }
                    }
                }); //->pluck('title', 'current_price', 'id');
            echo 'var productsArrayData = ' . json_encode($products) . ';';
            @endphp

            var data = $.map(productsArrayData, function(obj) {
                obj.text = obj.text || obj.title; // replace name with the property used for the text

                return obj;
            });

            $('#headerProductInquiryModal .select2').select2({
                data: data,
                dropdownParent: $('#headerProductInquiryModal'),
                placeholder: "{{ __('Attach Products') }}",
                templateResult: formatProduct
            });
        });

        function formatProduct(product) {
            //if (!product.id) {
            return product.text;
            //}
            // var $product = $(
            //     '<span><img src="' + product.feature_image + '" class="img-flag" style="max-width: 50px;max-height: 40px;"/> ' + product.text + '</span>'
            // );
            // return $product;
        };

        $('#headerProductInquiryModal .submit-button').on('click', function(e) {
            e.preventDefault();
            $('#headerProductInquiryModal form').submit();
        });
    </script>
    <script src="/assets/front/sidebar-nav/dist/hc-offcanvas-nav.js"></script>
    <script>
        var myNav = new hcOffcanvasNav('#main-nav', {
            insertClose: true,
            insertBack: true,
            labelClose: 'SHOP BY CATEGORY',
            labelBack: 'Back',
            levelTitleAsBack: true,
            pushContent: false, // default false
            //width: 280 // width & height,
            //height:'auto' // width & height,
            swipeGestures: true, // enable swipe gestures
            expanded: false, // initialize the menu in expanded mode
            levelOpen: 'expand', // overlap / expand / none
            levelSpacing: 40, // in pixels
            levelTitles: false, // shows titles for submenus
            closeOpenLevels: true, // close sub levels when the nav closes
            closeActiveLevel: false, // clear active levels when the nav closes
            navTitle: null, // the title of the first level
            navClass: '', // extra CSS class(es)
            disableBody: true, // disable body scroll
            closeOnClick: true, // close the nav on click
            customToggle: '#sidebarNavToggler', // custom toggle element
            bodyInsert: 'prepend', // prepend or append the menu to body
            keepClasses: true, // should original menus and their items classes be preserved or excluded.
            removeOriginalNav: false, // remove original menu from the DOM
            rtl: false // enable RTL mode
        });
        $('#sidebarNavToggler').css({
            'position': 'relative',
            'top': '0px'
        });
    </script>
    @yield('scripts')
</body>

</html>
