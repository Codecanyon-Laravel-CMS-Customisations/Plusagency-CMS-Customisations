@php
 if (Session::has('cart')) {
    $cart = Session::get('cart');
} else {
    $cart = null;
}
@endphp
<header id="site-header" class="site-header__v12 mb-7 pb-1">
    <div class="topbar bg-gray-1060 d-none d-md-block">
        <div class="container">
            <div class="topbar__nav d-md-flex justify-content-between align-items-center font-size-2">
                <ul class="topbar__nav--left nav">
                    <li class="nav-item mr-3">
                        <div class="position-relative h-100">
                            <a id="" class="d-flex align-items-center h-100 dropdown-nav-link p-2 dropdown-toggle nav-link link-black-100" href="javascript:;" role="button"
                                aria-controls="basicDropdownHover"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-unfold-event="hover"
                                data-unfold-target="#basicDropdownHover"
                                data-unfold-type="css-animation"
                                data-unfold-duration="300"
                                data-unfold-delay="300"
                                data-unfold-hide-on-scroll="true"
                                data-unfold-animation-in="slideInUp"
                                data-unfold-animation-out="fadeOut">
                                USD <i class=""></i>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item mr-3">
                        <div class="position-relative h-100">
                            <a id="" class="d-flex align-items-center h-100 dropdown-nav-link p-2 dropdown-toggle nav-link link-black-100" href="javascript:;" role="button"
                                aria-controls="basicDropdownHover1"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-unfold-event="hover"
                                data-unfold-target="#basicDropdownHover1"
                                data-unfold-type="css-animation"
                                data-unfold-duration="300"
                                data-unfold-delay="300"
                                data-unfold-hide-on-scroll="true"
                                data-unfold-animation-in="slideInUp"
                                data-unfold-animation-out="fadeOut">
                                English <i class=""></i>
                            </a>
                        </div>
                    </li>
                </ul>
                <ul class="topbar__nav--right nav">
                    {{-- <li class="nav-item"><a href="#" class="nav-link p-2 link-black-100 d-flex align-items-center ml-3"><i class="glph-icon flaticon-pin mr-2 font-size-3"></i>Store Location</a></li>
                    <li class="nav-item"><a href="#" class="nav-link p-2 link-black-100 d-flex align-items-center ml-3"><i class="glph-icon flaticon-sent mr-2 font-size-3"></i>Track Your Order</a></li> --}}
                </ul>
            </div>
        </div>
    </div>
    <div class="masthead">
        <div class="bg-punch-light">
            <div class="container py-3 py-md-4">
                <div class="d-flex align-items-center position-relative flex-wrap">
                    <div class="d-none d-xl-flex align-items-center mt-3 mt-md-0 mr-md-auto">
                        <!-- question -->
                        <a href="mailto:info@bookworm.com" class="mr-4 mb-4 mb-md-0">
                            <div class="d-flex align-items-center text-dark font-size-2 text-lh-sm">
                                <i class="flaticon-question font-size-5 mt-2 mr-1"></i>
                                <div class="ml-2">
                                    <span class="text-secondary-gray-1090 font-size-1">{{ $bs->support_email }}</span>
                                    <div class="h6 mb-0">Any questions</div>
                                </div>
                            </div>
                        </a>
                        <!-- End question -->

                        <!-- Customer care -->
                        <a href="tel:+1246-345-0695">
                            <div class="d-flex align-items-center text-dark font-size-2 text-lh-sm">
                                <i class="flaticon-phone font-size-5 mt-2 mr-1"></i>
                                <div class="ml-2">
                                    <span class="text-secondary-gray-1090 font-size-1">{{ $bs->support_phone }}</span>
                                    <div class="h6 mb-0">Call toll-free</div>
                                </div>
                            </div>
                        </a>
                        <!-- End Customer care -->
                    </div>

                    <div class="offcanvas-toggler d-xl-none mr-4">
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
                                <path fill-rule="evenodd"  fill="rgb(0, 0, 0)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                                <path fill-rule="evenodd"  fill="rgb(0, 0, 0)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                                <path fill-rule="evenodd"  fill="rgb(0, 0, 0)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                            </svg>
                        </a>
                    </div>

                    <div class="site-branding pr-md-7 mx-auto mx-md-0">
                        <a href="{{route('front.index')}}" class="d-block mb-1">
                            <img src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid lazy" alt="">
                        </a>
                    </div>

                    <div class="d-flex align-items-center ml-auto">
                        <!-- Account Sidebar Toggle Button -->
                        <a id="sidebarNavToggler" href="javascript:;" role="button" class="target-of-invoker-has-unfolds" aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent" data-unfold-type="css-animation" data-unfold-overlay="{
                                &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                &quot;animationSpeed&quot;: 500
                            }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                            <div class="d-flex align-items-center text-dark font-size-2 text-lh-sm">
                                <i class="flaticon-user font-size-5"></i>
                                <div class="ml-2 d-none d-md-block">
                                    <span class="text-secondary-gray-1090 font-size-1">Sign In</span>
                                    <div class="h6 mb-0">My Account</div>
                                </div>
                            </div>
                        </a>
                        <!-- End Account Sidebar Toggle Button -->

                        <!-- Cart Sidebar Toggle Button -->
                        <a id="sidebarNavToggler1" href="javascript:;" role="button" class="d-none d-md-block ml-4 target-of-invoker-has-unfolds" aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1" data-unfold-type="css-animation" data-unfold-overlay="{
                                &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                &quot;animationSpeed&quot;: 500
                            }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                            <div class="d-flex align-items-center text-dark font-size-2 text-lh-sm position-relative">
                                {{-- <span class="position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0 top-0 ml-n2 mt-n1">3</span> --}}
                                <i class="flaticon-icon-126515 font-size-5"></i>
                                <div class="ml-2 d-none d-md-block">
                                    <span class="text-secondary-gray-1090 font-size-1">My Cart</span>
                                    {{-- <div class="h6 mb-0">$40.93</div> --}}
                                </div>
                            </div>
                        </a>
                        <!-- End Cart Sidebar Toggle Button -->
                    </div>
                </div>
            </div>
        </div>

        <div class="border-bottom py-1 d-none d-xl-block">
            <div class="container">
                <div class="d-md-flex align-items-center position-relative">
                    <div class="site-navigation mx-auto">
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