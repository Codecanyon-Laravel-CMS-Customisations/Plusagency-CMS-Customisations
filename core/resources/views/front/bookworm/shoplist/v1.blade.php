@php
    // $bex->base_currency_symbol          = "AI";
    // $bex->base_currency_symbol_position = strtolower("Left");
    // $bex->base_currency_text            = "United States Dollar";
    // $bex->base_currency_text_position   = strtolower("Left");
    // $bex->base_currency_rate            = "1.00";

    // echo json_encode($bex);
    // return;

    $geo_data_base_currency = angel_get_base_currency_id(); //App\Models\Currency::find(81);
    $geo_data_user_currency = angel_get_user_currency_id(); //App\Models\Currency::find(23);

    // dd( $geo_data_base_currency);
    // echo json_encode( $geo_data_base_currency);return;
    // $bc_id      = App\Models\Currency::query()->where('name', App\BasicExtra::first()->base_currency_text)->orderBy('id', 'desc')->first();
    // echo json_encode($bc_id);//        return $bc_id->id;

    //$bex_user_currency = App\Models\Currency::find($geo_data_user_currency);
    $bex_user_currency = App\Models\Currency::find(1);
    $bex->base_currency_symbol = $bex_user_currency->symbol;
    $bex->base_currency_symbol_position = strtolower($bex_user_currency->symbol_position) == 'l' ? 'left' : 'right';
    $bex->base_currency_text = $bex_user_currency->name;
    $bex->base_currency_text_position = strtolower($bex_user_currency->text_position) == 'l' ? 'left' : 'right';

    // echo json_encode($bex);return;
    // echo json_encode(session()->all());return;

@endphp
<div class="page-header border-bottom mb-8">
    <div class="container">
        <div class="d-md-flex justify-content-between align-items-center py-4">
            <h1 class="page-title font-size-3 font-weight-medium m-0 text-lh-lg">Shop</h1>
            <p class="woocommerce-breadcrumb font-size-2">
                {{ convertUtf8($be->product_subtitle) }}
            </p>
        </div>
    </div>
</div>

