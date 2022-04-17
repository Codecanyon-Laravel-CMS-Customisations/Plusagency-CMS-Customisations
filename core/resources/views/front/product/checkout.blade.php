@extends("front.$version.layout")
@php
// $bex->base_currency_symbol = "AI";
// $bex->base_currency_symbol_position = strtolower("Left");
// $bex->base_currency_text = "United States Dollar";
// $bex->base_currency_text_position = strtolower("Left");
// $bex->base_currency_rate = "1.00";



// echo json_encode($bex);
// return;

$geo_data_base_currency = angel_get_base_currency_id();//App\Models\Currency::find(81);
$geo_data_user_currency = angel_get_user_currency_id();//App\Models\Currency::find(23);
//dd( [$geo_data_base_currency,$geo_data_user_currency]);
// echo json_encode( $geo_data_base_currency);return;
// $bc_id = App\Models\Currency::query()->where('name', App\BasicExtra::first()->base_currency_text)->orderBy('id', 'desc')->first();
// echo json_encode($bc_id);// return $bc_id->id;


$bex_user_currency = App\Models\Currency::find($geo_data_user_currency);
$bex->base_currency_symbol = $bex_user_currency->symbol;
$bex->base_currency_symbol_position = strtolower($bex_user_currency->symbol_position) == 'l'? 'left' : 'right';
$bex->base_currency_text = $bex_user_currency->name;
$bex->base_currency_text_position = strtolower($bex_user_currency->text_position) == 'l'? 'left' : 'right';

// echo json_encode($bex);return;
// echo json_encode(session()->all());return;



function pesa($money)
{
return isset($pvariation) ? angel_auto_convert_currency($pvariation->current_price, angel_get_base_currency_id(), angel_get_user_currency_id()) : angel_auto_convert_currency($money, angel_get_base_currency_id(), angel_get_user_currency_id());
}
@endphp

@section('pagename')
-
{{__('Checkout')}}
@endsection

@section('meta-keywords', "$be->checkout_meta_keywords")
@section('meta-description', "$be->checkout_meta_description")
@section('breadcrumb-links')
<nav class="woocommerce-breadcrumb font-size-2">
    <a href='/' class='h-primary'>{{convertUtf8($be->checkout_title)}}</a>
    <span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
    <a href='#' class='h-primary'>{{convertUtf8($be->checkout_subtitle)}}</a>
</nav>
@endsection

@section('content')

<style>
    .btn-radio {
        cursor: pointer;
    }

    /* start: must comment below css before push  */
    /*label, label:hover, .field-label {
        color: black;
    }

    input, input:hover {
        color: black;
    }*/
    /* end: must comment below css before push  */
</style>

