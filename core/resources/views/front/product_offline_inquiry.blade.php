@extends("front.$version.layout")

{{--@section('pagename')--}}
{{--    - {{__('Contact Us')}}--}}
{{--@endsection--}}

@section('meta-keywords', "$be->contact_meta_keywords")
@section('meta-description', "$be->contact_meta_description")

@section('breadcrumb-title', $bs->contact_title)
@section('breadcrumb-subtitle', $bs->contact_subtitle)
@section('breadcrumb-link', __('Contact Us'))

@section('content')


    <!--    contact form and map start   -->
    <div class="contact-form-section pt-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    {{--                    <span class="section-title">{{convertUtf8($bs->contact_form_title)}}</span>--}}
                    <h2 class="section-summary">{{convertUtf8($bs->contact_form_subtitle)}}</h2>
{{--                </div>--}}
{{--                <div class="col-lg-7">--}}
                    {{--                    <span class="section-title">{{convertUtf8($bs->contact_form_title)}}</span>--}}
                    <form action="{{route('product.inquiries.store', $product->id)}}" class="contact-form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-element">
                                    <label for="">{{__('Add More Products')}}</label>
                                    <select name="products[]" class="form-control select2" multiple="multiple" data-placeholder="{{__('Add More Products')}}"></select>
                                </div>
                                @if ($errors->has('name'))
                                    <p class="text-danger mb-0">{{$errors->first('name')}}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-element">
                                    <input name="name" type="text" placeholder="{{__('Name')}}" required>
                                </div>
                                @if ($errors->has('name'))
                                    <p class="text-danger mb-0">{{$errors->first('name')}}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-element">
                                    <input name="email" type="email" placeholder="{{__('Email')}}" required>
                                </div>
                                @if ($errors->has('email'))
                                    <p class="text-danger mb-0">{{$errors->first('email')}}</p>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="form-element">
                                    <input name="subject" type="text" placeholder="{{__('Subject')}}" required value="{{ old('subject', 'Inquiry of an offline product titled \''.$product->title.'\'') }}">
                                </div>
                                @if ($errors->has('subject'))
                                    <p class="text-danger mb-0">{{$errors->first('subject')}}</p>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="form-element">
                                    <textarea name="message" id="comment" cols="30" rows="10" placeholder="{{__('Comment')}}" required></textarea>
                                </div>
                                @if ($errors->has('message'))
                                    <p class="text-danger mb-0">{{$errors->first('message')}}</p>
                                @endif
                            </div>
                            @if ($bs->is_recaptcha == 1)
                                <div class="col-lg-12 mb-4">
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        @php
                                            $errmsg = $errors->first('g-recaptcha-response');
                                        @endphp
                                        <p class="text-danger mb-0">{{__("$errmsg")}}</p>
                                    @endif
                                </div>
                            @endif

                            <div class="col-md-12">
                                <div class="form-element no-margin">
                                    <input type="submit" value="{{__('Submit')}}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-5 woocommerce-product-gallery woocommerce-product-gallery--with-images images">
		        <figure class="woocommerce-product-gallery__wrapper pt-8 mb-0">
		            <div class="js-slick-carousel u-slick"
		            data-pagi-classes="text-center u-slick__pagination my-4">
		            @foreach ($product->product_images as $image)
		                <div class="js-slide">
		                    <img src="{{trim($image->image)}}" alt="Image Description" class="mx-auto img-fluid" width="300">
		                </div>
		                @endforeach
		            </div>
		        </figure>
		    </div>
            </div>
        </div>
    </div>
    <!--    contact form and map end   -->
@endsection
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            @php
                $products   = \App\Product::query()
                ->orderBy('title', 'ASC')
                ->get()
                ->each(function($query) use($product){
                    if($product->id == $query->id)
                    {
                        $query->selected = true;
                        return $query;
                    }
                    else if(session()->has('product_ids'))
                    {
                        $product_ids    = (Array)session('product_ids');
                        if(in_array($query->id, $product_ids))
                        {
                            $query->selected = true;
                            return $query;
                        }
                    }
                });//->pluck('title', 'current_price', 'id');
                echo "var productsArrayData = ".json_encode($products).";";
            @endphp

            var data = $.map(productsArrayData, function (obj) {
                obj.text = obj.text || obj.title; // replace name with the property used for the text

                return obj;
            });

            $('#productInquiryModal .select2').select2({
                data: data,
                dropdownParent: $('#productInquiryModal'),
                placeholder: "{{__('Add More Products')}}",
                templateResult: formatProduct
            });
        });

        function formatProduct (product) {
            if (!product.id) {
                return product.text;
            }
            var $product = $(
                '<span><img src="' + product.feature_image + '" class="img-flag" style="max-width: 50px;max-height: 40px;"/> ' + product.text + '</span>'
            );
            return $product;
        };
    </script>
@endsection
