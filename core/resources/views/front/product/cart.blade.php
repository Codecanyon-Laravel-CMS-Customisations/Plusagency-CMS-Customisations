@extends("front.$version.layout")
@php
    // $bex->base_currency_symbol          = "AI";
    // $bex->base_currency_symbol_position = strtolower("Left");
    // $bex->base_currency_text            = "United States Dollar";
    // $bex->base_currency_text_position   = strtolower("Left");
    // $bex->base_currency_rate            = "1.00";



    // echo json_encode($bex);
    // return;

    $geo_data_base_currency             = angel_get_base_currency_id();//App\Models\Currency::find(81);
    $geo_data_user_currency             = angel_get_user_currency_id();//App\Models\Currency::find(23);

    // dd( $geo_data_base_currency);
    // echo json_encode( $geo_data_base_currency);return;
    // $bc_id      = App\Models\Currency::query()->where('name', App\BasicExtra::first()->base_currency_text)->orderBy('id', 'desc')->first();
    // echo json_encode($bc_id);//        return $bc_id->id;


    $bex_user_currency                  = App\Models\Currency::find($geo_data_user_currency);
    $bex->base_currency_symbol          = $bex_user_currency->symbol;
    $bex->base_currency_symbol_position = strtolower($bex_user_currency->symbol_position) == 'l'?  'left' : 'right';
    $bex->base_currency_text            = $bex_user_currency->name;
    $bex->base_currency_text_position   = strtolower($bex_user_currency->text_position) == 'l'?  'left' : 'right';

    // echo json_encode($bex);return;
    // echo json_encode(session()->all());return;



    function pesa($money)
    {
        return isset($pvariation) ? angel_auto_convert_currency($pvariation->current_price, angel_get_base_currency_id(), angel_get_user_currency_id()) : angel_auto_convert_currency($money, angel_get_base_currency_id(), angel_get_user_currency_id());
    }
@endphp

@section('pagename')
 -
 {{__('Cart')}}
@endsection

@section('meta-keywords', "$be->cart_meta_keywords")
@section('meta-description', "$be->cart_meta_description")


@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/jquery-ui.min.css')}}">
@endsection


@section('breadcrumb-title', convertUtf8($be->cart_title))
@section('breadcrumb-subtitle', convertUtf8($be->cart_subtitle))
@section('breadcrumb-link', __('Cart'))

@section('content')

<!--====== SHOPPING CART PART START ======-->

<section class="cart-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                @if($cart != null)
                    <ul class="total-item-info">
                        @php
                            $cartTotal = 0;
                            $countitem = 0;
                            if($cart){
                            foreach($cart as $id => $p)
                            {
                                $product    = App\Product::find($id);
                                $cartTotal += $product->price * $p['qty'];
                                $countitem += $p['qty'];
                            }
                        }
                        @endphp
                        <li><strong>{{__('Total Items')}}:</strong> <strong class="cart-item-view">{{$cart ? $countitem : 0}}</strong></li>
                        <li><strong>{{__('Cart Total')}} :</strong>  <strong class="cart-total-view">
                            {{-- {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} --}}
                            {{ ship_to_india() ? "₹" : "$" }}
                            {{ pesa($cartTotal) }}
                            {{-- {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}} --}}
                        </strong></li>
                    </ul>
                @endif
                <div class="table-outer">
                    @if($cart != null)
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

                            @foreach ($cart as $id => $item)
                            @php
                                $product = App\Product::findOrFail($id);
                            @endphp
                            <tr class="remove{{$id}}">

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
                                                            $payload    = json_decode($product->attributes);
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
                                        <button type="button" id="sub" class="sub">-</button>
                                        <input type="text" class="cart_qty" id="1" value="{{$item['qty']}}" />
                                        <button type="button" id="add" class="add">+</button>
                                    </div>
                                </td>
                                <input type="hidden" value="{{$id}}" class="product_id">
                                <td class="unit-price">
                                    <div class="available-info">
                                        @if ($product->type == 'digital')
                                            <span class="icon fa fa-check thm-bg-clr"></span>{{__('Item(s)')}}<br>{{__('Avilable Now')}}
                                        @else
                                            @if($product->stock >= $item['qty'])
                                                <span class="icon fa fa-check thm-bg-clr"></span>{{__('Item(s)')}}<br>{{__('Avilable Now')}}
                                            @else
                                                <span class="icon fa fa-times thm-bg-rmv"></span>{{__('Item(s)')}}<br>{{__('Out Of Stock')}}
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="price cart_price">
                                    {{-- {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} --}}
                                    {{ $product->symbol }}
                                    <span>
                                        {{-- {{ isset($pvariation) ? angel_auto_convert_currency($pvariation->current_price, $geo_data_base_currency, $geo_data_user_currency) : angel_auto_convert_currency($product->current_price, $geo_data_base_currency, $geo_data_user_currency) }} --}}
                                        {{ number_format(!empty($product->price) ? $product->price : '0.00', 0) }}
                                    </span>
                                    {{-- {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}} --}}
                                </td>
                                <td class="sub-total">
                                    {{-- {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} --}}
                                    {{ $product->symbol }}
                                    <span>
                                        {{-- {{ isset($pvariation) ? angel_auto_convert_currency($item['qty'] * $item['price'], $geo_data_base_currency, $geo_data_user_currency) : angel_auto_convert_currency($item['qty'] * $item['price'], $geo_data_base_currency, $geo_data_user_currency) }} --}}
                                        {{ number_format(!empty($product->price) ? $item['qty'] * $product->price : '0.00', 0) }}
                                    </span>
                                    {{-- {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}} --}}
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
                            <h3 class="text-uppercase">{{__('Cart is empty!')}}</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if ($cart != null)
            <div class="row cart-middle">
                <div class="col-lg-6 offset-lg-6 col-sm-12">
                    <div class="update-cart float-right d-inline-block ml-4">
                        <a class="proceed-checkout-btn" href="{{route('front.checkout')}}" type="button"><span>{{__('Checkout')}}</span></a>
                    </div>
                    <div class="update-cart float-right d-inline-block">
                        <button class="main-btn main-btn-2" id="cartUpdate" data-href="{{route('cart.update')}}" type="button"><span>{{__('Update Cart')}}</span></button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!--====== SHOPPING CART PART ENDS ======-->

@endsection


@section('scripts')
<script>{{--
    var symbol      = "{ {$bex->base_currency_symbol} }";
    var position    = "{ {$bex->base_currency_symbol_position} }"; --}}
    var symbol      = "{{ ship_to_india() ? '₹' : '$' }}";
    var position    = "{{ 'left' }}";
</script>
<script src="{{asset('assets/front/js/jquery.ui.js')}}"></script>
<script src="{{asset('assets/front/js/cart.js')}}"></script>

<script>


</script>
@endsection