<!--====== CHECKOUT PART START ======-->
<section class="checkout-area">
    <form action="{{route('product.paypal.submit')}}" method="POST" id="payment" enctype="multipart/form-data">
        @csrf
        @if(Session::has('stock_error'))
        <p class="text-danger text-center my-3">{{Session::get('stock_error')}}</p>
        @endif
        <div class="container">

            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="form billing-info">
                        <div class="shop-title-box">
                            <h3>{{__('Billing Address')}}</h3>
                        </div>

                        <div class="row ml-1">
                            <div class="form-check-inline">
                              <label class="form-check-label field-label btn-radio" for="same-billing">
                                <input onchange="checkBillingAddress('same')" id="same-billing" type="radio" class="form-check-input" name="same_billing_address" value="same"  
                                {{ !old("same_billing_address") ? 'checked' : '' }}
                                {{ old("same_billing_address") == 'same' ? 'checked' : '' }}> Same as shipping address
                              </label>
                            </div>

                            <div class="form-check-inline">
                              <label class="form-check-label field-label btn-radio" for="other-billing">
                                <input onchange="checkBillingAddress('other')" type="radio" id="other-billing" class="form-check-input" name="same_billing_address" value="other" {{ old("same_billing_address") == 'other' ? 'checked' : '' }}>Other billing address
                              </label>
                            </div>
                        </div>

                        <div class="row billing-form {{ old('same_billing_address') == 'other' ? '' : 'd-none' }}">
                            <div class="col-md-12 mb-4">
                                <div class="field-label">{{__('Country')}} *</div>
                                {{-- <div class="field-input">
                                            @php
                                                $bcountry = '';
                                                if(empty(old())) {
                                                    if (Auth::check()) {
                                                        $bcountry = Auth::user()->billing_country;
                                                    }
                                                } else {
                                                    $bcountry = old('billing_country');
                                                }
                                            @endphp
                                            <input type="text" name="billing_country" value="{{$bcountry}}">
                            </div> --}}
                            <div class="ml-auto d-lg-flex justify-content-xl-end align-items-center form-group">
                                @php
                                $countries = App\Models\Country::all()->unique('name');
                                $countries_options = '';
                                @endphp

                                <select name="billing_country" class="form-control js-select selectpicker dropdown-select mb-3 mb-md-0" data-style="border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true" data-live-search="true">
                                    @foreach ($countries as $country)
                                    @php
                                    if (!empty(old('billing_country'))) {
                                        $user_country = '';
                                    }
                                    else {
                                        $user_country = session('geo_data_user_country');
                                    }
                                    
                                    $country_id = $country->id;

                                    $country_id_crypt = encrypt($country->id);
                                    $route = route('changeCountry', $country_id_crypt);
                                    $wc_selected = $country_id == $user_country ? 'selected' : '';
                                    $wc_value = $country->name.' ( '.$country->native_name.' )';

                                    if (!empty(old('billing_country')))
                                    {
                                    $wc_selected = $wc_value == old('billing_country', '') ? 'selected' : '';
                                    }

                                    $countries_options .= "<option data-link=\"$route\" data-value=\"$country->id\" value=\"$wc_value\" $wc_selected>$wc_value</option>";

                                    @endphp
                                    {{-- <option value="{{ $country->id }}" @if ($country->id == session('geo_data_user_country')) selected @endif>{{ "$country->name ($country->native_name)" }}</option> --}}
                                    @endforeach
                                    {!! $countries_options !!}
                                </select>
                            </div>
                            @error('billing_country')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="field-label">{{__('First Name')}} *</div>
                            <div class="field-input">
                                @php
                                $bfname = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $bfname = Auth::user()->billing_fname;
                                }
                                } else {
                                $bfname = old('billing_fname');
                                }
                                @endphp
                                <input type="text" name="billing_fname" value="{{$bfname}}">
                            </div>
                            @error('billing_fname')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="field-label">{{__('Last Name')}} *</div>
                            <div class="field-input">
                                @php
                                $blname = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $blname = Auth::user()->billing_lname;
                                }
                                } else {
                                $blname = old('billing_lname');
                                }
                                @endphp
                                <input type="text" name="billing_lname" value="{{$blname}}">
                            </div>
                            @error('billing_lname')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="field-label">{{__('Address')}} *</div>
                            <div class="field-input">
                                @php
                                $baddress = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $baddress = Auth::user()->billing_address;
                                }
                                } else {
                                $baddress = old('billing_address');
                                }
                                @endphp
                                <input type="text" name="billing_address" value="{{$baddress}}">
                            </div>
                            @error('billing_address')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="field-label">{{__('Town / City')}} *</div>
                            <div class="field-input">
                                @php
                                $bcity = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $bcity = Auth::user()->billing_city;
                                }
                                } else {
                                $bcity = old('billing_city');
                                }
                                @endphp
                                <input type="text" name="billing_city" value="{{$bcity}}">
                            </div>
                            @error('billing_city')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="field-label">{{__('Contact Email')}} *</div>
                            <div class="field-input">
                                @php
                                $bmail = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $bmail = Auth::user()->billing_email;
                                }
                                } else {
                                $bmail = old('billing_email');
                                }
                                @endphp
                                <input type="text" name="billing_email" value="{{$bmail}}">
                            </div>
                            @error('billing_email')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="field-label">{{__('Phone')}} *</div>
                            <div class="field-input">
                                @php
                                $bnumber = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $bnumber = Auth::user()->billing_number;
                                }
                                } else {
                                $bnumber = old('billing_number');
                                }
                                @endphp
                                <input type="text" name="billing_number" value="{{$bnumber}}">
                            </div>
                            @error('billing_number')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form shipping-info">
                    <div class="shop-title-box">
                        <h3>{{__('Shipping Address')}}</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="field-label">{{__('Country')}} *</div>
                            <div class="field-input form-group">
                                {{-- @php
                                            $scountry = '';
                                            if(empty(old())) {
                                                if (Auth::check()) {
                                                    $scountry = Auth::user()->shpping_country;
                                                }
                                            } else {
                                                $scountry = old('shpping_country');
                                            }
                                        @endphp
                                        <input type="text" name="shpping_country" value="{{$scountry}}"> --}}
                                <div class="ml-auto d-lg-flex justify-content-xl-end align-items-center">
                                    @php
                                    $countries = App\Models\Country::all()->unique('name');
                                    $countries_options = '';
                                    @endphp

                                    <select name="shpping_country" class="form-control changeCountry js-select selectpicker dropdown-select mb-3 mb-md-0" data-style="border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true" data-live-search="true">
                                        @foreach ($countries as $country)
                                        @php
                                        $user_country = session('geo_data_user_country');
                                        $country_id = $country->id;

                                        $country_id_crypt = encrypt($country->id);
                                        $route = route('changeCountry', $country_id_crypt);
                                        $wc_selected = $country_id == $user_country ? 'selected' : '';
                                        $wc_value = $country->name.' ( '.$country->native_name.' )';

                                        $countries_options .= "<option data-link=\"$route\" data-value=\"$country->id\" $wc_selected>$wc_value</option>";

                                        @endphp
                                        {{-- <option value="{{ $country->id }}" @if ($country->id == session('geo_data_user_country')) selected @endif>{{ "$country->name ($country->native_name)" }}</option> --}}
                                        @endforeach
                                        {!! $countries_options !!}
                                    </select>
                                </div>
                            </div>
                            @error('shpping_country')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="field-label">{{__('First Name')}} *</div>
                            <div class="field-input">
                                @php
                                $sfname = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $sfname = Auth::user()->shpping_fname;
                                }
                                } else {
                                $sfname = old('shpping_fname');
                                }
                                @endphp
                                <input type="text" name="shpping_fname" value="{{$sfname}}">
                            </div>
                            @error('shpping_fname')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="field-label">{{__('Last Name')}} *</div>
                            <div class="field-input">
                                @php
                                $slname = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $slname = Auth::user()->shpping_lname;
                                }
                                } else {
                                $slname = old('shpping_lname');
                                }
                                @endphp
                                <input type="text" name="shpping_lname" value="{{$slname}}">
                            </div>
                            @error('shpping_lname')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="field-label">{{__('Address')}} *</div>
                            <div class="field-input">
                                @php
                                $saddress = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $saddress = Auth::user()->shpping_address;
                                }
                                } else {
                                $saddress = old('shpping_address');
                                }
                                @endphp
                                <input type="text" name="shpping_address" value="{{$saddress}}">
                            </div>
                            @error('shpping_address')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <div class="field-label">{{__('Town / City')}} *</div>
                            <div class="field-input">
                                @php
                                $scity = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $scity = Auth::user()->shpping_city;
                                }
                                } else {
                                $scity = old('shpping_city');
                                }
                                @endphp
                                <input type="text" name="shpping_city" value="{{$scity}}">
                            </div>
                            @error('shpping_city')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="field-label">{{__('Contact Email')}} *</div>
                            <div class="field-input">
                                @php
                                $smail = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $smail = Auth::user()->shpping_email;
                                }
                                } else {
                                $smail = old('shpping_email');
                                }
                                @endphp
                                <input type="text" name="shpping_email" value="{{$smail}}">
                            </div>
                            @error('shpping_email')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="field-label">{{__('Phone')}} *</div>
                            <div class="field-input">
                                @php
                                $snumber = '';
                                if(empty(old())) {
                                if (Auth::check()) {
                                $snumber = Auth::user()->shpping_number;
                                }
                                } else {
                                $snumber = old('shpping_number');
                                }
                                @endphp
                                <input type="text" name="shpping_number" value="{{$snumber}}">
                            </div>
                            @error('shpping_number')
                            <p class="text-danger mt-2">{{convertUtf8($message)}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="bottom">
            <div class="container">
                <div class="row">
                    @if (!onlyDigitalItemsInCart() && count($shippings) > 0)
                    <div class="col-12 mb-5">
                        <div class="table">
                            <div class="shop-title-box">
                                <h3>{{__('Shipping Methods')}}</h3>
                            </div>
                            <table class="cart-table shipping-method">
                                <thead class="cart-header">
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('Method')}}</th>
                                        <th class="price">{{__('Cost')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shippings as $key => $charge)
                                    <tr>
                                        <td>
                                            <input type="radio" {{$key == 0 ? 'checked' : ''}} name="shipping_charge" {{$cart == null ? 'disabled' : ''}} data="{{$charge->charge}}" class="shipping-charge" value="{{$charge->id}}">
                                        </td>
                                        <td>
                                            <p class="mb-2"><strong>{{convertUtf8($charge->title)}}</strong></p>
                                            <p><small>{{convertUtf8($charge->text)}}</small></p>
                                        </td>
                                        <td>
                                            {{-- {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} --}}
                                            {{ ship_to_india() ? "₹" : "$" }}
                                            <span>{{ pesa($charge->charge) }}</span>
                                            {{-- {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}} --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="col-12">
                        <input style="visibility: hidden;" type="radio" checked name="shipping_charge" {{$cart == null ? 'disabled' : ''}} data="0" class="shipping-charge" value="0">
                    </div>
                    @endif
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="table">
                            <div class="shop-title-box">
                                <h3>{{__('Order Summary')}}</h3>
                            </div>
                            <table class="cart-table">
                                <thead class="cart-header">
                                    <tr>
                                        <th class="product-column">{{__('Product')}}</th>
                                        <th>&nbsp;</th>
                                        <th>{{__('Quantity')}}</th>
                                        <th class="price">{{__('Total')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total = 0;
                                    @endphp
                                    @if($cart)
                                    @foreach ($cart as $key => $item)
                                    <input type="hidden" name="product_id[]" value="{{$key}}">
                                    @php
                                    $total += $item['price'] * $item['qty'];
                                    $product = App\Product::findOrFail($key);

                                    @endphp
                                    <tr>
                                        <td colspan="2" class="product-column">
                                            <div class="column-box">
                                                <div class="product-title">
                                                    <a target="_blank" href="{{route('front.product.details',$product->slug)}}">
                                                        <h3 class="prod-title">{{convertUtf8($item['name'])}}</h3>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="qty">
                                            <input class="quantity-spinner" disabled type="text" value="{{$item['qty']}}" name="quantity">
                                        </td>
                                        <td class="price">
                                            {{-- {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} --}}
                                            {{ $product->symbol }}
                                            {{-- {{ pesa($item['qty'] * $item['price']) }} --}}
                                            {{ pesa($item['qty'] * $product->price) }}
                                            {{-- {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}} --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr class="text-center">
                                        <td colspan="4">{{__('Cart is empty')}}</td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="cart-total">
                            <div class="shop-title-box">
                                <h3>{{__('Order Total')}}</h3>
                            </div>

                            <div id="cartTotal">
                                <ul class="cart-total-table">
                                    <li class="clearfix">
                                        <span class="col col-title">{{__('Cart Total')}}</span>
                                        <span class="col">
                                            {{-- {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} --}}
                                            {{ ship_to_india() ? "₹" : "$" }}
                                            <span data="{{ pesa(cartTotal()) }}" class="subtotal">
                                                {{ pesa(cartTotal()) }}
                                            </span>
                                            {{-- {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}} --}}
                                        </span>
                                    </li>
                                    <li class="clearfix">
                                        <span class="col col-title">{{ __('Discount') }}
                                            <span class="text-success">(<i class="fas fa-minus"></i>)</span></span>
                                        <span class="col">
                                            {{-- {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }} --}}
                                            {{ ship_to_india() ? "₹" : "$" }}
                                            <span data="{{ pesa($discount) }}">{{ pesa($discount) }}</span>
                                            {{-- {{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }} --}}
                                        </span>

                                    </li>
                                    <li class="clearfix">
                                        <span class="col col-title">{{ __('Subtotal') }}</span>
                                        <span class="col">
                                            {{-- {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }} --}}
                                            {{ ship_to_india() ? "₹" : "$" }}
                                            <span data="{{ pesa(cartSubTotal()) }}" class="subtotal" id="subtotal">
                                                {{ pesa(cartSubTotal()) }}
                                            </span>
                                            {{-- {{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }} --}}
                                        </span>
                                    </li>


                                    @if (!onlyDigitalItemsInCart() && sizeof($shippings) > 0)
                                    @php
                                    $scharge = round($shippings[0]->charge,2);
                                    @endphp
                                    <li class="clearfix">
                                        <span class="col col-title">{{__('Shipping Charge')}}
                                            <span class="text-danger">(<i class="fas fa-plus"></i>)</span></span>
                                        <span class="col">
                                            {{-- {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} --}}
                                            {{ ship_to_india() ? "₹" : "$" }}
                                            <span data="{{ pesa($scharge) }}" class="shipping">
                                                {{ pesa($scharge) }}
                                            </span>
                                            {{-- {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}} --}}
                                        </span>
                                    </li>
                                    @else
                                    @php
                                    $scharge = 0;
                                    @endphp
                                    @endif

                                    <li class="clearfix">
                                        <span class="col col-title">{{ __('Tax') }}
                                            ({{$bex->tax}}%)
                                            <span class="text-danger">(<i class="fas fa-plus"></i>)</span>
                                        </span>
                                        <span class="col">
                                            {{-- {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }} --}}
                                            {{ ship_to_india() ? "₹" : "$" }}
                                            <span data-tax="{{ str_replace(',', '', pesa(tax())) }}" id="tax">
                                                {{ pesa(tax()) }}
                                            </span>
                                            {{-- {{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }} --}}
                                        </span>
                                    </li>

                                    <li class="clearfix">
                                        <span class="col col-title">{{__('Order Total')}}</span>
                                        <span class="col">
                                            {{-- {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} --}}
                                            {{ ship_to_india() ? "₹" : "$" }}
                                            <span data="{{ pesa(cartSubTotal() + $scharge + tax()) }}" class="grandTotal">
                                                {{ pesa(cartSubTotal() + $scharge + tax()) }}
                                            </span>
                                            {{-- {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}} --}}
                                        </span>
                                    </li>


                                </ul>
                            </div>

                            <div class="coupon mt-4">
                                <h4 class="mb-3">{{__('Coupon')}}</h4>
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control" name="coupon" value="">
                                    <button class="btn btn-primary base-bg border-0" type="button" onclick="applyCoupon();">{{__('Apply')}}</button>
                                </div>
                            </div>

                            <div class="payment-options">
                                <h4 class="mb-4">{{__('Pay Via')}}</h4>


                                @includeIf('front.product.payment-gateways')


                                <div class="placeorder-button text-left">
                                    <button {{$cart ? '' : 'disabled' }} class="main-btn" type="submit"><span class="btn-title">{{__('Place Order')}}</span></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<!--====== CHECKOUT PART ENDS ======-->
