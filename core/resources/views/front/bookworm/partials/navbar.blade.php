@php
    //$categories = \App\Language::where('code', 'en')->first()->pcategories;
    $lang           = \App\Language::where('code', 'en')->first();
    $categories     = \App\Pcategory::with('childs');
    $categories     = \App\Pcategory::all() //;
        ->where('language_id', $lang->id)
        ->where('status',1); //->get();
    $products       = \App\Product::withoutGlobalScope('variation')->where('status',1);
    $categories1    = $categories->where('menu_level', '1');
    $categories2    = $categories->where('menu_level', '2');
    $categories3    = $categories->where('menu_level', '3');
@endphp
@include('front.bookworm.header.' . $be->bookworm_header_version )











<!-- Sidebar Navigation -->
<aside id="sidebar001Content" class="u-sidebar u-sidebar__md u-sidebar--left" aria-labelledby="sidebar001Content">
    <div class="u-sidebar__scroller js-scrollbar">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">

                <div class="u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">

                        <header class="border-bottom px-4 px-md-5 py-4 d-flex align-items-center justify-content-between">
                            <h2 class="font-size-3 mb-0">SHOP BY CATEGORY</h2>

                            <div class="d-flex align-items-center">
                                <button
                                    type="button"
                                    class="close ml-auto"
                                    aria-controls="sidebar001Content"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    data-unfold-event="click"
                                    data-unfold-hide-on-scroll="false"
                                    data-unfold-target="#sidebar001Content"
                                    data-unfold-type="css-animation"
                                    data-unfold-animation-in="fadeInLeft"
                                    data-unfold-animation-out="fadeOutLeft"
                                    data-unfold-duration="500">
                                    <span aria-hidden="true"><i class="fas fa-times ml-2"></i></span>
                                </button>
                            </div>

                        </header>

                        <div class="border-bottom">
                            <div class="zeynep pt-4">
                                <ul>
                                    @foreach($categories1 as $category1)
                                        @php
                                            $products_m1    = \App\Product::query()->where('category_id', '=', $category1->id);
                                            $products_m11   = \App\Product::query()->whereIn('sub_category_id', $category1->child_cats->pluck('id'));
                                            //if($products_m1->count() < 1) continue;
                                        @endphp
                                        <li class="has-submenu">
                                            <a href="#" data-submenu="navCat1-{{ $category1->id }}">{{ $category1->name }}</a>
                                            <div id="navCat1-{{ $category1->id }}" class="submenu">
                                                <div class="submenu-header" data-submenu-close="navCat1-{{ $category1->id }}">
                                                    <a href="#">{{ $category1->name }}</a>
                                                </div>
                                                <ul>
                                                    @if ($products_m11->count() >= 1)
                                                        @foreach($category1->child_cats as $category2)
                                                            @php
                                                                $products_m2    = \App\Product::query()->where('category_id', '=', $category2->id);
                                                                $products_m22   = \App\Product::query()->whereIn('sub_child_category_id', $category2->child_sub_cats->pluck('id'));
                                                                //if($products_m2->count() < 1) continue;
                                                            @endphp
                                                            <li class="has-submenu">
                                                                <a href="#" data-submenu="navCat2-{{ $category2->id }}">{{ $category2->name }}</a>
                                                                <div id="navCat2-{{ $category2->id }}" class="submenu">
                                                                    <div class="submenu-header" data-submenu-close="navCat2-{{ $category2->id }}">
                                                                        <a href="#">{{ $category2->name }}</a>
                                                                    </div>
                                                                    <ul>
                                                                        @foreach($category2->child_sub_cats as $category3)
                                                                            @php
                                                                                $products_m3    = \App\Product::query()->where('sub_child_category_id', '=', $category3->id);
                                                                                //if($products_m3->count() < 1) continue;
                                                                            @endphp
                                                                            <li class="has-submenu">
                                                                                <a href="#" data-submenu="navCat3-{{ $category3->id }}">{{ $category3->name }}</a>
                                                                                <div id="navCat3-{{ $category3->id }}" class="submenu">
                                                                                    <div class="submenu-header" data-submenu-close="navCat3-{{ $category3->id }}">
                                                                                        <a href="#">{{ $category3->name }}</a>
                                                                                    </div>
                                                                                    <ul>
                                                                                        @foreach ($products_m3->get() as $product3)
                                                                                            <li>
                                                                                                <a href="{{route('front.product.details',$product3->slug)}}">{{ $product3->title }}</a>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </div>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        @foreach ($products_m1->get() as $product1)
                                                            <li>
                                                                <a href="{{route('front.product.details',$product1->slug)}}">{{ $product1->title }}</a>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="px-4 px-md-5 pt-5 pb-4 border-bottom">
                            <h2 class="font-size-3 mb-3">HELP & SETTINGS </h2>
                            <ul class="list-group list-group-flush list-group-borderless">
                                <li class="list-group-item px-0 py-2 border-0"><a href="{{ route('front.faq') }}" class="h-primary">Help</a></li>
                                <li class="list-group-item px-0 py-2 border-0"><a href="{{ route('user.login') }}" class="h-primary">Sign In</a></li>
                            </ul>
                        </div>

                        <div class="px-4 px-md-5 py-5">
                            {{-- <select class="custom-select mb-4 rounded-0 pl-4 height-4 shadow-none text-dark changeLanguageNav">
                                @php
                                    $languages = \App\Language::all()->sortBy('name', 0, false);
                                @endphp
                                @foreach($languages as $language)
                                    <option data-link="{{ route('changeLanguage', $language->code) }}" value="{{ $language->code }}" @if($language->code == session('lang')) selected @endif>{{ $language->name }}</option>
                                @endforeach
                            </select>
                            <script>
                                var tgtN = $('.changeLanguageNav');
                                tgtN.on('change', function () {
                                    changeDLNav();
                                });
                                function changeDLNav() {
                                    window.location.assign(tgtN.find('option:selected').attr('data-link'));
                                }
                            </script> --}}

                            {{-- <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a class="h-primary pr-2 font-size-2" href="#">
                                        <span class="fab fa-facebook-f btn-icon__inner"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h-primary pr-2 font-size-2" href="#">
                                        <span class="fab fa-google btn-icon__inner"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h-primary pr-2 font-size-2" href="#">
                                        <span class="fab fa-twitter btn-icon__inner"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h-primary pr-2 font-size-2" href="#">
                                        <span class="fab fa-github btn-icon__inner"></span>
                                    </a>
                                </li>
                            </ul> --}}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</aside>
