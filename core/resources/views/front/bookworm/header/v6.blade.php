@php
    if (Session::has('cart')) {
       $cart = Session::get('cart');
   } else {
       $cart = null;
   }
       $productmenus   = \App\Menu::where('language_id', $lang->id)->where('is_product', 1);

       $names = [];
       if($productmenus->count() > 0) {
           $productmenus = $productmenus->first()->menus;
           $productmenus = json_decode($productmenus, true);
           foreach ($productmenus as $key => $value) {
               $names[] = $value['text'];
           }
       }
       else {
           $productmenus = [];
       }
       $categories1 = \App\Pcategory::whereIn('name', $names)
                       ->where('language_id', $lang->id)
                       ->where('status',1)
                       ->with('childs')
                       ->where('menu_level', '1')
                       ->get();
       $megaMenuIds = \App\Megamenu::where('type', 'product_categories')->where('language_id', $lang->id)->where('category', 1)->first();
       $ids = [];
       $ids2 = [];
       $indexes2 = [];
       if(!empty($megaMenuIds)) {
           if(!empty($megaMenuIds->subcat)) {
               foreach (json_decode($megaMenuIds->subcat, true) as $key => $value) {
                   foreach ($value as $value2) {
                       $ids[] = $value2;
                   }
               }
           }

           if(!empty($megaMenuIds->menus)) {
               foreach (json_decode($megaMenuIds->menus, true) as $key2 => $value2) {
                   $indexes2[] = $key2;
                   foreach ($value2 as $value3) {
                       $ids2[] = $value3;
                   }
               }
           }

       }
       $products       = \App\Product::withoutGlobalScope('variation')->where('status',1);
@endphp
<header id="site-header" class="site-header__v6">
    <div class="topbar border-bottom d-none d-md-block bg-dark">
        <div class="container-fluid px-2 px-md-5 px-xl-8d75">
            <div class="topbar__nav d-lg-flex justify-content-between align-items-center font-size-2">
                <ul class="topbar__nav--left nav ml-lg-n3">
                    <li class="nav-item"><a href="#" class="nav-link text-white"><i class="font-size-3 glph-icon flaticon-question mr-2"></i>Can we help you?</a></li>
                    <li class="nav-item"><a href="#" class="nav-link text-white"><i class="font-size-3 glph-icon flaticon-phone mr-2"></i>{{ $bs->support_phone }}</a></li>
                </ul>
                <ul class="topbar__nav--right nav">
                    {{-- <li class="nav-item"><a href="#" class="nav-link py-2 px-3 text-white d-flex align-items-center"><i class="glph-icon flaticon-pin mr-2 font-size-3"></i>Store Location</a></li>
                    <li class="nav-item"><a href="#" class="nav-link py-2 px-3 text-white d-flex align-items-center"><i class="glph-icon flaticon-sent mr-2 font-size-3"></i>Track Your Order</a></li> --}}
                    <li class="nav-item">
                        <div class="position-relative h-100">
                            <a id="" class="d-flex align-items-center h-100 dropdown-nav-link py-2 px-3 dropdown-toggle nav-link text-white" href="javascript:;" role="button"
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

                            {{-- <div id="basicDropdownHover" class="dropdown-menu dropdown-unfold right-0 left-auto" aria-labelledby="basicDropdownHoverInvoker">
                                <a class="dropdown-item active" href="#">INR</a>
                                <a class="dropdown-item" href="#">Euro</a>
                                <a class="dropdown-item" href="#">Yen</a>
                            </div> --}}
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="position-relative h-100">
                            <a id="" class="d-flex align-items-center h-100 dropdown-nav-link py-2 px-3 dropdown-toggle nav-link text-white" href="javascript:;" role="button"
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
            </div>
        </div>
    </div>
    <div class="masthead position-relative" style="margin-bottom: -1px;">
        <div class="container-fluid px-3 px-md-5 px-xl-8d75 py-3 py-xl-0">
            <div class="d-flex align-items-center position-relative flex-wrap">
                <div class="offcanvas-toggler mr-5">
                    {{-- <!-- Account Sidebar Toggle Button --> --}}
                    <a id="sidebarNavToggler" class="cat-menu" href="javascript:;" role="button"
                        aria-controls="sidebarContent"
                        aria-haspopup="true"
                        aria-expanded="false"
                        data-unfold-event="click"
                        data-unfold-hide-on-scroll="false"
                        data-unfold-target="#sidebar001Content"
                        data-unfold-type="css-animation"
                        data-unfold-animation-in="fadeInLeft"
                        data-unfold-animation-out="fadeOutLeft"
                        data-unfold-duration="500">
                        <svg width="20px" height="18px">
                            <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                            <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                            <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                        </svg>
                    </a>
                    {{-- <!-- End Account Sidebar Toggle Button --> --}}
                </div>
                <div class="site-branding pr-4">
                    <a href="{{route('front.index')}}" class="d-block mb-1">
                        <img src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid lazy" alt="">
                    </a>
                </div>
                <div class="site-navigation mx-auto d-none d-xl-block">
{{--                    <ul class="nav d-none">--}}
{{--                        @foreach (json_decode($menus, true) as $link)--}}
{{--                            @php--}}
{{--                                $href = getHref($link);--}}
{{--                            @endphp--}}

