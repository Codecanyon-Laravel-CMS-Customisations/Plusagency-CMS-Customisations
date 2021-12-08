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

$bex_user_currency = App\Models\Currency::find($geo_data_user_currency);
$bex->base_currency_symbol = $bex_user_currency->symbol;
$bex->base_currency_symbol_position = strtolower($bex_user_currency->symbol_position) == 'l' ? 'left' : 'right';
$bex->base_currency_text = $bex_user_currency->name;
$bex->base_currency_text_position = strtolower($bex_user_currency->text_position) == 'l' ? 'left' : 'right';

// echo json_encode($bex);return;
// echo json_encode(session()->all());return;

@endphp
<div id="primary" class="content-area">
    <main id="main" class="site-main ">
        <div class="product">
            <div class="container mb-6">
                <div class="row">
                    <div
                        class="col-md-4 col-lg-3 woocommerce-product-gallery woocommerce-product-gallery--with-images images">
                        <figure class="woocommerce-product-gallery__wrapper pt-8 mb-0">
                            <div class="zoom-lens-control-wrapper pb-2">
                                <button type="button"
                                    class="btn btn-sm btn-dark disabled py-1 px-2 mag0">
                                    <strong>zoom </strong>
                                    <small>
                                        <strong><i class="fa fa-plus-circle" aria-hidden="true"></i></strong>
                                    </small>
                                </button>
                                    <button type="button"
                                        class="d-none animated animated fadeInLeft btn btn-sm btn-dark py-1 px-2 mag1"><small><strong>x1</strong></small></button>
                                <button type="button"
                                    class="d-none animated animated fadeInLeft delay-1s btn btn-sm btn-dark py-1 px-2 mag2"><small><strong>x2</strong></small></button>
                                {{-- <button type="button"
                                    class="d-none animated animated fadeInLeft delay-2s btn btn-sm btn-dark py-1 px-2 mag3"><small><strong>x3</strong></small></button>
                                <button type="button"
                                    class="d-none animated animated fadeInLeft delay-3s btn btn-sm btn-dark py-1 px-2 mag4"><small><strong>x4</strong></small></button>
                                <button type="button"
                                    class="d-none animated animated fadeInLeft delay-4s btn btn-sm btn-dark py-1 px-2 mag5"><small><strong>x5</strong></small></button> --}}
                            </div>
                            <div class="js-slick-carousel u-slick"
                                data-pagi-classes="text-center u-slick__pagination my-4">
                                <div class="js-slide">
                                    <img data-lazy="{{ trim($product->feature_image) }}" alt=""
                                        class="mx-auto img-fluid img-blowup">
                                </div>
                                @foreach ($product->product_images as $image)
                                    <div class="js-slide">
                                        <img data-lazy="{{ trim($image->image) }}" alt=""
                                            class="mx-auto img-fluid img-blowup">
                                    </div>
                                @endforeach
                            </div>
                            <div class="slider slider-nav">
                                <div class="js-slide-----not">
                                    <img data-lazy="{{ trim($product->feature_image) }}" alt=""
                                        class="mx-auto img-fluid">
                                </div>
                                @foreach ($product->product_images as $image)
                                    <div class="js-slide-----not">
                                        <img data-lazy="{{ trim($image->image) }}" alt=""
                                            class="mx-auto img-fluid">
                                    </div>
                                @endforeach
                            </div>
                        </figure>
                    </div>
                    <div class="col-md-8 col-lg-5 pl-0 summary entry-summary">
                        <div class="space-top-2 pl-4 pl-wd-6 px-wd-7 pb-5">
                            <h1 class="product_title entry-title font-size-7 mb-3">{{ convertUtf8($product->title) }}
                            </h1>
                            @if ($bex->product_rating_system == 1)
                                <div class="rate">
                                    <div class="rating" style="width:{{ $product->rating * 20 }}%"></div>
                                </div>
                            @endif
                            <div class="woocommerce-product-details__short-description font-size-2 mb-5 mt-5">
                                <div class="">{!! str_replace("\\n", '', convertUtf8(nl2br($product->summary))) !!}</div>
                            </div>

                            <ul class="list-unstyled my-0 list-features d-xl-flex align-items-center">
                                <li class="list-feature mb-6 mb-xl-0 mr-xl-4 mr-wd-6">
                                    <div class="media">
                                        <div class="feature__icon font-size-46 text-primary text-lh-xs">
                                            <i class="glyph-icon flaticon-delivery"></i>
                                        </div>
                                        <div class="media-body ml-4">
                                            <h6 class="feature__title">Free Delivery</h6>
                                            <p class="feature__subtitle m-0">Orders over $100</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-feature mb-6 mb-xl-0">
                                    <div class="media">
                                        <div class="feature__icon font-size-46 text-primary text-lh-xs">
                                            <i class="glyph-icon flaticon-credit"></i>
                                        </div>
                                        <div class="media-body ml-4">
                                            <h6 class="feature__title">Secure Payment</h6>
                                            <p class="feature__subtitle m-0">100% Secure Payment</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="border mt-md-8">
                            @if (!$product->digital && !$product->offline)
                                <div class="bg-white-100 py-4 px-5">
                                    <p class="price font-size-22 font-weight-medium mb-0">
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol">{{ strtolower($bex->base_currency_symbol_position) == 'left' ? $bex->base_currency_symbol : '' }}</span>
                                            {{ $pvariation ? angel_auto_convert_currency($pvariation->current_price, $geo_data_base_currency, $geo_data_user_currency) : angel_auto_convert_currency($product->current_price, $geo_data_base_currency, $geo_data_user_currency) }}
                                            <span class="woocommerce-Price-currencySymbol">{{ strtolower($bex->base_currency_symbol_position) == 'right' ? $bex->base_currency_symbol : '' }}</span>
                                        </span>
                                    </p>
                                </div>
                            @endif
                            <div class="py-4 px-5">
                                <!-- End Select -->

                                @if ($product->digital || $product->offline)
                                    @includeIf('front.bookworm.chemistry.molecules.offline_modal')
                                @else
                                    <div class="px-3 d-flex justify-content-center">
                                        <div class="product-quantity  d-flex" id="quantity">
                                            <button type="button" id="sub" class="sub subclick">-</button>
                                            <input type="text" class="cart-amount" id="1" value="1" />
                                            <button type="button" id="add" class="add addclick">+</button>
                                        </div>
                                    </div>
                                    <a data-href="{{ $pvariation ? route('add.cart', $pvariation->id) : route('add.cart', $product->id) }}"
                                        class="btn btn-block mb-2 btn-dark border-0 rounded-0 p-3 single_add_to_cart_button button alt mt-3 cart-btn cart-link"
                                        style="color: #fff;">Add to cart</a>
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
                                        <a href="javascript:;" data-href="javascript:;"
                                            class="btn btn-block mb-2 btn-dark border-0 rounded-0 p-3 min-width-250min-width-250-----naaah single_add_to_cart_button button alt cart-btn cart-link"
                                            style="color: #fff" data-toggle="modal"
                                            data-target="#headerProductInquiryModal">{{ $header_v2_button_text }}</a>
                                    @endif

                                @endif

                                @if (!is_null($product->variations))
                                    @php
                                        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                                            $url = 'https://';
                                        } else {
                                            $url = 'http://';
                                        }
                                        $url .= $_SERVER['HTTP_HOST'];
                                        $url .= strtok($_SERVER['REQUEST_URI'], '?');
                                    @endphp
                                    <div class="row mt-5">
                                        @foreach (explode(',', $product->variations) as $id)
                                            @php
                                                $variation = \App\Product::withoutGlobalScope('variation')->find($id);
                                                $selected = isset($_GET['variation']) && $_GET['variation'] == $variation->id ? 'selected' : '';

                                            @endphp

                                            <div class="col-sm-12 col-md-3">
                                                <div class="d-flex flex-column">
                                                    <p class="lead mt-3">{{ $variation->title }}</p>
                                                    <a href="{{ $url }}?variation={{ $variation->id }}">
                                                        {{-- <img src="{{ asset('assets/' . json_decode($variation->variation_data)->thumbnail) }}" alt="" width="75" style="border-radius: 50%; @if (isset($_GET['variation']) && $_GET['variation'] == $variation->id) border: 1px solid black; @endif"> --}}
                                                        <img src="{{ asset(json_decode($variation->variation_data)->thumbnail) }}"
                                                            alt="" width="75"
                                                            style="border-radius: 50%; @if (isset($_GET['variation']) && $_GET['variation'] == $variation->id) border: 1px solid black; @endif">
                                                    </a>

                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                    @if (isset($_GET['variation']))
                                        <a href="{{ $url }}" class="d-inline-block mt-3">Clear</a>
                                    @endif
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
        </div>
    </main>
</div>
