<div class="site-content space-bottom-3" id="content">
    <div class="container pt-5">
        <div class="row pt-5">
            @php
            $pdata = $products->toArray();
            $productIds = [];
            if(is_array(session()->get('wishlist'))){
            foreach(session()->get('wishlist') as $pId => $ptemp){
            array_push($productIds,$pId);
            }
            }
            @endphp
            @if ($products->count() > 0)
            <div id="primary" class="content-area order-2 col-md-8">
                <div class="shop-control-bar d-lg-flex justify-content-end align-items-center mb-5 mt-5 mt-md-0 text-center text-md-left">
                    <div class="shop-control-bar__left mb-4 m-lg-0">
                        <p class="woocommerce-result-count m-0 pr-2">Showing {{$pdata['from']}}–{{$pdata['to']}}of {{$pdata['total']}} results</p>
                    </div>
                    <div class="shop-control-bar__right d-flex align-items-start justify-content-start">
                        <div class="form-group mb-lg-1" style="margin-bottom: -40px;">
                            <input type="text" name="filter" id="filter" class="form-control js-shuffle-search p-1" style="height: 40px;">
                        </div>
                    </div>
                    <div class="shop-control-bar__right d-flex align-items-center justify-content-end">
                        <ul class="float-right nav nav-tab ml-lg-4 justify-content-end" id="pills-tab" role="tablist">
                            <li class="nav-item border">
                                <a class="nav-link p-0 height-38 width-38 justify-content-center d-flex align-items-center " id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1" role="tab" aria-controls="pills-one-example1" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17px" height="17px">
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,0.000 L3.000,0.000 L3.000,3.000 L-0.000,3.000 L-0.000,0.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,0.000 L10.000,0.000 L10.000,3.000 L7.000,3.000 L7.000,0.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M14.000,0.000 L17.000,0.000 L17.000,3.000 L14.000,3.000 L14.000,0.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,7.000 L3.000,7.000 L3.000,10.000 L-0.000,10.000 L-0.000,7.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,7.000 L10.000,7.000 L10.000,10.000 L7.000,10.000 L7.000,7.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M14.000,7.000 L17.000,7.000 L17.000,10.000 L14.000,10.000 L14.000,7.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,14.000 L3.000,14.000 L3.000,17.000 L-0.000,17.000 L-0.000,14.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,14.000 L10.000,14.000 L10.000,17.000 L7.000,17.000 L7.000,14.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M14.000,14.000 L17.000,14.000 L17.000,17.000 L14.000,17.000 L14.000,14.000 Z" />
                                    </svg>
                                </a>
                            </li>
                            <li class="nav-item border">
                                <a class="nav-link p-0 height-38 width-38 justify-content-center d-flex align-items-center active" id="pills-two-example1-tab" data-toggle="pill" href="#pills-two-example1" role="tab" aria-controls="pills-two-example1" aria-selected="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23px" height="17px">
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,0.000 L3.000,0.000 L3.000,3.000 L-0.000,3.000 L-0.000,0.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,0.000 L23.000,0.000 L23.000,3.000 L7.000,3.000 L7.000,0.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,7.000 L3.000,7.000 L3.000,10.000 L-0.000,10.000 L-0.000,7.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,7.000 L23.000,7.000 L23.000,10.000 L7.000,10.000 L7.000,7.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,14.000 L3.000,14.000 L3.000,17.000 L-0.000,17.000 L-0.000,14.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,14.000 L23.000,14.000 L23.000,17.000 L7.000,17.000 L7.000,14.000 Z" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Tab Content -->
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab">
                        <!-- Mockup Block -->
                        <ul id="searchable-filter-items-grid" class="products list-unstyled row no-gutters row-cols-2 row-cols-lg-3 row-cols-wd-4 border-top border-left mb-6">
                            @foreach ($products as $product)
                            <li class="product col searchable-filter-item">
                                <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                    <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                        <div class="woocommerce-loop-product__thumbnail">
                                            <a href="{{ route('front.product.details', $product->slug) }}" class="d-block">
                                                <img data-src="{{ trim($product->feature_image) }}" class="lazy img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="{{ "Product Image" }}" width="150">
                                            </a>
                                        </div>
                                        <div class="woocommerce-loop-product__body product__body pt-3 bg-white">
                                            <div class="text-uppercase font-size-1 mb-1 text-truncate">
                                                @if ($product->linked_sub_category)
                                                <a href="/products?search=&sc-id={{ $product->linked_sub_category->id }}&type=new">{{ $product->linked_sub_category->name }}</a>
                                                @else
                                                <a href="/products?search=&category_id={{ $product->category->id }}&type=new">{{ $product->category->name }}</a>
                                                @endif
                                            </div>
                                            {{-- <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark"><a href="{{route('front.product.details',$product->slug)}}">{{strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title}}</a></h2> --}}
                                            <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-3 crop-text-3 h-dark">
                                                <a href="{{ route('front.product.details', $product->slug) }}">
                                                    {{ $product->title }}</a>
                                            </h2>
                                            {{-- <div class="font-size-2  mb-1 text-truncate"><a href="../others/authors-single.html" class="text-gray-700">Jay Shetty</a></div> --}}
                                            <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                <span class="woocommerce-Price-amount amount">
                                                    <span class="woocommerce-Price-currencySymbol">
                                                        {{-- {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }} --}}
                                                        {{ $product->symbol }}
                                                    </span>
                                                    {{-- {{ angel_auto_convert_currency($product->current_price, $geo_data_base_currency, $geo_data_user_currency) }} --}}
                                                    {{ number_format(!empty($product->price) ? $product->price : '0.00', 0) }}
                                                    <span class="woocommerce-Price-currencySymbol">
                                                        {{-- {{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }} --}}
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                        @if ($bex->catalog_mode == 0)
                                        <div class="product__hover d-flex align-items-center">
                                            <a href="{{ route('add.cart', $product->id) }}" data-href="{{ route('add.cart', $product->id) }}" class="text-uppercase text-dark h-dark font-weight-medium mr-auto">
                                                <span class="product__add-to-cart">ADD TO CART</span>
                                                <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                            </a>
                                            <a href="{{ route('front.product.checkout', $product->slug) }}" title="Checkout" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                <i class="flaticon-switch"></i>
                                            </a>
                                            <a href="{{ route('wishlist.item.add', $product->id) }}" class="h-p-bg btn @if(in_array($product->id,$productIds)) btn-primary text-white @else btn-outline-primary @endif border-0" title="Add to Wishlist">
                                                <i class="flaticon-heart"></i>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <!-- End Mockup Block -->
                    </div>
                    <div class="tab-pane fade show active" id="pills-two-example1" role="tabpanel" aria-labelledby="pills-two-example1-tab">
                        <!-- Mockup Block -->
                        @if ($products->count() > 0)
                        <ul class="products list-unstyled mb-6">
                            @foreach ($products as $product)
                            <li class="product product__list">
                                <div class="product__inner overflow-hidden p-3 p-md-4d875">
                                    <div class="woocommerce-LoopProduct-link woocommerce-loop-product__link row position-relative">
                                        <div class="col-md-auto woocommerce-loop-product__thumbnail mb-3 mb-md-0">
                                            <a href="{{ route('front.product.details', $product->slug) }}" class="d-block">
                                                <img data-src="{{ trim($product->feature_image) }}" class="lazy img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid" alt="{{ "Product Image" }}" width="150"></a>
                                        </div>
                                        <div class="col-md woocommerce-loop-product__body product__body pt-3 bg-white mb-3 mb-md-0">
                                            <div class="text-uppercase font-size-1 mb-1 text-truncate">
                                                @if ($product->sub_category)
                                                <a href="/products?search=&sc-id={{ $product->sub_category->id }}&type=new">{{ $product->sub_category->name }}</a>
                                                @else
                                                <a href="/products?search=&category_id={{ $product->category->id }}&type=new">{{ $product->category->name }}</a>
                                                @endif
                                            </div>
                                            <h2 class="woocommerce-loop-product__title product__title h6 text-lh-md mb-1 crop-text-2 h-dark">
                                                <a href="{{ route('front.product.details', $product->slug) }}" tabindex="0">{{ $product->title }}</a>
                                            </h2>
                                            <p class="font-size-2 mb-2 crop-text-2">{!! str_replace('\n', '', nl2br($product->summary, false)) !!}
                                            </p>
                                            <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                                <span class="woocommerce-Price-amount amount">
                                                    {{-- @dd($bex->base_currency_symbol) --}}
                                                    <span class="woocommerce-Price-currencySymbol"> {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : $bex->base_currency_symbol }}</span>{{ $product->current_price }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-auto d-flex align-items-center">
                                            <a href="{{ route('add.cart', $product->id) }}" class="text-uppercase text-dark h-dark font-weight-medium mr-4" data-toggle="tooltip" data-placement="right" title="" data-original-title="ADD TO CART">
                                                <span class="product__add-to-cart">ADD TO CART</span>
                                                <span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>
                                            </a>
                                            <a href="{{ route('front.product.checkout', $product->slug) }}" class="mr-1 h-p-bg btn btn-outline-primary border-0">
                                                <i class="flaticon-switch"></i>
                                            </a>

                                            <a href="{{ route('wishlist.item.add', $product->id) }}" class="h-p-bg btn @if(in_array($product->id,$productIds)) btn-primary text-white @else btn-outline-primary @endif border-0" title="Add to Wishlist">
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
                    <div id="woocommerce_product_categories-2" class="widget p-4d875 border woocommerce widget_product_categories">
                        <div id="widgetHeadingOne" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#" data-toggle="collapse" data-target="#widgetCollapseOne" aria-expanded="true" aria-controls="widgetCollapseOne">
                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">
                                    <small><strong class="text-uppercase">categories</strong></small>
                                </h3>
                                <svg class="mins" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z" />
                                </svg>
                                <svg class="plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z" />
                                </svg>
                            </a>
                        </div>
                        <div id="widgetCollapseOne" class="mt-3 widget-content collapse show" aria-labelledby="widgetHeadingOne" data-parent="#widgetAccordion">
                            <ul class="product-categories">
                                @foreach ($categories->where('menu_level', 1)->where('name', '!=', 'Default Category')->sortBy('name', 0, false) as $category)
                                <li class="cat-item cat-item-{{$category->id}} {{ request()->input('category_id') == $category->id ? 'active-search' : '' }}">
                                    <a href="/products?search=&category_id={{ $category->id }}&type=new">
                                        {{ convertUtf8($category->name) }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div id="woocommerce_price_filter-2" class="widget p-4d875 border woocommerce widget_price_filter">
                        <div id="widgetHeadingTwo" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#" data-toggle="collapse" data-target="#widgetCollapseTwo" aria-expanded="true" aria-controls="widgetCollapseTwo">
                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">Filter by price</h3>
                                <svg class="mins" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z" />
                                </svg>
                                <svg class="plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z" />
                                </svg>
                            </a>
                        </div>
                        <div id="widgetCollapseTwo" class="mt-4 widget-content collapse show" aria-labelledby="widgetHeadingTwo" data-parent="#widgetAccordion">
                            <form method="get" action="#">
                                <div class="price_slider_wrapper">
                                    <div class="price_slider ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" style="">
                                        <div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 100%;"></div>
                                        <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 0%;"></span>
                                        <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 98%;"></span>
                                    </div>
                                    <div class="price_slider_amount">
                                        <input type="text" id="min_price" name="min_price" value="2" data-min="2" placeholder="Min price" style="display: none;">
                                        <input type="text" id="max_price" name="max_price" value="1495" data-max="1495" placeholder="Max price" style="display: none;">
                                        <button type="submit" class="button d-none">Filter</button>
                                        <div class="mx-auto price_label mt-2" style="">
                                            Price: <span class="from">{{ ship_to_india() ? "₹" : "$" }}2</span> — <span class="to">{{ ship_to_india() ? "₹" : "$" }}1,495</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="Review" class="widget p-4d875 border d-none d-md-block">
                        <div id="widgetHeading24" class="widget-head">
                            <a class="d-flex align-items-center justify-content-between text-dark" href="#" data-toggle="collapse" data-target="#widgetCollapse24" aria-expanded="true" aria-controls="widgetCollapse24">
                                <h3 class="widget-title mb-0 font-weight-medium font-size-3">By Review</h3>
                                <svg class="mins" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="2px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z" />
                                </svg>
                                <svg class="plus" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15px" height="15px">
                                    <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z" />
                                </svg>
                            </a>
                        </div>
                        <div id="widgetCollapse24" class="mt-4 widget-content collapse show" aria-labelledby="widgetHeading24" data-parent="#widgetAccordion">
                            <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 pb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating5">
                                    <label class="custom-control-label" for="rating5">
                                        <span class="d-block text-yellow-darker mt-plus-3 pt-1">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 "></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">{{ \App\Models\Unscoped\Product::query()->where('rating', '>=', 4)->where('rating', '<=', 5)->count() }}</small>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 pb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating4">
                                    <label class="custom-control-label" for="rating4">
                                        <span class="d-block text-yellow-darker mt-plus-3 pt-1">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 "></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">{{ \App\Models\Unscoped\Product::query()->where('rating', '>=', 4)->where('rating', '<=', 5)->count() }}</small>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 pb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating3">
                                    <label class="custom-control-label" for="rating3">
                                        <span class="d-block text-yellow-darker mt-plus-3 pt-1">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 "></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">{{ \App\Models\Unscoped\Product::query()->where('rating', '>=', 3)->where('rating', '<', 4)->count() }}</small>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 pb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating2">
                                    <label class="custom-control-label" for="rating2">
                                        <span class="d-block text-yellow-darker mt-plus-3 pt-1">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2"></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">{{ \App\Models\Unscoped\Product::query()->where('rating', '>=', 2)->where('rating', '<', 3)->count() }}</small>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-2 pb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating1">
                                    <label class="custom-control-label" for="rating1">
                                        <span class="d-block text-yellow-darker mt-plus-3 pt-1">
                                            <span class="fas fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2"></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">{{ \App\Models\Unscoped\Product::query()->where('rating', '>=', 1)->where('rating', '<', 2)->count('rating') }}</small>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between font-size-1 text-lh-md text-secondary mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="rating0">
                                    <label class="custom-control-label" for="rating0">
                                        <span class="d-block text-yellow-darker mt-plus-3 pt-1">
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2 mr-1"></span>
                                            <span class="far fa-star font-size-2"></span>
                                        </span>
                                    </label>
                                </div>
                                <small class="font-size-2 text-gray-600">{{ \App\Models\Unscoped\Product::query()->where('rating', '>=', 0)->where('rating', '<', 1)->count('rating') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>