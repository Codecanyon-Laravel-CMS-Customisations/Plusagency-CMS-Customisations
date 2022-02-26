@extends("front.$version.layout")



@section('pagename')
    - {{ __('Product') }} - {{ convertUtf8($product->title) }}
@endsection

@section('styles')


<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/front/magiczoomplus-trial/magiczoomplus/magiczoomplus.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/front/css/slick.css') }}">
    @if ($product->offline)
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endif
    <style>
        .zoom-lens-control-wrapper button:is(:active, :focus, :hover){
            box-shadow: none !important;
        }
        .slick-lightbox :is(.slick-prev, .slick-next) {
            z-index: 1111111;
        }
        .slick-lightbox {
            z-index: 999999;
        }
        .js-slick-carousel img {
            cursor: zoom-in !important;
        }
        .slider-nav img {
            cursor: col-resize !important;
        }
        .slick-prev:before, .slick-next:before {
            font-size: 35px !important;
        }
        .slick-lightbox .slick-prev {
            left: 0px;
        }
    </style>
    <style type="text/css">
        html { position: relative; min-height: 100%; }
        body { position: absolute; left:0; right: 0; min-height: 100%; background:#fff; margin:0; padding:0; font-size: 100%; }
        body, td {
            font-family: 'Helvetica Neue', Helvetica, 'Lucida Grande', Tahoma, Arial, Verdana, sans-serif;
            line-height: 1.5em;
            -webkit-text-rendering: geometricPrecision;
            text-rendering: geometricPrecision;
        }
        h1 { font-size:1.5em; font-weight:normal; color:#555; }
        h2 { font-size:1.3em; font-weight:normal; color:#555; }
        h2.caption { margin: 2.5em 0 0;}
        h3 { font-size:1.1em; font-weight: normal; color:#555; }
        h3.pad { margin: 2em 0 1em; }
        h4 { font-size: 1em; font-weight:normal; color:#555; }
        p.pad { margin-top: 1.5em; }
        a { outline: none; }


        .cfg-btn {
            background-color: rgb(55, 181, 114);
            color: #fff;
            border: 0;
            box-shadow: 0 0 1px 0px rgba(0,0,0,0.3);
            outline:0;
            cursor: pointer;
            width: 200px;
            padding: 10px;
            font-size: 1em;
            position: relative;
            display: inline-block;
            margin: 10px auto;
        }
        .cfg-btn:hover:not([disabled]) {
            background-color: rgb(37, 215, 120);
        }
        .mobile-magic .cfg-btn:hover:not([disabled]) { background: rgb(55, 181, 114); }
        .cfg-btn[disabled] { opacity: .5; color: #808080; background: #ddd; }

        .cfg-btn.btn-preview,
        .cfg-btn.btn-preview:active,
        .cfg-btn.btn-preview:focus {
            font-size: 1em;
            position: relative;
            display: block;
            margin: 10px auto;
        }

        .cfg-btn,
        .preview,
        .app-figure,
        .api-controls,
        .wizard-settings,
        .wizard-settings .inner,
        .wizard-settings .footer,
        .wizard-settings input,
        .wizard-settings select {
            -webkit-box-sizing: border-box;
               -moz-box-sizing: border-box;
                    box-sizing: border-box;
        }
        .preview,
        .wizard-settings {
            padding: 10px;
            border: 0;
            min-height: 1px;
        }
        .preview {
            position: relative;
        }

        .api-controls {
            text-align: center;
        }
        .api-controls button,
        .api-controls button:active,
        .api-controls button:focus {
             width: 80px; font-size: .7em;
             white-space: nowrap;
        }

        .app-figure {
            width: 80% !important;
            margin: 0px auto;
            border: 0px solid red;
            padding: 20px;
            position: relative;
            text-align: center;
        }
        .selectors { margin-top: 10px; }
        .selectors .mz-thumb img { max-width: 56px; }

        .app-code-sample {
            max-width: 80%;
            margin: 30px auto 0;
            text-align: center;
            position: relative;
        }
        .app-code-sample input[type="radio"] {
            display: none;
        }
        .app-code-sample label {
            display: inline-block;
            padding: 2px 12px;
            margin: 0;
            font-size: .8em;
            text-decoration: none;
            cursor: pointer;
            color: #666;
            border: 1px solid rgba(136, 136, 136, 0.5);
            background-color: transparent;
        }
        .app-code-sample label:hover {
            color: #fff;
            background-color: rgb(253, 154, 30);
            border-color: rgb(253, 154, 30);
        }
        .app-code-sample input[type="radio"]:checked+label {
            color: #fff;
            background-color: rgb(110, 110, 110) !important;
            border-color: rgba(110, 110, 110, 0.7) !important;
        }
        .app-code-sample label:first-of-type {
            border-radius: 4px 0 0 4px;
            border-right-color: transparent;
        }
        .app-code-sample label:last-of-type {
            border-radius: 0 4px 4px 0;
            border-left-color: transparent;
        }

        .app-code-sample .app-code-holder {
            padding: 0;
            position: relative;
            border: 1px solid #eee;
            border-radius: 0px;
            background-color: #fafafa;
            margin: 15px 0;
        }
        .app-code-sample .app-code-holder > div {
            display: none;
        }
        .app-code-sample .app-code-holder pre {
            text-align: left;
            white-space: pre-line;
            border: 0px solid #eee;
            border-radius: 0px;
            background-color: transparent;
            padding: 25px 50px 25px 25px;
            margin: 0;
            min-height: 25px;
        }
        .app-code-sample input[type="radio"]:nth-of-type(1):checked ~ .app-code-holder > div:nth-of-type(1) {
            display: block;
        }
        .app-code-sample input[type="radio"]:nth-of-type(2):checked ~ .app-code-holder > div:nth-of-type(2) {
            display: block;
        }

        .app-code-sample .app-code-holder .cfg-btn-copy {
            display: none;
            z-index: -1;
            position: absolute;
            top:10px; right: 10px;
            width: 44px;
            font-size: .65em;
            white-space: nowrap;
            margin: 0;
            padding: 4px;
        }
        .copy-msg {
            font: normal 11px/1.2em 'Helvetica Neue', Helvetica, 'Lucida Grande', 'Lucida Sans Unicode', Verdana, Arial, sans-serif;
            color: #2a4d14;
            border: 1px solid #2a4d14;
            border-radius: 4px;
            position: absolute;
            top: 8px;
            left: 0;
            right: 0;
            width: 200px;
            max-width: 70%;
            padding: 4px;
            margin: 0px auto;
            text-align: center;
        }
        .copy-msg-failed {
            color: #b80c09;
            border-color: #b80c09;
            width: 430px;
        }
        .mobile-magic .app-code-sample .cfg-btn-copy { display: none; }
        #code-to-copy { position: absolute; width: 0; height: 0; top: -10000px; }
        .lt-ie9-magic .app-code-sample { display: none; }

        .wizard-settings {
            background-color: #4f4f4f;
            color: #a5a5a5;
            position: absolute;
            right: 0;
            width: 340px;
        }
        .wizard-settings .inner {
            width: 100%;
            margin-bottom: 30px;
        }
        .wizard-settings .footer {
            color: #c7d59f;
            font-size: .75em;
            width: 100%;
            position: relative;
            vertical-align: bottom;
            text-align: center;
            padding: 6px;
            margin-top: 10px;
        }
        .wizard-settings .footer a { color: inherit; text-decoration: none; }
        .wizard-settings .footer a:hover { text-decoration: underline; }

        .wizard-settings a { color: #cc9933; }
        .wizard-settings a:hover { color: #dfb363; }
        .wizard-settings table > tbody > tr > td { vertical-align: top; }
        .wizard-settings table { min-width: 300px; max-width: 100%; font-size: .8em; margin: 0 auto; }
        .wizard-settings table caption { font-size: 1.5em; padding: 16px 8px; }
        .wizard-settings table td { padding: 4px 8px; }
        .wizard-settings table td:first-child { white-space: nowrap; }
        .wizard-settings table td:nth-child(2) { text-align: left; }
        .wizard-settings table td .values {
            color: #a08794;
            font-size: 0.8em;
            line-height: 1.3em;
            display: block;
            max-width: 126px;
        }
        .wizard-settings table td .values:before { content: ''; display: block; }

        .wizard-settings input,
        .wizard-settings select {
            width: 126px;
        }
        .wizard-settings input {
            padding: 0px 4px;
        }
        .wizard-settings input[disabled] {
            color: #808080;
            background: #a7a7a7;
            border: 1px solid #a7a7a7;
        }

        .preview { width: 70%; float: left; }
        @media (min-width: 0px) {
            .preview { width: 100%; float: none; }
        }

        @media (min-width: 1024px) {
            .preview { width: calc(100% - 340px); }
            .wizard-settings { top: 0; min-height: 100%; }
            .wizard-settings .inner { margin-top: 60px; }
            .wizard-settings .footer { position: absolute; bottom: 0; left: 0; }
            .wizard-settings .settings-controls {
                position: fixed;
                top: 0; right: 0;
                width: 340px;
                padding: 10px 0 0;
                text-align: center;
                background-color: inherit;
            }
        }
        @media screen and (max-width: 1024px) {
            .api-controls button, .api-controls button:active, .api-controls button:focus {
                width: 70px;
            }
        }
        @media screen and (max-width: 1023px) {
            .app-figure { width: 98% !important; margin: 50px auto; padding: 0; }
            .app-code-sample { display: none; }
            .wizard-settings { width: 100%; }
        }
        @media screen and (max-width: 600px) {
            .mz-thumb img { max-width: 39px; }
        }
        @media screen and (max-width: 560px) {
            .api-controls .sep { content: ''; display: table; }
        }
        @media screen and (min-width: 1600px) {
            .preview { padding: 10px 160px; }
        }

        a[href="http://www.magictoolbox.com/magiczoomplus/"],
        a[href="https://www.magictoolbox.com/magiczoomplus/"]{
            display: none !important;
        }
        .shop-tab-area .tab-pane > .list-group > .list-group-item {
            border-bottom-color: transparent !important;
        }
        a#cartIcon .cart-total {
            color: #161619 !important;
        }
    </style>
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
    <script type="text/javascript" src="{{ asset('assets/front/magiczoomplus-trial/magiczoomplus/magiczoomplus.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('assets/front/magnifier/lib/blowup.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('assets/front/js/slick.min.js') }}"></script> --}}
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
    <script type="text/javascript">
        var mzMobileOptions = {};
        var mzOptions       = {};
        @if(!$mzoom)
            mzOptions = {
                zoomMode: "magnifier",
                onZoomReady: function() {
                    console.log('onReady', arguments[0]);
                },
                onUpdate: function() {
                    console.log('onUpdated', arguments[0], arguments[1], arguments[2]);
                },
                onZoomIn: function() {
                    console.log('onZoomIn', arguments[0]);
                },
                onZoomOut: function() {
                    console.log('onZoomOut', arguments[0]);
                },
                onExpandOpen: function() {
                    console.log('onExpandOpen', arguments[0]);
                },
                onExpandClose: function() {
                    console.log('onExpandClosed', arguments[0]);
                }
            };
            var mzMobileOptions = {
                zoomMode: "magnifier"
            };
        @else
            mzOptions = {
                @php
                    $arr_d  = json_decode($mzoom->desktop_options, true);
                    foreach($arr_d as $key => $value)
                    {
                        echo "$key: \"$value\",\n";
                    }
                @endphp
                onZoomReady: function() {
                    console.log('onReady', arguments[0]);
                },
                onUpdate: function() {
                    console.log('onUpdated', arguments[0], arguments[1], arguments[2]);
                },
                onZoomIn: function() {
                    console.log('onZoomIn', arguments[0]);
                },
                onZoomOut: function() {
                    console.log('onZoomOut', arguments[0]);
                },
                onExpandOpen: function() {
                    console.log('onExpandOpen', arguments[0]);
                },
                onExpandClose: function() {
                    console.log('onExpandClosed', arguments[0]);
                }
            };
            var mzMobileOptions = {
                @php
                    $arr_m  = json_decode($mzoom->mobile_options, true);
                    $c      = count($arr_m);
                    $i      = 0;
                    foreach($arr_m as $key => $value)
                    {
                        $i++;
                        echo $i == $c ? "$key: \"$value\"\n" : "$key: \"$value\",\n";
                    }
                @endphp
            };
    @endif
    function isDefaultOption(o) {
        return magicJS.$A(magicJS.$(o).byTag('option')).filter(function(opt){
            return opt.selected && opt.defaultSelected;
        }).length > 0;
    }

    function toOptionValue(v) {
        if ( /^(true|false)$/.test(v) ) {
            return 'true' === v;
        }
        if ( /^[0-9]{1,}$/i.test(v) ) {
            return parseInt(v,10);
        }
        return v;
    }

    function makeOptions(optType) {
        var  value = null, isDefault = true, newParams = Array(), newParamsS = '', options = {};
        magicJS.$(magicJS.$A(magicJS.$(optType).getElementsByTagName("INPUT"))
            .concat(magicJS.$A(magicJS.$(optType).getElementsByTagName('SELECT'))))
            .forEach(function(param){
                value = ('checkbox'==param.type) ? param.checked.toString() : param.value;

                isDefault = ('checkbox'==param.type) ? value == param.defaultChecked.toString() :
                    ('SELECT'==param.tagName) ? isDefaultOption(param) : value == param.defaultValue;

                if ( null !== value && !isDefault) {
                    options[param.name] = toOptionValue(value);
                }
        });
        return options;
    }

    function updateScriptCode() {
        var code = '&lt;script&gt;\nvar mzOptions = ';
        code += JSON.stringify(mzOptions, null, 2).replace(/\"(\w+)\":/g,"$1:")+';';
        code += '\n&lt;/script&gt;';

        magicJS.$('app-code-sample-script').changeContent(code);
    }

    function updateInlineCode() {
        var code = '&lt;a class="MagicZoom" data-options="';
        code += JSON.stringify(mzOptions).replace(/\"(\w+)\":(?:\"([^"]+)\"|([^,}]+))(,)?/g, "$1: $2$3; ").replace(/\{([^{}]*)\}/,"$1").replace(/\s*$/,'');
        code += '"&gt;';

        magicJS.$('app-code-sample-inline').changeContent(code);
    }

    function applySettings() {
        MagicZoom.stop('Zoom-1');
        mzOptions = makeOptions('params');
        mzMobileOptions = makeOptions('mobile-params');
        MagicZoom.start('Zoom-1');
        updateScriptCode();
        updateInlineCode();
        try {
            prettyPrint();
        } catch(e) {}
    }

    function copyToClipboard(src) {
        var
            copyNode,
            range, success;

        if (!isCopySupported()) {
            disableCopy();
            return;
        }
        copyNode = document.getElementById('code-to-copy');
        copyNode.innerHTML = document.getElementById(src).innerHTML;

        range = document.createRange();
        range.selectNode(copyNode);
        window.getSelection().addRange(range);

        try {
            success = document.execCommand('copy');
        } catch(err) {
            success = false;
        }
        window.getSelection().removeAllRanges();
        if (!success) {
            disableCopy();
        } else {
            new magicJS.Message('Settings code copied to clipboard.', 3000,
                document.querySelector('.app-code-holder'), 'copy-msg');
        }
    }

    function disableCopy() {
        magicJS.$A(document.querySelectorAll('.cfg-btn-copy')).forEach(function(node) {
            node.disabled = true;
        });
        new magicJS.Message('Sorry, cannot copy settings code to clipboard. Please select and copy code manually.', 3000,
            document.querySelector('.app-code-holder'), 'copy-msg copy-msg-failed');
    }

    function isCopySupported() {
        if ( !window.getSelection || !document.createRange || !document.queryCommandSupported ) { return false; }
        return document.queryCommandSupported('copy');
    }
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
