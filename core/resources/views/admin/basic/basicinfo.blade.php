@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Basic Informations</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Basic Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Basic Informations</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="" action="{{route('admin.basicinfo.update')}}" method="post">
          @csrf
{{--          <div class="card-header">--}}
{{--              <div class="row">--}}
{{--                  <div class="col-lg-10">--}}
{{--                      <div class="card-title">Update Basic Informations</div>--}}
{{--                  </div>--}}
{{--              </div>--}}
{{--          </div>--}}
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-8 offset-lg-2">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                          <label>Website Title **</label>
                          <input class="form-control" name="website_title" value="{{$abs->website_title}}">
                          @if ($errors->has('website_title'))
                            <p class="mb-0 text-danger">{{$errors->first('website_title')}}</p>
                          @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Timezone</label>
                            <select class="form-control select2" name="timezone">
                                <option value="" selected disabled>Select a Timezone</option>
                                @foreach ($timezones as $timezone)
                                <option value="{{$timezone->timezone}}" {{$abx->timezone == $timezone->timezone ? 'selected' : ''}}>{{$timezone->timezone}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Base Currency **</label>
                            <select class="form-control ltr currency_selector">
                                @foreach ($currencies as $wc)
                                    <option data-name="{{ $wc->name }}" data-acronym="{{ $wc->acronym }}" data-symbol="{{ $wc->symbol }}" data-symbol-position="{{ $wc->symbol_position == "R" ? "Right" : "Left" }}" data-text-position="{{ $wc->text_position == "R" ? "Right" : "Left"  }}" data-rate="{{ $wc->conversion ? $wc->conversion->rate : ""  }}" value="{{ $wc->id }}">{{ $wc->name }} ({{ $wc->acronym }})</option>
                                @endforeach
                            </select>
                            @if ($errors->has('base_currency_text_position'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_text_position')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Base Currency Text **</label>
                            <input type="text" class="form-control ltr" name="base_currency_text" disabled value="{{$abx->base_currency_text}}">
                            @if ($errors->has('base_currency_text'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_text')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Base Currency Symbol **</label>
                            <input type="text" class="form-control ltr" name="base_currency_symbol" disabled value="{{$abx->base_currency_symbol}}">
                            @if ($errors->has('base_currency_symbol'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_symbol')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Base Currency Symbol Position **</label>
                            <input name="base_currency_symbol_position" class="form-control ltr" disabled>
                            @if ($errors->has('base_currency_symbol_position'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_symbol_position')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Base Currency Rate **</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">1 USD =</span>
                                </div>
                                <input type="text" name="base_currency_rate" class="form-control ltr" disabled value="{{$abx->base_currency_rate}}">
                                <div class="input-group-append">
                                  <span class="input-group-text span-rated-symbol">{{$abx->base_currency_text}}</span>
                                </div>
                            </div>

                            @if ($errors->has('base_currency_rate'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_rate')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Base Currency Text Position **</label>
                            <input name="base_currency_text_position" class="form-control ltr" disabled>
                            @if ($errors->has('base_currency_text_position'))
                              <p class="mb-0 text-danger">{{$errors->first('base_currency_text_position')}}</p>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                          <label>Base Color Code **</label>
                          <input class="jscolor form-control ltr" name="base_color" value="{{$abs->base_color}}">
                          @if ($errors->has('base_color'))
                            <p class="mb-0 text-danger">{{$errors->first('base_color')}}</p>
                          @endif
                        </div>
                    </div>
                    <div class="col-lg-6">

                        @if ($abe->theme_version != 'dark' && $abe->theme_version != 'gym' && $abe->theme_version != 'car' && $abe->theme_version != 'construction' && $abe->theme_version != 'lawyer')
                            <div class="form-group">
                                <label>Secondary Base Color Code **</label>
                                <input class="jscolor form-control ltr" name="secondary_base_color" value="{{$abs->secondary_base_color}}">
                                @if ($errors->has('secondary_base_color'))
                                    <p class="mb-0 text-danger">{{$errors->first('secondary_base_color')}}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>


                @if ($abe->theme_version != 'cleaning' && $abe->theme_version != 'logistic')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Hero Area Overlay Color Code **</label>
                            <input class="jscolor form-control ltr" name="hero_area_overlay_color" value="{{$abe->hero_overlay_color}}">
                            @if ($errors->has('hero_area_overlay_color'))
                            <p class="mb-0 text-danger">{{$errors->first('hero_area_overlay_color')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Hero Area Overlay Opacity **</label>
                            <input type="text" class="form-control ltr" name="hero_area_overlay_opacity" value="{{$abe->hero_overlay_opacity}}">
                            <p class="text-warning mb-0">Opacity can be between 0 to 1.</p>
                            @if ($errors->has('hero_area_overlay_opacity'))
                            <p class="mb-0 text-danger">{{$errors->first('hero_area_overlay_opacity')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif


                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Breadcrumb Area Overlay Color Code **</label>
                            <input class="jscolor form-control ltr" name="breadcrumb_area_overlay_color" value="{{$abe->breadcrumb_overlay_color}}">
                            @if ($errors->has('breadcrumb_area_overlay_color'))
                              <p class="mb-0 text-danger">{{$errors->first('breadcrumb_area_overlay_color')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Breadcrumb Area Overlay Opacity **</label>
                            <input type="text" class="form-control ltr" name="breadcrumb_area_overlay_opacity" value="{{$abe->breadcrumb_overlay_opacity}}">
                            <p class="text-warning mb-0">Opacity can be between 0 to 1.</p>
                            @if ($errors->has('breadcrumb_area_overlay_opacity'))
                              <p class="mb-0 text-danger">{{$errors->first('breadcrumb_area_overlay_opacity')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Header V2 button text</label>
                            <input type="text" class="form-control ltr" name="header_v2_button_text" value="{{$abe->header_v2_button_text}}">
                            @if ($errors->has('header_v2_button_text'))
                              <p class="mb-0 text-danger">{{$errors->first('header_v2_button_text')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Header V3 shipping text</label>
                            <input type="text" class="form-control ltr" name="header_shipping_text" value="{{$abe->header_shipping_text}}">
                            @if ($errors->has('header_shipping_text'))
                              <p class="mb-0 text-danger">{{$errors->first('header_shipping_text')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Digital Resource Link</label>
                            <input type="text" class="form-control ltr" placeholder="e.g https://digital.angelbookhouse.com/" name="digital_resource_link" value="{{$abe->digital_resource_link}}">
                            @if ($errors->has('digital_resource_link'))
                              <p class="mb-0 text-danger">{{$errors->first('digital_resource_link')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Digital Resource Text</label>
                            <input type="text" class="form-control ltr" placeholder="e.g CLICK  TO ACCESS RESOURCE" name="digital_resource_text" value="{{$abe->digital_resource_text}}">
                            @if ($errors->has('digital_resource_text'))
                              <p class="mb-0 text-danger">{{$errors->first('digital_resource_text')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Offline Resource Text</label>
                            <input type="text" class="form-control ltr" placeholder="e.g CLICK  TO ACCESS RESOURCE" name="offline_resource_text" value="{{$abe->offline_resource_text}}">
                            @if ($errors->has('offline_resource_text'))
                              <p class="mb-0 text-danger">{{$errors->first('offline_resource_text')}}</p>
                            @endif
                        </div>
                    </div>
                </div>

              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
@section('scripts')
  <script>
        $(document).ready(function(){
            let currency_selector = $('.currency_selector');

            initCurrencySelector(currency_selector);

            currency_selector.on('change', function() {
                initCurrencySelector(this);
            });

            function initCurrencySelector(tgt) {
                let activeOption    = $(tgt).find('option:selected');

                let dName           = activeOption.attr('data-name');
                let dRate           = activeOption.attr('data-rate');
                let dAcronym        = activeOption.attr('data-acronym');
                let dSymbol         = activeOption.attr('data-symbol');
                let dSymbolPosition = activeOption.attr('data-symbol-position');
                let dTextPosition   = activeOption.attr('data-text-position');

                $('.span-rated-symbol').text(dSymbol);
                $('input[name="base_currency_text"]').val(dName);
                $('input[name="base_currency_rate"]').val(dRate);
                $('input[name="base_currency_symbol"]').val(dSymbol);
                $('input[name="base_currency_text_position"]').val(dAcronym);
                $('input[name="base_currency_text_position"]').val(dTextPosition);
                $('input[name="base_currency_symbol_position"]').val(dSymbolPosition);
            }
        });
  </script>
@endsection
