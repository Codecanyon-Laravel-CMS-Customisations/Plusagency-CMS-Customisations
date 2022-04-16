@php
if (Session::has('cart')) {
$cart = Session::get('cart');
} else {
$cart = null;
}
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
@php
$header_v2_button_text = 'GIVE US FEEDBACK';
try {
$lang = App\Language::where('code', request()->has('language', 'en'))->first();
$settings = $lang->basic_extended;

$header_v2_button_text = $settings->header_v2_button_text;
} catch (\Exception $e) {
}
@endphp
@if(isset($cart) && $cart != null)
@php
$cartTotal = 0;
$countitem = 0;
if($cart){
foreach($cart as $p){
$cartTotal += $p['price'] * $p['qty'];
$countitem += $p['qty'];
}
}
@endphp
@endif
@if(isset($wish) && $wish != null)
@php
$cartTotal = 0;
$countitem = 0;
if($wish){
foreach($wish as $p){
$cartTotal += $p['price'] * $p['qty'];
$countitem += $p['qty'];
}
}
@endphp
@endif

<style>
    
    option {
        background-color: #fff;
    }

    #sidebarNavToggler {
            margin-bottom: -6px;
    }

    .hc-nav-trigger {
        width: 169px !important;
    }

    #basicDropdownHoverInvoker19-9:hover, #basicDropdownHoverInvoker19-9-m:hover, #basicDropdownHoverInvoker19-7:hover, #basicDropdownHoverInvoker19-7-m:hover, #cartModal:hover, #cartModal-m:hover {
        color: #D55534 !important;
    }

    @media only screen and (max-width: 441px) {
      .helper-text {
        /* display: none; */
        font-size: 2.4vw;
        font-weight: 400;
      }

      .paddings {
        padding-left: 0.2rem !important;
        padding-right: 0.4rem !important;
      }
    }

    /* media query for mobile screens */
    @media only screen and (max-width: 366px) {
        .fonts {
             font-size: 1.0rem !important;
        }

        .paddings {
            padding-left: 0.25rem !important;
            padding-right: 0.25rem !important;
        }
    }

    /* media query for mobile screens */
    @media only screen and (max-width: 308px) {
        .fonts {
             font-size: 0.8rem !important;
        }
    }

    /* media query for mobile screens */
    @media only screen and (max-width: 278px) {
        .fonts {
             font-size: 0.7rem !important;
        }
    }
</style>