<!-- End Sidebar Navigation -->




<!-- Sidebar Navigation -->
{{-- <aside id="sidebar001Content" class="u-sidebar u-sidebar__md u-sidebar--left" aria-labelledby="sidebarNavToggler">
    <div class="u-sidebar__scroller js-scrollbar">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">

                <div class="u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">

                        <header class="border-bottom px-4 px-md-5 py-4 d-flex align-items-center justify-content-between">
                            <h2 class="font-size-3 mb-0">SHOP BY CATEGORY</h2>

                            <div class="d-flex align-items-center">
                                <button type="button" class="close ml-auto"
                                        aria-controls="sidebar001Content"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        data-unfold-event="click"
                                        data-unfold-hide-on-scroll="false"
                                        data-unfold-target="#sidebar001Content"
                                        data-unfold-type="css-animation"
                                        data-unfold-animation-in="fadeInLeft"
                                        data-unfold-animation-out="fadeOutLeft"
                                        data-unfold-duration="500">
                                    <span aria-hidden="true"><i class="fas fa-times ml-2"></i></span>
                                </button>
                            </div>

                        </header>

                        <div class="border-bottom">
                            <div class="zeynep pt-4">
                                <ul>
                                    @foreach($categories1 as $category1)
                                        @php
                                            $products_m1 = \App\Product::query()->where('category_id', '=', $category1->id)
                                        @endphp
                                        {{--only show categories with either products or sub-categories--} }
                                        @if(
                                            $categories2->where('parent_menu_id', $category1->id)->count() >= 1 ||
                                            $products_m1->count() >= 1
                                            )
                                            @if($products_m1->count() >= 1)
                                                <li class="has-submenu">
                                                    <a href="#" data-submenu="cat-{{ $category1->id }}">{{ $category1->name }}</a>
                                                    <div id="cat-{{ $category1->id }}" class="submenu">
                                                        <div class="submenu-header" data-submenu-close="cat-{{ $category1->id }}">
                                                            <a href="#">{{ $category1->name }}</a>
                                                        </div>
                                                        <ul>



                                                            @foreach($categories2->where('parent_menu_id', $category1->id) as $category2)
                                                                @php
                                                                    $products_m2 = \App\Product::query()->where('sub_category_id', '=', $category2->id)
                                                                @endphp
                                                                {{--only show categories with either products or sub-categories--} }
                                                                @if(
                                                                    $categories2->where('parent_menu_id', $category1->id)->count() >= 1 ||
                                                                    $products_m2->count() >= 1
                                                                    )
                                                                    @if($products_m2->count() >= 1)
                                                                        @if($categories2->where('parent_menu_id', $category1->id)->count() >= 1)
                                                                            <li class="has-submenu">
                                                                                <a href="#" data-submenu="cat2-{{ $category2->id }}">{{ $category2->name }}</a>
                                                                                <div id="cat2-{{ $category2->id }}" class="submenu">
                                                                                    <div class="submenu-header" data-submenu-close="cat2-{{ $category2->id }}">
                                                                                        <a href="#">{{ $category2->name }}</a>
                                                                                    </div>
                                                                                    <ul>



                                                                                        @foreach($categories3->where('parent_menu_id', $category2->id) as $category3)
                                                                                            @php
                                                                                                $products_m3 = \App\Product::query()->where('sub_child_category_id', '=', $category3->id)
                                                                                            @endphp
                                                                                            {{--only show categories with either products or sub-categories--} }
                                                                                            @if(
                                                                                                $categories3->where('parent_menu_id', $category2->id)->count() >= 1 &&
                                                                                                $products_m3->count() >= 1
                                                                                                )
                                                                                                <li class="has-submenu">
                                                                                                    <a href="#" data-submenu="cat3-{{ $category3->id }}">{{ $category3->name }}</a>
                                                                                                    <div id="cat3-{{ $category3->id }}" class="submenu">
                                                                                                        <div class="submenu-header" data-submenu-close="cat3-{{ $category3->id }}">
                                                                                                            <a href="#">{{ $category3->name }}</a>
                                                                                                        </div>
                                                                                                        <ul>
                                                                                                            @foreach ($products_m3->get() as $product3)
                                                                                                                <li>
                                                                                                                    <a href="{{route('front.product.details',$product3->slug)}}">{{ $product3->title }}</a>
                                                                                                                </li>
                                                                                                            @endforeach
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </li>
                                                                                            @endif
                                                                                        @endforeach



                                                                                    </ul>
                                                                                </div>
                                                                            </li>
                                                                        @elseif($products_m2->count() >= 1)
                                                                            @foreach ($products_m2->get() as $product)
                                                                                <li>
                                                                                    <a href="{{route('front.product.details',$product->slug)}}">{{ $product->title }}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach



                                                        </ul>
                                                    </div>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="px-4 px-md-5 pt-5 pb-4 border-bottom">
                            <h2 class="font-size-3 mb-3">HELP & SETTINGS </h2>
                            <ul class="list-group list-group-flush list-group-borderless">
                                <li class="list-group-item px-0 py-2 border-0"><a href="{{ route('front.faq') }}" class="h-primary">Help</a></li>
                                <li class="list-group-item px-0 py-2 border-0"><a href="{{ route('user.login') }}" class="h-primary">Sign In</a></li>
                            </ul>
                        </div>
                        <div class="px-4 px-md-5 py-5">
                            <select class="custom-select mb-4 rounded-0 pl-4 height-4 shadow-none text-dark changeLanguageNav">
                                @php
                                    $languages = \App\Language::all()->sortBy('name', 0, false);
                                @endphp
                                @foreach($languages as $language)
                                    <option data-link="{{ route('changeLanguage', $language->code) }}" value="{{ $language->code }}" @if($language->code == session('lang')) selected @endif>{{ $language->name }}</option>
                                @endforeach
                            </select>
                            <script>
                                var tgtN = $('.changeLanguageNav');
                                tgtN.on('change', function () {
                                    changeDLNav();
                                });
                                function changeDLNav() {
                                    window.location.assign(tgtN.find('option:selected').attr('data-link'));
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside> --}}
<!-- End Sidebar Navigation -->
