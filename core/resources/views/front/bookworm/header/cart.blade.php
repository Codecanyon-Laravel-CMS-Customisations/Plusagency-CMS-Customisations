<style>
    .btn-disable
    {
        cursor: not-allowed;
        pointer-events: none;

        /*Button disabled - CSS color class*/
        color: #c0c0c0;
        background-color: #ffffff;
    }

    .cus-pos {
        max-width: 4.5rem !important; 
        position: relative !important;
        float: left !important;
    }
</style>

<aside id="sidebarContent1" class="u-sidebar u-sidebar__xl cart-sidebar" aria-labelledby="sidebarNavToggler1">
    <div class="u-sidebar__scroller js-scrollbar">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">
                <!-- Toggle Button -->
                <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                    <button type="button" class="close ml-auto"
                        aria-controls="sidebarContent1"
                        aria-haspopup="true"
                        aria-expanded="false"
                        data-unfold-event="click"
                        data-unfold-hide-on-scroll="false"
                        data-unfold-target="#sidebarContent1"
                        data-unfold-type="css-animation"
                        data-unfold-animation-in="fadeInRight"
                        data-unfold-animation-out="fadeOutRight"
                        data-unfold-duration="500">
                        <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                    </button>
                </div>
                <!-- End Toggle Button -->

                <!-- Content -->
                <div class="u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">
                        @if(isset($cart) && $cart != null)
                            @php
                                $cartTotal = 0;
                                $countitem = 0;
                                if($cart){
                                foreach($cart as $p){
                                    $cartTotal += $p['price'] * $p['qty'];
                                    $countitem += $p['qty'];
                                }
                            }
                            @endphp
                        @endif
                        <!-- Title -->
                        <header class="border-bottom px-4 px-md-6 py-4">
                            <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-icon-126515 mr-3 font-size-5"></i>Your cart (<span class="cart-items">{{ isset($cart) && $cart ? $countitem : 0 }}</span>)</h2>
                        </header>
                        <!-- End Title -->
                        @if(isset($cart) && $cart != null)
                        @foreach ($cart as $id => $item)
                            @php
                                $product = App\Product::findOrFail($id);
                            @endphp
                            <div class="px-4 py-5 px-md-6 border-bottom">
                                <div class="media">
                                    <a target="_blank" href="{{route('front.product.details',$product->slug)}}" class="d-block">
                                        <img src="@if($item['photo']!=null){{$item['photo']}}@else{{asset('https://via.placeholder.com/150')}}@endif" class="img-fluid cus-pos" alt="image-description" width="150"></a>
                                    <!-- <div class="media-body ml-4d875"> -->
                                    <div class="media-body ml-1">
                                        {{-- <div class="text-primary text-uppercase font-size-1 mb-1 text-truncate"><a href="#">Hard Cover</a></div> --}}
                                        <h2 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 mt-3">
                                            <a href="{{route('front.product.details', $product->slug)}}" class="text-dark">{{convertUtf8($item['name'])}}</a>
                                        </h2>
                                        <form class="form-{{$product->id}} cart d-block" method="post" enctype="multipart/form-data">
                                            <div class="price d-flex align-items-center font-weight-medium font-size-3 mt-3">
                                            <span class="woocommerce-Price-amount amount">
                                                <div class="product-quantity d-flex mb-35" id="quantity">
                                                <button type="button" id="sub" class="sub">-</button>
                                                <input type="text" class="quantity-{{$product->id}} cart_qty cart-value" id="1" value="{{$item['qty']}}" />
                                                <button type="button" id="add" class="add">+</button>
                                                <input type="hidden" value="{{$id}}" class="product_id">
                                                </div>
                                            </span>
                                                <span class="woocommerce-Price-amount amount d-inline-block ml-3">
                                                {{ $product->symbol }}
                                                <span> {{ number_format($product->price, 0) }}</span>
                                            </span>
                                            </div>
                                            <br/>
                                            <!-- Update button removed
                                            <a id="{{ $product->id }}" data-href="{{ route('singleCartItem.update') }}"
                                               class="btn btn-sm btn-dark border-0 rounded-0 py-2 px-5 single_add_to_cart_button button alt cart-btn cart-sidebar-link my-1"
                                               style="color: #fff">Update cart</a> 
                                            -->
                                        </form>
                                    </div>
                                    <div class="mt-3 ml-3">
                                        <a href="{{ route('cart.item.remove', $product->id) }}" class="text-dark"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif

                        {{-- <div class="px-4 py-5 px-md-6 d-flex justify-content-between align-items-center font-size-3">
                            <h4 class="mb-0 font-size-3">Subtotal:</h4>
                            <div class="font-weight-medium">{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}} <span>{{$item['qty'] * $item['price']}}</span> {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</div>
                        </div> --}}

                        <div class="px-4 mb-8 px-md-6">
                            <a href="{{route('front.cart')}}" class="btn btn-block py-4 rounded-0 btn-outline-dark mb-4">View Cart</a>
                            <a href="{{route('front.checkout')}}" type="submit" class="btn btn-block py-4 rounded-0 btn-dark">Checkout</a>
                        </div>
                    </div>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </div>
