@extends("front.$version.layout")

@section('pagename')
-
{{__('Wishlist')}}
@endsection

@section('meta-keywords', "$be->cart_meta_keywords")
@section('meta-description', "$be->cart_meta_description")


@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/jquery-ui.min.css')}}">
@endsection

@section('breadcrumb-links')
<nav class="woocommerce-breadcrumb font-size-2">
    <a href='/' class='h-primary'>{{convertUtf8("Wishlist")}}</a>
    <span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
    <a href='#' class='h-primary'>{{convertUtf8("My wishlist items")}}</a>
</nav>
@endsection
@section('content')

<!--====== SHOPPING CART PART START ======-->

<section class="cart-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                @if($wishlist != null)
                <ul class="total-item-info">
                    @php
                    $wishlistTotal = 0;
                    $countitem = 0;
                    if($wishlist){
                    foreach($wishlist as $id => $p)
                    {
                    $product = App\Product::find($id);
                    $wishlistTotal += $product->price * $p['qty'];
                    $countitem += $p['qty'];
                    }
                    }
                    @endphp
                    <li><strong>{{__('Total Items')}}:</strong> <strong class="cart-item-view">{{$wishlist ? $countitem : 0}}</strong></li>
                    <li>
                        <strong>{{__('Wishlist Total')}} :</strong>
                        <span style="font-weight: bolder;">{{ ship_to_india() ? "₹" : "$" }}</span>
                        <strong class="cart-total-view">{{ trim($wishlistTotal) }}</strong>
                    </li>
                </ul>
                @endif
                <div class="table-outer">
                    @if($wishlist != null)
                    <table class="cart-table">
                        <thead class="cart-header">
                            <tr>
                                <th style="max-width: 77px !important;width: 20px !important;min-width: auto;">
                                    <div class="form-group">
                                        <input type="checkbox" class="form-control addAllToCartCheck" style="height: 1.5em;">
                                    </div>
                                </th>
                                <th class="prod-column">{{__('Products')}}</th>
                                <th class="hide-column"></th>
                                <th>{{__('Quantity')}}</th>
                                <th class="availability">{{__('Availability')}}</th>
                                <th class="price">{{__('Price')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Remove')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($wishlist as $id => $item)
                            @php
                            $product = App\Product::findOrFail($id);
                            @endphp
                            <tr class="remove{{$id}}">
                                <td class="p-0" style="width: 50px !important;">
                                    <div class="form-group">
                                        <input type="checkbox" value="{{ $product->id }}" class="form-control addToCartCheck" style="height: 1.5em;">
                                    </div>
                                </td>

                                <td colspan="2" class="prod-column">
                                    <div class="column-box">
                                        <div class="title pl-0">
                                            <a target="_blank" href="{{route('front.product.details',$product->slug)}}" class="d-flex justify-content-start">
                                                <img src="{{$product->feature_image}}" alt="" style="max-width: 77px">
                                                <div class="px-2">
                                                    <h3 class="prod-title">{{convertUtf8($item['name'])}}</h3>
                                                    @php
                                                    $isbn = "";
                                                    try
                                                    {
                                                    $payload = json_decode($product->attributes);
                                                    foreach ($payload as $attribute)
                                                    {
                                                    if($attribute->name == "ISBN") $isbn = explode(',', $attribute->value)[0];
                                                    }
                                                    }
                                                    catch (\Exception $th)
                                                    {
                                                    //throw $th;
                                                    }
                                                    @endphp
                                                    <span class="prod-summary">{!! convertUtf8($isbn) !!}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="qty">
                                    <div class="product-quantity d-flex mb-35" id="quantity">
                                        <button type="button" id="sub" class="sub btn-sub">-</button>
                                        <input type="text" class="cart_qty" id="1" value="{{$item['qty']}}" />
                                        <button type="button" id="add" class="add btn-add">+</button>
                                    </div>
                                </td>
                                <input type="hidden" value="{{$id}}" class="product_id">
                                <td class="unit-price">
                                    <div class="available-info">
                                        @if ($product->type == 'digital')
                                        <span class="icon fa fa-check thm-bg-clr"></span>{{__('Item(s)')}}<br>{{__('Available Now')}}
                                        @else
                                        @if($product->stock >= $item['qty'])
                                        <span class="icon fa fa-check thm-bg-clr"></span>{{__('Item(s)')}}<br>{{__('Available Now')}}
                                        @else
                                        <span class="icon fa fa-times thm-bg-rmv"></span>{{__('Item(s)')}}<br>{{__('Out Of Stock')}}
                                        @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="price cart_price">
                                    {{ $product->symbol }}
                                    <span>
                                        {{ number_format(!empty($product->price) ? $product->price : '0.00', 0) }}
                                    </span>
                                </td>
                                <td class="sub-total">
                                    {{ $product->symbol }}
                                    <span>
                                        {{ number_format(!empty($product->price) ? $item['qty'] * $product->price : '0.00', 0) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="remove">
                                        <div class="checkbox">
                                            <span class="fas fa-times item-remove" rel="{{$id}}" data-href="{{route('cart.item.remove',$id)}}"></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @else
                    <div class="bg-light py-5 text-center">
                        <h3 class="text-uppercase">{{__('Wishlist is empty!')}}</h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @if ($wishlist != null)
        <div class="row cart-middle">
            <div class="col-lg-6 offset-lg-6 col-sm-12">
                <div class="update-cart float-right d-inline-block ml-4">
                    <a class="proceed-checkout-btn d-none wish2Cart" data-href="{{route('wishlist.to.cart')}}" href="javascript:;" type="button"><span>{{__('Add to Cart')}}</span></a>
                </div>
                <div class="update-cart float-right d-inline-block">
                    <button class="main-btn main-btn-2 wishUpdate" id="cartUpdate" data-href="{{route('wishlist.update')}}" type="button"><span>{{__('Update Wishlist')}}</span></button>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!--====== SHOPPING CART PART ENDS ======-->

@endsection


@section('scripts')
<script>
    var symbol = "@if(ship_to_india()) ₹ @else $ @endif";
    var position = "{{ $bex->base_currency_symbol_position }}";
</script>
<script>
    var link = "";
    var payload = "";
    let checkWishes = $('.addToCartCheck');
    let wish2CartBtn = $('.wish2Cart');

    //master checkbox start
    $(document).ready(function() {
        $('input[type="checkbox"]').click();
    });
    $(function() {
        $('.addAllToCartCheck').on("change", function() {
            if (this.checked) {
                checkWishes.filter(':not(:checked)').each(function() {
                    $(this).click();
                });
            } else {
                checkWishes.filter(':checked').each(function() {
                    $(this).click();
                });
            }
        });
    });
    //master checkbox end





    checkWishes.on('change', function(event) {
        canAddToCart();
        payload = "";
        checkWishes.filter(':checked').each(function() {
            canAddToCart(true);
            payload += $(this).val() + "-";
        });
        //payload     = payload.split('-');
        link = wish2CartBtn.attr('data-href') + "?products=" + payload;
        updateLink();
    });

    function canAddToCart(status = false) {
        if (status == true) {
            $('.wish2Cart').attr('class', 'proceed-checkout-btn wish2Cart');
        } else {
            $('.wish2Cart').attr('class', 'proceed-checkout-btn d-none wish2Cart');
        }
    }

    function updateLink() {
        wish2CartBtn.attr('href', link);
    }
</script>
<script src="{{asset('assets/front/js/jquery.ui.js')}}"></script>
<script src="{{asset('assets/front/js/cart.js')}}"></script>

<script>


</script>
@endsection