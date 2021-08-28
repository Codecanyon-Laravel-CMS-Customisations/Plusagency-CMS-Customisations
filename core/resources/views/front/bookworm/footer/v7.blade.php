<footer class="site-footer_v6">
    <div class="space-1 space-lg-3 bg-gray-200">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="mb-5 mb-lg-0">
                        <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1">{{__('Useful Links')}}</h4>
                        <ul class="list-unstyled mb-0">
                            @foreach ($ulinks as $key => $ulink)
                            <li class="pb-2">
                                <a class="font-size-2 link-black-100 widgets-hover transition-3d-hover" href="{{$ulink->url}}">{{convertUtf8($ulink->name)}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <!-- Newsletter -->
                    <div class="pb-6">
                        <div class="mb-5">
                            <h5 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1">Join Our Newsletter
                            </h5>
                            <p class="font-size-2">Signup to be the first to hear about exclusive deals, special offers and upcoming collections</p>
                        </div>
                        <form id="footerSubscribeForm" action="{{route('front.subscribe')}}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="email" class="form-control py-4d75 font-size-2 pl-4 border-0 bg-gray-220" name="email" id="subscribeSrEmail" placeholder="Enter email" aria-label="Your email" aria-describedby="subscribeButton" required="" data-msg="Please enter a valid email address.">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-dark text-white px-3 font-size-4 border-0" id="subscribeButton">
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
    <div class="space-1">
        <div class="container">
            <div class="d-lg-flex text-center text-lg-left justify-content-between align-items-center">
                <!-- Copyright -->
                <p class="mb-3 mb-lg-0 font-size-2">{!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}</p>
                <!-- End Copyright -->
                <div class="d-md-flex justify-content-xl-end align-items-center">
                    <div class="mb-4 mb-md-0 mr-md-6">
                       <img class="img-fluid" src="../../assets/img/324x38/img1.png" alt="Image-Description">
                    </div>

                    <!-- Select -->
                    <div class="dropdown bootstrap-select js-select dropdown-select mb-3 mb-md-0"><select class="js-select selectpicker dropdown-select mb-3 mb-md-0" data-style="border border-gray-300 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true" tabindex="-98">
                        <option value="one" selected="">English (United States)</option>
                        <option value="two">Deutsch</option>
                        <option value="three">Français</option>
                        <option value="four">Español</option>
                    </select><button type="button" class="btn dropdown-toggle border border-gray-300 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-toggle="dropdown" role="button" title="English (United States)"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">English (United States)</div></div> </div></button><div class="dropdown-menu dropdown-menu-right" role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                    <!-- End Select -->

                    <!-- Select -->
                    <div class="dropdown bootstrap-select js-select dropdown-select ml-md-3 fit-width"><select class="js-select selectpicker dropdown-select ml-md-3" data-style="border border-gray-300 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-width="fit" data-dropdown-align-right="true" tabindex="-98">
                        <option value="one" selected="">$ USD</option>
                        <option value="two">€ EUR</option>
                        <option value="three">₺ TL</option>
                        <option value="four">₽ RUB</option>
                    </select><button type="button" class="btn dropdown-toggle border border-gray-300 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2" data-toggle="dropdown" role="button" title="$ USD"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">$ USD</div></div> </div></button><div class="dropdown-menu dropdown-menu-right" role="combobox"><div class="inner show" role="listbox" aria-expanded="false" tabindex="-1"><ul class="dropdown-menu inner show"></ul></div></div></div>
                    <!-- End Select -->
                </div>
            </div>
        </div>
    </div>
</footer>