@endsection


@section('scripts')
<script src="https://js.stripe.com/v2/"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
@if (session()->has('unsuccess'))
<script>
    toastr["error"]("{{__(session('unsuccess'))}}");
</script>
@endif
<script>
    // apply coupon functionality starts
    function applyCoupon() {
        $.post(
            "{{route('front.coupon')}}", {
                coupon: $("input[name='coupon']").val(),
                _token: document.querySelector('meta[name=csrf-token]').getAttribute('content')
            },
            function(data) {
                console.log(data);
                if (data.status == 'success') {
                    toastr["success"](data.message);
                    $("input[name='coupon']").val('');
                    $("#cartTotal").load(location.href + " #cartTotal", function() {
                        let scharge = parseFloat($("input[name='shipping_charge']:checked").attr('data'));
                        let total = parseFloat($(".grandTotal").attr('data'));

                        $(".shipping").attr('data', scharge);
                        $(".shipping").text(scharge);

                        total += scharge;
                        $(".grandTotal").attr('data', total);
                        $(".grandTotal").text(total);
                    });
                } else {
                    toastr["error"](data.message);
                }
            }
        );
    }
    $("input[name='coupon']").on('keypress', function(e) {
        let code = e.which;
        if (code == 13) {
            e.preventDefault();
            applyCoupon();
        }
    });
    // apply coupon functionality ends

    $(document).on('click', '.shipping-charge', function() {
        let total = 0;
        let subtotal = 0;
        let grantotal = 0;
        let shipping = 0;

        subtotal = parseFloat($('.subtotal').attr('data'));
        grantotal = parseFloat($('.grandTotal').attr('data'));
        shipping = parseFloat($('.shipping').attr('data'));

        let shipCharge = parseFloat($(this).attr('data'));

        shipping = parseFloat(shipCharge);
        total = parseFloat(parseFloat(grantotal) + parseFloat(shipCharge));
        $('.shipping').text(shipping);
        $('.grandTotal').text(total);


    })

    $(document).ready(function() {
        $(".input-check").first().attr('checked', true);

        let tabid = $(".input-check:checked").data('tabid');

        $('#payment').attr('action', $(".input-check:checked").data('action'));

        showDetails(tabid);
    });

    // this function will decide which form to show...
    function showDetails(tabid) {

        $(".gateway-details").removeClass("d-flex");
        $(".gateway-details").addClass("d-none");
        $(".gateway-details input").attr('disabled', true);

        if ($("#tab-" + tabid).length > 0) {
            $("#tab-" + tabid + " input").removeAttr('disabled');
            $("#tab-" + tabid).removeClass("d-none");
            $("#tab-" + tabid).addClass("d-flex");
        }

        if (tabid == 'paystack') {
            $('#payment').prop('id', 'paystack');
        }

    }

    // on gateway change...
    $(document).on('click', '.input-check', function() {
        // change form action
        $('#payment').attr('action', $(this).data('action'));
        // show relevant form (if any)
        showDetails($(this).data('tabid'));
    });

    // after paystack form is submitted
    $(document).on('submit', '#paystack', function() {
        var val = $('#sub').val();
        if (val == 0) {
            var total = $(".grandTotal").text();
            var curr = "{{$bex->base_currency_text}}";
            total = Math.round(total);
            var handler = PaystackPop.setup({
                key: "{{ $paystack['key']}}",
                email: "{{ $paystack['email']}}",
                amount: total * 100,
                currency: curr,
                ref: '' + Math.floor((Math.random() * 1000000000) + 1),
                callback: function(response) {
                    $('#ref_id').val(response.reference);
                    $('#sub').val('1');
                    $('#paystack button[type="submit"]').click();
                },
                onClose: function() {
                    window.location.reload();
                }
            });
            handler.openIframe();
            return false;

        } else {
            return true;
        }
    });


    var cnstatus = false;
    var dateStatus = false;
    var cvcStatus = false;

    function validateCard(cn) {
        cnstatus = Stripe.card.validateCardNumber(cn);
        if (!cnstatus) {
            $("#errCard").html('Card number not valid<br>');
        } else {
            $("#errCard").html('');
        }
        //   btnStatusChange();


    }

    function validateCVC(cvc) {
        cvcStatus = Stripe.card.validateCVC(cvc);
        if (!cvcStatus) {
            $("#errCVC").html('CVC number not valid');
        } else {
            $("#errCVC").html('');
        }
        //   btnStatusChange();
    }

    function checkBillingAddress(value) {
        if (value == 'other') {
            $('.billing-form').removeClass('d-none');
        }
        else {
            $('.billing-form').addClass('d-none');
        }
    }
</script>
@endsection