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


@section('breadcrumb-title', convertUtf8("Wishlist"))
@section('breadcrumb-subtitle', convertUtf8("my wishlist items"))
@section('breadcrumb-link', __('Cart'))

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
                            foreach($wishlist as $p){
                                $wishlistTotal += $p['price'] * $p['qty'];
                                $countitem += $p['qty'];
                            }
                        }
                        @endphp
                        <li><strong>{{__('Total Items')}}:</strong> <strong class="cart-item-view">{{$wishlist ? $countitem : 0}}</strong></li>
                        <li><strong>{{__('Wishlist Total')}} :</strong>  <strong class="cart-total-view">
                            {{-- {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} --}}
                            {{ ship_to_india() ? "₹" : "$" }}
                            {{ trim($wishlistTotal) }}
                            {{-- {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}} --}}
                        </strong></li>
                    </ul>
                @endif
                <div class="table-outer">
                    @if($wishlist != null)
                    <table class="cart-table">
                        <thead class="cart-header">
                            <tr>
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

                                <td colspan="2" class="prod-column">
                                    <div class="column-box">
                                        <div class="title pl-0">
                                            <a target="_blank" href="{{route('front.product.details',$product->slug)}}"><h3 class="prod-title">{{convertUtf8($item['name'])}}</h3></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="qty">
                                    <div class="product-quantity d-flex mb-35" id="quantity">
                                        <button type="button" id="sub" class="sub">-</button>
                                        <input type="text" class="cart_qty" id="1" value="{{$item['qty']}}" />
                                        <button type="button" id="add" class="add">+</button>
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
                        <a class="proceed-checkout-btn" href="{{route('wishlist.to.cart')}}" type="button"><span>{{__('Add to Cart')}}</span></a>
                    </div>
                    <div class="update-cart float-right d-inline-block">
                        <button class="main-btn main-btn-2" id="cartUpdate" data-href="{{route('wishlist.update')}}" type="button"><span>{{__('Update Wishlist')}}</span></button>
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
    var symbol = "{{$bex->base_currency_symbol}}";
    var position = "{{$bex->base_currency_symbol_position}}";
</script>
<script src="{{asset('assets/front/js/jquery.ui.js')}}"></script>
<script src="{{asset('assets/front/js/cart.js')}}"></script>

<script>


</script>
@endsection