{{--                            @if (strpos($link["type"], '-megamenu') !==  false)--}}
{{--                                @includeIf('front.bookworm.partials.mega-menu')--}}

{{--                            @else--}}

{{--                                @if (!array_key_exists("children",$link))--}}
{{--                                    --}}{{--- Level1 links which doesn't have dropdown menus ---}}
{{--                                    <!--TODO add dynamic actve class-->--}}
{{--                                    <li class="nav-item"><a href="{{ $href }}" target="{{ $link["target"] }}"class="nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium">{{ $link["text"] }}</a></li>--}}

{{--                                @else--}}
{{--                                    <li class="nav-item dropdown">--}}
{{--                                        <a id="{{ \Str::slug($link['text']) }}DropdownInvoker" href="{{ $href }}" target="{{ $link['target'] }}" class="dropdown-toggle nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium d-flex align-items-center"--}}
{{--                                            aria-haspopup="true"--}}
{{--                                            aria-expanded="false"--}}
{{--                                            data-unfold-event="hover"--}}
{{--                                            data-unfold-target="#{{ \Str::slug($link['text']) }}DropdownMenu"--}}
{{--                                            data-unfold-type="css-animation"--}}
{{--                                            data-unfold-duration="200"--}}
{{--                                            data-unfold-delay="50"--}}
{{--                                            data-unfold-hide-on-scroll="true"--}}
{{--                                            data-unfold-animation-in="slideInUp"--}}
{{--                                            data-unfold-animation-out="fadeOut">--}}
{{--                                            {{ $link['text'] }}--}}
{{--                                        </a>--}}
{{--                                        <ul id="{{ \Str::slug($link['text']) }}DropdownMenu" class="dropdown-unfold dropdown-menu font-size-2 rounded-0 border-gray-900" aria-labelledby="{{ \Str::slug($link['text']) }}DropdownInvoker">--}}
{{--                                            --}}{{-- START: 2nd level links --}}
{{--                                            @foreach ($link["children"] as $level2)--}}
{{--                                                @php--}}
{{--                                                    $l2Href = getHref($level2);--}}
{{--                                                @endphp--}}

{{--                                                <li @if(array_key_exists("children", $level2)) class="submenus" @endif>--}}
{{--                                                --}}

{{--                                                    --}}{{-- START: 3rd Level links --}}
{{--                                                    @if(array_key_exists("children", $level2))--}}
{{--                                                        <li class="position-relative">--}}
{{--                                                            <a id="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($level2['text']) }}DropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $level2['text'] }}--}}
{{--                                                            </a>--}}
{{--                                                            <ul id="{{ \Str::slug($level2['text']) }}DropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--hidden u-unfold--reverse-y" aria-labelledby="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker" style="animation-duration: 200ms;">--}}
{{--                                                                @foreach ($level2["children"] as $level3)--}}
{{--                                                                @php--}}
{{--                                                                    $l3Href = getHref($level3);--}}
{{--                                                                @endphp--}}
{{--                                                                <li>--}}
{{--                                                                <a href="{{$l3Href}}" target="{{$level3["target"]}}" class="dropdown-item link-black-100">{{ $level3['text'] }}</a></li>--}}
{{--                                                                @endforeach--}}
{{--                                                            </ul>--}}
{{--                                                        </li>--}}
{{--                                                    @else--}}
{{--                                                        <a href="{{$l2Href}}" target="{{$level2["target"]}}" class="dropdown-item link-black-100">{{ $level2['text'] }}</a>--}}
{{--                                                    @endif--}}
{{--                                                    --}}{{-- END: 3rd Level links --}}

{{--                                                </li>--}}
{{--                                            @endforeach--}}
{{--                                            --}}{{-- END: 2nd level links --}}
{{--                                        </ul>--}}
{{--                                    </li>--}}
{{--                                @endif--}}

{{--                            @endif--}}

{{--                        @endforeach--}}
{{--                    </ul>--}}
                    @includeIf('front.bookworm.chemistry.molecules.front_main_nav_strip')
                </div>
                <ul class="nav align-self-center ml-auto ml-xl-0">
                    <li class="d-none d-md-block nav-item"><a href="#" class="nav-link text-dark"><i class="glph-icon flaticon-heart font-size-4"></i></a></li>
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
                    <li class="d-none d-md-block nav-item">
                        <!-- Cart Sidebar Toggle Button -->
                        <a id="sidebarNavToggler1" href="javascript:;" role="button" class="nav-link pr-0 text-dark position-relative target-of-invoker-has-unfolds" aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1" data-unfold-type="css-animation" data-unfold-overlay="{
                                &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                &quot;animationSpeed&quot;: 500
                            }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                            {{-- <span class="position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0">3</span> --}}
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
