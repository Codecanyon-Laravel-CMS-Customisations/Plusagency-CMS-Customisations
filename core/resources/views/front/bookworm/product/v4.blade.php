<div class="site-content" id="content">
    <div class="container">
        <div class="row  space-top-2">
            <div id="primary" class="content-area">
                <main id="main" class="site-main ">
                    <div class="product">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5 woocommerce-product-gallery woocommerce-product-gallery--with-images images">
                                    <figure class="woocommerce-product-gallery__wrapper mb-0">
                                        <div class="js-slick-carousel u-slick"
                                        data-pagi-classes="text-center u-slick__pagination my-4">
                                        @foreach ($product->product_images as $image)
                                            <div class="js-slide">
                                                <img src="{{trim($image->image)}}" alt="Image Description" class="mx-auto img-fluid">
                                            </div>
                                            @endforeach
                                        </div>
                                    </figure>
                                </div>
                                <div class="col-lg-7 pl-lg-0 summary entry-summary">
                                    <div class="px-lg-4 px-xl-6">
                                        <h1 class="product_title entry-title font-size-7 mb-3">{{convertUtf8($product->title)}}</h1>
                                        @if ($bex->product_rating_system == 1)
                                        <div class="rate">
                                            <div class="rating" style="width:{{$product->rating * 20}}%"></div>
                                        </div>
                                        @endif

                                        <div class="woocommerce-product-details__short-description font-size-2 mb-4 mt-5">
                                            <div class="">{!! str_replace("\\n", "", convertUtf8(nl2br($product->summary))) !!}</div>
                                        </div>

                                        <p class="price font-size-22 font-weight-medium mb-4">
                                            <span class="woocommerce-Price-amount amount">
                                                <span class="woocommerce-Price-currencySymbol">{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}</span>{{ $pvariation ?$pvariation->current_price : $product->current_price }}
                                            </span>
                                        </p>

                                        <div class="mb-4">
                                        </div>

                                        <div class="px-3 d-flex mb-5 align-items-center">
                                            <div class="product-quantity d-flex mr-3" id="quantity">
                                                <button type="button" id="sub" class="sub subclick">-</button>
                                                <input type="text" class="cart-amount" id="1" value="1" />
                                                <button type="button" id="add" class="add addclick">+</button>
                                            </div>
                                            <a data-href="{{ $pvariation ? route('add.cart',$pvariation->id) : route('add.cart',$product->id) }}" class="btn btn-dark border-0 rounded-0 p-3 btn-block ml-md-4 single_add_to_cart_button button alt cart-btn cart-link" style="color: #fff;">Add to cart</a>
                                        </div>

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
                                                                <img src="{{ asset(json_decode($variation->variation_data)->thumbnail }}" alt="" width="75" style="border-radius: 50%; @if(isset($_GET['variation']) && $_GET['variation'] == $variation->id) border: 1px solid black; @endif">
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


                                    </div>
                                    <div class="px-lg-4 px-xl-7 py-5 d-flex align-items-center">
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
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </div>
</div>
