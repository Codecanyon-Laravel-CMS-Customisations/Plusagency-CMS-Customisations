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
