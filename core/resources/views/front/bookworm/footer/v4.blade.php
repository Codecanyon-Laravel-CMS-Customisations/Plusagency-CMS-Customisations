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
                                @foreach ($socials as $key => $social)
                                    <li class="h-white btn @if($loop->first) pl-0 @endif">
                                        <a class="link-gray-450" target="_blank" href="{{$social->url}}">
                                            <span class="{{$social->icon}}"></span>
                                        </a>
                                    </li>
                                @endforeach
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
                        <select class="changeLanguage js-select selectpicker dropdown-select ml-lg-4 mb-3 mb-md-0" data-style="text-white-60 bg-secondary-gray-800 px-4 py-2 rounded-lg height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true">
                            @php
                                $languages = \App\Language::all()->sortBy('name', 0, false);
                            @endphp
                            @foreach($languages as $language)
                                <option data-link="{{ route('changeLanguage', $language->code) }}" value="{{ $language->code }}" @if($language->code == session('lang')) selected @endif>{{ $language->name }}</option>
                            @endforeach
                        </select>
                        @php
                            $world_currencies       = App\Models\Country::with('currencies')
                            // ->whereHas('currencies')
                            // ->where('status', true)
                            ->get()
                            ->sortBy('name', 0, false);
                            // $countries              = App\Models\Country::all()->sortBy('name', 0, false);
                            // $currencies             = App\Models\Currency::with('conversion')->whereHas('conversion')->orderBy('name', 'asc');

                            $counter                = 0;
                            $cc_options_1           = '';
                            $countries_options      = '';

                        @endphp
                        @foreach ($world_currencies as $world_currency)
                            @php
                                //get only active currencies + countries
                                $session_wc         = session('geo_data_user_country');
                                $cc_options         = '';
                                $wc_id              = $world_currency->id;
                                if ($session_wc    != $wc_id) continue;

                                $wc_e_id            = encrypt($world_currency->id);
                                $route              = route('changeCountry', $wc_e_id);
                                $wc_selected        = $wc_id == $session_wc ? 'selected' : '';
                                $wc_value           = $world_currency->name.'  ( '.$world_currency->native_name.' )';

                                foreach ($world_currency->currencies as $pc)
                                {
                                    $cc_id          = $pc->id;
                                    $cc_e_id        = encrypt($pc->id);
                                    $cc_route       = route('changeCurrency', ['hash' => $cc_e_id, 'country' => $world_currency->id]);
                                    $cc_selected    = $cc_id == session('geo_data_user_currency') ? 'selected' : '';
                                    $cc_value       = trim($pc->symbol) != trim($pc->acronym) ? $pc->symbol.' '.$pc->acronym : ''.$pc->acronym;

                                    if ($counter < 1) $cc_options_1    .= "<option data-link='$cc_route' value='$cc_e_id' $cc_selected>$cc_value</option>";
                                    $cc_options    .= "<option data-link='$cc_route' value='$cc_e_id' $cc_selected>$cc_value</option>";

                                }

                                $countries_options .= "<option data-active=\"true\" data-link=\"$route\" data-cc=\"$cc_options\" value=\"$wc_e_id\" $wc_selected>$wc_value</option>";
                                $counter++;
                            @endphp
                        @endforeach
                        @foreach ($world_currencies as $world_currency)
                            @php
                                $session_wc         = session('geo_data_user_country');
                                $cc_options         = '';
                                $wc_id              = $world_currency->id;
                                if ($session_wc     == $wc_id) continue;

                                $wc_e_id            = encrypt($world_currency->id);
                                $route              = route('changeCountry', $wc_e_id);
                                $wc_selected        = $wc_id == $session_wc ? 'selected' : '';
                                $wc_value           = $world_currency->name;//.'  ( '.$world_currency->native_name.' )';

                                foreach ($world_currency->currencies as $pc)
                                {
                                    $cc_id          = $pc->id;
                                    $cc_e_id        = encrypt($pc->id);
                                    $cc_route       = route('changeCurrency', ['hash' => $cc_e_id, 'country' => $world_currency->id]);
                                    $cc_selected    = $cc_id == session('geo_data_user_currency') ? 'selected' : '';
                                    $cc_value       = trim($pc->symbol) != trim($pc->acronym) ? $pc->symbol.' '.$pc->acronym : ''.$pc->acronym;

                                    if ($counter < 1) $cc_options_1    .= "<option data-link='$cc_route' value='$cc_e_id' $cc_selected>$cc_value</option>";
                                    $cc_options    .= "<option data-link='$cc_route' value='$cc_e_id' $cc_selected>$cc_value</option>";

                                }

                                $countries_options .= "<option data-active=\"false\" data-link=\"$route\" data-cc=\"$cc_options\" value=\"$wc_e_id\" $wc_selected>$wc_value</option>";
                                $counter++;
                            @endphp
                        @endforeach
                        <select class="changeCountry js-select selectpicker dropdown-select ml-lg-4 mb-3 mb-md-0" data-size="5" data-style="text-white-60 bg-secondary-gray-800 px-4 py-2 rounded-lg height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true" data-live-search="true">
                            {!! $countries_options !!}
                        </select>
                        <script>
                            var tgtLang     = $('.changeLanguage');
                            var tgtCountry  = $('.changeCountry');

                            tgtCountry.on('hidden.bs.select', function (e) {
                                if($(e.target).find('option:selected').attr('data-active') == "true") return;
                                window.location.assign($(e.target).find('option:selected').attr('data-link'));
                            });
                            tgtLang.on('hidden.bs.select', function (e) {
                                changeLanguageMethod();
                            });


                            function changeLanguageMethod() {
                                window.location.assign(tgtLang.find('option:selected').attr('data-link'));
                            }
                            function changeCountryMethod() {
                                tgtCountry.selectpicker('refresh');
                                window.location.assign(tgtCountry.find('option:selected').attr('data-link'));
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
