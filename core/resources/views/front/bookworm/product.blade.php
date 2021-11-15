@extends("front.$version.layout")



@section('pagename')
    - {{ __('Product') }} - {{ convertUtf8($product->title) }}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/front/css/slick.css') }}">
    @if ($product->offline)
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endif
@endsection

@section('meta-keywords', "$product->meta_keywords")
@section('meta-description', "$product->meta_description")

@php
$reviews = App\ProductReview::where('product_id', $product->id)->get();
$avarage_rating = App\ProductReview::where('product_id', $product->id)->avg('review');
$avarage_rating = round($avarage_rating, 2);

if (isset($_GET['variation'])) {
    $pvariation = \App\Product::withoutGlobalScope('variation')->find($_GET['variation']);
} else {
    $pvariation = false;
}

@endphp

@section('breadcrumb-title', $be->product_details_title)
@section('breadcrumb-subtitle', strlen($product->title) > 40 ? mb_substr($product->title, 0, 40, 'utf-8') . '...' :
    $product->title)
@section('breadcrumb-link', strlen($product->title) > 40 ? mb_substr($product->title, 0, 40, 'utf-8') . '...' :
    $product->title)

@section('content')


    <!--====== PRODUCT DETAILS PART START ======-->

    @include('front.bookworm.product.'. $be->bookworm_shop_single_version)

    <!--====== PRODUCT DETAILS PART ENDS ======-->

    <!--====== SHOP TAB PART START ======-->

    <div class="shop-tab-area" @if ($related_product->count() == 0) style="padding-bottom:120px;" @endif>
        <div class="container">
            <div class="row">
                <div class="col-lg-11">
                    <div class="shop-tab-area">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Description') }}</a>
                            </li>
                            @if ($bex->product_rating_system == 1 && $bex->catalog_mode == 0)
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact"
                                        role="tab" aria-controls="pills-contact" aria-selected="false">{{ __('Reviews') }}
                                        ({{ count($reviews) }})</a>
                                </li>
                            @endif
                            @if (!$pvariation)
                                @if (!is_null($product->attributes) || !is_null($product->custom_fields))
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-attributes-tab" data-toggle="pill"
                                            href="#pills-attributes" role="tab" aria-controls="pills-attributes"
                                            aria-selected="false">Details</a>
                                    </li>
                                @endif
                            @else
                                @if (!is_null($pvariation->attributes) || !is_null($pvariation->custom_fields))
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-attributes-tab" data-toggle="pill"
                                            href="#pills-attributes" role="tab" aria-controls="pills-attributes"
                                            aria-selected="false">Details</a>
                                    </li>
                                @endif
                            @endif
                            @if (!is_null($be->product_tabs))
                                @foreach (json_decode($be->product_tabs) as $tab)
                                    @if ($tab->global == '0')
                                        @if ($tab->product_id != $product->id) @continue @endif
                                    @endif
                                    @php
                                        $tab_link = '#pills-' . Str::slug($tab->title);
                                    @endphp
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-{{ Str::slug($tab->title) }}-tab"
                                            @if ($tab->type == 'content') data-toggle="pill" @endif href="{{ $tab->type == 'content' ? $tab_link : $tab->link }}" role="tab" aria-controls="pills-{{ Str::slug($tab->title) }}" aria-selected="false" @if ($tab->content == 'link') target="_blank" @endif>{{ $tab->title }}</a>
                                    </li>
                                @endforeach
                            @endif
                            @if (!is_null($product->tabs))
                                @php
                                    try {
                                        $tabs = json_decode($product->tabs);
                                        foreach ($tabs as $tab) {
                                            $tab_title = $tab->title;
                                            echo "<li class='nav-item'>";
                                            echo "<a class='nav-link' id='pills-" . Str::slug($tab_title) . "-tab' data-toggle='pill' href='#pills-" . \Illuminate\Support\Str::slug($tab_title) . "' role='tab' aria-controls='pills-" . \Illuminate\Support\Str::slug($tab_title) . "' aria-selected='false'>" . $tab_title . '</a>';
                                            echo '</li>';
                                        }
                                    } catch (\Exception $exception) {
                                    }
                                @endphp
                            @endif
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                {{-- {!! replaceBaseUrl(convertUtf8($product->description)) !!} --}}
                                {{-- {!! replaceBaseUrl(convertUtf8(str_replace('\n', '', nl2br($product->description, false)))) !!} --}}
                                {!! str_replace('\n', '', nl2br(replaceBaseUrl(convertUtf8($product->description)), false)) !!}

                            </div>
                            @if (!is_null($be->product_tabs))
                                @foreach (json_decode($be->product_tabs) as $tab)
                                    @if ($tab->content == 'link') @continue @endif
                                    @if ($tab->global == '0')
                                        @if ($tab->product_id != $product->id) @continue @endif
                                    @endif
                                    <div class="tab-pane fade show" id="pills-{{ Str::slug($tab->title) }}"
                                        role="tabpanel" aria-labelledby="pills-home-tab">
                                        {!! replaceBaseUrl(convertUtf8($tab->content)) !!}

                                    </div>
                                @endforeach
                            @endif

                            <div class="tab-pane fade show" id="pills-attributes" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                @if (!is_null($be->product_attributes))
                                    <ul class="list-group">
                                        @if (!is_null($be->product_attributes))
                                            @foreach (json_decode($be->product_attributes) as $attribute)
                                                <li class="list-group-item"><strong>{{ $attribute->name }}</strong> -
                                                    {{ $attribute->value }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                @endif


                                <ul class="list-group">
                                    @if (!is_null($product->attributes))
                                        @foreach (json_decode($product->attributes) as $attribute)
                                            <li class="list-group-item"><strong>{{ $attribute->name }}</strong> -
                                                {{ $attribute->value }}</li>
                                        @endforeach
                                    @endif

                                    @if (!is_null($product->custom_fields))
                                        @foreach (json_decode($product->custom_fields) as $field)
                                            <li class="list-group-item"><strong>{{ $field->name }}</strong> -
                                                {{ $field->value }}</li>
                                        @endforeach
                                    @endif
                                    @if ($pvariation)
                                        @if (!is_null($pvariation->attributes))
                                            @foreach (json_decode($pvariation->attributes) as $attribute)
                                                <li class="list-group-item"><strong>{{ $attribute->name }}</strong> -
                                                    {{ $attribute->value }}</li>
                                            @endforeach
                                        @endif

                                        @if (!is_null($pvariation->custom_fields))
                                            @foreach (json_decode($pvariation->custom_fields) as $field)
                                                <li class="list-group-item"><strong>{{ $field->name }}</strong> -
                                                    {{ $field->value }}</li>
                                            @endforeach
                                        @endif
                                    @endif
                                </ul>
                            </div>
                            @if ($bex->product_rating_system == 1 && $bex->catalog_mode == 0)
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <div class="shop-review-area">
                                        <div class="shop-review-title">
                                            <h3 class="title">{{ convertUtf8($product->title) }}</h3>
                                        </div>
                                        @if (count($reviews) > 0)
                                            @foreach ($reviews as $review)
                                                <div class="shop-review-user">
                                                    @if (strpos($review->user->photo, 'facebook') !== false || strpos($review->user->photo, 'google'))
                                                        <img class="lazy"
                                                            data-src="{{ $review->user->photo ? $review->user->photo : asset('assets/front/img/user/profile.jpg') }}"
                                                            alt="user image" width="60">
                                                    @else
                                                        <img class="lazy"
                                                            data-src="{{ $review->user->photo ? asset('assets/front/img/user/' . $review->user->photo) : '' }}"
                                                            alt="user image" width="60">
                                                    @endif
                                                    <ul>
                                                        <div class="rate">
                                                            <div class="rating"
                                                                style="width:{{ $review->review * 20 }}%"></div>
                                                        </div>
                                                    </ul>
                                                    <span><span>{{ convertUtf8($review->user->username) }}</span> –
                                                        {{ $review->created_at->format('d-m-Y') }}</span>
                                                    <p>{{ convertUtf8($review->comment) }}</p>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="bg-light mt-4 text-center py-5">
                                                {{ __('NOT RATED YET') }}
                                            </div>
                                        @endif
                                        @if (Auth::user())
                                            @if (App\OrderItem::where('user_id', Auth::user()->id)->where('product_id', $product->id)->exists())
                                                <div class="shop-review-form">
                                                    @error('error')
                                                        <p class="text-danger my-2">{{ Session::get('error') }}</p>
                                                    @enderror
                                                    <form class="mt-5"
                                                        action="{{ route('product.review.submit') }}" method="POST">@csrf
                                                        <div class="input-box">
                                                            <span>{{ __('Comment') }}</span>
                                                            <textarea name="comment" cols="30" rows="10"
                                                                placeholder="{{ __('Comment') }}"></textarea>
                                                        </div>
                                                        <input type="hidden" value="" id="reviewValue" name="review">
                                                        <input type="hidden" value="{{ $product->id }}"
                                                            name="product_id">
                                                        <div class="input-box">
                                                            <span>{{ __('Rating') }} *</span>
                                                            <div class="review-content ">
                                                                <ul class="review-value review-1">
                                                                    <li><a class="cursor-pointer" data-href="1"><i
                                                                                class="far fa-star"></i></a></li>
                                                                </ul>
                                                                <ul class="review-value review-2">
                                                                    <li><a class="cursor-pointer" data-href="2"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="2"><i
                                                                                class="far fa-star"></i></a></li>
                                                                </ul>
                                                                <ul class="review-value review-3">
                                                                    <li><a class="cursor-pointer" data-href="3"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="3"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="3"><i
                                                                                class="far fa-star"></i></a></li>
                                                                </ul>
                                                                <ul class="review-value review-4">
                                                                    <li><a class="cursor-pointer" data-href="4"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="4"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="4"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="4"><i
                                                                                class="far fa-star"></i></a></li>
                                                                </ul>
                                                                <ul class="review-value review-5">
                                                                    <li><a class="cursor-pointer" data-href="5"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="5"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="5"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="5"><i
                                                                                class="far fa-star"></i></a></li>
                                                                    <li><a class="cursor-pointer" data-href="5"><i
                                                                                class="far fa-star"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="input-btn mt-3">
                                                            <button type="submit">{{ __('Submit') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        @else
                                            <div class="review-login mt-5">
                                                <a class="boxed-btn d-inline-block mr-2"
                                                    href="{{ route('user.login') }}">{{ __('Login') }}</a>
                                                {{ __('to leave a rating') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if (!is_null($product->tabs))
                                @php
                                    try {
                                        $tabs = json_decode($product->tabs);
                                        foreach ($tabs as $tab) {
                                            $tab_title = $tab->title;
                                            $tab_content = $tab->content;
                                            echo "<div class='tab-pane fade' id='pills-" . \Illuminate\Support\Str::slug($tab_title) . "' role='tabpanel' aria-labelledby='pills-" . \Illuminate\Support\Str::slug($tab_title) . "-tab'>";
                                            echo str_replace('\n', '', nl2br(replaceBaseUrl(convertUtf8($tab_content)), false));
                                            echo '</div>';
                                        }
                                    } catch (\Exception $exception) {
                                    }
                                @endphp
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== SHOP TAB PART ENDS ======-->


    @if ($related_product->count() > 0)
        <!--====== product items PART ENDS ======-->
        {{-- <div class="product-items">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <span class="section-title">{{__('Related Products')}}</span>
                <h2 class="section-summary"{{__('>Have a look at the finlance latest Product')}}></h2>
            </div>
        </div>

        <div class="owl-carousel shop-item-slide-2">

             @foreach ($related_product as $product)
                 <div class="shop-item">
                    <div class="shop-thumb">
                        <img class="lazy" data-src="{{asset('assets/front/img/product/featured/'.$product->feature_image)}}" alt="">
                        <ul>

                            @if ($bex->catalog_mode == 0)
                                <li><a href="{{route('front.product.checkout',$product->slug)}}" data-toggle="tooltip" data-placement="top" title="{{__('Order Now')}}"><i class="far fa-credit-card"></i></a></li>

                                <li><a class="cart-link" data-href="{{route('add.cart',$product->id)}}" data-toggle="tooltip" data-placement="top" title="{{__('Add to Cart')}}"><i class="fas fa-shopping-cart"></i></a></li>
                            @endif

                            <li><a href="{{route('front.product.details',$product->slug)}}" data-toggle="tooltip" data-placement="top" title="{{__('View Details')}}"><i class="fas fa-eye"></i></a></li>
                        </ul>
                    </div>
                    <div class="shop-content text-center {{$bex->catalog_mode == 1 ? 'pt-3' : ''}}">
                        @if ($bex->product_rating_system == 1 && $bex->catalog_mode == 0)
                        <div class="rate">
                            <div class="rating" style="width:{{$product->rating * 20}}%"></div>
                        </div>
                        @endif
                        <a class="{{$bex->product_rating_system == 0 ? 'mt-3' : ''}}" href="{{route('front.product.details',$product->slug)}}">{{convertUtf8($product->title)}}</a> <br>

                        @if ($bex->catalog_mode == 0)

                            <span>
                                {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$product->current_price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                @if (!empty($product->previous_price))
                                    <del>  <span class="prepice"> {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}{{$product->previous_price}}{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span></del>
                                @endif
                            </span>
                        @endif
                    </div>
                </div>
             @endforeach


        </div>

    </div>
</div> --}}
    @endif
    <!--====== product items PART ENDS ======-->

@endsection

@section('scripts')
    <script src="{{ asset('assets/front/magnifier/lib/blowup.js') }}"></script>
    <script src="{{ asset('assets/front/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/product.js') }}"></script>
    <script>
        $('.image-popup').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        })
    </script>
    <script>
        $(document).on('click', '.review-value li a', function() {
            $('.review-value li a i').removeClass('text-primary');
            let reviewValue = $(this).attr('data-href');
            parentClass = `review-${reviewValue}`;
            $('.' + parentClass + ' li a i').addClass('text-primary');
            $('#reviewValue').val(reviewValue);
        })
    </script>
    <script>
        $(document).ready(function() {
            var scale = 1;
            $('.mag1').on('click', function() {
                scale = 1;
                $(this).removeClass('btn-dark')
                .addClass('btn-primary');
                $(this).siblings('button').removeClass('btn-primary')
                .addClass('btn-dark');
            });
            $('.mag2').on('click', function() {
                scale = 2;
                $(this).removeClass('btn-dark')
                .addClass('btn-primary');
                $(this).siblings('button').removeClass('btn-primary')
                .addClass('btn-dark');
            });
            $('.mag3').on('click', function() {
                scale = 3;
                $(this).removeClass('btn-dark')
                .addClass('btn-primary');
                $(this).siblings('button').removeClass('btn-primary')
                .addClass('btn-dark');
            });
            $('.mag4').on('click', function() {
                scale = 4;
                $(this).removeClass('btn-dark')
                .addClass('btn-primary');
                $(this).siblings('button').removeClass('btn-primary')
                .addClass('btn-dark');
            });
            $('.mag5').on('click', function() {
                scale = 5;
                $(this).removeClass('btn-dark')
                .addClass('btn-primary');
                $(this).siblings('button').removeClass('btn-primary')
                .addClass('btn-dark');
            });
            $(".img-blowup").on('mouseenter', function(evt) {
                $(this).blowup({
                    "background": "#000",
                    "scale": scale,
                    "width": 250,
                    "height": 250
                });
            });
            $(".img-blowup").blowup({
                "background": "#000",
                "scale": scale,
                "width": 250,
                "height": 250
            });
        });
    </script>
    @if ($product->offline)
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                @php
                $products = \App\Product::query()
                    ->orderBy('title', 'ASC')
                    ->get()
                    ->each(function ($query) use ($product) {
                        if ($product->id == $query->id) {
                            $query->selected = true;
                            return $query;
                        } elseif (session()->has('product_ids')) {
                            $product_ids = (array) session('product_ids');
                            if (in_array($query->id, $product_ids)) {
                                $query->selected = true;
                                return $query;
                            }
                        }
                    }); //->pluck('title', 'current_price', 'id');
                echo 'var productsArrayData = ' . json_encode($products) . ';';
                @endphp

                var data = $.map(productsArrayData, function(obj) {
                    obj.text = obj.text || obj.title; // replace name with the property used for the text

                    return obj;
                });

                $('#productInquiryModal .select2').select2({
                    data: data,
                    dropdownParent: $('#productInquiryModal'),
                    placeholder: "{{ __('Add More Products') }}",
                    templateResult: formatProduct
                });
            });

            function formatProduct(product) {
                if (!product.id) {
                    return product.text;
                }
                var $product = $(
                    '<span><img src="' + product.feature_image +
                    '" class="img-flag" style="max-width: 50px;max-height: 40px;"/> ' + product.text + '</span>'
                );
                return $product;
            };
        </script>
    @else
        <script src="{{ asset('assets/front/js/cart.js') }}"></script>
    @endif

@endsection
