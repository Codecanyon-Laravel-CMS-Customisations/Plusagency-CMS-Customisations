<footer>
    <div class="bg-gray-200 border-top space-top-1 space-top-lg-3">
        @if (!($bex->home_page_pagebuilder == 0 && $bs->top_footer_section == 0))
        <div class="border-bottom pb-5 space-bottom-lg-3">
            <div class="container">
                <!-- Newsletter -->
                <div class="space-bottom-2 space-bottom-md-3">
                    <div class="text-center mb-5">
                        <h5 class="font-size-7 font-weight-medium">{{__('Newsletter')}}</h5>
                        <p class="text-gray-700">{{convertUtf8($bs->newsletter_text)}}</p>
                    </div>
                    <form id="footerSubscribeForm" action="{{route('front.subscribe')}}" method="post">
                        @csrf
                        <!-- Form Group -->
                        <div class="form-row justify-content-center">
                            <div class="col-md-5 mb-3 mb-md-2">
                                <div class="js-form-message">
                                    <div class="input-group">
                                        <input type="email" class="form-control px-5 height-60 border-dark" name="email" value="" placeholder="{{__('Enter Email Address')}}" />
                                           <p id="erremail" class="text-danger mb-0 err-email"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 ml-md-2">
                                <button type="submit" class="btn btn-dark rounded-0 btn-wide py-3 font-weight-medium">{{ __('Subscribe') }}      
                                </button>
                            </div>
                        </div>
                        <!-- End Form Group -->
                    </form>
                </div>
                <!-- End  Newsletter -->
                <div class="row">
                    <div class="col-lg-6 mb-6 mb-lg-0">
                        <div class="pb-6">
                            <a href="{{route('front.index')}}" class="d-inline-block mb-5">
                                <img class="lazy" data-src="{{asset('assets/front/img/'.$bs->footer_logo)}}" alt="">
                            </a>
                            <address class="font-size-2 mb-5">
                                <span class="mb-2 font-weight-normal text-dark">
                                    @php
                                    $addresses = explode(PHP_EOL, $bex->contact_addresses);
                                    @endphp
                                    <span>
                                        @foreach ($addresses as $address)
                                        {{$address}}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                        @endforeach
                                    </span>
                                </span>
                            </address>
                            <div class="mb-4">
                                <a href="#" class="font-size-2 d-block link-black-100 mb-1">
                                    @php
                                     $mails = explode(',', $bex->contact_mails);
                                    @endphp
                                    <span>
                                        @foreach ($mails as $mail)
                                        {{$mail}}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                        @endforeach
                                    </span>
                                </a>
                                <a href="#" class="font-size-2 d-block link-black-100">@php
                                    $phones = explode(',', $bex->contact_numbers);
                                   @endphp
                                   <span>
                                       @foreach ($phones as $phone)
                                       {{$phone}}
                                       @if (!$loop->last)
                                           ,
                                       @endif
                                       @endforeach
                                   </span></a>
                            </div>
                            <ul class="list-unstyled mb-0 d-flex">
                                <li class="btn pl-0">
                                    <a class="link-black-100" href="#">
                                        <span class="fab fa-instagram"></span>
                                    </a>
                                </li>
                                <li class="btn">
                                    <a class="link-black-100" href="#">
                                        <span class="fab fa-facebook-f"></span>
                                    </a>
                                </li>
                                <li class="btn">
                                    <a class="link-black-100" href="#">
                                        <span class="fab fa-youtube"></span>
                                    </a>
                                </li>
                                <li class="btn">
                                    <a class="link-black-100" href="#">
                                        <span class="fab fa-twitter"></span>
                                    </a>
                                </li>
                                <li class="btn">
                                    <a class="link-black-100" href="#">
                                        <span class="fab fa-pinterest"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-6 mb-lg-0">
                        <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1">About</h4>
                        <p>
                            @if (strlen(convertUtf8($bs->footer_text)) > 194)
                               {{substr(convertUtf8($bs->footer_text), 0, 194)}}<span style="display: none;">{{substr(convertUtf8($bs->footer_text), 194)}}</span>
                               <a href="#" class="see-more">{{__('see more')}}...</a>
                            @else
                               {{convertUtf8($bs->footer_text)}}
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-3 mb-6 mb-lg-0">
                        <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1">{{__('Useful Links')}}</h4>
                        <ul class="list-unstyled mb-0">
                            @foreach ($ulinks as $key => $ulink)
                            <li class="pb-2">
                                <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="{{$ulink->url}}">{{convertUtf8($ulink->name)}}</a>
                            </li>
                            @endforeach
                                
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="space-1">
            <div class="container">
                <div class="d-lg-flex text-center text-lg-left justify-content-between align-items-center">
                    @if (!($bex->home_page_pagebuilder == 0 && $bs->copyright_section == 0))
                    <!-- Copyright -->
                    <p class="mb-3 mb-lg-0 font-size-2"> {!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}</p>
                    <!-- End Copyright -->
                    @endif

                    <div class="ml-auto d-lg-flex align-items-center">
                        <div class="mb-4 mb-lg-0 mr-5">
                           <img class="img-fluid" src="{{ asset('assets/bookworm/img/324x38/img1.png') }}" alt="Image-Description">
                        </div>

                        <!-- Select -->
                        <select class="js-select selectpicker dropdown-select mb-3 mb-lg-0"
                            data-style="border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2"
                            data-dropdown-align-right="true">
                            <option value="one" selected>English (United States)</option>
                            <option value="two">Deutsch</option>
                            <option value="three">Français</option>
                            <option value="four">Español</option>
                        </select>
                        <!-- End Select -->

                        <!-- Select -->
                        <select class="js-select selectpicker dropdown-select ml-md-3"
                            data-style="border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2"
                            data-dropdown-align-right="true"
                            data-width="fit">
                            <option value="one" selected>$ USD</option>
                            <option value="two">€ EUR</option>
                            <option value="three">₺ TL</option>
                            <option value="four">₽ RUB</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>