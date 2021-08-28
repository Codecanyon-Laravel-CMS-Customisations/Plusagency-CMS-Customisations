@php
 if (Session::has('cart')) {
    $cart = Session::get('cart');
} else {
    $cart = null;
}
@endphp
<header id="site-header" class="site-header__v9 site-header__white-text">
    <div class="masthead">
        <div class="container pt-3 pt-md-4 pb-3 pb-md-5">
            <div class="d-flex align-items-center position-relative flex-wrap">
                <div class="offcanvas-toggler mr-5">
                    <a id="sidebarNavToggler2" href="javascript:;" role="button" class="cat-menu"
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
                            <path fill-rule="evenodd"  fill="rgb(25, 17, 11)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                            <path fill-rule="evenodd"  fill="rgb(25, 17, 11)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                            <path fill-rule="evenodd"  fill="rgb(25, 17, 11)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                        </svg>
                    </a>
                </div>
                <div class="site-branding pr-7">
                    <a href="{{route('front.index')}}" class="d-block mb-1">
                        <img src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid lazy" alt="">
                    </a>
                </div>
                <div class="site-search ml-xl-0 ml-md-auto w-r-100 flex-grow-1 mr-md-5 mt-2 mt-md-0 order-1 order-md-0">
                    <div class="form-inline my-2 my-xl-0">
                        <div class="input-group input-group-borderless w-100">
                            <input type="text" class="form-control px-3 bg-gray-200 bg-focus__1" placeholder="Search for books by keyword" aria-label="Amount (to the nearest dollar)" id="search" onkeydown="if(event.key === 'Enter') window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=&type=new&tag=&review=`;" value="{{ isset($_GET['search']) ? $_GET['search'] : ''}}">
                            <div class="input-group-append">
                                <button class="btn btn-primary px-3 py-2" type="button"><i class="mx-1 glph-icon flaticon-loupe text-white" onclick="window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=&type=new&tag=&review=`" style="cursor: pointer;"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-lg-3 mt-xl-0">
                    <!-- Account Sidebar Toggle Button -->
                    <a id="sidebarNavToggler" href="javascript:;" role="button" aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent" data-unfold-type="css-animation" data-unfold-overlay="{
                            &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                            &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                            &quot;animationSpeed&quot;: 500
                        }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500" class="target-of-invoker-has-unfolds">
                        <div class="d-flex align-items-center text-white font-size-2 text-lh-sm">
                            <i class="flaticon-user font-size-4 text-dark"></i>
                            <div class="ml-2 d-none d-lg-block">
                                <span class="text-secondary-gray-1080 font-size-1">Sign In</span>
                                <div class="text-secondary-black-100 font-size-2">My Account</div>
                            </div>
                        </div>
                    </a>
                    <!-- End Account Sidebar Toggle Button -->

                    <!-- Cart Sidebar Toggle Button -->
                    <a id="sidebarNavToggler1" href="javascript:;" role="button" class="ml-4 d-none d-lg-block target-of-invoker-has-unfolds" aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1" data-unfold-type="css-animation" data-unfold-overlay="{
                            &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                            &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                            &quot;animationSpeed&quot;: 500
                        }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                        <div class="d-flex align-items-center text-white font-size-2 text-lh-sm position-relative">
                            {{-- <span class="position-absolute width-16 height-16 rounded-circle d-flex align-items-center justify-content-center bg-dark-1 text-white font-size-n9 left-0 top-0 ml-n2 mt-n1">3</span> --}}
                            <i class="flaticon-icon-126515 font-size-4 text-secondary-black-100"></i>
                            <div class="ml-2">
                                <span class="text-secondary-gray-1080 font-size-1">My Cart</span>
                                {{-- <div class="font-size-2 text-secondary-black-100">$40.93</div> --}}
                            </div>
                        </div>
                    </a>
                    <!-- End Cart Sidebar Toggle Button -->
                </div>
            </div>
        </div>
        <div class="container">
            <div class="bg-primary rounded-md d-none d-md-block">
                <div class="d-flex align-items-center justify-content-center position-relative">
                    <div class="site-navigation mr-auto d-none d-xl-block">
                        <ul class="nav pl-xl-4">
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
                                        <li class="nav-item"><a href="{{ $href }}" target="{{ $link["target"] }}"class="nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium">{{ $link["text"] }}</a></li>

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