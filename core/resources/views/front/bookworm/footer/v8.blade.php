<footer class="site-footer_v7">
    <div class="space-1 space-lg-3 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="mb-5 mb-lg-0">
                        <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1 text-gray-500">Store</h4>
                        <address class="font-size-2 mb-5">
                            <span class="mb-2 font-weight-normal text-white">
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
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="mb-5 mb-lg-0">
                        <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1 text-gray-500">Contact</h4>
                        <div class="mb-4">
                            <a href="#" class="font-size-2 d-block mb-1 text-white">
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
                            <a href="#" class="font-size-2 d-block text-white">
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
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <div class="mb-5 mb-lg-0">
                        <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1 text-gray-500">Follow</h4>
                        <ul class="list-unstyled mb-0 d-flex">
                            <li class="btn pl-0">
                                <a class="text-white" href="#">
                                    <span class="fab fa-instagram"></span>
                                </a>
                            </li>
                            <li class="btn">
                                <a class="text-white" href="#">
                                    <span class="fab fa-facebook-f"></span>
                                </a>
                            </li>
                            <li class="btn">
                                <a class="text-white" href="#">
                                    <span class="fab fa-youtube"></span>
                                </a>
                            </li>
                            <li class="btn">
                                <a class="text-white" href="#">
                                    <span class="fab fa-twitter"></span>
                                </a>
                            </li>
                            <li class="btn">
                                <a class="text-white" href="#">
                                    <span class="fab fa-pinterest"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Newsletter -->
                    <div class="pl-lg-7">
                        <div class="mb-5">
                            <h5 class="font-size-3 font-weight-medium text-gray-500 mb-2 mb-xl-5 pb-xl-1">Join Our Newsletter
                            </h5>
                        </div>
                        <form id="footerSubscribeForm" action="{{route('front.subscribe')}}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="email" class="form-control placeholder-color-2 py-4d75 font-size-2 pl-4 border-0 rounded-0 bg-dark" name="email" id="subscribeSrEmail" placeholder="Enter email" aria-label="Your email" aria-describedby="subscribeButton" required="" data-msg="Please enter a valid email address.">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-white bg-white px-3 font-size-4 border-0 rounded-0" id="subscribeButton">
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
    <div class="py-3 bg-black">
        <div class="container py-1">
            <div class="d-md-flex text-center text-md-left justify-content-between align-items-center">
                <!-- Copyright -->
                <p class="mb-3 mb-lg-0 font-size-2 text-gray-500">{!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}</p>
                <!-- End Copyright -->

                <div class="d-md-flex justify-content-md-end align-items-center">
                    <!-- Select -->
                    <div class="dropdown bootstrap-select js-select dropdown-select"><select class="js-select selectpicker dropdown-select" data-style="bg-transparent border-0 text-gray-500 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true" tabindex="-98">
                        <option value="one" selected="">English (United States)</option>
                        <option value="two">Deutsch</option>
                        <option value="three">Français</option>
                        <option value="four">Español</option>
                    </select><button type="button" class="btn dropdown-toggle bg-transparent border-0 text-gray-500 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-toggle="dropdown" role="button" title="English (United States)"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">English (United States)</div></div> </div></button><div class="dropdown-menu dropdown-menu-right" role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                    <!-- End Select -->

                    <!-- Select -->
                    <div class="dropdown bootstrap-select js-select dropdown-select ml-md-3 fit-width"><select class="js-select selectpicker dropdown-select ml-md-3" data-style="bg-transparent border-0 text-gray-500 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true" data-width="fit" tabindex="-98">
                        <option value="one" selected="">$ USD</option>
                        <option value="two">€ EUR</option>
                        <option value="three">₺ TL</option>
                        <option value="four">₽ RUB</option>
                    </select><button type="button" class="btn dropdown-toggle bg-transparent border-0 text-gray-500 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-toggle="dropdown" role="button" title="$ USD"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">$ USD</div></div> </div></button><div class="dropdown-menu dropdown-menu-right" role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                    <!-- End Select -->
                </div>
            </div>
        </div>
    </div>
</footer>