<div class="row">
    <div class="col-12">
        @if (!$product->digital)
            <a href="{{ preg_replace("/\/$/", "", $be->digital_resource_link) }}/my-account" class="btn btn-dark border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link" style="color: #fff" data-toggle="modal" data-target="#productInquiryModal">
                {{ $be->digital_resource_text }}
            </a>
        @endif
        {{--                                    <a href="{{ route('product.inquiries.form',$product->id) }}" data-href="{{ route('product.inquiries.form',$product->id) }}" class="btn btn-dark border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link" style="color: #fff">{{ $be->offline_resource_text }}</a>--}}
        <button type="button" class="btn btn-dark border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link" style="color: #fff" data-toggle="modal" data-target="#productInquiryModal">
            {{ $be->offline_resource_text }}
        </button>
        <div class="modal fade" id="productInquiryModal" tabindex="-1" aria-labelledby="productInquiryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productInquiryModalLabel">{{convertUtf8($bs->contact_form_subtitle)}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('product.inquiries.bulk-inquiry')}}" class="contact-form" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="productsSelect">{{__('Add More Products')}}</label>
                                <select id="productsSelect" name="products[]" class="form-control select2" multiple="multiple" data-placeholder="{{__('Add More Products')}}" aria-describedby="productsHelp" style="width: 100%"></select>
                                @if ($errors->has('products'))
                                    <small id="productsHelp" class="form-text text-danger">{{$errors->first('products')}}</small>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" name="name" type="text" placeholder="{{__('Name')}}" required>
                                        @if ($errors->has('name'))
                                            <small id="nameHelp" class="form-text text-danger">{{$errors->first('name')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control" name="email" type="email" placeholder="{{__('Email')}}" required>
                                        @if ($errors->has('email'))
                                            <small id="emailHelp" class="form-text text-danger">{{$errors->first('email')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input name="subject" class="form-control" type="text" placeholder="{{__('Subject')}}" required value="{{ old('subject', 'Inquiry of an offline product titled \''.$product->title.'\'') }}">
                                        @if ($errors->has('subject'))
                                            <small id="subjectHelp" class="form-text text-danger">{{$errors->first('subject')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" id="comment" cols="30" rows="10" placeholder="{{__('Comment')}}" required></textarea>
                                        @if ($errors->has('message'))
                                            <small id="messageHelp" class="form-text text-danger">{{$errors->first('message')}}</small>
                                        @endif
                                    </div>
                                </div>
                                @if ($bs->is_recaptcha == 1)
                                    <div class="col-md-12 my-2">
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
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        {{--                                                        <button type="button" class="btn btn-secondary py-3" data-dismiss="modal">Close</button>--}}
                        <button type="button" class="btn btn-dark submit-button border-0 rounded-0 p-3 min-width-250 ml-md-4 single_add_to_cart_button button alt cart-btn cart-link" style="color: #fff">{{__('Submit')}}</button>
                        {{--                                                        <input class="py-3" type="submit" value="{{__('Submit')}}">--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#productInquiryModal .submit-button').on('click', function (e) {
        e.preventDefault();
        $('#productInquiryModal form').submit();
    });
</script>
