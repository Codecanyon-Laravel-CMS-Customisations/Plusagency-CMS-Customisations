<aside id="sidebarContent-wishlist" class="u-sidebar u-sidebar__lg u-unfold--css-animation u-unfold--hidden wishlist-sidebar" aria-labelledby="sidebarNavToggler-wishlist">
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
                    @if(isset($wish) && $wish != null)
                        @php
                            $cartTotal = 0;
                            $countitem = 0;
                            if($wish){
                            foreach($wish as $p){
                                $cartTotal += $p['price'] * $p['qty'];
                                $countitem += $p['qty'];
                            }
                        }
                        @endphp
                    @endif
                    <!-- Title -->
                        <header class="border-bottom px-4 px-md-6 py-4">
                            <h2 class="font-size-3 mb-0 d-flex align-items-center">
                                <i class="flaticon-heart mr-3 font-size-5"></i>
                                @php
                                    echo "My Wishlist (";
                                    try {
                                        echo is_array( session()->get('wishlist') ) ? count(session()->get('wishlist')) : '0';
                                    }
                                    catch (\Exception $e){ }
                                    echo ")";
                                @endphp
                            </h2>
                        </header>
                        <!-- End Title -->
                        @if(is_array( session()->get('wishlist') ) && count( session()->get('wishlist') ) >= 1)
                            @foreach ( session()->get('wishlist') as $id => $wish)
                                @php
                                    $product = App\Product::find($id);
                                    if(is_null($product)) continue;
                                @endphp
                                <div class="px-4 py-5 px-md-6 border-bottom">
                                    <div class="media">
                                        <a target="_blank" href="{{route('front.product.details', $product->slug)}}" class="d-block"><img src="@if($wish['photo']!=null){{$wish['photo']}}@else{{asset('https://via.placeholder.com/150')}}@endif" class="img-fluid" alt="image-description" width="150"></a>
                                        <div class="media-body ml-4d875">
                                            <h2 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                                <a href="{{route('front.product.details', $product->slug)}}" class="text-dark">{{convertUtf8($wish['name'])}}</a>
                                            </h2>
                                            <form class="cart d-block" method="post" enctype="multipart/form-data">
                                                <div class="price d-flex align-items-center font-weight-medium font-size-3 mt-3">
                                            <span class="woocommerce-Price-amount amount">
                                                <div class="product-quantity d-flex mb-35" id="quantity">
                                                <button type="button" id="sub" class="sub">-</button>
                                                <input type="text" class="cart_qty" id="1" value="{{$wish['qty']}}" />
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
                                                <a data-href="{{ route('wishlist.item.add', $product->id) }}"
                                                   class="btn btn-sm btn-dark border-0 rounded-0 py-2 px-5 single_add_to_cart_button button alt cart-btn wishlist-sidebar-link my-1"
                                                   style="color: #fff">Update wishlist</a>
                                            </form>
                                        </div>
                                        <div class="mt-3 ml-3">
                                            <a href="{{ route('wishlist.item.remove', $product->id) }}" class="text-dark"><i class="fas fa-times"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="px-4 mb-8 px-md-6 d-flex justify-content-around pb-2 pt-4">
                            <a href="{{route('wishlist.to.cart')}}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">Add To Cart</a>
                            <a href="{{route('front.wishlist')}}" class="btn px-5 py-3 rounded-0 btn-outline-dark mb-4">View Wishlist</a>
                            {{-- <button type="submit" class="btn btn-block py-4 rounded-0 btn-dark">Checkout</button> --}}
                        </div>
                    </div>
                </div>
                <!-- End Content -->
            </div>
        </div>
    </div>
</aside>
<script>
    !function(t) {
        "use strict";
        jQuery(document).ready(function(t) {
            t(".wishlist-sidebar .wishlist-sidebar-link").click(function() {
                let e = t(this).attr("data-href")+'/'+t(this).parents('form').find('.cart_qty').val();
                console.log(e);
                t.get(e, function(e) {
                    e.message ? (toastr.success(e.message)) : (toastr.error(e.error))
                })
            })
        })
    }(jQuery);

</script>
