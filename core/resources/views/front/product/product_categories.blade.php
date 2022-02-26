@extends("front.$version.layout")

@section('pagename')
-
{{ __('Categories') }}
@endsection

@section('meta-keywords', "$be->products_meta_keywords")
@section('meta-description', "$be->products_meta_description")


@section('breadcrumb-title', convertUtf8('Categories'))
@section('breadcrumb-subtitle', convertUtf8('explore a wide range of products'))
@section('breadcrumb-link', __('Categories'))
@section('breadcrumb-links')
<nav class="woocommerce-breadcrumb font-size-2">
    <a href='/' class='h-primary'>Home</a>
    <span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
    <a href='/products' class='h-primary'>Products</a>
    <span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
    <a href='#' class='h-primary'>Categories</a>
</nav>
@endsection

@section('content')

{{-- <!--====== SHOPPING CART PART START ======--> --}}

<section class="cart-area product-categories">
    <div class="container d-none d-md-block">
        <div class="row">
            @foreach ($pcategories->where('menu_level', '1') as $pc1)
            @php
            if ($pc1->products()->count() < 1) { continue; } @endphp <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card pc-card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a class="" href="/products?search=&c-id={{ $pc1->id }}&type=new">
                                {{ $pc1->name }}
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </h5>
                        @foreach ($pc1->childs->sortBy('name', 0, false) as $pc2)
                        <p class="card-text">
                            <a href="/products?search=&sc-id={{ $pc2->id }}&type=new">{{ $pc2->name }}</a>
                        </p>
                        @endforeach
                    </div>
                </div>
        </div>
        @endforeach
    </div>
    </div>
    <div class="container d-sm-block d-md-none">
        <div class="row">
            <div class="col-sm-12 col-md-6 offset-md-3">

                <div class="accordion" id="productCategoriesAccordion">
                    @foreach ($pcategories->where('menu_level', '1') as $pc1)
                    @php
                    if ($pc1->products()->count() < 1) { continue; } @endphp <div class="card pc-card">
                        <div class="card-header" id="heading{{ $pc1->id }}">
                            <h5 class="card-title">
                                <a class="" data-toggle="collapse" data-target="#collapse{{ $pc1->id }}" aria-expanded="@if ($loop->first) true @else false @endif" aria-controls="collapse{{ $pc1->id }}">
                                    {{ $pc1->name }}
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </h5>
                        </div>

                        <div id="collapse{{ $pc1->id }}" class="collapse @if ($loop->first) show @endif" aria-labelledby="heading{{ $pc1->id }}" data-parent="#productCategoriesAccordion">
                            <div class="card-body">
                                @foreach ($pc1->childs->sortBy('name', 0, false) as $pc2)
                                <p class="card-text">
                                    <a href="/products?search=&sc-id={{ $pc2->id }}&type=new">{{ $pc2->name }}</a>
                                </p>
                                @endforeach
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
</section>

{{-- <!--====== SHOPPING CART PART ENDS ======--> --}}

@endsection