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
                    <select class="changeLanguage js-select selectpicker dropdown-select ml-lg-4 mb-3 mb-md-0" data-style-not="text-white-60 bg-secondary-gray-800 px-4 py-2 rounded-lg height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true">
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
                    <select class="changeCountry js-select selectpicker dropdown-select ml-lg-4 mb-3 mb-md-0" data-size="5" data-style-not="text-white-60 bg-secondary-gray-800 px-4 py-2 rounded-lg height-5 outline-none shadow-none form-control font-size-2" data-dropdown-align-right="true" data-live-search="true">
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
</footer>