</aside>
<script>
    // previous code commented 
    // !function(t) {
    //     "use strict";
    //     jQuery(document).ready(function(t) {
    //         t(".cart-sidebar .cart-sidebar-link").click(function() {
    //             let e = t(this).attr("data-href");
    //             console.log(e);
    //             let a = t(".cart-amount").val();
    //             a > 1 ? t.get(e + ",,," + a, function(e) {
    //                 e.message ? (toastr.success(e.message),
    //                     t(".cart-amount").val(1),
    //                     t("#cartIconWrapper").load(location.href + " #cartIconWrapper")) : (toastr.error(e.error),
    //                     t(".cart-amount").val(1),
    //                     t("#cartIconWrapper").load(location.href + " #cartIconWrapper"))
    //             }) : t.get(e, function(e) {
    //                 e.message ? (toastr.success(e.message),
    //                     t("#cartIconWrapper").load(location.href + " #cartIconWrapper")) : (toastr.error(e.error),
    //                     t("#cartIconWrapper").load(location.href + " #cartIconWrapper"))
    //             })
    //         })
    //     })
    // }(jQuery);

    !function(t) {
        "use strict";
        jQuery(document).ready(function(t) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            // on update button click
            t(".cart-sidebar .cart-sidebar-link").click(function() {
                let e = t(this).attr("data-href");
                console.log(e);


                let a = t(".cart-amount").val();

                var product_id = this.id;

                var quantity = $('.quantity-'+this.id+'').val();

                console.log("quantity form ", quantity);

                $.ajax({
                    type:'POST',
                    url:"{{ route('singleCartItem.update') }}",
                    data:{
                        product_id: this.id,
                        quantity:quantity
                    },
                    success:function (a) {
                        if (console.log(a), a.message) {

                            // updating count items for carts
                            $('.cart-items').text(a.count);
                            $(".quantity-"+product_id).val(quantity);
                            console.log("amount ssss ", a)

                            $(".sub-total-"+product_id).text(a.sub_total);

                            let r = [];
                            t(".cart_price span").each(function () {
                                r.push(parseFloat(t(this).text()))
                            }),
                            // removed toast message 
                            // toastr.success(a.message), 
                            a.count && (t(".cart-item-view").text(a.count), t(".cart-total-view").text(("left" == position ? symbol + " " : "") + a.total + ("right" == position ? " " + symbol : ""))), t("#cartIconWrapper").load(location.href + " #cartIconWrapper")
                        } else toastr.error(a.error)
                    }
                });
            })


            // on subtract(-) icon click
            t(".cart-sidebar .sub").click(function() {
                // disable add sub buttons
                enabledisableAddSubBtns("disable");

                let e = t(".cart-sidebar-link").attr("data-href");
                console.log(e);


                let a = t(".cart-amount").val();

                var product_id = this.nextElementSibling.nextElementSibling.nextElementSibling.value;

                var quantity = $('.quantity-'+product_id+'').val();

                console.log("quantity form ", quantity);

                $.ajax({
                    type:'POST',
                    url:"{{ route('singleCartItem.update') }}",
                    data:{
                        product_id: product_id,
                        quantity:quantity
                    },
                    success:function (a) {
                        if (console.log(a), a.message) {
                            // updating count items for carts
                            $('.cart-items').text(a.count);
                            $(".quantity-"+product_id).val(quantity);
                            console.log("amount ssss ", a)

                            $(".sub-total-"+product_id).text(a.sub_total);

                            let r = [];
                            t(".cart_price span").each(function () {
                                r.push(parseFloat(t(this).text()))
                            }), 
                            // toastr.success(a.message), 
                            a.count && (t(".cart-item-view").text(a.count), t(".cart-total-view").text(("left" == position ? symbol + " " : "") + a.total + ("right" == position ? " " + symbol : ""))), t("#cartIconWrapper").load(location.href + " #cartIconWrapper")
                            
                        } else toastr.error(a.error)


                        // disable add sub buttons
                        enabledisableAddSubBtns("enable");
                    }
                });
            })

            // on add(+) icon click
            t(".cart-sidebar .add").click(function() {

                
                enabledisableAddSubBtns("disable");

                let e = t(".cart-sidebar-link").attr("data-href");
                console.log(e);


                let a = t(".cart-amount").val();

                var product_id = this.nextElementSibling.value;


                var quantity = $('.quantity-'+product_id+'').val();

                console.log("quantity form ", quantity);    

                $.ajax({
                    type:'POST',
                    url:"{{ route('singleCartItem.update') }}",
                    data:{
                        product_id: product_id,
                        quantity:quantity
                    },
                    success:function (a) {

                        if (console.log(a), a.message) {
                            console.log("count ", a.count)
                            // updating count items for carts
                            $('.cart-items').text(a.count);
                            $(".quantity-"+product_id).val(quantity);
                            console.log("amount ssss ", a)

                            $(".sub-total-"+product_id).text(a.sub_total);

                            let r = [];
                            t(".cart_price span").each(function () {
                                r.push(parseFloat(t(this).text()))
                            }), 
                            // toastr.success(a.message), 
                            a.count && (t(".cart-item-view").text(a.count), t(".cart-total-view").text(("left" == position ? symbol + " " : "") + a.total + ("right" == position ? " " + symbol : ""))), t("#cartIconWrapper").load(location.href + " #cartIconWrapper")

                        } else toastr.error(a.error)


                        // remove class disable
                        enabledisableAddSubBtns("enable");
                    }
                });
            })


            // on input cart quantity change
            t(".cart-sidebar .cart_qty").blur(function() {

                
                enabledisableAddSubBtns("disable");

                let e = t(".cart-sidebar-link").attr("data-href");
                console.log(e);


                let a = t(".cart-amount").val();

                var product_id = this.nextElementSibling.nextElementSibling.value;
                console.log("product_id", product_id);

                var quantity = $('.quantity-'+product_id+'').val();

                console.log("quantity form ", quantity);    

                $.ajax({
                    type:'POST',
                    url:"{{ route('singleCartItem.update') }}",
                    data:{
                        product_id: product_id,
                        quantity:quantity
                    },
                    success:function (a) {

                        if (console.log(a), a.message) {
                            console.log("count ", a.count)
                            // updating count items for carts
                            $('.cart-items').text(a.count);
                            $(".quantity-"+product_id).val(quantity);
                            console.log("amount ssss ", a)

                            $(".sub-total-"+product_id).text(a.sub_total);

                            let r = [];
                            t(".cart_price span").each(function () {
                                r.push(parseFloat(t(this).text()))
                            }), 
                            // toastr.success(a.message), 
                            a.count && (t(".cart-item-view").text(a.count), t(".cart-total-view").text(("left" == position ? symbol + " " : "") + a.total + ("right" == position ? " " + symbol : ""))), t("#cartIconWrapper").load(location.href + " #cartIconWrapper")

                        } else toastr.error(a.error)


                        // remove class disable
                        enabledisableAddSubBtns("enable");
                    }
                });
            })
            
        })
    }(jQuery);

    function enabledisableAddSubBtns(param) {
        const btnsAdd = document.getElementsByClassName("add");
        const btnsSub = document.getElementsByClassName("sub");

        if ( param == "disable" ) {
            for (var i = 0; i < btnsAdd.length; i++) {
                btnsAdd[i].classList.add("btn-disable");
            }

            for (var i = 0; i < btnsSub.length; i++) {
                btnsSub[i].classList.add("btn-disable");
            }
        }
        else if( param == "enable" ) {
            for (var i = 0; i < btnsAdd.length; i++) {
                btnsAdd[i].classList.remove("btn-disable");
            }

            for (var i = 0; i < btnsSub.length; i++) {
                btnsSub[i].classList.remove("btn-disable");
            }
        }
        else {
            console.log(" please provide valid attributes to the function: enabledisableAddSubBtns")
        }
    }

</script>
<!-- End Cart Sidebar Navigation -->
