@extends("front.$version.layout")

@section('pagename')
    -
    {{ __('Product Categories') }}
@endsection

@section('meta-keywords', "$be->products_meta_keywords")
@section('meta-description', "$be->products_meta_description")


@section('breadcrumb-title', convertUtf8('Product Categories'))
@section('breadcrumb-subtitle', convertUtf8('explore a wide range of products'))
@section('breadcrumb-link', __('Categories'))

@section('content')

    {{-- <!--====== SHOPPING CART PART START ======--> --}}

    <section class="cart-area">
        <div class="container">
            <div class="row">
                @foreach ($pcategories->where('menu_level', '1') as $pc1)
                    @php
                        if($pc1->products()->count() < 1) continue;
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="/products?search=&c-id={{ $pc1->id }}&type=new">
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
    </section>

    {{-- <!--====== SHOPPING CART PART ENDS ======--> --}}

@endsection