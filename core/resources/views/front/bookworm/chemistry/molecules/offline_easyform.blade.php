<div class="row">
    <div class="col-12">
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
                        <div class="row">
                            <div class="col-12">
                                <!-- Easy Forms -->
                                <link href="https://forms.upwork-plus.test/static_files/css/form.popup.min.css" rel="stylesheet" type="text/css">
                                <style>
                                    .ef-modal {
                                        background: rgba(0, 0, 0, 0.75) !important; /* Overlay color */
                                    }
                                    .ef-modal-box {
                                        margin: 60px auto !important; /* Pop-Up margin */
                                        padding: 20px !important; /* Pop-Up pading */
                                        width: 60% !important; /* Pop-Up width */
                                        border-radius: 10px !important; /* Pop-Up radius */
                                        background: rgb(255, 255, 255) !important; /* Pop-Up background */

                                        /** Animation duration **/
                                        -webkit-transition: all 0.6s !important;
                                        -moz-transition: all 0.6s !important;
                                        -o-transition: all 0.6s !important;
                                        transition: all 0.6s !important;
                                    }
                                </style>
                                <div class="ef-btn-wrapper ef-btn-wrapper-1">
                                    <button id="ef-button-1" class="ef-button ef-button-1 ef-button-default ef-button-inline-placement">Open Pop-Up Form</button>
                                </div>
                                <div id="ef-content-1" class="ef-content-wrapper">
                                    <div id="c1" class="ef-content">
                                        Fill out my <a href="https://forms.upwork-plus.test/app/form?id=2lyEsw">online form</a>.
                                    </div>
                                    <script type="text/javascript">
                                        (function(d, t) {
                                            var s = d.createElement(t), options = {
                                                'id': '2lyEsw',
                                                'container': 'c1',
                                                'height': '644px',
                                                'form': '//forms.upwork-plus.test/app/embed'
                                            };
                                            s.type= 'text/javascript';
                                            s.src = '//forms.upwork-plus.test/static_files/js/form.widget.js';
                                            s.onload = s.onreadystatechange = function() {
                                                var rs = this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return;
                                                try { (new EasyForms()).initialize(options).display() } catch (e) { }
                                            };
                                            var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);
                                        })(document, 'script');
                                    </script>
                                </div>
                                <script src="//forms.upwork-plus.test/static_files/js/form.popup.min.js"></script>
                                <script type="text/javascript">
                                    var modal1 = new EasyForms.Modal({
                                        autoOpen: false,
                                        cssClass: ['ef-effect-fade-in']
                                    });
                                    var btn1 = document.querySelector('.ef-button-1');
                                    btn1.addEventListener('click', function(){
                                        modal1.open();
                                    });
                                    modal1.setContent(document.getElementById('ef-content-1'));
                                </script>
                                <!-- End Easy Forms -->
                            </div>
                        </div>
                        <form action="{{route('product.inquiries.store', $product->id)}}" class="contact-form" method="POST">
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
    $('.submit-button').on('click', function (e) {
        e.preventDefault();
        $('#productInquiryModal form').submit();
    });
</script>



