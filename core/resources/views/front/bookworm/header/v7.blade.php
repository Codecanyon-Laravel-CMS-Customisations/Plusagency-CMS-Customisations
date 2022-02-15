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
<header id="site-header" class="site-header__v7">
    <div class="topbar d-none d-md-block bg-punch-light">
        <div class="container">
            <div class="topbar__nav d-lg-flex justify-content-between align-items-center font-size-2">
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
                                $countries                  = App\Models\Country::get()
                                    ->sortBy('name', 0, false);
                                    $country                = $countries->last();

                                    try
                                    {
                                        $country    = $countries->where('id', session('geo_data_user_country'))->last();
                                    }
                                    catch (\exception $e)
                                    {
                                        //throw $th;
                                    }

                            @endphp
                            {{ "$country->name ( $country->native_name )" }}
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
                            <a id="basicDropdownHoverInvoker19"
                               class="d-flex align-items-center h-100 dropdown-nav-link p-2 dropdown-toggle nav-link link-black-100"
                               href="javascript:;" role="button" aria-controls="basicDropdownHover19"
                               aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                               data-unfold-target="#basicDropdownHover19" data-unfold-type="css-animation"
                               data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true"
                               data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                @foreach($languages as $language)
                                    @if($language->code == session('lang')) {{ $language->name }} @endif
                                @endforeach
                                <i class=""></i>
                            </a>
                            <div id="basicDropdownHover19" class="dropdown-menu dropdown-unfold right-0 left-auto"
                                 aria-labelledby="basicDropdownHoverInvoker19">
                                @foreach($languages as $language)
                                    <a class="dropdown-item @if($language->code == session('lang')) active @endif"
                                       href="{{ route('changeLanguage', $language->code) }}">{{ $language->name }}
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
                                    <select
                                        class="d-none d-lg-block custom-select pr-7 pl-4 rounded-0 height-5 shadow-none text-dark"
                                        id="category_id" style="max-width: 150px;">
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
                                            <option @if ($active_category == $search_category->id) selected
                                                    @endif value="{{ $search_category->id }}">
                                                {{ $search_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="text" class="form-control border-right-0 px-3"
                                       placeholder="Search for books by keyword"
                                       aria-label="Amount (to the nearest dollar)" id="search"
                                       onkeydown="if(event.key === 'Enter') window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=${document.querySelector('#category_id option:checked').value}&type=new&tag=&review=`;"
                                       value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                                <div class="input-group-append border-left">
                                    <button class="btn btn-dark btn-search px-3 rounded-0 py-2" type="button"><i
                                            class="mx-1 glph-icon flaticon-loupe "
                                            onclick="window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=${document.querySelector('#category_id option:checked').value}&type=new&tag=&review=`"
                                            style="cursor: pointer;"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav align-self-center d-none d-md-flex">
                        <li class="nav-item">
                            <!-- Wishlist Sidebar Toggle Button -->
                            {{-- <a id="sidebarNavToggler-wishlist" href="javascript:;" role="button"
                               class="nav-link text-dark target-of-invoker-has-unfolds" aria-controls="sidebarContent-wishlist"
                               aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                               data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent-wishlist"
                               data-unfold-type="css-animation" data-unfold-overlay="{
                                    &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                    &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                    &quot;animationSpeed&quot;: 500
                                }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                               data-unfold-duration="500" style="z-index: auto;">
                                <i class="glph-icon flaticon-heart font-size-4"></i>
                            </a> --}}
                            <style>
                                #basicDropdownHoverInvoker19-7::after {
                                    display: none;
                                }
                            </style>
                            <a id="basicDropdownHoverInvoker19-7"
                               class="d-flex align-items-center h-100 dropdown-nav-link p-2 dropdown-toggle nav-link link-black-100"
                               href="javascript:;" role="button" aria-controls="basicDropdownHover19-7"
                               aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                               data-unfold-target="#basicDropdownHover19-7" data-unfold-type="css-animation"
                               data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true"
                               data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                               <i class="flaticon-heart font-size-5"></i>
                            </a>
                            <div id="basicDropdownHover19-7" class="dropdown-menu dropdown-unfold right-0 left-auto"
                                 aria-labelledby="basicDropdownHoverInvoker19-7">
                                <!-- Title -->
                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h5 class="font-size-5 h5 mb-0 d-flex align-items-center">
                                        @php
                                            echo "My Wishlist (";
                                            try {
                                                echo is_array( session()->get('wishlist') ) ? count(session()->get('wishlist')) : '0';
                                            }
                                            catch (\Exception $e){ }
                                            echo ")";
                                        @endphp
                                    </h5>
                                </header>
                                <!-- End Title -->
                                @if(is_array( session()->get('wishlist') ) && count( session()->get('wishlist') ) >= 1)
                                    @php
                                        $wish2cart      = route('wishlist.to.cart')."?products=";
                                    @endphp
                                    @foreach ( session()->get('wishlist') as $id1 => $wish1)
                                        @php
                                            $product1   = App\Product::find($id1);
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
                                                    <div class="cart d-block" >
                                                        <div class="price d-flex align-items-center font-weight-medium font-size-3 mt-3">
                                                            <span class="woocommerce-Price-amount amount d-inline-block ml-3">
                                                                {{ $product1->symbol }}
                                                                <span> {{ number_format($product1->price, 0) }}</span>
                                                            </span>
                                                            <div class="mt-0 ml-auto">
                                                                <a href="{{ route('wishlist.item.remove', $product1->id) }}" class="text-dark"><i class="fas fa-times"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="px-4 mb-8 px-md-6 d-flex justify-content-around pb-2 pt-4">
                                    <a href="{{ isset($wish2cart) ? $wish2cart : 'javascript:;' }}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">Add To Cart</a>
                                    <a href="{{route('front.wishlist')}}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">View Wishlist</a>
                                    {{-- <button type="submit" class="btn btn-block py-4 rounded-0 btn-dark">Checkout</button> --}}
                                </div>



                            </div>
                            <!-- End Wishlist Sidebar Toggle Button -->
                        </li>
                        <li class="nav-item">
                            <!-- Account Sidebar Toggle Button -->
                            <a id="sidebarNavToggler-account" href="javascript:;" role="button" class="nav-link text-dark" aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent" data-unfold-type="css-animation" data-unfold-overlay='{
                                        "className": "u-sidebar-bg-overlay",
                                        "background": "rgba(0, 0, 0, .7)",
                                        "animationSpeed": 500
                                    }' data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                                <i class="glph-icon flaticon-user font-size-4"></i>
                            </a>
                            <!-- End Account Sidebar Toggle Button -->
                        </li>
                        <li class="nav-item">
                            <!-- Cart Sidebar Toggle Button -->
                            <a id="sidebarNavToggler1" href="javascript:;" role="button"
                               class="nav-link pr-0 text-dark position-relative target-of-invoker-has-unfolds"
                               aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false"
                               data-unfold-event="click" data-unfold-hide-on-scroll="false"
                               data-unfold-target="#sidebarContent1" data-unfold-type="css-animation"
                               data-unfold-overlay="{
                                    &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                    &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                    &quot;animationSpeed&quot;: 500
                                }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                               data-unfold-duration="500">
                                {{-- <span class="ml-1 position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0">3</span> --}}
                                <i class="glph-icon flaticon-icon-126515 font-size-4"></i>
                                {{-- <span class="d-none d-xl-inline h6 mb-0 ml-1">$40.93</span> --}}
                            </a>
                            <!-- End Cart Sidebar Toggle Button -->
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-bottom py-3 py-md-0">
            <div class="container">
                <div class="d-md-flex position-relative">
                    <div class="offcanvas-toggler align-self-center mr-md-8 d-flex d-md-block">
                        {{-- <!-- Account Sidebar Toggle Button --> --}}
                        <a id="sidebarNavToggler" class="cat-menu" href="javascript:;" role="button"
                           aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false"
                           data-unfold-event="click" data-unfold-hide-on-scroll="false"
                           data-unfold-target="#sidebar001Content" data-unfold-type="css-animation"
                           data-unfold-animation-in="fadeInLeft" data-unfold-animation-out="fadeOutLeft"
                           data-unfold-duration="500">
                            <svg width="20px" height="18px">
                                <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z" />
                                <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z" />
                                <path fill-rule="evenodd" fill="rgb(0, 0, 0)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z" />
                            </svg>
                        </a>
                        {{-- <!-- End Account Sidebar Toggle Button --> --}}
                        <ul class="nav d-md-none ml-auto">
                            @php
                                $rand_id = rand(77, 777);
                            @endphp
                            <style>
                                #basicDropdownHoverInvoker19-7{{$rand_id}}::after ,
                                #basicDropdownHoverInvoker19-8{{$rand_id}}::after {
                                    display: none;
                                }
                            </style>

                            @if (trim($header_v2_button_text) != '')
                                <li class="nav-item">
                                    <!-- Inquiry form Toggle Button -->
                                    <a id="basicDropdownHoverInvoker19-7{{$rand_id}}"
                                        href="{{ route('feedback') }}"
                                        data-toggle="modal"
                                        data-target=".headerProductInquiryModal"

                                        class="d-block  h-100 dropdown-nav-link p-2  nav-link link-black-100">
                                        {{ $header_v2_button_text }}
                                    </a>
                                    <!-- End Inquiry form Toggle Button -->
                                </li>
                            @endif
                            <li class="nav-item">
                                <!-- Wishlist Sidebar Toggle Button -->
                                <a id="basicDropdownHoverInvoker19-8{{$rand_id}}"
                                   class="d-flex align-items-center h-100 dropdown-nav-link p-2 dropdown-toggle nav-link link-black-100"
                                   href="javascript:;" role="button" aria-controls="basicDropdownHover19-8{{$rand_id}}"
                                   aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                                   data-unfold-target="#basicDropdownHover19-8{{$rand_id}}" data-unfold-type="css-animation"
                                   data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true"
                                   data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                    <i class="flaticon-heart"></i>
                                </a>
                                <div id="basicDropdownHover19-7{{$rand_id}}" class="dropdown-menu dropdown-unfold right-0 left-auto"
                                     aria-labelledby="basicDropdownHoverInvoker19-7{{$rand_id}}">
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
                                            $wish2cart      = route('wishlist.to.cart')."?products=";
                                        @endphp
                                        @foreach ( session()->get('wishlist') as $id1 => $wish1)
                                            @php
                                                $product1   = App\Product::find($id1);
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
                                                        <div class="cart d-block" >
                                                            <div class="price d-flex align-items-center font-weight-medium font-size-3 mt-3">
                                                                <span class="woocommerce-Price-amount amount d-inline-block ml-3">
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
                                    <div class="px-4 mb-8 px-md-6 d-flex justify-content-around pb-2 pt-4">
                                        <a href="{{ isset($wish2cart) ? $wish2cart : 'javascript:;' }}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">Add To Cart</a>
                                        <a href="{{route('front.wishlist')}}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">View Wishlist</a>
                                        {{-- <button type="submit" class="btn btn-block py-4 rounded-0 btn-dark">Checkout</button> --}}
                                    </div>



                                </div>
                                <!-- End Wishlist Sidebar Toggle Button -->
                            </li>
                            <li class="nav-item">
                                <!-- Account Sidebar Toggle Button - Mobile -->
                                <a id="sidebarNavToggler9" href="javascript:;" role="button"
                                   class="px-2 nav-link h-primary" aria-controls="sidebarContent9" aria-haspopup="true"
                                   aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                                   data-unfold-target="#sidebarContent9" data-unfold-type="css-animation"
                                   data-unfold-overlay='{
                                        "className": "u-sidebar-bg-overlay",
                                        "background": "rgba(0, 0, 0, .7)",
                                        "animationSpeed": 500
                                    }' data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                                   data-unfold-duration="500">
                                    <i class="glph-icon flaticon-user"></i>
                                </a>
                                <!-- End Account Sidebar Toggle Button - Mobile -->
                            </li>
                        </ul>
                    </div>

                    <div class="site-navigation mr-auto d-none d-xl-block">
                        @includeIf('front.bookworm.chemistry.molecules.front_main_nav_strip')
                    </div>
                    <div class="d-none d-md-block ml-md-auto secondary-navigation">                        
                        @if (trim($header_v2_button_text) != '')
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="{{ route('feedback') }}"
                                        data-toggle="modal"
                                        data-target="#headerProductInquiryModal"
                                        class="nav-link link-black-100 mx-2 px-0 py-3 font-weight-medium">
                                        {{ $header_v2_button_text }}
                                    </a>
                                </li>
                                {{-- <li class="nav-item"><a href="#" class="nav-link link-black-100 mx-2 px-0 py-3 font-weight-medium">Best Seller</a></li>
                                <li class="nav-item"><a href="#" class="nav-link link-black-100 mx-2 px-0 py-3 font-weight-medium">Trending Books</a></li> --}}
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="modal fade headerProductInquiryModal" id="headerProductInquiryModal" tabindex="-1"
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
