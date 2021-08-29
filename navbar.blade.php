@php
    //$categories = \App\Language::where('code', 'en')->first()->pcategories;
    $lang           = \App\Language::where('code', 'en')->first();
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
@include('front.bookworm.header.' . $be->bookworm_header_version )

<!-- Categories Sidebar Navigation -->
<aside id="sidebarContent2" class="u-sidebar u-sidebar__md u-sidebar--left" aria-labelledby="sidebarNavToggler2">
    <div class="u-sidebar__scroller js-scrollbar">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">
                <!-- Content -->
                <div class="u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">
                        <!-- Title -->
                        <header class="border-bottom px-4 px-md-5 py-4 d-flex align-items-center justify-content-between">
                            <h2 class="font-size-3 mb-0">SHOP BY CATEGORY</h2>

                            <!-- Toggle Button -->
                            <div class="d-flex align-items-center">
                                <button type="button" class="close ml-auto"
                                        aria-controls="sidebarContent2"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        data-unfold-event="click"
                                        data-unfold-hide-on-scroll="false"
                                        data-unfold-target="#sidebarContent2"
                                        data-unfold-type="css-animation"
                                        data-unfold-animation-in="fadeInLeft"
                                        data-unfold-animation-out="fadeOutLeft"
                                        data-unfold-duration="500">
                                    <span aria-hidden="true"><i class="fas fa-times ml-2"></i></span>
                                </button>
                            </div>
                            <!-- End Toggle Button -->
                        </header>
                        <!-- End Title -->

                        <div class="border-bottom">
                            <div class="zeynep pt-4">
                                <ul>
                                    @foreach($categories1 as $category1)
                                        @php
                                            $products_m1 = \App\Product::query()->where('category_id', '=', $category1->id);
                                            $categories2    = $category1->child_cats()->whereIn('id', $ids)->get();
                                        @endphp
                                        {{--only show categories with either products or sub-categories--}}
                                        <li class="has-submenu">
                                            <a href="#" data-submenu="cat-{{ $category1->id }}">{{ $category1->name }}</a>
                                            <div id="cat-{{ $category1->id }}" class="submenu">
                                                <div class="submenu-header" data-submenu-close="cat-{{ $category1->id }}">
                                                    <a href="#">{{ $category1->name }}</a>
                                                </div>
                                                <ul>
                                                    @foreach($categories2 as $category2)
                                                        @php
                                                            $products_m2 = \App\Product::query()->where('sub_category_id', '=', $category2->id);
                                                            $categories3    = $category2->child_sub_cats()->whereIn('parent_menu_id', $indexes2)->get();
                                                        @endphp
                                                        {{--only show categories with either products or sub-categories--}}
                                                        @if(!empty($categories2) || !empty($products_m2))
                                                            @if(!empty($products_m2))
                                                                @if(!empty($categories2))
                                                                    <li class="has-submenu">
                                                                        <a href="#" data-submenu="cat2-{{ $category2->id }}">{{ $category2->name }}</a>
                                                                        <div id="cat2-{{ $category2->id }}" class="submenu">
                                                                            <div class="submenu-header" data-submenu-close="cat2-{{ $category2->id }}">
                                                                                <a href="#">{{ $category2->name }}</a>
                                                                            </div>
                                                                            <ul>
                                                                                @foreach($categories3 as $category3)
                                                                                    @php
                                                                                        $products_m3 = \App\Product::query()->where('sub_child_category_id', '=', $category3->id)
                                                                                    @endphp
                                                                                    {{--only show categories with either products or sub-categories--}}
                                                                                    @if(!empty($categories3) && !empty($products_m3))
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
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </div>
</aside>
<!-- End Categories Sidebar Navigation -->

