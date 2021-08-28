@php
 if (Session::has('cart')) {
    $cart = Session::get('cart');
} else {
    $cart = null;
}
@endphp
<header id="site-header" class="site-header__v8">
    <div class="masthead position-relative" style="margin-bottom: -1px;">
        <div class="container-fluid px-3 px-md-5 px-xl-8d75 py-3 pb-xl-0 bg-transparent">
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
                <div class="site-branding pr-2 mr-1">
                    <a href="{{route('front.index')}}" class="d-block mb-2">
                        <img src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid lazy" alt="">
                    </a>
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
                <ul class="nav align-self-center ml-auto ml-xl-0">
                    <li class="nav-item d-none d-md-block">
                            <!-- Search Content -->
                            <div id="searchSlideDown" class="dropdown-unfold u-search-slide-down u-unfold--css-animation u-unfold--hidden" aria-labelledby="searchSlideDownInvoker" style="animation-duration: 800ms;">
                                {{-- <form> --}}
                                    <!-- Input Group -->
                                    <div class="input-group input-group-borderless u-search-slide-down__input rounded mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-size-3 nav-link">
                                                <span class="flaticon-loupe"></span>
                                            </span>
                                        </div>
                                        <input type="search" class="form-control px-3" placeholder="Search BookWorm" aria-label="Search BookWorm" id="search" onkeydown="if(event.key === 'Enter') window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=&type=new&tag=&review=`;" value="{{ isset($_GET['search']) ? $_GET['search'] : ''}}">
                                        <div class="input-group-append">
                                            <a class="input-group-text px-4 target-of-invoker-has-unfolds" href="javascript:;" aria-label="close" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#searchSlideDown" data-unfold-type="css-animation" data-unfold-animation-in="active" data-unfold-animation-out="fadeOutUp" data-unfold-delay="0" data-unfold-duration="800" data-unfold-overlay="{
                                                    &quot;className&quot;: &quot;u-search-slide-down-bg-overlay&quot;,
                                                    &quot;background&quot;: &quot;rgba(55, 125, 255, .1)&quot;,
                                                    &quot;animationSpeed&quot;: 400
                                                }" aria-expanded="false" onclick="window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=&type=new&tag=&review=`" style="cursor: pointer;">
                                                <span class="fas fa-times" aria-hidden="true"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Input Group -->

                                    <!-- Suggestions Content -->
                                    {{-- <div class="rounded bg-white u-search-slide-down__suggestions py-3 px-3">
                                        <ul class="list-group list-unstyled list-group-flush list-group-borderless mb-0">
                                            <li><a class="list-group-item list-group-item-action text-dark font-size-2" href="#">About BookWorm</a></li>
                                            <li><a class="list-group-item list-group-item-action text-dark font-size-2" href="#">Getting Started</a></li>
                                            <li><a class="list-group-item list-group-item-action text-dark font-size-2" href="#">Documentation</a></li>
                                        </ul>
                                    </div> --}}
                                    <!-- End Suggestions Content -->
                                {{-- </form> --}}
                            </div>
                            <!-- End Search Content -->

                            <!-- Search -->
                            <div class="position-relative">
                                <a id="searchSlideDownInvoker" class="shadow-none font-size-3 nav-link link-black-100 border-0 btn btn-xs btn-icon btn-text-secondary u-search-slide-down-trigger target-of-invoker-has-unfolds" href="javascript:;" role="button" aria-haspopup="true" aria-expanded="false" aria-controls="searchSlideDown" data-unfold-type="css-animation" data-unfold-hide-on-scroll="false" data-unfold-target="#searchSlideDown" data-unfold-animation-in="active" data-unfold-animation-out="fadeOutUp" data-unfold-delay="0" data-unfold-duration="800" data-unfold-overlay="{
                                        &quot;className&quot;: &quot;u-search-slide-down-bg-overlay&quot;,
                                        &quot;background&quot;: &quot;rgba(55, 125, 255, .1)&quot;,
                                        &quot;animationSpeed&quot;: 400
                                    }">
                                    <span class="flaticon-loupe link-black-100 btn-icon__inner u-search-slide-down-trigger__icon"></span>
                                </a>
                            </div>
                            <!-- End Search -->
                        </li>
                    <li class="d-none d-md-block nav-item"><a href="#" class="nav-link link-black-100"><i class="glph-icon flaticon-heart font-size-4"></i></a></li>
                    <li class="nav-item">
                        <!-- Account Sidebar Toggle Button -->
                        <a id="sidebarNavToggler" href="javascript:;" role="button" class="nav-link link-black-100 target-of-invoker-has-unfolds" aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent" data-unfold-type="css-animation" data-unfold-overlay="{
                                &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                &quot;animationSpeed&quot;: 500
                            }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                            <i class="glph-icon flaticon-user font-size-4"></i>
                        </a>
                        <!-- End Account Sidebar Toggle Button -->
                    </li>
                    <li class="d-none d-md-block  nav-item">
                        <!-- Cart Sidebar Toggle Button -->
                        <a id="sidebarNavToggler1" href="javascript:;" role="button" class="nav-link pr-0 link-black-100 position-relative target-of-invoker-has-unfolds" aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1" data-unfold-type="css-animation" data-unfold-overlay="{
                                &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                &quot;animationSpeed&quot;: 500
                            }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                            {{-- <span class="position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0 ml-2">3</span> --}}
                            <i class="glph-icon flaticon-icon-126515 font-size-4"></i>
                            {{-- <span class="d-none d-xl-inline h6 mb-0 ml-1">$40.93</span> --}}
                        </a>
                        <!-- End Cart Sidebar Toggle Button -->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
@include('front.bookworm.header.aside')