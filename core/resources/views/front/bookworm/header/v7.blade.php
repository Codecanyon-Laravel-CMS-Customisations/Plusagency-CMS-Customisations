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
<header id="site-header" class="site-header__v7">
    <div class="topbar d-none d-md-block bg-punch-light">
        <div class="container">
            <div class="topbar__nav d-lg-flex justify-content-between align-items-center font-size-2">
                <ul class="topbar__nav--left nav ml-lg-n3 justify-content-center">
                    @php
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
                                {{ $header_v2_button_text }}
                            </a>
                        </li>
                    @endif
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
                            <a id="sidebarNavToggler-wishlist" href="javascript:;" role="button"
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
                            </a>
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
                                <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                      d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                                <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                      d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                                <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                      d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                            </svg>
                        </a>
                        {{-- <!-- End Account Sidebar Toggle Button --> --}}
                        <ul class="nav d-md-none ml-auto">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="modal fade" id="headerProductInquiryModal" tabindex="-1"
                 aria-labelledby="headerProductInquiryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title ml-auto" id="productInquiryModalLabel">Books Inquiry & Info</h5>
                            <button style="font-weight: bolder;font-size: 2rem;" type="button" class="close"
                                    data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('product.inquiries.bulk-inquiry') }}" class="contact-form"
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
                        </div>
                        <div class="modal-footer" style="display: flex;align-self: center;">
                            {{-- <button type="button" class="btn btn-secondary py-3" data-dismiss="modal">Close</button> --}}
                            <button type="button"
                                    class="btn btn-dark submit-button border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link"
                                    style="color: #fff">{{ __('Submit') }}</button>
                            {{-- <input class="py-3" type="submit" value="{{__('Submit')}}"> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@include('front.bookworm.header.aside')