<div class="site-content space-bottom-3" id="content">
    <div class="container">
        <div class="row">
            @if ($products->count() > 0)
                <div id="primary" class="content-area order-2 col-md-8">
                    <div
                        class="shop-control-bar d-lg-flex justify-content-end align-items-center mb-5 text-center text-md-left">
                        {{-- <div class="shop-control-bar__left mb-4 m-lg-0">
                            <p class="woocommerce-result-count m-0">Showing 1–12 of 126 results</p>
                        </div> --}}
                        <div class="shop-control-bar__right d-flex align-items-center justify-content-end">
                            {{-- <form class="woocommerce-ordering mb-4 m-md-0" method="get">
                                <!-- Select -->
                                <select class="js-select selectpicker dropdown-select orderby" name="orderby"
                                data-style="border-bottom shadow-none outline-none py-2">
                                    <option value="popularity">Sort by popularity</option>
                                    <option value="default" selected="selected">Default sorting</option>
                                    <option value="date">Sort by newness</option>
                                    <option value="price">Sort by price: low to high</option>
                                    <option value="price-desc">Sort by price: high to low</option>
                                </select>
                                <!-- End Select -->
                            </form>

                            <form class="number-of-items ml-md-4 mb-4 m-md-0 d-none d-xl-block" method="get">
                                <!-- Select -->
                                <select class="js-select selectpicker dropdown-select orderby" name="orderby"
                                data-style="border-bottom shadow-none outline-none py-2"
                                data-width="fit">
                                    <option value="show10">Show 10</option>
                                    <option value="show15">Show 15</option>
                                    <option value="show20" selected="selected">Show 20</option>
                                    <option value="show25">Show 25</option>
                                    <option value="show30">Show 30</option>
                                </select>
                                <!-- End Select -->
                            </form> --}}

                            <ul class="float-right nav nav-tab ml-lg-4 justify-content-end" id="pills-tab"
                                role="tablist">
                                <li class="nav-item border">
                                    <a class="nav-link p-0 height-38 width-38 justify-content-center d-flex align-items-center active"
                                       id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1"
                                       role="tab" aria-controls="pills-one-example1" aria-selected="true">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="17px" height="17px">
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M-0.000,0.000 L3.000,0.000 L3.000,3.000 L-0.000,3.000 L-0.000,0.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M7.000,0.000 L10.000,0.000 L10.000,3.000 L7.000,3.000 L7.000,0.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M14.000,0.000 L17.000,0.000 L17.000,3.000 L14.000,3.000 L14.000,0.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M-0.000,7.000 L3.000,7.000 L3.000,10.000 L-0.000,10.000 L-0.000,7.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M7.000,7.000 L10.000,7.000 L10.000,10.000 L7.000,10.000 L7.000,7.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M14.000,7.000 L17.000,7.000 L17.000,10.000 L14.000,10.000 L14.000,7.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M-0.000,14.000 L3.000,14.000 L3.000,17.000 L-0.000,17.000 L-0.000,14.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M7.000,14.000 L10.000,14.000 L10.000,17.000 L7.000,17.000 L7.000,14.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M14.000,14.000 L17.000,14.000 L17.000,17.000 L14.000,17.000 L14.000,14.000 Z"/>
                                        </svg>
                                    </a>
                                </li>
                                <li class="nav-item border">
                                    <a class="nav-link p-0 height-38 width-38 justify-content-center d-flex align-items-center"
                                       id="pills-two-example1-tab" data-toggle="pill" href="#pills-two-example1"
                                       role="tab" aria-controls="pills-two-example1" aria-selected="false">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" width="23px" height="17px">
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M-0.000,0.000 L3.000,0.000 L3.000,3.000 L-0.000,3.000 L-0.000,0.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M7.000,0.000 L23.000,0.000 L23.000,3.000 L7.000,3.000 L7.000,0.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M-0.000,7.000 L3.000,7.000 L3.000,10.000 L-0.000,10.000 L-0.000,7.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M7.000,7.000 L23.000,7.000 L23.000,10.000 L7.000,10.000 L7.000,7.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M-0.000,14.000 L3.000,14.000 L3.000,17.000 L-0.000,17.000 L-0.000,14.000 Z"/>
                                            <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                                  d="M7.000,14.000 L23.000,14.000 L23.000,17.000 L7.000,17.000 L7.000,14.000 Z"/>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>


                    <!-- Tab Content -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-one-example1" role="tabpanel"
                             aria-labelledby="pills-one-example1-tab">
                            <!-- Mockup Block -->
                            <ul
                                class="products list-unstyled row no-gutters row-cols-2 row-cols-lg-3 row-cols-wd-4 border-top border-left mb-6">
                                @foreach ($products as $product)
                                    <li class="product col">
                                        <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                            <div
                                                class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                                <div class="woocommerce-loop-product__thumbnail">
                                                    <a href="{{ route('front.product.details', $product->slug) }}"
                                                       class="d-block"><img
                                                            src="{{ trim($product->feature_image) }}"
                                                            class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"
                                                            alt="image-description" width="150"></a>
                                                </div>
                                                <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                                    <div class="text-uppercase font-size-1 mb-1 text-truncate"><a
                                                            href="/products?search=&category_id={{ $product->category->id }}&type=new">
{{--                                                            {{ $product->category->name }}--}}
                                                            @php
                                                                                                    try {
                                                                     echo $product->child_category->name;
                                                                 }
                                                                 catch (Exception $e){

                                                                 }
                                                            @endphp
                                                        </a>
                                                    </div>
                                                    {{-- <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="{{route('front.product.details',$product->slug)}}">{{strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title}}</a></h2> --}}
                                                    <h2
                                                        class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-3 crop-text-3 h-dark">
                                                        <a href="{{ route('front.product.details', $product->slug) }}">
                                                            {{ $product->title }}</a></h2>
                                                    {{-- <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Jay Shetty</a></div> --}}
                                                    <div
                                                        class="price d-flex align-items-center font-weight-medium font-size-3">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <span class="woocommerce-Price-currencySymbol">
                                                                {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}
                                                            </span>
                                                            {{ angel_auto_convert_currency($product->current_price, $geo_data_base_currency, $geo_data_user_currency) }}
                                                            <span class="woocommerce-Price-currencySymbol">
                                                                {{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </div>
                                                @if ($bex->catalog_mode == 0)
                                                    <div class="product__hover d-flex align-items-center">
                                                        <a href="{{ route('add.cart', $product->id) }}"
                                                           class="text-uppercase text-dark h-dark font-weight-medium mr-auto"
                                                           data-toggle="tooltip" data-placement="right" title=""
                                                           data-original-title="ADD TO CART">
                                                            <span class="product__add-to-cart">
                                                                <i class="flaticon-icon-126515 font-size-5"></i>
                                                            </span>
                                                            <span class="product__add-to-cart-icon font-size-4"><i
                                                                    class="flaticon-icon-126515"></i></span>
                                                        </a>
                                                        <a href="{{ route('front.product.checkout', $product->slug) }}"
                                                           class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                            <i class="flaticon-switch"></i>
                                                        </a>
                                                        <form method="get" action="{{url('wishlist/')}}" class="h-p-bg btn btn-outline-primary border-0">
                                                            <input type="hidden" name="id" value="{{$product->id}}">
                                                            <button type="submit" style="background: transparent; border-color: transparent;"><i class="flaticon-heart"></i></button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- End Mockup Block -->
                        </div>
                        <div class="tab-pane fade" id="pills-two-example1" role="tabpanel"
                             aria-labelledby="pills-two-example1-tab">
                            <!-- Mockup Block -->
                            @if ($products->count() > 0)
                                <ul class="products list-unstyled mb-6">
                                    @foreach ($products as $product)
                                        <li class="product product__list">
                                            <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                                <div
                                                    class="woocommerce-LoopProduct-link woocommerce-loop-product__link row position-relative">
                                                    <div
                                                        class="col-md-auto woocommerce-loop-product__thumbnail mb-3 mb-md-0">
                                                        <a href="{{ route('front.product.details', $product->slug) }}"
                                                           class="d-block"><img
                                                                src="{{ trim($product->feature_image) }}"
                                                                class="img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid"
                                                                alt="image-description" width="150"></a>
                                                    </div>
                                                    <div
                                                        class="col-md woocommerce-loop-product__body product__body pt-3 bg-white mb-3 mb-md-0">
                                                        <div class="text-uppercase font-size-1 mb-1 text-truncate"><a
                                                                href="/products?search=&category_id={{ $product->category->id }}&type=new">
{{--                                                                {{ $product->category->name }}--}}
                                                                @php
                                                                    try {
                                                                             echo $product->child_category->name;
                                                                         }
                                                                         catch (Exception $e){

                                                                         }
                                                                @endphp
                                                            </a>
                                                        </div>
                                                        {{-- <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 crop-text-2 h-dark"><a href="{{route('front.product.details',$product->slug)}}" tabindex="0">{{strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title}}</a></h2> --}}
                                                        <h2
                                                            class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 crop-text-2 h-dark">
                                                            <a href="{{ route('front.product.details', $product->slug) }}"
                                                               tabindex="0">{{ $product->title }}</a></h2>
                                                        {{-- <div class="font-size-2  mb-2 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Jay Shetty</a></div> --}}
                                                        {{-- <p class="font-size-2 mb-2 crop-text-2">{!! nl2br($product->summary) !!}</p> --}}
                                                        <p class="font-size-2 mb-2 crop-text-2">{!! str_replace('\n', '', nl2br($product->summary, false)) !!}
                                                        </p>
                                                        <div
                                                            class="price d-flex align-items-center font-weight-medium font-size-3">
                                                            <span class="woocommerce-Price-amount amount"><span
                                                                    class="woocommerce-Price-currencySymbol">{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}</span>{{ $product->current_price }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-auto d-flex align-items-center">
                                                        <a href="{{ route('add.cart', $product->id) }}"
                                                           class="text-uppercase text-dark h-dark font-weight-medium mr-4"
                                                           data-toggle="tooltip" data-placement="right" title=""
                                                           data-original-title="ADD TO CART">
                                                            <span class="product__add-to-cart">
                                                                <i class="flaticon-icon-126515 font-size-5"></i>
                                                            </span>
                                                            <span class="product__add-to-cart-icon font-size-4"><i
                                                                    class="flaticon-icon-126515"></i></span>
                                                        </a>
                                                        <a href="{{ route('front.product.checkout', $product->slug) }}"
                                                           class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                            <i class="flaticon-switch"></i>
                                                        </a>
                                                        <a href="{{route('wishlist')}}" class="h-p-bg btn btn-outline-primary border-0">
                                                            <i class="flaticon-heart"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                        @endif
                        <!-- End Mockup Block -->
                        </div>
                    </div>
                    <!-- End Tab Content -->


                    <nav class="pagination-nav {{ $products->count() > 6 ? 'mb-4' : '' }}">
                        {{ $products->appends(['search' => request()->input('search'), 'minprice' => request()->input('minprice'), 'maxprice' => request()->input('maxprice'), 'category_id' => request()->input('category_id'), 'type' => request()->input('type'), 'tag' => request()->input('tag'), 'review' => request()->input('review')])->links() }}
                    </nav>
                </div>
            @else
                <div class="col-12 text-center py-5 bg-light" style="margin-top: 30px;">
                    <h4 class="text-center">{{ __('Product Not Found') }}</h4>
                </div>
            @endif
            <div id="secondary" class="sidebar widget-area order-1 col-md-4" role="complementary">


                <div id="widgetAccordion">
                    <div id="woocommerce_product_categories-2"
                         class="widget p-4d875 border woocommerce widget_product_categories">
                        <div id="widgetHeadingOne" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#"
                               data-toggle="collapse" data-target="#widgetCollapseOne" aria-expanded="true"
                               aria-controls="widgetCollapseOne">
                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">
                                    <small><strong class="text-uppercase">categories</strong></small>
                                </h3>
                                <svg class="mins" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"/>
                                </svg>
                                <svg class="plus" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"/>
                                </svg>
                            </a>
                        </div>
                        <div id="widgetCollapseOne" class="mt-3 widget-content collapse show"
                             aria-labelledby="widgetHeadingOne" data-parent="#widgetAccordion">
                            <ul class="product-categories">
                                @foreach ($categories->where('menu_level', 1)->where('name', '!=', 'Default Category')->sortBy('name', 0, false) as $category)
                                    <li
                                        class="cat-item cat-item-{{$category->id}} {{ request()->input('category_id') == $category->id ? 'active-search' : '' }}">
                                        <a href="/products?search=&category_id={{ $category->id }}&type=new">
                                            {{ convertUtf8($category->name) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div id="Authors" class="widget widget_search widget_author p-4d875 border">
                        <div id="widgetHeading21" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#"
                               data-toggle="collapse" data-target="#widgetCollapse21" aria-expanded="true"
                               aria-controls="widgetCollapse21">
                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">
                                    <small><strong class="text-uppercase">Author</strong></small>
                                </h3>
                                <svg class="mins" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"/>
                                </svg>
                                <svg class="plus" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"/>
                                </svg>
                            </a>
                        </div>
                        <div id="widgetCollapse21" class="mt-4 widget-content collapse show"
                             aria-labelledby="widgetHeading21" data-parent="#widgetAccordion">
                            <form class="form-inline my-2 overflow-hidden">
                                <div class="input-group flex-nowrap w-100">
                                    <div class="input-group-prepend">
                                        <i
                                            class="glph-icon flaticon-loupe py-2d75 bg-white-100 border-white-100 text-dark pl-3 pr-0 rounded-0"></i>
                                    </div>
                                    <input
                                        class="form-control bg-white-100 py-2d75 height-4 border-white-100 rounded-0"
                                        type="search" placeholder="Search" aria-label="Search">
                                </div>
                                <button class="btn btn-outline-success my-2 my-sm-0 sr-only"
                                        type="submit">Search
                                </button>
                            </form>
                            <ul class="product-categories">
                                <li class="cat-item cat-item-9 cat-parent">
                                    <a href="../others/authors-single.html">A. J. Finn</a>
                                </li>
                                <li class="cat-item cat-item-69 cat-parent">
                                    <a href="../others/authors-single.html">Anne Frank</a>
                                </li>
                                <li class="cat-item cat-item-65 cat-parent">
                                    <a href="../others/authors-single.html">Camille Pagán</a>
                                </li>
                                <li class="cat-item cat-item-11 cat-parent"><a
                                        href="../others/authors-single.html">Daniel H. Pink</a>
                                </li>
                                <li class="cat-item cat-item-12"><a href="../others/authors-single.html">Danielle
                                        Steel</a></li>
                                <li class="cat-item cat-item-31"><a href="../others/authors-single.html">David
                                        Quammen</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="Language" class="widget p-4d875 border">
                        <div id="widgetHeading22" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#"
                               data-toggle="collapse" data-target="#widgetCollapse22" aria-expanded="true"
                               aria-controls="widgetCollapse22">
                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">Language</h3>
                                <svg class="mins" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"/>
                                </svg>
                                <svg class="plus" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"/>
                                </svg>
                            </a>
                        </div>
                        <div id="widgetCollapse22" class="mt-4 widget-content collapse show"
                             aria-labelledby="widgetHeading22" data-parent="#widgetAccordion">
                            <ul class="product-categories">
                                <li class="custom-control custom-checkbox mb-2 pb-2">
                                    <input type="checkbox" class="custom-control-input" id="brandEnglish">
                                    <label class="custom-control-label" for="brandEnglish">English</label>
                                </li>
                                <li class="custom-control custom-checkbox mb-2 pb-2">
                                    <input type="checkbox" class="custom-control-input" id="brandGerman">
                                    <label class="custom-control-label" for="brandGerman">German</label>
                                </li>
                                <li class="custom-control custom-checkbox mb-2 pb-2">
                                    <input type="checkbox" class="custom-control-input" id="brandFrench">
                                    <label class="custom-control-label" for="brandFrench">French</label>
                                </li>
                                <li class="custom-control custom-checkbox mb-2 pb-2">
                                    <input type="checkbox" class="custom-control-input" id="brandSpanish">
                                    <label class="custom-control-label" for="brandSpanish">Spanish</label>
                                </li>
                                <li class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="brandTurkish">
                                    <label class="custom-control-label" for="brandTurkish">Turkish</label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="woocommerce_price_filter-2" class="widget p-4d875 border woocommerce widget_price_filter">
                        <div id="widgetHeadingTwo" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#"
                               data-toggle="collapse" data-target="#widgetCollapseTwo" aria-expanded="true"
                               aria-controls="widgetCollapseTwo">
                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">Filter by price</h3>
                                <svg class="mins" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"/>
                                </svg>
                                <svg class="plus" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"/>
                                </svg>
                            </a>
                        </div>
                        <div id="widgetCollapseTwo" class="mt-4 widget-content collapse show"
                             aria-labelledby="widgetHeadingTwo" data-parent="#widgetAccordion">
                            <form method="get" action="https://themes.woocommerce.com/storefront/shop/">
                                <div class="price_slider_wrapper">
                                    <div
                                        class="price_slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"
                                        style="">
                                        <div class="ui-slider-range ui-widget-header ui-corner-all"
                                             style="left: 0%; width: 100%;"></div>
                                        <span
                                            class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"
                                            style="left: 0%;"></span><span
                                            class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"
                                            style="left: 98%;"></span>
                                    </div>
                                    <div class="price_slider_amount">
                                        <input type="text" id="min_price" name="min_price" value="2" data-min="2"
                                               placeholder="Min price" style="display: none;">
                                        <input type="text" id="max_price" name="max_price" value="1495" data-max="1495"
                                               placeholder="Max price" style="display: none;">
                                        <button type="submit" class="button d-none">Filter</button>
                                        <div class="mx-auto price_label mt-2" style="">
                                            Price: <span class="from">£2</span> — <span
                                                class="to">£1,495</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="Review" class="widget p-4d875 border">
                        <div id="widgetHeading24" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#"
                               data-toggle="collapse" data-target="#widgetCollapse24" aria-expanded="true"
                               aria-controls="widgetCollapse24">
                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">By Review</h3>
                                <svg class="mins" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"/>
                                </svg>
                                <svg class="plus" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"/>
                                </svg>
                            </a>
                        </div>
                        <div id="widgetCollapse24" class="mt-4 widget-content collapse show"
                             aria-labelledby="widgetHeading24" data-parent="#widgetAccordion">
                            <div
                                class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 pb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating5">
                                    <label class="custom-control-label" for="rating5">
                                        <span class="d-block text-yellow-darker mt-plus-3">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 "></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">24</small>
                            </div>
                            <div
                                class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 pb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating4">
                                    <label class="custom-control-label" for="rating4">
                                        <span class="d-block text-yellow-darker mt-plus-3">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 "></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">15</small>
                            </div>
                            <div
                                class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 pb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating3">
                                    <label class="custom-control-label" for="rating3">
                                        <span class="d-block text-yellow-darker mt-plus-3">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 "></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">43</small>
                            </div>
                            <div
                                class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 pb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating2">
                                    <label class="custom-control-label" for="rating2">
                                        <span class="d-block text-yellow-darker mt-plus-3">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2"></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">78</small>
                            </div>
                            <div
                                class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating1">
                                    <label class="custom-control-label" for="rating1">
                                        <span class="d-block text-yellow-darker mt-plus-3">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2"></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">21</small>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="widgetAccordion11111">
                    <div id="woocommerce_product_categories-2"
                         class="widget p-4d875 border woocommerce widget_product_categories">
                        <div id="widgetHeadingOne" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#"
                               data-toggle="collapse" data-target="#widgetCollapseOne" aria-expanded="true"
                               aria-controls="widgetCollapseOne">

                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">Categories</h3>

                                <svg class="mins" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"/>
                                </svg>

                                <svg class="plus" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"/>
                                </svg>
                            </a>
                        </div>

                        <div id="widgetCollapseOne" class="mt-3 widget-content collapse show"
                             aria-labelledby="widgetHeadingOne" data-parent="#widgetAccordion">
                            <ul class="product-categories">
                                @foreach ($categories->where('menu_level', 2)->where('name', '!=', 'Default Category')->sortBy('name', 0, false) as $category)
                                    <li
                                        class="cat-item cat-item-12 {{ request()->input('category_id') == $category->id ? 'active-search' : '' }}">
                                        <a
                                            href="/products?search=&category_id={{ $category->id }}&type=new">{{ convertUtf8($category->name) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div id="woocommerce_price_filter-2" class="widget p-4d875 border woocommerce widget_price_filter">
                        <div id="widgetHeadingTwo" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#"
                               data-toggle="collapse" data-target="#widgetCollapseTwo" aria-expanded="true"
                               aria-controls="widgetCollapseTwo">

                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">Filter by price</h3>

                                <svg class="mins" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"/>
                                </svg>

                                <svg class="plus" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"/>
                                </svg>
                            </a>
                        </div>

                        <div id="widgetCollapseTwo" class="mt-4 widget-content collapse show"
                             aria-labelledby="widgetHeadingTwo" data-parent="#widgetAccordion">
                            <form action="#">
                                <div id="slider-range"></div>
                                <span>{{ __('Price') }}: </span>
                                <input type="text" name="text" id="amount"/>
                                <button class="btn mt-2 filter-button" type="button">{{ __('Filter') }}</button>
                            </form>
                        </div>
                    </div>

                    <div id="Review" class="widget p-4d875 border">
                        <div id="widgetHeading24" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#"
                               data-toggle="collapse" data-target="#widgetCollapse24" aria-expanded="true"
                               aria-controls="widgetCollapse24">

                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">By Review</h3>

                                <svg class="mins" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"/>
                                </svg>

                                <svg class="plus" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)"
                                          d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"/>
                                </svg>
                            </a>
                        </div>

                        <div id="widgetCollapse24" class="mt-4 widget-content collapse show"
                             aria-labelledby="widgetHeading24" data-parent="#widgetAccordion">
                            <ul class="checkbox_common checkbox_style2">
                                <li>
                                    <input type="radio" class="review_val" name="review_value"
                                           {{ request()->input('review') == '' ? 'checked' : '' }} id="checkbox4"
                                           value="">
                                    <label for="checkbox4"><span></span> {{ __('Show All') }}</label>
                                </li>
                                <li>
                                    <input type="radio" class="review_val" name="review_value" id="checkbox5"
                                           value="4"
                                           {{ request()->input('review') == 4 ? 'checked' : '' }} id="checkbox4"
                                           value="all">
                                    <label for="checkbox5"><span></span>4 {{ __('Star and higher') }}</label>
                                </li>
                                <li>
                                    <input type="radio" class="review_val" name="review_value" id="checkbox6"
                                           value="3"
                                           {{ request()->input('review') == 3 ? 'checked' : '' }} id="checkbox4"
                                           value="all">
                                    <label for="checkbox6"><span></span>3 {{ __('Star and higher') }}</label>
                                </li>

                                <li>
                                    <input type="radio" class="review_val" name="review_value" id="checkbox7"
                                           value="2"
                                           {{ request()->input('review') == 2 ? 'checked' : '' }} id="checkbox4"
                                           value="all">
                                    <label for="checkbox7"><span></span>2 {{ __('Star and higher') }}</label>
                                </li>

                                <li>
                                    <input type="radio" class="review_val" name="review_value" id="checkbox8"
                                           value="1"
                                           {{ request()->input('review') == 1 ? 'checked' : '' }} id="checkbox4"
                                           value="all">
                                    <label for="checkbox8"><span></span>1 {{ __('Star and higher') }}</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
