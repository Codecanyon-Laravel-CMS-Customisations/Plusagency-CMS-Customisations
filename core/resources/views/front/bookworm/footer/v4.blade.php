<footer class="site-footer_v4">
    <div class="space-top-3 bg-dark-1 border-top border-gray-710">
        <div class="pb-5 space-bottom-lg-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="pb-6 pb-lg-0">
                            <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1 text-white">Contact Us</h4>
                            <address class="font-size-2 mb-5">
                                <span class="mb-2 font-weight-normal text-gray-450">
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
                                <a href="#" class="font-size-2 d-block text-gray-450">
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
                    <div class="col-lg-2">
                        <div class="mb-6 mb-lg-0">
                            <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1 text-white">{{__('Useful Links')}}</h4>
                            <ul class="list-unstyled mb-0">
                                @foreach ($ulinks as $key => $ulink)
                                <li class="h-white pb-2">
                                    <a class="font-size-2 text-gray-450 widgets-hover transition-3d-hover" href="{{$ulink->url}}">{{convertUtf8($ulink->name)}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Newsletter -->
                        <div class="mb-6">
                            <div class="mb-5">
                                <h5 class="font-size-3 font-weight-medium text-white mb-2 mb-xl-5 pb-xl-1">Join Our Newsletter
                                </h5>
                            </div>
                            <form id="footerSubscribeForm" action="{{route('front.subscribe')}}" method="post">
                                @csrf
                                <div class="input-group">
                                    <input type="email" class="form-control placeholder-color-1 py-4d75 font-size-2 pl-4 rounded-0 bg-transparent border-0" name="email" id="subscribeSrEmail" placeholder="Enter email" aria-label="Your email" required="" data-msg="Please enter a valid email address.">
                                    <button type="submit" class="btn bg-white rounded-0 px-4 text-dark-1 py-2 font-weight-medium m-1">Subscribe
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- End  Newsletter -->
                        <div>
                            <div class="mb-5">
                                <h5 class="font-size-3 font-weight-medium text-white mb-2 mb-xl-5 pb-xl-1">Available On</h5>
                            </div>
                            <button type="button" class="btn btn-wide border border-gray-710 rounded-0 py-2 px-4 text-left mb-4 mr-md-2 mr-lg-4">
                                <span class="media align-items-center m-1">
                                    <span class="flaticon-apple font-size-9 mr-3 text-white"></span>
                                    <span class="media-body">
                                      <strong class="font-weight-normal text-white">App Store
                                      </strong>
                                      <span class="d-block font-weight-normal font-size-2 text-gray-450">Available now on the</span>
                                    </span>
                                </span>
                            </button>
                            <button type="button" class="btn btn-wide border border-gray-710 rounded-0 py-2 px-4 pr-lg-9 text-left mb-4 mb-md-0 mr-md-2 mr-lg-4">
                                <span class="media align-items-center my-1 mx-2">
                                    <span class="flaticon-play-store font-size-9 mr-3 text-white"></span>
                                    <span class="media-body">
                                      <strong class="font-weight-normal text-white font-size-2">Google Play
                                      </strong>
                                      <span class="d-block font-weight-normal font-size-2 text-gray-450">Get in on</span>
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-1 border-top border-gray-710">
            <div class="container">
                <div class="d-md-flex text-center text-md-left justify-content-between align-items-center">

                    <!-- Copyright -->
                    <p class="mb-3 mb-md-0 font-size-2 text-gray-450">{!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}</p>
                    <!-- End Copyright -->

                    <div class="d-md-flex justify-content-md-end align-items-center">

                        <!-- Select -->
                        <div class="dropdown bootstrap-select js-select dropdown-select ml-md-3 mb-3 mb-md-0"><select class="js-select selectpicker dropdown-select ml-md-3 mb-3 mb-md-0" data-style="border border-gray-710 bg-transparent px-4 py-2 text-gray-450 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true" tabindex="-98">
                            <option value="one" selected="">English (United States)</option>
                            <option value="two">Deutsch</option>
                            <option value="three">Français</option>
                            <option value="four">Español</option>
                        </select><button type="button" class="btn dropdown-toggle border border-gray-710 bg-transparent px-4 py-2 text-gray-450 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-toggle="dropdown" role="button" title="English (United States)"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">English (United States)</div></div> </div></button><div class="dropdown-menu dropdown-menu-right" role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                        <!-- End Select -->

                        <!-- Select -->
                        <div class="dropdown bootstrap-select js-select dropdown-select ml-md-3 fit-width"><select class="js-select selectpicker dropdown-select ml-md-3" data-style="border border-gray-710 bg-transparent px-4 py-2 text-gray-450 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-width="fit" data-dropdown-align-right="true" tabindex="-98">
                            <option value="one" selected="">$ USD</option>
                            <option value="two">€ EUR</option>
                            <option value="three">₺ TL</option>
                            <option value="four">₽ RUB</option>
                        </select><button type="button" class="btn dropdown-toggle border border-gray-710 bg-transparent px-4 py-2 text-gray-450 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-toggle="dropdown" role="button" title="$ USD"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">$ USD</div></div> </div></button><div class="dropdown-menu dropdown-menu-right" role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                        <!-- End Select -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>