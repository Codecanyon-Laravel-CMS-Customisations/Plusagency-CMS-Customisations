<footer class="site-footer_v5">
    <div class="border-top">
        <div class="container">
            <!-- Newsletter -->
            <form id="footerSubscribeForm" action="{{route('front.subscribe')}}" method="post">
                @csrf
            <div>
                <div class="space-1 space-lg-2">
                    <div class="text-center mb-5">
                        <h5 class="font-size-7 font-weight-medium">Join Our Newsletter</h5>
                        <p class="text-gray-700">Signup to be the first to hear about exclusive deals, special offers and upcoming collections</p>
                    </div>
                    <!-- Form Group -->
                    <div class="form-row justify-content-center">
                        <div class="col-lg-5 mb-2">
                            <div class="js-form-message">
                                <div class="input-group">
                                    <input type="text" class="form-control rounded-0 border-dark font-size-2 px-5 py-4d75" name="name" id="signupSrName" placeholder="Enter email for weekly newsletter." aria-label="Your name" required="" data-msg="Name must contain only letters." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <div class="ml-lg-2">
                            <button type="submit" class="btn btn-dark rounded-0 btn-wide py-3 font-weight-medium">Subscribe
                            </button>
                        </div>
                    </div>
                    <!-- End Form Group -->
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- End  Newsletter -->
    <div class="bg-dark">
        <div class="container space-bottom-3">
            <div class="space-top-2">
                <div class="row">
                    <div class="col-md-8 col-lg-10">
                        <div class="pb-6 pb-lg-0">
                            <a href="/" class="d-inline-block mb-5">
                                <img class="img-fluid" src="{{ asset('assets/bookworm/img/324x38/img1.png') }}" alt="Image-Description">
                            </a>
                            <address class="font-size-2 mb-5">
                                <span class="mb-2 font-weight-normal text-gray-500">
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
                                <a href="" class="font-size-2 d-block text-gray-500 mb-1">
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
                                <a href="" class="font-size-2 d-block text-gray-500">
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
                                        <a class="link-gray-500" target="_blank" href="{{$social->url}}">
                                            <span class="{{$social->icon}}"></span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="mb-5 mb-md-0">
                            <h4 class="font-size-3 text-white font-weight-medium mb-2 mb-xl-5 pb-xl-1">{{__('Useful Links')}}</h4>
                            <ul class="list-unstyled mb-0">
                                @foreach ($ulinks as $key => $ulink)
                                <li class="h-white pb-2">
                                    <a class="font-size-2 text-gray-500 widgets-hover transition-3d-hover" href="{{$ulink->url}}">{{convertUtf8($ulink->name)}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-1 bg-black">
            <div class=" container">
                <div class="text-center">
                    <!-- Copyright -->
                    <p class="d-inline-block mb-3 mb-lg-0 font-size-2 text-gray-500">{!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}</p>
                    <!-- End Copyright -->
                    <div class="d-inline-block">
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
