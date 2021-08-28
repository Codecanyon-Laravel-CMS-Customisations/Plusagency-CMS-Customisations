<footer class="site-footer_v2">
    @if (!($bex->home_page_pagebuilder == 0 && $bs->top_footer_section == 0))
    <div class="space-top-3 bg-gray-850">
        <div class="pb-5 space-bottom-lg-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 mb-6 mb-lg-0">
                        <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1 text-white">{{__('Useful Links')}}</h4>
                        <ul class="list-unstyled mb-0">
                            @foreach ($ulinks as $key => $ulink)
                            <li class="h-white pb-2">
                                <a class="widgets-hover transition-3d-hover font-size-2 text-gray-450" href="{{$ulink->url}}">{{convertUtf8($ulink->name)}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-6 mb-6 mb-lg-0">
                        <div class="pb-lg-6">
                            <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1 text-white">Contact Us</h4>
                            <address class="font-size-2 mb-5">
                                @php
                                $addresses = explode(PHP_EOL, $bex->contact_addresses);
                                @endphp
                                <span class="text-gray-450">
                                    @foreach ($addresses as $address)
                                    {{$address}}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                    @endforeach
                                </span>
                            </address>
                            <div class="mb-4 h-white">
                                <a href="#" class="font-size-2 d-block text-gray-450 mb-1">
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
                                <a href="tel:+1246-345-0695" class="font-size-2 d-block text-gray-450">
                                    @php
                                        $phones = explode(',', $bex->contact_numbers);
                                       @endphp
                                       <span>
                                           @foreach ($phones as $phone)
                                           {{$phone}}
                                           @if (!$loop->last)
                                               ,
                                           @endif
                                           @endforeach
                                       </span>
                                </a>
                            </div>
                            <ul class="list-unstyled mb-0 d-flex">
                                <li class="h-white btn pl-0">
                                    <a class="text-gray-450" href="#">
                                        <span class="fab fa-instagram"></span>
                                    </a>
                                </li>
                                <li class="h-white btn">
                                    <a class="text-gray-450" href="#">
                                        <span class="fab fa-facebook-f"></span>
                                    </a>
                                </li>
                                <li class="h-white btn">
                                    <a class="text-gray-450" href="#">
                                        <span class="fab fa-youtube"></span>
                                    </a>
                                </li>
                                <li class="h-white btn">
                                    <a class="text-gray-450" href="#">
                                        <span class="fab fa-twitter"></span>
                                    </a>
                                </li>
                                <li class="h-white btn">
                                    <a class="text-gray-450" href="#">
                                        <span class="fab fa-pinterest"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 mb-6 mb-lg-0">
                        <!-- Newsletter -->
                        <div>
                            <div class="mb-5">
                                <h5 class="font-size-3 font-weight-medium text-white mb-2 mb-xl-5 pb-xl-1">{{__('Newsletter')}}
                                </h5>
                                <p class="text-gray-450 font-size-2">{{convertUtf8($bs->newsletter_text)}}</p>
                            </div>
                            <form id="footerSubscribeForm" action="{{route('front.subscribe')}}" method="post">
                                @csrf
                                <div class="input-group">
                                    <input type="email" class="form-control height-50 font-size-2 pl-4 border-0 rounded-left-pill" name="email" id="subscribeSrEmail" placeholder="Enter email" aria-label="Your email" aria-describedby="subscribeButton" required="" data-msg="Please enter a valid email address.">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary-green text-white px-3 py-2 font-size-4 border-0" id="subscribeButton">
                                            <span class="flaticon-send mx-1"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End  Newsletter -->
                    </div>
                </div>
            </div>
        </div>
        <div class="space-1 border-top border-gray-750">
            <div class="container">
                <div class="d-lg-flex text-center text-lg-left justify-content-between align-items-center">
                    <!-- Copyright -->
                    <p class="mb-4 mb-lg-0 font-size-2 text-gray-450">{!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}</p>
                    <!-- End Copyright -->

                    <div class="ml-auto d-lg-flex justify-content-xl-end align-items-center">
                        <!-- Select -->
                        <div class="dropdown bootstrap-select js-select dropdown-select ml-lg-4 mb-3 mb-md-0"><select class="js-select selectpicker dropdown-select ml-lg-4 mb-3 mb-md-0" data-style="text-white-60 bg-secondary-gray-800 px-4 py-2 rounded-lg height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true" tabindex="-98">
                            <option value="one" selected="">English (United States)</option>
                            <option value="two">Deutsch</option>
                            <option value="three">Français</option>
                            <option value="four">Español</option>
                        </select><button type="button" class="btn dropdown-toggle text-white-60 bg-secondary-gray-800 px-4 py-2 rounded-lg height-5 outline-none shadow-none form-control font-size-2" data-toggle="dropdown" role="button" title="English (United States)"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">English (United States)</div></div> </div></button><div class="dropdown-menu dropdown-menu-right" role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                        <!-- End Select -->
                        
                        <!-- Select -->
                        <div class="dropdown bootstrap-select js-select dropdown-select ml-md-3 fit-width"><select class="js-select selectpicker dropdown-select ml-md-3" data-style="text-white-60 bg-secondary-gray-800 px-4 py-2 rounded-lg height-5 outline-none shadow-none form-control font-size-2" data-width="fit" data-dropdown-align-right="true" tabindex="-98">
                            <option value="one" selected="">$ USD</option>
                            <option value="two">€ EUR</option>
                            <option value="three">₺ TL</option>
                            <option value="four">₽ RUB</option>
                        </select><button type="button" class="btn dropdown-toggle text-white-60 bg-secondary-gray-800 px-4 py-2 rounded-lg height-5 outline-none shadow-none form-control font-size-2" data-toggle="dropdown" role="button" title="$ USD"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">$ USD</div></div> </div></button><div class="dropdown-menu dropdown-menu-right" role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                        <!-- End Select -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</footer>