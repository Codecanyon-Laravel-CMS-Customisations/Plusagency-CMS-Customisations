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
<header id="site-header" class="site-header__v2 site-header__white-text">
    <div class="masthead">
        <div class="bg-secondary-gray-800">
            <div class="container pt-3 pt-md-4 pb-3 pb-md-5">
                <div class="d-flex align-items-center position-relative flex-wrap justify-content-between">
                    <div class="offcanvas-toggler mr-4">
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
                                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="site-branding pr-7">
                        <a href="{{route('front.index')}}" class="d-block mb-2">
                            <img src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid lazy" alt="">
                        </a>
                    </div>
                    <div class="site-search ml-xl-0 ml-md-auto w-r-100 flex-grow-1 mr-md-5 mt-2 mt-md-0 order-1 order-md-0">
                        <div class="form-inline my-2 my-xl-0">
                            <div class="input-group input-group-borderless w-100">
                                <input type="text" class="form-control border-left rounded-left-1 rounded-left-xl-0 px-3" placeholder="Search for books by keyword" aria-label="Amount (to the nearest dollar)" id="search" onkeydown="if(event.key === 'Enter') window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=&type=new&tag=&review=`;" value="{{ isset($_GET['search']) ? $_GET['search'] : ''}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary-green btn-search px-3 py-2" type="button"><i class="mx-1 glph-icon flaticon-loupe text-white" onclick="window.location.href = `/products?search=${document.querySelector('#search').value}&minprice=0&maxprice=500.00&category_id=&type=new&tag=&review=`" style="cursor: pointer;"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center text-white font-size-2 text-lh-sm">
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
                        @endauth
                        <!-- Cart Sidebar Toggle Button -->
                        <a id="sidebarNavToggler1" href="javascript:;" role="button" class="ml-4 d-none d-lg-block target-of-invoker-has-unfolds" aria-controls="sidebarContent1" aria-haspopup="true" aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1" data-unfold-type="css-animation" data-unfold-overlay="{
                                &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                                &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                                &quot;animationSpeed&quot;: 500
                            }" data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                            <div class="d-flex align-items-center text-white font-size-2 text-lh-sm position-relative">
                                {{-- <span class="position-absolute bg-white width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-dark font-size-n9 left-0 top-0 ml-n2 mt-n1">3</span> --}}
                                <i class="flaticon-icon-126515 font-size-5"></i>
                                <div class="ml-2">
                                    <span class="text-secondary-gray-1080 font-size-1">My Cart</span>
                                    {{-- <div class="">$40.93</div> --}}
                                </div>
                            </div>
                        </a>
                        <!-- End Cart Sidebar Toggle Button -->
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-secondary-black-200 d-none d-md-block">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center position-relative">
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

                            @foreach ($categories1 as $item)
                                <li class="nav-item dropdown">
                                    <a id="{{ \Str::slug($item->name) }}DropdownInvoker" href="#" class="dropdown-toggle nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium d-flex align-items-center" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($item->name) }}DropdownMenu" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="50" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                                        {{ $item->name }}
                                    </a>
                                    @php
                                        $products_m1 = \App\Product::query()->where('category_id', '=', $item->id);
                                        $subcats = $item->child_cats()->whereIn('id', $ids)->whereNotIn('id', $indexes2)->get();
                                        $subcatchilds = $item->child_cats()->WhereHas('childs')->whereIn('id', $ids)->get();
                                    @endphp
                                    @if (!empty($subcats))
                                        <ul id="{{ \Str::slug($item->name) }}DropdownMenu" class="dropdown-unfold dropdown-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--hidden" aria-labelledby="{{ \Str::slug($item->name) }}DropdownInvoker" style="animation-duration: 200ms; left: 0px;">
                                            @foreach ($subcatchilds as $subcat)
                                                @php
                                                    $products_m2 = \App\Product::query()->where('sub_category_id', '=', $subcat->id);
                                                    $subsubcats = $subcat->child_sub_cats()->WhereIn('id', $ids2)->get();
                                                @endphp
                                                @if ($subsubcats->count() >= 1 || !empty($products_m2))
                                                    @if(!empty($products_m2))
                                                        @if ($subsubcats->count() >= 1)
                                                            <li class="submenu"></li>
                                                            <li class="position-relative">
                                                                <a id="{{ \Str::slug($subcat->id) }}TDropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="true" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($subcat->id) }}TDropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $subcat->name }}
                                                                </a>
                                                            </li>
                                                            <ul id="{{ \Str::slug($subcat->id) }}TDropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--reverse-y fadeOut" aria-labelledby="{{ \Str::slug($subcat->id) }}TDropdownsubmenuoneInvoker" style="animation-duration: 200ms;">
                                                                @foreach ($subsubcats as $subsubcat)
                                                                    @php
                                                                        $products_m3 = \App\Product::query()->where('sub_child_category_id', '=', $subsubcat->id)
                                                                    @endphp
                                                                        <li class="submenu"></li>
                                                                        <li class="position-relative">
                                                                            <a id="{{ \Str::slug($subsubcat->id) }}CDropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="true" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($subsubcat->id) }}CDropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $subsubcat->name }}
                                                                            </a>
                                                                            <ul id="{{ \Str::slug($subsubcat->id) }}CDropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--reverse-y fadeOut" aria-labelledby="{{ \Str::slug($subsubcat->id) }}CDropdownsubmenuoneInvoker" style="animation-duration: 200ms;">
                                                                                @foreach ($products_m3->get() as $product3)
                                                                                    <li>
                                                                                        <a class="dropdown-item link-black-100" href="{{route('front.product.details',$product3->slug)}}">{{ $product3->title }}</a>
                                                                                    </li>
                                                                                @endforeach

                                                                            </ul>
                                                                        </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endif
                                                @endif
                                                @if ($subsubcats->count() == 0 && $subcat->child_cats->count() === 0)
                                                    @if ($subsubcats->count() == 0)
                                                        <li class="submenu"></li>
                                                        <li class="position-relative">
                                                            <a id="{{ \Str::slug($subcat->id) }}MDropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="true" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($subcat->id) }}MDropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $subcat->name }}
                                                            </a>
                                                            <ul id="{{ \Str::slug($subcat->id) }}MDropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--reverse-y fadeOut" aria-labelledby="{{ \Str::slug($subcat->id) }}MDropdownsubmenuoneInvoker" style="animation-duration: 200ms;">
                                                                @foreach ($products_m2->get() as $product3)
                                                                    <li>
                                                                        <a class="dropdown-item link-black-100" href="{{route('front.product.details',$product3->slug)}}">{{ $product3->title }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endif
                                                @endif
                                            @endforeach

                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@include('front.bookworm.header.aside')
