@php
 if (Session::has('cart')) {
    $cart = Session::get('cart');
} else {
    $cart = null;
}
@endphp
<header id="site-header" class="site-header__v7">
    <div class="topbar d-none d-md-block bg-punch-light">
        <div class="container">
            <div class="topbar__nav d-lg-flex justify-content-between align-items-center font-size-2">
                <ul class="topbar__nav--left nav ml-lg-n3 justify-content-center">
                    <li class="nav-item"><a href="#" class="nav-link text-dark"><i class="font-size-3 glph-icon flaticon-question mr-2"></i>Can we help you?</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-dark"><i class="font-size-3 glph-icon flaticon-phone mr-2"></i>{{ $bs->support_phone }}</a></li>
                </ul>
                <ul class="topbar__nav--right nav justify-content-center">
                    {{-- <li class="nav-item"><a href="#" class="nav-link p-2 link-black-100 d-flex align-items-center"><i class="glph-icon flaticon-pin mr-2 font-size-3"></i>Store Location</a></li>
                    <li class="nav-item"><a href="#" class="nav-link p-2 link-black-100 d-flex align-items-center"><i class="glph-icon flaticon-sent mr-2 font-size-3"></i>Track Your Order</a></li> --}}
                    <li class="nav-item">
                        <div class="position-relative h-100">
                            <a id="" class="d-flex align-items-center h-100 dropdown-nav-link p-2 dropdown-toggle nav-link link-black-100" href="javascript:;" role="button"
                                aria-controls="basicDropdownHover9"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-unfold-event="hover"
                                data-unfold-target="#basicDropdownHover9"
                                data-unfold-type="css-animation"
                                data-unfold-duration="300"
                                data-unfold-delay="300"
                                data-unfold-hide-on-scroll="true"
                                data-unfold-animation-in="slideInUp"
                                data-unfold-animation-out="fadeOut">
                                USD <i class=""></i>
                            </a>

                            {{-- <div id="basicDropdownHover9" class="dropdown-menu dropdown-unfold right-0 left-auto" aria-labelledby="basicDropdownHoverInvoker9">
                                <a class="dropdown-item active" href="#">INR</a>
                                <a class="dropdown-item" href="#">Euro</a>
                                <a class="dropdown-item" href="#">Yen</a>
                            </div> --}}
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="position-relative h-100">
                            <a id="" class="d-flex align-items-center h-100 dropdown-nav-link p-2 dropdown-toggle nav-link link-black-100" href="javascript:;" role="button"
                                aria-controls="basicDropdownHover19"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-unfold-event="hover"
                                data-unfold-target="#basicDropdownHover19"
                                data-unfold-type="css-animation"
                                data-unfold-duration="300"
                                data-unfold-delay="300"
                                data-unfold-hide-on-scroll="true"
                                data-unfold-animation-in="slideInUp"
                                data-unfold-animation-out="fadeOut">
                                English <i class=""></i>
                            </a>

                            {{-- <div id="basicDropdownHover19" class="dropdown-menu dropdown-unfold right-0 left-auto" aria-labelledby="basicDropdownHoverInvoker19">
                                <a class="dropdown-item active" href="#">Tamil</a>
                                <a class="dropdown-item" href="#">Arabic</a>
                                <a class="dropdown-item" href="#">French</a>
                            </div> --}}
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
                        <a href="{{route('front.index')}}" class="d-block mb-1">
                            <img src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid lazy" alt="">
                        </a>
                    </div>
                    <div class="site-search ml-xl-0 ml-md-auto w-r-100 flex-grow-1 mr-md-5 py-2 py-md-0">
                        <div class="form-inline my-2 my-xl-0">
                            <div class="input-group w-100">
                                <div class="input-group-prepend z-index-2 d-none d-xl-block">
                                    <select class="d-none d-lg-block custom-select pr-7 pl-4 rounded-0 height-5 shadow-none text-dark" id="category_id">
                                        <option selected>All Categories</option>
                                        @php
                                            $active_category      = request()->has('category_id') ? request('category_id') : '';
                                            $search_categories    = App\Pcategory::query()->where('show_in_menu', '1')->where('menu_level', '1')->orderBy('name')->get();
                                        @endphp
                                        @foreach($search_categories as $search_category)
                                            <option @if($active_category == $search_category->id) selected @endif value="{{ $search_category->id }}">{{ $search_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="text" class="form-control border-right-0 px-3" placeholder="Search for books by keyword" aria-label="Amount (to the nearest dollar)" id="search" onkeydown="if(event.key === 'Enter') window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=${document.querySelector('#category_id option:checked').value}&type=new&tag=&review=`;" value="{{ isset($_GET['search']) ? $_GET['search'] : ''}}">
                                <div class="input-group-append border-left">
                                    <button class="btn btn-dark btn-search px-3 rounded-0 py-2" type="button"><i class="mx-1 glph-icon flaticon-loupe " onclick="window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=${document.querySelector('#category_id option:checked').value}&type=new&tag=&review=`" style="cursor: pointer;"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav align-self-center d-none d-md-flex">
                        <li class="nav-item"><a href="#" class="nav-link text-dark"><i class="glph-icon flaticon-heart font-size-4"></i></a></li>
                        <li class="nav-item">
                            <!-- Account Sidebar Toggle Button -->
                            <a id="sidebarNavToggler" href="javascript:;" role="button" class="nav-link text-dark target-of-invoker-has-unfolds" aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent" data-unfold-type="css-animation" data-unfold-overlay="{
                                    &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                    &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                    &quot;animationSpeed&quot;: 500
                                }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                                <i class="glph-icon flaticon-user font-size-4"></i>
                            </a>
                            <!-- End Account Sidebar Toggle Button -->
                        </li>
                        <li class="nav-item">
                            <!-- Cart Sidebar Toggle Button -->
                            <a id="sidebarNavToggler1" href="javascript:;" role="button" class="nav-link pr-0 text-dark position-relative target-of-invoker-has-unfolds" aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1" data-unfold-type="css-animation" data-unfold-overlay="{
                                    &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                    &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                    &quot;animationSpeed&quot;: 500
                                }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
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
                        <a id="sidebarNavToggler2" href="javascript:;" role="button" class="cat-menu text-dark"
                        aria-controls="sidebarContent2"
                        aria-haspopup="true"
                        aria-expanded="false"
                        data-unfold-event="click"
                        data-unfold-hide-on-scroll="false"
                        data-unfold-target="#sidebarContent2"
                        data-unfold-type="css-animation"
                        data-unfold-overlay='{
                            "className": "u-sidebar-bg-overlay",
                            "background": "rgba(0, 0, 0, .7)",
                            "animationSpeed": 100
                        }'
                        data-unfold-animation-in="fadeInLeft"
                        data-unfold-animation-out="fadeOutLeft"
                        data-unfold-duration="100">
                            <svg width="20px" height="18px">
                                <path fill-rule="evenodd"  fill="rgb(0, 0, 0)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                                <path fill-rule="evenodd"  fill="rgb(0, 0, 0)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                                <path fill-rule="evenodd"  fill="rgb(0, 0, 0)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                            </svg>
                            <span class="ml-3 font-weight-medium">Browse categories</span>
                        </a>

                        <ul class="nav d-md-none ml-auto">
                            <li class="nav-item">
                                <!-- Account Sidebar Toggle Button - Mobile -->
                                <a id="sidebarNavToggler9" href="javascript:;" role="button" class="px-2 nav-link h-primary"
                                    aria-controls="sidebarContent9"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    data-unfold-event="click"
                                    data-unfold-hide-on-scroll="false"
                                    data-unfold-target="#sidebarContent9"
                                    data-unfold-type="css-animation"
                                    data-unfold-overlay='{
                                        "className": "u-sidebar-bg-overlay",
                                        "background": "rgba(0, 0, 0, .7)",
                                        "animationSpeed": 500
                                    }'
                                    data-unfold-animation-in="fadeInRight"
                                    data-unfold-animation-out="fadeOutRight"
                                    data-unfold-duration="500">
                                    <i class="glph-icon flaticon-user"></i>
                                </a>
                                <!-- End Account Sidebar Toggle Button - Mobile -->
                            </li>
                        </ul>
                    </div>

                    <div class="site-navigation mr-auto d-none d-xl-block">
                        <ul class="nav">
                            @foreach (json_decode($menus, true) as $link)
                                @php
                                    $href = getHref($link);
                                @endphp

                                @if (strpos($link["type"], '-megamenu') !==  false)
                                    @includeIf('front.bookworm.partials.mega-menu')

                                @else

                                    @if (!array_key_exists("children",$link))
                                        {{--- Level1 links which doesn't have dropdown menus ---}}
                                        <!--TODO add dynamic actve class-->
                                        <li class="nav-item"><a href="{{ $href }}" target="{{ $link["target"] }}"class="nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium border-bottom border-primary border-width-2">{{ $link["text"] }}</a></li>

                                    @else
                                        <li class="nav-item dropdown">
                                            <a id="{{ \Str::slug($link['text']) }}DropdownInvoker" href="{{ $href }}" target="{{ $link['target'] }}" class="dropdown-toggle nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium d-flex align-items-center"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                data-unfold-event="hover"
                                                data-unfold-target="#{{ \Str::slug($link['text']) }}DropdownMenu"
                                                data-unfold-type="css-animation"
                                                data-unfold-duration="200"
                                                data-unfold-delay="50"
                                                data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="slideInUp"
                                                data-unfold-animation-out="fadeOut">
                                                {{ $link['text'] }}
                                            </a>
                                            <ul id="{{ \Str::slug($link['text']) }}DropdownMenu" class="dropdown-unfold dropdown-menu font-size-2 rounded-0 border-gray-900" aria-labelledby="{{ \Str::slug($link['text']) }}DropdownInvoker">
                                                {{-- START: 2nd level links --}}
                                                @foreach ($link["children"] as $level2)
                                                    @php
                                                        $l2Href = getHref($level2);
                                                    @endphp

                                                    <li @if(array_key_exists("children", $level2)) class="submenus" @endif>


                                                        {{-- START: 3rd Level links --}}
                                                        @if(array_key_exists("children", $level2))
                                                            <li class="position-relative">
                                                                <a id="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($level2['text']) }}DropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $level2['text'] }}
                                                                </a>
                                                                <ul id="{{ \Str::slug($level2['text']) }}DropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--hidden u-unfold--reverse-y" aria-labelledby="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker" style="animation-duration: 200ms;">
                                                                    @foreach ($level2["children"] as $level3)
                                                                    @php
                                                                        $l3Href = getHref($level3);
                                                                    @endphp
                                                                    <li>
                                                                    <a href="{{$l3Href}}" target="{{$level3["target"]}}" class="dropdown-item link-black-100">{{ $level3['text'] }}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @else
                                                            <a href="{{$l2Href}}" target="{{$level2["target"]}}" class="dropdown-item link-black-100">{{ $level2['text'] }}</a>
                                                        @endif
                                                        {{-- END: 3rd Level links --}}

                                                    </li>
                                                @endforeach
                                                {{-- END: 2nd level links --}}
                                            </ul>
                                        </li>
                                    @endif

                                @endif

                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@include('front.bookworm.header.aside')