<header id="site-header" class="site-header__v7">
    <div class="topbar bg-punch-light">
        <div class="container">
            <div class="topbar__nav d-lg-flex justify-content-between align-items-center font-size-2 test1234">
                <ul class="topbar__nav--left nav ml-lg-n3 justify-content-center">
                    {{-- @php
                        $header_v2_button_text = 'GIVE US FEEDBACK';
                        try {
                            $lang = App\Language::where('code', request()->has('language', 'en'))->first();
                            $settings = $lang->basic_extended;

                            $header_v2_button_text = $settings->header_v2_button_text;
                        } catch (\Exception $e) {
                        }
                    @endphp
                    @if (trim($header_v2_button_text) != '')
                        <li class="nav-item">
                            <a href="javascript:;" data-href="{{ route('feedback') }}" data-toggle="modal"
                    data-target="#headerProductInquiryModal" href="#" class="nav-link text-dark">
                    <i class="font-size-3 glph-icon flaticon-question mr-2"></i>
                    { { $header_v2_button_text } }
                    </a>
                    </li>
                    @endif --}}
                    <li class="nav-item">
                        <a href="tel:{{ $bs->support_phone }}" class="nav-link text-dark">
                            <i class="font-size-3 glph-icon flaticon-phone mr-2"></i>
                            {{ $bs->support_phone }}
                        </a>
                    </li>
                </ul>
                <ul class="topbar__nav--right nav justify-content-center">
                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link py-2 px-3 text-dark d-flex align-items-center">
                            <i class="glph-icon flaticon-pin mr-2 font-size-3"></i>
                            @php
                            $countries = App\Models\Country::get()
                            ->sortBy('name', 0, false);
                            $country = $countries->last();

                            try
                            {
                            $country = $countries->where('id', session('geo_data_user_country'))->last();
                            }
                            catch (\exception $e)
                            {
                            //throw $th;
                            }

                            @endphp
                            {{ $country?"$country->name ( $country->native_name )":'' }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="position-relative h-100">
                            @php
                            $languages = \App\Language::all()->sortBy('name', 0, false);
                            if(empty(session('lang')))
                            {
                            if($languages->where('id', 169)->count() >= 1)
                            {
                            session(['lang' => $languages->where('id', 169)->last()->code]);
                            }
                            }
                            @endphp
                            <a id="basicDropdownHoverInvoker19" class="d-flex align-items-center h-100 dropdown-nav-link p-2 dropdown-toggle nav-link link-black-100" href="javascript:;" role="button" aria-controls="basicDropdownHover19" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#basicDropdownHover19" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                @foreach($languages as $language)
                                @if($language->code == session('lang')) {{ $language->name }} @endif
                                @endforeach
                                <i class=""></i>
                            </a>
                            <div id="basicDropdownHover19" class="dropdown-menu dropdown-unfold right-0 left-auto" aria-labelledby="basicDropdownHoverInvoker19">
                                @foreach($languages as $language)
                                <a class="dropdown-item @if($language->code == session('lang')) active @endif" href="{{ route('changeLanguage', $language->code) }}">{{ $language->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="masthead">
        <div class="bg-white border-bottom">
            <div class="container pt-3 pb-2 pt-lg-5 pb-lg-5">
                <div class="d-flex align-items-center position-relative flex-wrap justify-content-between">
                    <div class="site-branding pr-md-11 mx-auto mx-md-0">
                        <a href="{{ route('front.index') }}" class="d-block mb-1">
                            <img src="{{ asset('assets/front/img/' . $bs->logo) }}" class="img-fluid lazy" alt="">
                        </a>
                    </div>
                    <div class="site-search ml-xl-0 ml-md-auto w-r-100 flex-grow-1 mr-md-5 py-2 py-md-0">
                        <div class="form-inline my-2 my-xl-0">
                            <div class="input-group w-100">
                                <div class="input-group-prepend z-index-2 d-none d-xl-block">
                                    <select class="d-none d-lg-block custom-select pr-7 pl-4 rounded-0 height-5 shadow-none text-dark" id="category_id" {{-- style="max-width: 150px;" --}}>
                                        <option selected>All Categories</option>
                                        @php
                                        $active_category = request()->has('category_id') ? request('category_id') : '';
                                        $search_categories = App\Pcategory::query()
                                        ->where('language_id', $lang->id)
                                        ->where('show_in_menu', '1')
                                        ->where('menu_level', '1')
                                        ->orderBy('name')
                                        ->get();
                                        @endphp
                                        @foreach ($search_categories as $search_category)
                                        <option @if ($active_category==$search_category->id) selected
                                            @endif value="{{ $search_category->id }}">
                                            {{ $search_category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="text" class="form-control border-right-0 px-3" placeholder="Search for books by keyword" aria-label="Amount (to the nearest dollar)" id="search" onkeydown="if(event.key === 'Enter') window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=${document.querySelector('#category_id option:checked').value}&type=new&tag=&review=`;" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                                <div class="input-group-append border-left">
                                    <button class="btn btn-dark btn-search px-3 rounded-0 py-2" type="button" onclick="window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=${document.querySelector('#category_id option:checked').value}&type=new&tag=&review=`" style="cursor: pointer;"><i class="mx-1 glph-icon flaticon-loupe "></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    $custom_buttons = \App\Models\MobileHeaderCustomButton::all()->where('status', true)->sortBy('link_rank', 0, false);
                    $rand_id = rand(77, 777);
                    @endphp
                    @if ($custom_buttons->count() >= 1)
                    <div class="nav text-center d-flex d-lg-none custom-header-button-wrapper">
                        @foreach ($custom_buttons as $custom_button)
                        <div class="nav-item px-1 my-1 custom-header-button">
                            <a @if(str_contains($custom_button->link_target, 'blank')) target="_blank" @endif
                                href="{{ $custom_button->link_url }}" role="button"
                                class="btn btn-secondary btn-sm">
                                <span>{!! $custom_button->link_text !!}</span>
                            </a>

                        </div>
                        @endforeach
                        <div class="nav-item px-1 my-1 custom-header-button">
                            <a id="basicDropdownHoverInvoker19-7{{$rand_id}}" href="{{ route('feedback') }}" data-toggle="modal" data-target=".hPIM" class="btn btn-secondary btn-sm">
                                <span>{{ $header_v2_button_text }}</span>
                            </a>
                        </div>
                    </div>
                    @endif

                    <ul class="nav align-self-center d-none d-lg-flex">
                        <style>
                            #basicDropdownHoverInvoker19-7::after {
                                display: none;
                            }

                            #basicDropdownHoverInvoker19-9::after {
                                display: none;
                            }
                        </style>

                        <!-- Start: Desktop Account Drop Down Button --> 
                        <li class="nav-item px-2 hover-red">
                            <a id="basicDropdownHoverInvoker19-9" href="javascript:;" role="button" class="nav-link pr-0 text-dark position-relative" aria-controls="basicDropdownHover19-9" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-target="#basicDropdownHover19-9" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="false" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                <i class="glph-icon flaticon-user font-size-5"></i>
                                Account
                            </a>
                            <div id="basicDropdownHover19-9" class="dropdown-menu dropdown-unfold right-0 left-auto mr-8" aria-labelledby="basicDropdownHoverInvoker19-9">
                                <!-- Title -->
                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h6 class="font-size-3 mb-0 d-flex align-items-center">
                                        @php
                                        echo "My Account";
                                        @endphp
                                    </h6>
                                </header>

                                @if(auth()->user())
                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <a href="{{ route('user-dashboard') }}" class="text-dark">
                                        <div class="media-body ml-4">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                {{convertUtf8("Dashboard")}}
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                                @else
                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <a href="{{ route('user.login') }}" class="text-dark">
                                        <div class="media-body ml-4">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                {{convertUtf8("Login")}}
                                            </h6>
                                        </div>
                                    </a>
                                </div>

                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <a href="{{ route('user-register') }}" class="text-dark">
                                        <div class="media-body ml-4">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                {{convertUtf8("Register")}}
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                                @endif



                                @foreach ($ulinks as $key => $ulink)
                                @if($ulink->id == 18)
                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <a href="{{$ulink->url}}" class="text-dark">
                                        <div class="media-body ml-4">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                {{convertUtf8($ulink->name)}}
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                                @endif
                                @endforeach

                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <a href="#" class="text-dark">
                                        <div class="media-body ml-4">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                {{convertUtf8("Help")}}
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <!-- End: Desktop Account Drop Down Button --> 

                        <li class="nav-item px-2">
                            <a id="basicDropdownHoverInvoker19-7" href="javascript:;" role="button" class="nav-link pr-0 text-dark position-relative" aria-controls="basicDropdownHover19-7" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-target="#basicDropdownHover19-7" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="false" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                <span class="ml-1 position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0">
                                    @php
                                    try {
                                    echo is_array( session()->get('wishlist') ) ? count(session()->get('wishlist')) : '0';
                                    }
                                    catch (\Exception $e){ }
                                    @endphp
                                </span>
                                <i class="flaticon-heart font-size-5"></i>
                                Wishlist
                            </a>
                            <div id="basicDropdownHover19-7" class="dropdown-menu dropdown-unfold right-0 left-auto" aria-labelledby="basicDropdownHoverInvoker19-7">
                                <!-- Title -->
                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h6 class="font-size-5 h6 mb-0 d-flex align-items-center">
                                        @php
                                        echo "My Wishlist (";
                                        try {
                                        echo is_array( session()->get('wishlist') ) ? count(session()->get('wishlist')) : '0';
                                        }
                                        catch (\Exception $e){ }
                                        echo ")";
                                        @endphp
                                    </h6>
                                </header>
                                <!-- End Title -->
                                @if(is_array( session()->get('wishlist') ) && count( session()->get('wishlist') ) >= 1)
                                @php
                                $wish2cart = route('wishlist.to.cart')."?products=";
                                @endphp
                                @foreach ( session()->get('wishlist') as $id1 => $wish1)
                                @php
                                $product1 = App\Product::find($id1);
                                if(is_null($product1)) continue;
                                $wish2cart .= "$product1->id";
                                if (!$loop->last)
                                {
                                $wish2cart .= "-";
                                }
                                @endphp
                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <div class="media">
                                        <a target="_blank" href="{{route('front.product.details', $product1->slug)}}" class="d-block">
                                            <img src="@if($wish1['photo']!=null){{$wish1['photo']}}@else{{asset('https://via.placeholder.com/55')}}@endif" class="img-fluid" alt="image-description" width="55">
                                        </a>
                                        <div class="media-body ml-1">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                <a href="{{route('front.product.details', $product1->slug)}}" class="text-dark">{{convertUtf8($wish1['name'])}}</a>
                                            </h6>
                                            <div class="cart d-block">
                                                <div class="price d-flex align-items-center font-weight-medium font-size-3 mt-3">
                                                    <span class="woocommerce-Price-amount amount d-inline-block ml-3 d-flex">
                                                        {{ $product1->symbol }}
                                                        <span> {{ number_format($product1->price, 0) }}</span>
                                                    </span>
                                                    <div class="mt-0 ml-auto pr-2">
                                                        <a href="{{ route('wishlist.item.remove', $product1->id) }}" class="text-dark"><i class="fas fa-times"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <div class="px-4 mb-4 px-md-6 d-flex justify-content-around pb-2 pt-4">
                                    <a href="{{ isset($wish2cart) ? $wish2cart : 'javascript:;' }}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">Add To Cart</a>
                                    <a href="{{route('front.wishlist')}}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">View Wishlist</a>
                                </div>
                            </div>
                        </li>
                        
                        <!-- 
                        Previous cart code commented for header -->
                        <!-- <li class="nav-item px-2">
                            <a id="sidebarNavToggler1-desktop" href="javascript:;" role="button" class="nav-link pr-0 text-dark position-relative" aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1" data-unfold-type="css-animation" data-unfold-overlay='{
                                                                    "className": "u-sidebar-bg-overlay",
                                                                    "background": "rgba(0, 0, 0, .7)",
                                                                    "animationSpeed": 500
                                                                }' data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                                <span class="ml-1 position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0 cart-items">{{ isset($cart) && $cart ? $countitem : 0 }}</span>
                                <i class="glph-icon flaticon-icon-126515 font-size-5"></i>
                                <span>Cart</span>
                            </a>
                        </li>  -->

                        <li class="nav-item px-2">
                            <a id="cartModal" class="nav-link pr-0 btn text-dark position-relative" data-toggle="modal" data-target="#exampleModalCenter">
                                <span class="ml-1 position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0 cart-items">{{ isset($cart) && $cart ? $countitem : 0 }}</span>
                                <i class="glph-icon flaticon-icon-126515 font-size-5"></i>
                                Cart
                            </a>
                        </li> 


                    </ul>
                </div>
            </div>
        </div>

        <div class="border-bottom py-3 py-md-0">
            <div class="container">
                <div class="d-flex position-relative">
                    <div class="offcanvas-toggler d-flex align-self-center mr-md-8 ">
                        <!-- Account Sidebar Toggle Button -->
                        <a id="sidebarNavToggler" style="min-width: 30px !important; z-index:1" class="cat-menu py-3 text-dark target-of-invoker-has-unfolds fonts" href="javascript:;" role="button" aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebar001Content" data-unfold-type="css-animation" data-unfold-animation-in="fadeInLeft" data-unfold-animation-out="fadeOutLeft" data-unfold-duration="500">
                            <svg width="20px" height="18px" class="my-auto mr-2">
                                <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"></path>
                                <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"></path>
                                <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"></path>
                            </svg>
                            &nbsp;Books Menu
                            <!-- <span class="fonts"></span> -->
                        </a>
                        <!-- End Account Sidebar Toggle Button -->
                        <ul class="nav d-lg-none ml-auto">
                            @php
                            $rand_id = rand(77, 777);
                            @endphp
                            <style>
                                #basicDropdownHoverInvoker19-7 {
                                        {
                                        $rand_id
                                    }
                                }

                                ::after,
                                #basicDropdownHoverInvoker19-8 {
                                        {
                                        $rand_id
                                    }
                                }

                                ::after {
                                    display: none;
                                }

                                ::after,
                                #basicDropdownHoverInvoker19-9 {
                                        {
                                        $rand_id
                                    }
                                }

                                ::after {
                                    display: none;
                                }
                            </style>
                            @if (trim($header_v2_button_text) != '')
                            <li class="nav-item d-none d-lg-block">
                                <!-- Inquiry form Toggle Button -->
                                <a id="basicDropdownHoverInvoker19-7{{$rand_id}}" href="{{ route('feedback') }}" data-toggle="modal" data-target=".headerProductInquiryModal" class="d-block  h-100 dropdown-nav-link p-2  nav-link link-black-100">
                                    {{ $header_v2_button_text }}
                                </a>
                                <!-- End Inquiry form Toggle Button -->
                            </li>
                            @endif


                        </ul>

                    </div>
                    <div class="d-flex align-self-center">

                    </div>
                    <!-- Cart Wishlist and User Icon displayed in small screen -->
                    <ul class="nav align-self-center d-lg-none ml-auto">
                        <style>
                            #basicDropdownHoverInvoker19-7::after {
                                display: none;
                            }

                            #basicDropdownHoverInvoker19-9::after {
                                display: none;
                            }
                        </style>



                        <!-- Start: Mobile Account Drop Down Button --> 
                        <li class="nav-item px-2 paddings">
                            <a id="basicDropdownHoverInvoker19-9-m" href="javascript:;" role="button" class="nav-link pr-0 text-dark position-relative" aria-controls="basicDropdownHover19-9-m" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-target="#basicDropdownHover19-9-m" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="false" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                <i class="glph-icon flaticon-user font-size-5 fonts"></i>
                                <div class="helper-text">Account</div>
                            </a>
                            <div id="basicDropdownHover19-9-m" class="dropdown-menu dropdown-unfold right-0 left-auto" aria-labelledby="basicDropdownHoverInvoker19-9-m">
                                <!-- Title -->
                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h6 class="font-size-3 mb-0 d-flex align-items-center">
                                        @php
                                        echo "My Account";
                                        @endphp
                                    </h6>
                                </header>

                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <a href="{{ route('user.login') }}" class="text-dark">
                                        <div class="media-body ml-4">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                {{convertUtf8("Login")}}
                                            </h6>
                                        </div>
                                    </a>
                                </div>

                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <a href="{{ route('user-register') }}" class="text-dark">
                                        <div class="media-body ml-4">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                {{convertUtf8("Register")}}
                                            </h6>
                                        </div>
                                    </a>
                                </div>



                                @foreach ($ulinks as $key => $ulink)
                                @if($ulink->id == 18)
                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <a href="{{$ulink->url}}" class="text-dark">
                                        <div class="media-body ml-4">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                {{convertUtf8($ulink->name)}}
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                                @endif
                                @endforeach

                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <a href="#" class="text-dark">
                                        <div class="media-body ml-4">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                {{convertUtf8("Help")}}
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <!-- End: Mobile Account Drop Down Button --> 


                        <li class="nav-item px-2 paddings">
                            <a id="basicDropdownHoverInvoker19-7-m" href="javascript:;" role="button" class="nav-link pr-0 text-dark position-relative" aria-controls="basicDropdownHover19-7-m" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-target="#basicDropdownHover19-7-m" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="false" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                <span class="ml-1 position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0">
                                    @php
                                    try {
                                    echo is_array( session()->get('wishlist') ) ? count(session()->get('wishlist')) : '0';
                                    }
                                    catch (\Exception $e){ }
                                    @endphp
                                </span>
                                <i class="flaticon-heart font-size-5 fonts"></i>
                                <div class="helper-text">Wishlist</div>
                            </a>
                            <div id="basicDropdownHover19-7-m" class="dropdown-menu dropdown-unfold right-0 left-auto" aria-labelledby="basicDropdownHoverInvoker19-7-m">
                                <!-- Title -->
                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h6 class="font-size-5 h6 mb-0 d-flex align-items-center">
                                        @php
                                        echo "My Wishlist (";
                                        try {
                                        echo is_array( session()->get('wishlist') ) ? count(session()->get('wishlist')) : '0';
                                        }
                                        catch (\Exception $e){ }
                                        echo ")";
                                        @endphp
                                    </h6>
                                </header>
                                <!-- End Title -->
                                @if(is_array( session()->get('wishlist') ) && count( session()->get('wishlist') ) >= 1)
                                @php
                                $wish2cart = route('wishlist.to.cart')."?products=";
                                @endphp
                                @foreach ( session()->get('wishlist') as $id1 => $wish1)
                                @php
                                $product1 = App\Product::find($id1);
                                if(is_null($product1)) continue;
                                $wish2cart .= "$product1->id";
                                if (!$loop->last)
                                {
                                $wish2cart .= "-";
                                }
                                @endphp
                                <div class="px-1 py-2 px-md-3 border-bottom">
                                    <div class="media">
                                        <a target="_blank" href="{{route('front.product.details', $product1->slug)}}" class="d-block">
                                            <img src="@if($wish1['photo']!=null){{$wish1['photo']}}@else{{asset('https://via.placeholder.com/55')}}@endif" class="img-fluid" alt="image-description" width="55">
                                        </a>
                                        <div class="media-body ml-1">
                                            <h6 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                <a href="{{route('front.product.details', $product1->slug)}}" class="text-dark">{{convertUtf8($wish1['name'])}}</a>
                                            </h6>
                                            <div class="cart d-block">
                                                <div class="price d-flex align-items-center font-weight-medium font-size-3 mt-3">
                                                    <span class="woocommerce-Price-amount amount d-inline-block ml-3 d-flex">
                                                        {{ $product1->symbol }}
                                                        <span> {{ number_format($product1->price, 0) }}</span>
                                                    </span>
                                                    <div class="mt-0 ml-auto pr-2">
                                                        <a href="{{ route('wishlist.item.remove', $product1->id) }}" class="text-dark"><i class="fas fa-times"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <div class="px-4 mb-4 px-md-6 d-flex justify-content-around pb-2 pt-4">
                                    <a href="{{ isset($wish2cart) ? $wish2cart : 'javascript:;' }}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">Add To Cart</a>
                                    <a href="{{route('front.wishlist')}}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">View Wishlist</a>
                                </div>
                            </div>
                        </li>
                        
                        <!-- Commented below code for solving cart issue -->

                        <!-- <li class="nav-item px-2">
                            <a id="sidebarNavToggler1-desktop" href="javascript:;" role="button" class="nav-link pr-0 text-dark position-relative" aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1" data-unfold-type="css-animation" data-unfold-overlay='{
                                                                    "className": "u-sidebar-bg-overlay",
                                                                    "background": "rgba(0, 0, 0, .7)",
                                                                    "animationSpeed": 500
                                                                }' data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                                <span class="ml-1 position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0 cart-items">{{ isset($cart) && $cart ? $countitem : 0 }}</span>
                                <i class="glph-icon flaticon-icon-126515 font-size-5 fonts"></i>
                                <div class="helper-text">Cart</div>
                            </a>
                        </li> -->

                        <li class="nav-item px-2 paddings">
                            <a id="cartModal-m" class="nav-link pr-0 btn text-dark position-relative" data-toggle="modal" data-target="#exampleModalCenter">
                                <span class="ml-1 position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0 cart-items">{{ isset($cart) && $cart ? $countitem : 0 }}</span>
                                <i class="glph-icon flaticon-icon-126515 font-size-5 fonts"></i>
                                <div class="helper-text">Cart</div>
                            </a>
                        </li> 

                    </ul>
                    <div class="site-navigation mr-auto d-none d-lg-block">
                        @includeIf('front.bookworm.chemistry.molecules.front_main_nav_strip')
                    </div>
                    <div class="d-none d-lg-block ml-md-auto secondary-navigation">
                        @if (trim($header_v2_button_text) != '')
                        <ul class="nav">
                            <li class="nav-item">
                                <a href="{{ route('feedback') }}" data-toggle="modal" data-target="#headerProductInquiryModal" class="nav-link link-black-100 mx-2 px-0 py-3 font-weight-medium">
                                    {{ $header_v2_button_text }}
                                </a>
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="modal fade headerProductInquiryModal hPIM" id="headerProductInquiryModal" tabindex="-1" aria-labelledby="headerProductInquiryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg--- modal-lg modal-dialog-centered modal-dialog-scrollable---naaah">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="container-fluid">
                                <div class="row">
                                    {{-- <div class="col-lg-5 py-2 pl-3 pr-2 d-none d-lg-block" style="background-repeat:no-repeat;background-size:cover;background-image: url('https://img.freepik.com/free-photo/abstract-blur-defocused-bookshelf-library_1203-9640.jpg?w=740');background-position:top">
                                        <div class="d-flex align-content-center flex-wrap bd-highlight mb-3" style="min-height: 77vh">
                                            <div style="background-color: #00000050;font-weight: bolder;border-radius: 7px;" class="p-2 w-100">
                                                <h3 style="text-shadow: 0px 1px 7px black;color: white;font-weight: bolder;" class="modal-title m-0" id="productInquiryModalLabel">Books Inquiry & Info</h3>
                                            </div>
                                            <div class="p-2 bd-highlight">
                                                <p class="py-5 d-none" style="color: black;text-shadow: 1px 1px 7px black;text-align: justify;">
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

                                        </div>
                                    </div> --}}
                                    <div class="col-sm-12 col-lg-12 p-2" style="max-height: 77vh;overflow: hidden;overflow-y: scroll;">
                                        <button type="button" class="close" style="background-color: white;font-weight: bolder;font-size: 1.7rem;color: #000000;width: 35px;height: 35px;border-radius: 50%;opacity: .9;box-shadow: 0px 0px 7px #000000;" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <form action="{{ route('product.inquiries.bulk-inquiry') }}" class="contact-form pt-5 mt-5" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="headerProductsSelect">{{ __('Book(s) Selector') }}</label>
                                                <select id="headerProductsSelect" name="products[]" class="form-control select2" multiple="multiple" data-placeholder="{{ __('Select/Type Name, Author or ISBN') }}" aria-describedby="productsHelp" style="width: 100%" required></select>
                                                @if ($errors->has('products'))
                                                <small id="productsHelp" class="form-text text-danger">{{ $errors->first('products') }}</small>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input class="form-control" name="name" type="text" placeholder="{{ __('Your name') }}" required>
                                                        @if ($errors->has('name'))
                                                        <small id="nameHelp" class="form-text text-danger">{{ $errors->first('name') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input class="form-control" name="email" type="email" placeholder="{{ __('Email') }}" required>
                                                        @if ($errors->has('email'))
                                                        <small id="emailHelp" class="form-text text-danger">{{ $errors->first('email') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea name="message" class="form-control" id="comment" cols="30" rows="5" placeholder="{{ __('Type your message') }}" required></textarea>
                                                        @if ($errors->has('message'))
                                                        <small id="messageHelp" class="form-text text-danger">{{ $errors->first('message') }}</small>
                                                        @endif
                                                    </div>

                                                </div>
                                                @if ($bs->is_recaptcha == 1)
                                                <style>
                                                    .captcha-col>div {
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
                                                <div class="col-md-12">
                                                    <div class="p-2 text-right">
                                                        <button type="button" class="btn btn-dark submit-button border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link" style="color: #fff">{{ __('Submit') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- <div class="px-0 text-center w-100 py-2  d-block d-lg-none">
                                            <button type="button" class="btn btn-dark submit-button border-0 rounded-0 p-3 ml-auto mr-auto min-width-250 single_add_to_cart_button button alt cart-btn cart-link" style="color: #fff">{{ __('Submit') }}
                                            </button>
                                        </div> -->
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
