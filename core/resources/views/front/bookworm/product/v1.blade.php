<!-- $selected = isset($_GET['variation']) && $_GET['variation'] == $variation->id ? 'selected' : ''; -->
@php
$variation = null;

$selected_variation = null;
if(isset($_GET['variation'])) {
    $selected_variation = \App\Product::withoutGlobalScope('variation')->find($_GET['variation']);
    $variation = $selected_variation;
}

$no_image_url = 'https://as1.ftcdn.net/v2/jpg/04/34/72/82/1000_F_434728286_OWQQvAFoXZLdGHlObozsolNeuSxhpr84.jpg';
@endphp

<style>
    .cart-btn:hover {
        background-color: #D55534 !important;
    }
</style>


@section('breadcrumb-links')
<nav class="woocommerce-breadcrumb font-size-2">
    @php

    // dump($product);
    // dump($product->category);
    $links = "<a href='" . url('') . "' class='h-primary'>Home</a>";
    $links .=
    "<span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
    <a href='" .
                url('products') . "' class='h-primary'>Products</a>" ; try { $product_category=$product->category;
        $links .= "<span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
        <a href='/products?search=&category_id=$product_category->id&type=new' class='h-primary'>$product_category->name</a>";
        } catch (\Exception $th) {
        /*throw $th;*/
        }
        try {
        $product_category = $product->subcategory;
        $links .= "<span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
        <a href='/products?search=&sc-id=$product_category->id&type=new' class='h-primary'>$product_category->name </a>";
        } catch (\Exception $th) {
        /*throw $th;*/
        }
        $links .= "<span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>$product->title";
        @endphp

        {{-- @dd($links) --}}
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
                            <div class="js-slick-carousel---naaah u-slick---naaah" data-pagi-classes="text-center u-slick__pagination my-4">
                                <a id="Zoom-1" class="MagicZoom" title="{{ config('app.name') }} | {{ $product->title }}" href="{{ trim($product->feature_image) }}" data-zoom-image-2x="{{ trim($product->feature_image) }}" data-image-2x="{{ trim($product->feature_image) }}">
                                    @php
                                        if( isset($variation) ) {
                                            if( isset(json_decode($variation->variation_data)->thumbnail) ) {
                                                $thumbnail = json_decode($variation->variation_data)->thumbnail;
                                            } else {
                                                $thumbnail = $no_image_url;
                                            }
                                            
                                        } else {
                                            $thumbnail = trim($product->feature_image);
                                        }

                                    @endphp

                                    <img src="{{ $thumbnail }}" srcset="{{ $thumbnail }}" alt="" />
                                </a>
                                <div class="selectors">
                                    @foreach ($product->product_images as $image)
                                    <a data-zoom-id="Zoom-1" href="{{ trim($image->image) }}" data-image="{{ trim($image->image) }}" data-zoom-image-2x="{{ trim($image->image) }}" data-image-2x="{{ trim($image->image) }}">
                                        <img srcset="{{ trim($image->image) }}" src="{{ trim($image->image) }}" />
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </figure>
                    </div>
                    <div class="col-md-7 pl-0 summary entry-summary border-left">

                        {{-- @dd('here') --}}
                        <div class="space-top-2 px-4 px-xl-7 border-bottom pb-5">
                            <h1 class="product_title entry-title font-size-7 mb-3">{{ convertUtf8($product->title) }}
                            </h1>
                            <div class="row font-size-2">
                                @if ($bex->product_rating_system == 1)
                                <div class="rate" style="margin-left:12px">
                                    <div class="rating" style="width:{{ $product->rating * 20 }}%"></div>
                                </div>
                                @endif

                                
                                @php

                                $author_name = null;
                                if (!is_null($product->attributes)) {
                                    foreach(json_decode($product->attributes) as $attribute) {
                                        if (str_contains(strtolower( $attribute->name ), 'author')) {
                                            $author_name = $attribute->value;
                                        } 
                                    }
                                }
                                
                                @endphp
                                <div class="font-size-2 ml-3 mb-2" style="margin-top:-3px">
                                    <span class="mb-2"> <b> By (author): </b> {{ $author_name }} </span>
                                </div>
                            </div>


                            @if (!$product->digital && !$product->offline)
                            <p class="price font-size-22 font-weight-medium mb-3">
                                Price:
                                <span class="woocommerce-Price-amount amount"> 
                                    <span class="woocommerce-Price-currencySymbol">
                                        {{-- 
                                            {{ strtolower($bex->base_currency_symbol_position) == 'left' ? $bex->base_currency_symbol : '' }} 
                                        --}}

                                        {{ trim($product->symbol) }}
                                    </span>
                                    {{-- 
                                        {{ $pvariation ? angel_auto_convert_currency($pvariation->current_price, $geo_data_base_currency, $geo_data_user_currency) : angel_auto_convert_currency($product->current_price, $geo_data_base_currency, $geo_data_user_currency) }} 
                                    --}}
                                    
                                    <span class="product-price {{ ($variation)? 'd-none':''}}">
                                        {{ number_format($product->price) }}
                                    </span>

                                    <span class="variation-price {{ (!$variation)? 'd-none':''}}">
                                        {{ ($variation)? number_format(!empty($variation->price) ? $variation->price : '0.00', 0) : number_format(!empty($product->price) ? $product->price : '0.00', 0) }}
                                    </span>
                                    
                                    <span class="woocommerce-Price-currencySymbol">
                                        {{-- 
                                            {{ strtolower($bex->base_currency_symbol_position) == 'right' ? $bex->base_currency_symbol : '' }} 
                                        --}}
                                    </span>
                                </span>
                            </p>

                            <p class="price font-size-22 font-weight-medium mb-3">
                                <span class="woocommerce-Price-amount amount">

                                    @php
                                    $variation_prices = [];

                                    if($product->variations) {
                                        foreach (explode(',', $product->variations) as $id) {

                                            $variation = \App\Product::withoutGlobalScope('variation')->find($id);
                                            
                                            $variation_prices[]=$variation->price;
                                            
                                        }
                                    }

                                    @endphp

                                    @if($variation_prices && count($variation_prices)>1)
                                    <span class="woocommerce-Price-currencySymbol">
                                        {{-- 
                                            {{ strtolower($bex->base_currency_symbol_position) == 'left' ? $bex->base_currency_symbol : '' }} 
                                        --}}

                                        {{ trim($product->symbol) }} {{number_format(min($variation_prices), 0)}} - {{ trim($product->symbol) }} {{number_format(max($variation_prices), 0)}}
                                    </span>
                                    @endif
                                </span>
                            </p>
                            @endif

                            {{-- Added Variation Here --}}

                            @if (!is_null($product->variations))
                            <div class="variation">
                                @php
                                    if( isset($variation) ) {
                                        if( isset(json_decode($variation->variation_data)->title) ) {
                                            $title = json_decode($variation->variation_data)->title;
                                        } else {
                                            $title = 'No title for selected book format';
                                        }
                                        
                                    } else {
                                        $title = 'Choose an option';
                                    }
                                @endphp

                                <span> Book Format:</span> <span style="color: #00000070;" class="sel-book-format">{{$title}} </span>
                            </div>
                            @php
                            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                            $url = 'https://';
                            } else {
                            $url = 'http://';
                            }
                            $url .= $_SERVER['HTTP_HOST'];
                            $url .= strtok($_SERVER['REQUEST_URI'], '?');
                            @endphp
                            <div class="row mt-2">
                                @foreach (explode(',', $product->variations) as $id)
                                @php
                                $variation = \App\Product::withoutGlobalScope('variation')->find($id);
                                $selected = isset($_GET['variation']) && $_GET['variation'] == $variation->id ? 'selected' : '';

                                @endphp

                                <div class="col-sm-12 col-md-3">
                                    <div class="d-flex flex-column">
                                        <p class="lead">{{ $variation->title }}</p>


                                        <a data-zoom-id="Zoom-1" href="{{ trim((json_decode($variation->variation_data)->thumbnail)?json_decode($variation->variation_data)->thumbnail:$no_image_url) }}" data-image="{{ trim((json_decode($variation->variation_data)->thumbnail)?json_decode($variation->variation_data)->thumbnail:$no_image_url) }}" data-zoom-image-2x="{{ trim((json_decode($variation->variation_data)->thumbnail)?json_decode($variation->variation_data)->thumbnail:$no_image_url) }}" data-image-2x="{{ trim((json_decode($variation->variation_data)->thumbnail)?json_decode($variation->variation_data)->thumbnail:$no_image_url) }}" href="{{ $url }}?variation={{ $variation->id }}" onclick="addVariation(event, '{{ $variation->id }}'); changeSelectedBookFormatTitle(event, '{{ $variation->title }}'); showVariantThumbnail(event, '{{ (json_decode($variation->variation_data)->thumbnail)?json_decode($variation->variation_data)->thumbnail:$no_image_url }}')" class="sel-variation mz-thumb">
                                            {{-- <img src="{{ asset('assets/' . json_decode($variation->variation_data)->thumbnail) }}" alt="" width="75" style="border-radius: 50%; @if (isset($_GET['variation']) && $_GET['variation'] == $variation->id) border: 1px solid black; @endif"> --}}



                                            <img srcset="{{ trim((json_decode($variation->variation_data)->thumbnail)?json_decode($variation->variation_data)->thumbnail:$no_image_url) }}" src="{{ (json_decode($variation->variation_data)->thumbnail)?json_decode($variation->variation_data)->thumbnail:$no_image_url }}" alt="" width="75" style="border-radius: 50%; @if (isset($_GET['variation']) && $_GET['variation'] == $variation->id) border: 1px solid black; @endif" >



                                        </a>

                                    </div>

                                    <p> <span>{{ ship_to_india() ? "₹" : "$" }}</span> <span class="variation-price-{{$variation->id}}">{{ round($variation->price) }}</span> </p>
                                </div>
                                @endforeach

                            </div>

                            {{-- 
                            @if (isset($_GET['variation']))
                            <a href="{{ $url }}" class="d-inline-block mt-3">Clear</a>
                            @endif
                            --}}
                            <a href="{{ $url }}" onclick="clearVariation(event, '{{ $product->id }}')" class="btn-clear {{(isset($_GET['variation']))?'d-inline-block':'d-none'}} mt-3">Clear</a>

                            {{-- <select name="" id="variation-selector" class="form-control mt-3" onchange="window.location.replace( location.protocol + `//` + location.host + location.pathname + document.querySelector('#variation-selector').value )">
                                    @if (isset($_GET['variation']))
                                    <option value="">{{ $product->title }}</option>
                            @endif
                            @foreach (explode(',', $product->variations) as $id)
                            @php
                            $variation = \App\Product::withoutGlobalScope('variation')->find($id);
                            $selected = isset( $_GET['variation'] ) && $_GET['variation'] == $variation->id ? 'selected' : '';
                            @endphp
                            @if (!isset($_GET['variation']))
                            <option value="" readonly>Choose {{ json_decode($variation->variation_data)->title }}</option>
                            @endif
                            <option {{ $selected }} value="?variation={{ $variation->id }}">{{ json_decode($variation->variation_data)->value }}</option>
                            @endforeach
                            </select> --}}
                            @endif

                            {{-- Added Variation Here --}}


                            
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
                                <div class="">{!! str_replace("\\n", '', convertUtf8(nl2br($product->summary))) !!}</div>
                            </div>

                            @if ($product->digital || $product->offline)
                            @includeIf('front.bookworm.chemistry.molecules.offline_modal')
                            @else
                            <form class="cart d-md-flex align-items-center" method="post" enctype="multipart/form-data">
                                <div class="quantity mb-4 mb-md-0 d-flex align-items-center">
                                    <!-- Quantity -->
                                    <div class="width-120">
                                        <div class="product-quantity  d-flex" id="quantity">
                                            <button type="button" id="sub" class="sub subclick">-</button>
                                            <input type="text" class="cart-amount" id="1" value="1" />
                                            <button type="button" id="add" class="add addclick">+</button>
                                        </div>
                                    </div>
                                    <!-- End Quantity -->
                                </div>
                                <a id="single_add_to_cart_button" data-href="{{ $selected_variation ? route('add.cart', $selected_variation->id) : route('add.cart', $product->id) }}" class="btn btn-dark border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link my-1" style="color: #fff">Add to cart</a>
                                @if ($product->show_inquiry_form)
                                @php
                                $header_v2_button_text = 'GIVE US FEEDBACK';
                                try {
                                $lang = App\Language::where('code', request()->has('language', 'en'))->first();
                                $settings = $lang->basic_extended;

                                $header_v2_button_text = $settings->header_v2_button_text;
                                } catch (\Exception $e) {
                                }
                                @endphp
                                <a href="javascript:;" data-href="javascript:;" class="btn btn-dark border-0 rounded-0 p-3 min-width-250min-width-250-----naaah ml-md-4 single_add_to_cart_button button alt cart-btn cart-link my-1" style="color: #fff" data-toggle="modal" data-target="#headerProductInquiryModal">{{ $header_v2_button_text }}</a>
                                @endif
                            </form>
                            @endif
                            
                            <div class="px-4 px-xl-7 py-5 d-flex align-items-center">
                                <ul class="list-unstyled nav">
                                    <li class="mr-6 mb-4 mb-md-0">
                                        <a href="{{ route("wishlist.item.add", $product->id) }}" class="h-primary"><i class="flaticon-heart mr-2"></i> 
                                        @php
                                        
                                        if(session()->get('wishlist') ){
                                            // dd('have this ');
                                            echo "Added to Wishlist";
                                        }
                                        else{
                                            echo "Add to Wishlist";

                                            // dd('not in wish list');
                                        }
                                        // echo is_array( session()->get('wishlist') ) ?  'Added to Wishlist' : 'Add to Wishlist';
                                        @endphp
                                    </a>
                                    </li>
                                    <li class="mr-6">
                                        <a href="whatsapp://send?text={{$bs->website_title. ' - Product - '.  $product->title.' '. route('front.product.details', $product->slug) }}" data-action="share/whatsapp/share" class="h-primary"><svg style="width:18px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
                                            </svg> Whatsapp</a>

                                        <span class="btooltip">
                                            <span class="ml-3 h-primary" style="color:black !important; " onclick="copyToClipBoard('{{route('front.product.details', $product->slug) }}')" onmouseout="outFunc()">
                                                <span class="tooltiptext" id="myTooltip">  Click to copy</span>
                                                {{-- <svg style="width:16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path d="M384 96L384 0h-112c-26.51 0-48 21.49-48 48v288c0 26.51 21.49 48 48 48H464c26.51 0 48-21.49 48-48V128h-95.1C398.4 128 384 113.6 384 96zM416 0v96h96L416 0zM192 352V128h-144c-26.51 0-48 21.49-48 48v288c0 26.51 21.49 48 48 48h192c26.51 0 48-21.49 48-48L288 416h-32C220.7 416 192 387.3 192 352z" />
                                                </svg> --}} <i class="fa fa-share-alt" aria-hidden="true"></i>

                                            </span>
                                        </span>
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
<style>
    .btooltip {
        position: relative;
        display: inline-block;
    }

    .btooltip .tooltiptext {
        visibility: hidden;
        width: 180px;
        color: white;
        background-color: #555;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 150%;
        left: 50%;
        margin-left: -75px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .btooltip .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
    }

    .btooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>
