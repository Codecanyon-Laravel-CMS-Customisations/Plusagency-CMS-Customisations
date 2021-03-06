@php
if (Session::has('cart')) {
    $cart = Session::get('cart');
} else {
    $cart = null;
}
$sitemenus = \App\Menu::where('language_id', $lang->id)->where('is_product', 0);
$productmenus = \App\Menu::where('language_id', $lang->id)->where('is_product', 1);

$names = [];
if ($productmenus->count() > 0) {
    $productmenus = $productmenus->first()->menus;
    $productmenus = json_decode($productmenus, true);
    foreach ($productmenus as $key => $value) {
        $names[] = $value['text'];
    }
} else {
    $productmenus = [];
}
$categories1 = \App\Pcategory::whereIn('name', $names)
    ->where('language_id', $lang->id)
    ->where('status', 1)
    ->with('childs')
    ->where('menu_level', '1')
    ->get();
$megaMenuIds = \App\Megamenu::where('type', 'product_categories')
    ->where('language_id', $lang->id)
    ->where('category', 1)
    ->first();
$ids = [];
$ids2 = [];
$indexes2 = [];
if (!empty($megaMenuIds)) {
    if (!empty($megaMenuIds->subcat)) {
        foreach (json_decode($megaMenuIds->subcat, true) as $key => $value) {
            foreach ($value as $value2) {
                $ids[] = $value2;
            }
        }
    }

    if (!empty($megaMenuIds->menus)) {
        foreach (json_decode($megaMenuIds->menus, true) as $key2 => $value2) {
            $indexes2[] = $key2;
            foreach ($value2 as $value3) {
                $ids2[] = $value3;
            }
        }
    }
}
$products = \App\Product::withoutGlobalScope('variation')->where('status', 1);
@endphp
<!--===== HEADER CONTENT =====-->
<header id="site-header" class="site-header__v1">
    <div class="topbar border-bottom d-none d-md-block">
        <div class="container-fluid px-2 px-md-5 px-xl-8d75">
            <div class="topbar__nav d-md-flex justify-content-between align-items-center">
                <ul class="topbar__nav--left nav ml-md-n3">
                    <li class="nav-item"><a href="#" class="nav-link link-black-100"><i
                                class="glph-icon flaticon-question mr-2"></i>Can we help you?</a></li>
                    <li class="nav-item"><a href="tel:{{ $bs->support_phone }}" class="nav-link link-black-100"><i
                                class="glph-icon flaticon-phone mr-2"></i>{{ $bs->support_phone }}</a></li>
                </ul>
                <ul class="topbar__nav--right nav mr-md-n3">
                    {{-- <li class="nav-item"><a href="#" class="nav-link link-black-100"><i
                                class="glph-icon flaticon-pin"></i></a></li>
                    <li class="nav-item"><a href="#" class="nav-link link-black-100"><i
                                class="glph-icon flaticon-switch"></i></a></li>
                    <li class="nav-item"><a href="#" class="nav-link link-black-100"><i
                                class="glph-icon flaticon-heart"></i></a></li> --}}

                    @php
                        $header_v2_button_text = 'GIVE US FEEDBACK';
                        try {
                            $lang = App\Language::where('code', request()->has('language', 'en'))->first();
                            $settings = $lang->basic_extended;

                            $header_v2_button_text = $settings->header_v2_button_text;
                        } catch (\Exception $e) {
                        }
                    @endphp
                    {{-- <a href="{{ route('feedback') }}" class="btn btn-dark rounded-0 btn-wide py-1 px-3 font-weight-medium ml-auto">
                        {{ $header_v2_button_text }}
                    </a> --}}
                    @if (trim($header_v2_button_text) != '')
                        <li class="nav-item">
                            <a href="javascript:;" data-href="{{ route('feedback') }}" class="nav-link link-black-100"
                                data-toggle="modal"
                                data-target="#headerProductInquiryModal">{{ $header_v2_button_text }}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <!-- Account Sidebar Toggle Button -->
                        <a id="sidebarNavToggler" href="javascript:;" role="button" class="nav-link link-black-100"
                            aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false"
                            data-unfold-event="click" data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarContent" data-unfold-type="css-animation" data-unfold-overlay='{
                            "className": "u-sidebar-bg-overlay",
                            "background": "rgba(0, 0, 0, .7)",
                            "animationSpeed": 500
                        }' data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                            data-unfold-duration="500">
                            <i class="glph-icon flaticon-user"></i>
                        </a>
                        <!-- End Account Sidebar Toggle Button -->
                    </li>
                    <li class="nav-item">
                        <!-- Cart Sidebar Toggle Button -->
                        <a id="sidebarNavToggler1" href="javascript:;" role="button"
                            class="nav-link link-black-100 position-relative" aria-controls="sidebarContent1"
                            aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                            data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1"
                            data-unfold-type="css-animation" data-unfold-overlay='{
                            "className": "u-sidebar-bg-overlay",
                            "background": "rgba(0, 0, 0, .7)",
                            "animationSpeed": 500
                        }' data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                            data-unfold-duration="500">
                            {{-- <span class="position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 right-0">3</span> --}}
                            <i class="glph-icon flaticon-icon-126515"></i>
                        </a>
                        <!-- End Cart Sidebar Toggle Button -->
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="masthead border-bottom position-relative" style="margin-bottom: -1px;">
        <div class="container-fluid px-3 px-md-5 px-xl-8d75 py-2 py-md-0">
            <div class="d-flex align-items-center position-relative flex-wrap">
                <div class="offcanvas-toggler mr-4 mr-lg-8">
                    {{-- <!-- Account Sidebar Toggle Button --> --}}
                    <a id="sidebarNavToggler" class="cat-menu" href="javascript:;" role="button"
                        aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false"
                        data-unfold-event="click" data-unfold-hide-on-scroll="false"
                        data-unfold-target="#sidebar001Content" data-unfold-type="css-animation"
                        data-unfold-animation-in="fadeInLeft" data-unfold-animation-out="fadeOutLeft"
                        data-unfold-duration="500">
                        <svg width="20px" height="18px">
                            <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z" />
                            <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z" />
                            <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z" />
                        </svg>
                    </a>
                    {{-- <!-- End Account Sidebar Toggle Button --> --}}
                </div>
                <div class="site-branding pr-md-4">
                    <a href="{{ route('front.index') }}" class="d-block mb-1">
                        <img src="{{ asset('assets/front/img/' . $bs->logo) }}" class="img-fluid lazy" alt="">
                    </a>
                </div>
                <div class="site-navigation mr-auto d-none d-xl-block">
                    {{-- <ul class="nav d-none"> --}}
                    {{-- @foreach (json_decode($menus, true) as $link) --}}
                    {{-- @php --}}
                    {{-- $href = getHref($link); --}}
                    {{-- @endphp --}}

                    {{-- @if (strpos($link['type'], '-megamenu') !== false) --}}
                    {{-- @includeIf('front.bookworm.partials.mega-menu') --}}

                    {{-- @else --}}

                    {{-- @if (!array_key_exists('children', $link)) --}}
                    {{--  --}}{{-- - Level1 links which doesn't have dropdown menus - --}}
                    {{-- <!--TODO add dynamic actve class--> --}}
                    {{-- <li class="nav-item"><a href="{{ $href }}" target="{{ $link["target"] }}"class="nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium border-bottom border-primary border-width-2">{{ $link["text"] }}</a></li> --}}

                    {{-- @else --}}
                    {{-- <li class="nav-item dropdown"> --}}
                    {{-- <a id="{{ \Str::slug($link['text']) }}DropdownInvoker" href="{{ $href }}" target="{{ $link['target'] }}" class="dropdown-toggle nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium d-flex align-items-center" --}}
                    {{-- aria-haspopup="true" --}}
                    {{-- aria-expanded="false" --}}
                    {{-- data-unfold-event="hover" --}}
                    {{-- data-unfold-target="#{{ \Str::slug($link['text']) }}DropdownMenu" --}}
                    {{-- data-unfold-type="css-animation" --}}
                    {{-- data-unfold-duration="200" --}}
                    {{-- data-unfold-delay="50" --}}
                    {{-- data-unfold-hide-on-scroll="true" --}}
                    {{-- data-unfold-animation-in="slideInUp" --}}
                    {{-- data-unfold-animation-out="fadeOut"> --}}
                    {{-- {{ $link['text'] }} --}}
                    {{-- </a> --}}
                    {{-- <ul id="{{ \Str::slug($link['text']) }}DropdownMenu" class="dropdown-unfold dropdown-menu font-size-2 rounded-0 border-gray-900" aria-labelledby="{{ \Str::slug($link['text']) }}DropdownInvoker"> --}}
                    {{--  --}}{{-- START: 2nd level links --}}
                    {{-- @foreach ($link['children'] as $level2) --}}
                    {{-- @php --}}
                    {{-- $l2Href = getHref($level2); --}}
                    {{-- @endphp --}}

                    {{-- <li @if (array_key_exists('children', $level2)) class="submenus" @endif> --}}


                    {{--  --}}{{-- START: 3rd Level links --}}
                    {{-- @if (array_key_exists('children', $level2)) --}}
                    {{-- <li class="position-relative"> --}}
                    {{-- <a id="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($level2['text']) }}DropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $level2['text'] }} --}}
                    {{-- </a> --}}
                    {{-- <ul id="{{ \Str::slug($level2['text']) }}DropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--hidden u-unfold--reverse-y" aria-labelledby="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker" style="animation-duration: 200ms;"> --}}
                    {{-- @foreach ($level2['children'] as $level3) --}}
                    {{-- @php --}}
                    {{-- $l3Href = getHref($level3); --}}
                    {{-- @endphp --}}
                    {{-- <li> --}}
                    {{-- <a href="{{$l3Href}}" target="{{$level3["target"]}}" class="dropdown-item link-black-100">{{ $level3['text'] }}</a></li> --}}
                    {{-- @endforeach --}}
                    {{-- </ul> --}}
                    {{-- </li> --}}
                    {{-- @else --}}
                    {{-- <a href="{{$l2Href}}" target="{{$level2["target"]}}" class="dropdown-item link-black-100">{{ $level2['text'] }}</a> --}}
                    {{-- @endif --}}
                    {{--  --}}{{-- END: 3rd Level links --}}

                    {{-- </li> --}}
                    {{-- @endforeach --}}
                    {{--  --}}{{-- END: 2nd level links --}}
                    {{-- </ul> --}}
                    {{-- </li> --}}
                    {{-- @endif --}}

                    {{-- @endif --}}

                    {{-- @endforeach --}}
                    {{-- </ul> --}}
                    @includeIf('front.bookworm.chemistry.molecules.front_main_nav_strip')

                    <div class="site-search ml-xl-0 ml-md-auto w-r-100 my-2 my-xl-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <i class="glph-icon flaticon-loupe input-group-text py-2d75 bg-white-100 border-white-100"
                                    onclick="window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=&type=new&tag=&review=`"
                                    style="cursor: pointer;"></i>
                            </div>
                            <input class="form-control bg-white-100 min-width-380 py-2d75 height-4 border-white-100"
                                type="search" placeholder="Search for Books by Keyword ..." aria-label="Search"
                                id="search"
                                onkeydown="if(event.key === 'Enter') window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=&type=new&tag=&review=`;"
                                value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                        </div>
                        <button class="btn btn-outline-success btn-search my-2 my-sm-0 sr-only" type="button"
                            onclick="window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=&type=new&tag=&review=`"
                            style="cursor: pointer;">Search</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="modal fade" id="headerProductInquiryModal" tabindex="-1"
                 aria-labelledby="headerProductInquiryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg--- modal-xl modal-dialog-centered modal-dialog-scrollable---naaah">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-5 py-2 pl-3 pr-2 d-none d-lg-block" style="background-repeat:no-repeat;background-size:cover;background-image: url('https://img.freepik.com/free-photo/abstract-blur-defocused-bookshelf-library_1203-9640.jpg?w=740');background-position:top">
                                        <div class="d-flex align-content-center flex-wrap bd-highlight mb-3" style="min-height: 77vh">
                                            <div
                                                style="background-color: #00000050;font-weight: bolder;border-radius: 7px;"
                                                class="p-2 w-100">
                                                <h3
                                                    style="text-shadow: 0px 1px 7px black;color: white;font-weight: bolder;"
                                                    class="modal-title m-0"
                                                    id="productInquiryModalLabel">Books Inquiry & Info</h3>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <p
                                                    class="py-5 d-none"
                                                    style="color: black;text-shadow: 1px 1px 7px black;text-align: justify;">
                                                    Give us a call or drop by anytime, we endeavour to answer all enquiries within 24 hours on business days.
                                                </p>
                                            </div>
                                            <div class="p-2 mt-5 pt-5 bd-highlight">
                                                <div class="key-icon-box icon-default icon-left cont-left py-2">
                                                    <i class="fas fa-phone-volume d-inline-block px-2"></i>
                                                    <h5 class="service-heading d-inline-block"><a href="tel:{{ $bs->support_phone }}">{{ $bs->support_phone }}</a></h5>
                                                </div>
                                                <div class="key-icon-box icon-default icon-left cont-left py-2">
                                                    <i class="fas fa-envelope-open-text d-inline-block px-2"></i>
                                                    <h5 class="service-heading d-inline-block"><a href="mailto:{{ $bs->support_email }}">{{ $bs->support_email }}</a></h5>
                                                </div>
                                            </div>
                                            <div class="p-2">
                                                <button type="button"
                                                    class="btn btn-dark submit-button border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link"
                                                    style="color: #fff">{{ __('Submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-sm-12 col-lg-7 p-2"
                                        style="max-height: 77vh;overflow: hidden;overflow-y: scroll;">
                                        <button type="button" class="close"
                                        style="background-color: white;font-weight: bolder;font-size: 1.7rem;color: #000000;width: 35px;height: 35px;border-radius: 50%;opacity: .9;box-shadow: 0px 0px 7px #000000;"
                                        data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <form action="{{ route('product.inquiries.bulk-inquiry') }}" class="contact-form pt-5 mt-5"
                                              method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="headerProductsSelect">{{ __('Book(s) Selector') }}</label>
                                                <select id="headerProductsSelect" name="products[]" class="form-control select2"
                                                        multiple="multiple"
                                                        data-placeholder="{{ __('Select/Type Name, Author or ISBN') }}"
                                                        aria-describedby="productsHelp" style="width: 100%"></select>
                                                @if ($errors->has('products'))
                                                    <small id="productsHelp"
                                                           class="form-text text-danger">{{ $errors->first('products') }}</small>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input class="form-control" name="name" type="text"
                                                               placeholder="{{ __('Name') }}" required>
                                                        @if ($errors->has('name'))
                                                            <small id="nameHelp"
                                                                   class="form-text text-danger">{{ $errors->first('name') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input class="form-control" name="whatsapp_number" type="text"
                                                               placeholder="{{ __('Whatsapp Number') }}" required>
                                                        @if ($errors->has('whatsapp_number'))
                                                            <small id="whatsappNumberHelp"
                                                                   class="form-text text-danger">{{ $errors->first('whatsapp_number') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input class="form-control" name="email" type="email"
                                                               placeholder="{{ __('Email') }}" required>
                                                        @if ($errors->has('email'))
                                                            <small id="emailHelp"
                                                                   class="form-text text-danger">{{ $errors->first('email') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12 pt-2 pb-4">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">Preferred Communication: </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="radioCom1">
                                                            <input type="radio" class="form-check-input" id="radioCom1"
                                                                   name="preferred_communication" value="Whatsapp" checked>
                                                            Whatsapp
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="radioCom2">
                                                            <input type="radio" class="form-check-input" id="radioCom2"
                                                                   name="preferred_communication" value="Email"> Email
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input name="subject" class="form-control" type="text"
                                                               placeholder="{{ __('Subject') }}" required
                                                               value="{{ old('subject', 'Inquiry of a number of products') }}">
                                                        @if ($errors->has('subject'))
                                                            <small id="subjectHelp"
                                                                   class="form-text text-danger">{{ $errors->first('subject') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea name="message" class="form-control" id="comment" cols="30"
                                                                  rows="10" placeholder="{{ __('Type your message') }}"
                                                                  required></textarea>
                                                        @if ($errors->has('message'))
                                                            <small id="messageHelp"
                                                                   class="form-text text-danger">{{ $errors->first('message') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($bs->is_recaptcha == 1)
                                                    <style>
                                                        .captcha-col > div {
                                                            display: inline-block;
                                                        }

                                                    </style>
                                                    <div class="col-md-12 my-2 text-center captcha-col">
                                                        {!! NoCaptcha::renderJs() !!}
                                                        {!! NoCaptcha::display() !!}
                                                        @if ($errors->has('g-recaptcha-response'))
                                                            @php
                                                                $errmsg = $errors->first('g-recaptcha-response');
                                                            @endphp
                                                            <p class="text-danger mb-0">{{ __("$errmsg") }}</p>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </form>
                                        <div class="px-0 text-center w-100 py-2  d-block d-lg-none">
                                            <button type="button"
                                                class="btn btn-dark submit-button border-0 rounded-0 p-3 ml-auto mr-auto min-width-250 single_add_to_cart_button button alt cart-btn cart-link"
                                                style="color: #fff">{{ __('Submit') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@include('front.bookworm.header.aside')


<!--===== END HEADER CONTENT =====-->
