@php
if (Session::has('cart')) {
    $cart = session()->get('cart');
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
<header id="site-header" class="site-header__v2 site-header__white-text">
    <div class="masthead">
        <div class="bg-secondary-gray-800">
            <div class="container pt-3 pt-md-4 pb-3 pb-md-5">
                <div class="d-flex align-items-center position-relative flex-wrap justify-content-between">
                    <div class="offcanvas-toggler mr-4">
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
                    <div class="site-branding pr-7">
                        <a href="{{ route('front.index') }}" class="d-block mb-2">
                            <img src="{{ asset('assets/front/img/' . $bs->logo) }}" class="img-fluid lazy" alt="">
                        </a>
                    </div>
                    <div
                        class="site-search ml-xl-0 ml-md-auto w-r-100 flex-grow-1 mr-md-5 mt-2 mt-md-0 order-1 order-md-0">
                        <div class="form-inline my-2 my-xl-0">
                            <div class="input-group input-group-borderless w-100">
                                <div class="input-group-prepend mr-0 d-none d-xl-block">
                                    <select
                                        class="custom-select pr-7 pl-4 rounded-right-0 height-5 shadow-none border-0 text-dark"
                                        id="category_id"
                                        style="max-width: 150px;">
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
                                            <option @if ($active_category == $search_category->id) selected @endif value="{{ $search_category->id }}">
                                                {{ $search_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="text"
                                    class="form-control border-left rounded-left-1 rounded-left-xl-0 px-3"
                                    placeholder="Search for books by keyword"
                                    aria-label="Amount (to the nearest dollar)" id="search"
                                    onkeydown="if(event.key === 'Enter') window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=${document.querySelector('#category_id option:checked').value}&type=new&tag=&review=`;"
                                    value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary-green btn-search px-3 py-2" type="button"><i
                                            class="mx-1 glph-icon flaticon-loupe text-white"
                                            onclick="window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=${document.querySelector('#category_id option:checked').value}&type=new&tag=&review=`"
                                            style="cursor: pointer;"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        {{-- <div class="d-flex align-items-center text-white font-size-2 text-lh-sm">
                            <i class="flaticon-user font-size-5"></i>
                            <div class="ml-2 d-none d-lg-block">
                                @auth
                                    <a href="{{ url('user/dashboard') }}" class="text-secondary-gray-1080 font-size-1">Dashboard</a>
                                @else
                                    <a href="{{ url('login') }}" class="text-secondary-gray-1080 font-size-1">Sign In</a>
                                @endauth

                                <div class="">My Account</div>
                            </div>
                        </div>
                        @auth
                            <div class="d-flex align-items-center text-white font-size-2 text-lh-sm">
                                <div class="ml-3 d-none d-lg-block">
                                    <a class="text-secondary-gray-1080 font-size-2" href="{{route('user-logout')}}" target="_self">{{__('Logout')}}</a>
                                </div>
                            </div>
                        @endauth --}}
                        <!-- Account Sidebar Toggle Button -->
                        <a id="sidebarAuthToggler" href="javascript:;" role="button" aria-controls="sidebarContent"
                            aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                            data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent"
                            data-unfold-type="css-animation" data-unfold-animation-in="fadeInRight"
                            data-unfold-animation-out="fadeOutRight" data-unfold-duration="500"
                            class="target-of-invoker-has-unfolds">
                            @if (auth()->check())
                                <a href="{{ route('user-dashboard') }}">
                                    <div class="d-flex align-items-center text-white font-size-2 text-lh-sm">
                                        <i class="flaticon-user font-size-4 text-secondary-gray-1080"></i>
                                        <div class="ml-2 d-none d-lg-block">
                                            <span class="text-secondary-gray-1080 font-size-1">{{ auth()->user()->username }}</span>
                                            <div class="font-size-2">My Account</div>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <div class="d-flex align-items-center text-white font-size-2 text-lh-sm">
                                    <i class="flaticon-user font-size-4 text-secondary-gray-1080"></i>
                                    <div class="ml-2 d-none d-lg-block">
                                        <span class="text-secondary-gray-1080 font-size-1">Sign In</span>
                                        <div class="font-size-2">My Account</div>
                                    </div>
                                </div>
                            @endif
                        </a>
                        <!-- End Account Sidebar Toggle Button -->
                        <!-- Cart Sidebar Toggle Button -->
                        <a id="sidebarNavToggler1" href="javascript:;" role="button"
                            class="ml-4 d-none d-lg-block target-of-invoker-has-unfolds" aria-controls="sidebarContent1"
                            aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                            data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1"
                            data-unfold-type="css-animation" data-unfold-animation-in="fadeInRight"
                            data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                            <div class="d-flex align-items-center text-white font-size-2 text-lh-sm position-relative">
                                 <span class="position-absolute bg-white width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-dark font-size-n9 left-0 top-0 ml-n2 mt-n1">
                                     {{ is_array(session()->get('cart')) ? count(session()->get('cart')) : '0' }}
                                 </span>
                                <i class="flaticon-icon-126515 font-size-5"></i>
                                <div class="ml-2">
                                    <span class="text-secondary-gray-1080 font-size-1">My Cart</span>
                                    {{-- <div class="">$40.93</div> --}}
                                </div>
                            </div>
                        </a>
                        {{-- <a id="sidebarNavToggler2" href="javascript:;" role="button"
                            class="ml-4 d-none d-lg-block target-of-invoker-has-unfolds" aria-controls="sidebarContent2"
                            aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                            data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent2"
                            data-unfold-type="css-animation" data-unfold-animation-in="fadeInRight"
                            data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                            <div class="d-flex align-items-center text-white font-size-2 text-lh-sm position-relative">
                                <span class="position-absolute bg-white width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-dark font-size-n9 left-0 top-0 ml-n2 mt-n1">
                                    {{is_array(session()->get('wishlist')) ? count(session()->get('wishlist')) : '0'}}
                                </span>
                                <i class="flaticon-heart font-size-5"></i>
                                <div class="ml-2">
                                    <span class="text-secondary-gray-1080 font-size-1">My Wishlist</span>
                                    {{-- <div class="">$40.93</div> --} }
                                </div>
                            </div>
                        </a> --}}
                        <!-- End Cart Sidebar Toggle Button -->
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
                            <span class="position-absolute bg-white width-16 height-16 rounded-circle d-none d-md-flex align-items-center justify-content-center text-dark font-size-n9 left-0 top-0 ml-n2 mt-n1">
                                {{is_array(session()->get('wishlist')) ? count(session()->get('wishlist')) : '0'}}
                            </span>
                            <i class="flaticon-heart font-size-5 d-none d-md-block"></i>
                            <i class="flaticon-heart font-size-4 pl-2 d-block d-md-none"></i>
                            <div class="ml-2">
                                <span class="text-secondary-gray-1080 font-size-1">My Wishlist</span>
                                {{-- <div class="">$40.93</div> --}}
                            </div>
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
                            </div>
                        </div>
                        <!-- End Wishlist Sidebar Toggle Button -->
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-secondary-black-200 d-none d-md-block">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center position-relative">
                    <div class="site-navigation mr-auto d-none d-xl-block">
                        @includeIf('front.bookworm.chemistry.molecules.front_main_nav_strip')
                    </div>
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
                        <div class="secondary-navigation">
                            <ul class="nav">
                                <li class="nav-item"><a href="javascript:;" data-href="{{ route('feedback') }}"
                                        class="nav-link link-black-100 mx-2 px-0 py-3 font-size-2 font-weight-medium"
                                        data-toggle="modal"
                                        data-target="#headerProductInquiryModal">{{ $header_v2_button_text }}</a></li>
                                {{-- <li class="nav-item"><a href="#" class="nav-link link-black-100 mx-2 px-0 py-3 font-size-2 font-weight-medium">Best Seller</a></li>
                                <li class="nav-item"><a href="#" class="nav-link link-black-100 mx-2 px-0 py-3 font-size-2 font-weight-medium">Trending Books</a></li>
                                <li class="nav-item"><a href="#" class="nav-link link-black-100 mx-2 px-0 py-3 font-size-2 font-weight-medium">Gift Cards</a></li> --}}
                            </ul>
                        </div>
                    @endif
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
                                                    name="preferred_communication" value="Whatsapp" checked> Whatsapp
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