<script>
    function copyToClipBoard(link) {
        navigator.clipboard.writeText(link);

        var tooltip = document.getElementById("myTooltip");
        tooltip.innerHTML = "Copied: " + link;
    }

    function outFunc() {
        var tooltip = document.getElementById("myTooltip");
        tooltip.innerHTML = "Click to copy";
    }
</script>

<script>
    function addVariation(event, id) {
        event.preventDefault();
        
        var currentURL = window.location.protocol + "//" + window.location.host + window.location.pathname + '?variation='+id+'';
        window.history.pushState({ path: currentURL }, '', currentURL);

        // removing styles from all img tags first
        $('img').each(function () {
            $(this).removeAttr('style');
        });

        $('.sel-variation').each(function () {
            $(this).removeAttr('style');
        });

        event.target.style.borderRadius  = "50%";
        event.target.style.border = "1px solid black";

        var elem = document.getElementById("single_add_to_cart_button");

        if (elem) {
            var cart_button_url = elem.getAttribute("data-href");
            var new_url = cart_button_url.substring(0, cart_button_url.lastIndexOf("/") + 1) + id;

            elem.setAttribute("data-href", new_url);
        }
        

        var variation_price = $('.variation-price-'+id).text();

        $('.product-price').addClass('d-none');
        $('.variation-price').text(variation_price);
        $('.variation-price').removeClass('d-none');
        
        $('.btn-clear').removeClass('d-none');
    }

    function showVariantThumbnail(event, thumbnail) {
        event.preventDefault();

        let mainImageElement = document.querySelector('.mz-figure > img');

        mainImageElement.setAttribute("srcset", thumbnail);

    }

    function changeSelectedBookFormatTitle(event, title) {
        event.preventDefault();

        console.log("changeSelectedBookFormatTitle");
        let book_format = 'No title for selected book format';
        if (title) {
            book_format = title;
        }

        document.getElementsByClassName('sel-book-format')[0].innerHTML = book_format;
    }


    function clearVariation(event, defaultProductId) {
        event.preventDefault();
        
        $('.variation-price').addClass('d-none');
        $('.product-price').removeClass('d-none');

        // removing styles from all img tags first
        $('img').each(function () {
            $(this).removeAttr('style');
        });

        // setting default url to cart
        var elem = document.getElementById("single_add_to_cart_button");
        var cart_button_url = elem.getAttribute("data-href");
        var new_url = cart_button_url.substring(0, cart_button_url.lastIndexOf("/") + 1) + defaultProductId;
        
        elem.setAttribute("data-href", new_url);

        var currentURL = window.location.protocol + "//" + window.location.host + window.location.pathname;
        window.history.pushState({ path: currentURL }, '', currentURL);
    }


</script>