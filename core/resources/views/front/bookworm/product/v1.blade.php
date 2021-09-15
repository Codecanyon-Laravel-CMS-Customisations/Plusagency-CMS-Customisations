{{-- @section('breadcrumb-title')
Product Details
@endsection --}}
@section('breadcrumb-links')
    <nav class="woocommerce-breadcrumb font-size-2">
        @php
            $links      = "<a href='".url('')."' class='h-primary'>Home</a>";
            $links     .= "<span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
                            <a href='".url('products')."' class='h-primary'>Products</a>";

            try
            {
                $product_category   = $product->category;
                $links             .= "<span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
                                    <a href='/products?search=&category_id=$product_category->id&type=new' class='h-primary'>$product_category->name</a>";
            }
            catch (\Exception $th) { /*throw $th;*/ }
            try
            {
                $product_category   = $product->child_category;
                $links             .= "<span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
                                    <a href='/products?search=&sub-category-id=$product_category->id&type=new' class='h-primary'>$product_category->name</a>";
            }
            catch (\Exception $th) { /*throw $th;*/ }
            $links .= "<span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>$product->title";
        @endphp
        {!! convertUtf8($links) !!}
    </nav>
@endsection








<div id="primary" class="content-area">
    <main id="main" class="site-main ">
        <div class="product">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 woocommerce-product-gallery woocommerce-product-gallery--with-images images">
                        <figure class="woocommerce-product-gallery__wrapper pt-8 mb-0">
                            <div class="js-slick-carousel u-slick"
                            data-pagi-classes="text-center u-slick__pagination my-4">
                            @foreach ($product->product_images as $image)
                                <div class="js-slide">
                                    <img src="{{trim($image->image)}}" alt="Image Description" class="mx-auto img-fluid" width="300">
                                </div>
                                @endforeach
                            </div>
                        </figure>
                    </div>
                    <div class="col-md-7 pl-0 summary entry-summary border-left">
                        <div class="space-top-2 px-4 px-xl-7 border-bottom pb-5">
                            <h1 class="product_title entry-title font-size-7 mb-3">{{convertUtf8($product->title)}}</h1>
                            <div class="font-size-2 mb-4">
                                @if ($bex->product_rating_system == 1)
                                <div class="rate">
                                    <div class="rating" style="width:{{$product->rating * 20}}%"></div>
                                </div>
                                @endif
                                {{-- <span class="ml-3">(3,714)</span>
                                <span class="ml-3 font-weight-medium">By (author)</span>
                                <span class="ml-2 text-gray-600">Anna Banks</span> --}}
                            </div>
                            @if(!$product->offline)
                                <p class="price font-size-22 font-weight-medium mb-3">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">
                                            {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}</span>{{ $pvariation ?$pvariation->current_price : $product->current_price }}
                                    </span>
                                </p>
                            @endif
                            {{-- <div class="mb-2 font-size-2">
                                <span class="font-weight-medium">Book Format:</span>
                                <span class="ml-2 text-gray-600">Choose an option</span>
                            </div>
                            <!-- Radio Checkbox Group -->
                            <div class="row mx-gutters-2 mb-4">
                                <div class="col-6 col-md-3 mb-3 mb-md-0">
                                    <div class="">
                                        <input type="radio" id="typeOfListingRadio1" name="typeOfListingRadio1" class="custom-control-input checkbox-outline__input">
                                        <label class="border-bottom d-block checkbox-outline__label py-3 px-1 mb-0" for="typeOfListingRadio1">
                                            <span class="d-block">Hardcover</span>
                                            <span class="">$9.59</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3 mb-md-0">
                                    <div class="">
                                        <input type="radio" id="typeOfListingRadio2" name="typeOfListingRadio1" class="custom-control-input checkbox-outline__input" checked>
                                        <label class="border-bottom d-block checkbox-outline__label py-3 px-1 mb-0" for="typeOfListingRadio2">
                                            <span class="d-block">Paperback</span>
                                            <span class="">$9.59</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="">
                                        <input type="radio" id="typeOfListingRadio3" name="typeOfListingRadio1" class="custom-control-input checkbox-outline__input">
                                        <label class="border-bottom d-block checkbox-outline__label py-3 px-1 mb-0" for="typeOfListingRadio3">
                                            <span class="d-block">Kindle</span>
                                            <span class="">$9.59</span>
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- End Radio Checkbox Group -->

                            <div class="woocommerce-product-details__short-description font-size-2 mb-5">
                                <div class="">{!! str_replace("\\n", "", convertUtf8(nl2br($product->summary))) !!}</div>
                            </div>

                            <form class="cart d-md-flex align-items-center" method="post" enctype="multipart/form-data">
                                @if($product->offline)
                                    <a href="{{ route('product.inquiries.form',$product->id) }}" data-href="{{ route('product.inquiries.form',$product->id) }}" class="btn btn-dark border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link" style="color: #fff">{{ $be->offline_resource_text }}</a>
                                @else
                                    <div class="quantity mb-4 mb-md-0 d-flex align-items-center">
                                        <!-- Quantity -->
                                        <div class="px-3 width-120">
                                            <div class="product-quantity  d-flex" id="quantity">
                                                <button type="button" id="sub" class="sub subclick">-</button>
                                                <input type="text" class="cart-amount" id="1" value="1" />
                                                <button type="button" id="add" class="add addclick">+</button>
                                            </div>
                                        </div>
                                        <!-- End Quantity -->
                                    </div>
                                    <a data-href="{{ $pvariation ? route('add.cart',$pvariation->id) : route('add.cart',$product->id) }}" class="btn btn-dark border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link" style="color: #fff">Add to cart</a>
                                @endif
                            </form>
                            @if( ! is_null($product->variations) )
                                @php
                                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                                     $url = "https://";
                                else
                                     $url = "http://";
                                $url.= $_SERVER['HTTP_HOST'];
                                $url.= strtok($_SERVER["REQUEST_URI"], '?');
                                @endphp
                                <div class="row mt-5">
                                    @foreach( explode( ',', $product->variations ) as $id)
                                        @php
                                        $variation = \App\Product::withoutGlobalScope('variation')->find($id);
                                        $selected = isset( $_GET['variation'] ) && $_GET['variation'] == $variation->id ? 'selected' : '';

                                        @endphp

                                        <div class="col-sm-12 col-md-3">
                                            <div class="d-flex flex-column">
                                                <p class="lead mt-3">{{ $variation->title }}</p>
                                                <a href="{{ $url }}?variation={{ $variation->id }}">
                                                    {{-- <img src="{{ asset('assets/' . json_decode($variation->variation_data)->thumbnail) }}" alt="" width="75" style="border-radius: 50%; @if(isset($_GET['variation']) && $_GET['variation'] == $variation->id) border: 1px solid black; @endif"> --}}
                                                    <img src="{{ json_decode($variation->variation_data)->thumbnail }}" alt="" width="75" style="border-radius: 50%; @if(isset($_GET['variation']) && $_GET['variation'] == $variation->id) border: 1px solid black; @endif">
                                                </a>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                @if(isset($_GET['variation']))
                                    <a href="{{ $url }}" class="d-inline-block mt-3">Clear</a>
                                @endif
                                {{-- <select name="" id="variation-selector" class="form-control mt-3" onchange="window.location.replace( location.protocol + `//` + location.host + location.pathname + document.querySelector('#variation-selector').value )">
                                    @if(isset($_GET['variation']))
                                    <option value="">{{ $product->title }}</option>
                                    @endif
                                    @foreach( explode( ',', $product->variations ) as $id)
                                        @php
                                        $variation = \App\Product::withoutGlobalScope('variation')->find($id);
                                        $selected = isset( $_GET['variation'] ) && $_GET['variation'] == $variation->id ? 'selected' : '';
                                        @endphp
                                        @if(!isset($_GET['variation']))
                                        <option value="" readonly>Choose {{ json_decode($variation->variation_data)->title }}</option>
                                        @endif
                                        <option {{ $selected }} value="?variation={{ $variation->id }}">{{ json_decode($variation->variation_data)->value }}</option>
                                    @endforeach
                                </select> --}}
                            @endif
                            <div class="product-social-icon social-link a2a_kit a2a_kit_size_32 mt-3">
                                <ul class="social-share d-flex justify-around">
                                    <li>
                                        <a class="facebook a2a_button_facebook" href="">
                                          <i class="fab fa-facebook-f"></i>
                                        </a>
                                      </li>
                                        <li>
                                            <a class="twitter a2a_button_twitter" href="">
                                              <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="linkedin a2a_button_linkedin" href="">
                                              <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="pinterest a2a_button_pinterest" href="">
                                              <i class="fab fa-pinterest"></i>
                                            </a>
                                        </li>
                                        <li>

                                        <a class="a2a_dd plus" href="https://www.addtoany.com/share">
                                            <i class="fas fa-plus"></i>
                                          </a>
                                        </li>
                                </ul>
                            </div>
                            <script async src="https://static.addtoany.com/menu/page.js"></script>
                        </div>

                        {{-- <div class="px-4 px-xl-7 py-5 d-flex align-items-center">
                            <ul class="list-unstyled nav">
                                <li class="mr-6 mb-4 mb-md-0">
                                    <a href="#" class="h-primary"><i class="flaticon-heart mr-2"></i> Add to Wishlist</a>
                                </li>
                                <li class="mr-6">
                                    <a href="#" class="h-primary"><i class="flaticon-share mr-2"></i> Share</a>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>


        </div>
    </main>
</div>
