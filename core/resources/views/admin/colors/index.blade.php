@extends('admin.layout')

@section('content')
    <div class="page-header">
    <h4 class="page-title">Website Color Settings</h4>
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
        <a href="#">Website Colors</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Website Color Settings</a>
      </li>
    </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pt-5 pb-5">
                    <nav>
                        <div class="nav nav-pills" id="nav-tab" role="tablist">
                            <a class="nav-link mx-2 active" id="nav-first-tab" data-toggle="tab" href="#nav-first" role="tab" aria-controls="nav-first" aria-selected="true">
                                <strong>
                                    PREDEFINED SETTINGS
                                </strong>
                            </a>
                            <a class="nav-link mx-2" id="nav-second-tab" data-toggle="tab" href="#nav-second" role="tab" aria-controls="nav-second" aria-selected="false">
                                <strong>
                                    CUSTOM SETTINGS
                                </strong>
                            </a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-first" role="tabpanel" aria-labelledby="nav-first-tab">
                            <style>
                                .nav-pills.flex-column .nav-link:first-child,
                                .nav-pills.flex-column .nav-link:last-child,
                                .nav-pills.flex-column .nav-link {
                                    border-radius: 4px 4px !important;
                                }
                                .predefined-tabs-wrapper .nav-pills a {
                                    border:0px !important;
                                    display: block;
                                    padding: .5rem 1rem;
                                    /* background-color: transparent !important; */
                                    color: white !important;
                                    font-weight: bolder !important;
                                }
                                .predefined-tabs-wrapper .nav-pills :not(a.active) {
                                    background-color: transparent !important;
                                }
                                .predefined-tabs-wrapper .nav-pills a:first-child {
                                    margin-top: 2rem !important;

                                }
                            </style>
                            <div class="row pt-5 predefined-tabs-wrapper">
                                @php
                                    $website_colors_obj = App\WebsiteColors::COLOR_SELECTIONS;
                                    $website_colors_col = App\WebsiteColors::query()->get();
                                @endphp
                                <div class="col-3">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab1" role="tablist" aria-orientation="vertical">
                                        @foreach ($website_colors_obj as $key => $value)
                                            <a class="nav-link my-1 text-left pl-2 @if($value['active']) active @endif" id="v-pills-tab-{{ $key }}" data-toggle="pill" href="#v-pills-{{ $key }}" role="tab" aria-controls="v-pills-{{ $key }}" aria-selected="@if($value['active']) true @else false @endif">{{ $value['tab_title'] }}</a>
                                        @endforeach
                                        <button class="my-2 btn btn-block btn-success save-all-presets" >
                                            <strong>SAVE ALL</strong>
                                        </button>
                                        <button class="my-2 btn btn-block btn-danger clear-all-presets" >
                                            <strong>RESET ALL</strong>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="tab-content color-presets pt-4" id="v-pills-tabContent1">
                                        @foreach ($website_colors_obj as $key => $value)
                                            <?php
                                                $elements = $value['elements'];
                                            ?>
                                            <div class="tab-pane fade @if($value['active']) show active @endif" id="v-pills-{{ $key }}" role="tabpanel" aria-labelledby="v-pills-{{ $key }}-tab">
                                                <div class="row">
                                                    @foreach ($elements as $element)
                                                        <div class="col-12">
                                                            <div class="row border mb-2">
                                                                <div class="col-md-4 pt-2">
                                                                    <strong>{{ $element['section_title'] }}</strong>
                                                                    <p>{{ $element['section_description'] }}</p>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <form action="{{route('admin.colorSettings.store')}}" method="post">
                                                                                @csrf
                                                                                <input type="hidden" name="element" value="{{ $element['attr_default'] }}">
                                                                                @if ($website_colors_col->where('element', $element['attr_default'])->count() >= 1 )
                                                                                    @php
                                                                                        $saved_presets  = $website_colors_col->where('element', $element['attr_default']);
                                                                                        $color_set      = $saved_presets->where('attribute', 'color')->first();
                                                                                        $background_set = $saved_presets->where('attribute', 'background-color')->first();
                                                                                    @endphp
                                                                                    <div class="row">
                                                                                        <div class="col-lg-4">
                                                                                            <div class="form-group">
                                                                                                <label>Attribute ** </label>
                                                                                                @if ($element['attr_default'] == $element['attr_hover'])
                                                                                                    <input type="text" name="attribute" class="form-control"
                                                                                                        @php
                                                                                                            $data_color         = '';
                                                                                                            $data_important     = '';
                                                                                                            $data_value         = 'color';
                                                                                                            $data_title         = 'Color';

                                                                                                            if($color_set)
                                                                                                            {
                                                                                                                $data_color     = trim(str_replace('!important', '', $color_set->value));
                                                                                                            }
                                                                                                            elseif($background_set)
                                                                                                            {
                                                                                                                $data_color     = trim(str_replace('!important', '', $background_set->value));
                                                                                                            }
                                                                                                            if(isset($element['important_default']))
                                                                                                            {
                                                                                                                $data_important = trim($element['important_default']);
                                                                                                            }
                                                                                                            if(isset($element['attr_config']))
                                                                                                            {
                                                                                                                $data_value     = trim($element['attr_config']);
                                                                                                                $data_title     = trim(Illuminate\Support\Str::title(str_replace("-", " ", $data_value)));
                                                                                                            }
                                                                                                        @endphp
                                                                                                        data-color="{{$data_color}}"
                                                                                                        data-important="{{$data_important}}"
                                                                                                        value="{{$data_value}}"
                                                                                                        title="{{$data_title}}"
                                                                                                        readonly
                                                                                                        disabled
                                                                                                    >
                                                                                                @else
                                                                                                    <select name="attribute" class="form-control">
                                                                                                        <option @if ($color_set)
                                                                                                                data-color="{{ trim(str_replace('!important', '', $color_set->value)) }}"
                                                                                                                @endif
                                                                                                                data-important="@if(isset($element['important_default'])) {{ trim($element['important_default']) }} @endif"
                                                                                                                value="@if(isset($element['attr_config'])) {{ $element['attr_config'] }} @else color @endif">@if(isset($element['attr_config'])) {{ Illuminate\Support\Str::title(str_replace("-", " ", $element['attr_config'])) }} @else Text Color @endif</option>
                                                                                                        <option @if ($background_set)
                                                                                                                data-color="{{ trim(str_replace('!important', '', $background_set->value)) }}"
                                                                                                                @endif
                                                                                                                data-important="@if(isset($element['important_default'])) {{ trim($element['important_default']) }} @endif"
                                                                                                                value="@if(isset($element['attr_config'])) {{ $element['attr_config'] }} @else background-color @endif">@if(isset($element['attr_config'])) {{ Illuminate\Support\Str::title(str_replace("-", " ", $element['attr_config'])) }} @else Background Color @endif</option>
                                                                                                    </select>
                                                                                                @endif
                                                                                                @if (Session::get('data') == 0)
                                                                                                    @if ($errors->has('attribute'))
                                                                                                        <p class="mb-0 text-danger">{{$errors->first('attribute')}}</p>
                                                                                                    @endif
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-8">
                                                                                            <div class="row px-0">
                                                                                                <div class="col-lg-8 px-0">
                                                                                                    <div class="form-group">
                                                                                                        <label>Color **</label>
                                                                                                        <input class="jscolor form-control ltr" name="color">
                                                                                                        @if (Session::get('data') == 0)
                                                                                                            @if ($errors->has('color'))
                                                                                                                <p class="mb-0 text-danger">{{$errors->first('color')}}</p>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-4 px-0">
                                                                                                    <div class="form-group">
                                                                                                        <label>Click me!</label>
                                                                                                        <button type="submit" id="displayNotif" class="btn btn-success">Save</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="row">
                                                                                        <div class="col-lg-4">
                                                                                            <div class="form-group">
                                                                                                <label>Attribute **</label>
                                                                                                @if ($element['attr_default'] == $element['attr_hover'])
                                                                                                    <input type="text" name="attribute" class="form-control"
                                                                                                        @php
                                                                                                            $data_color         = '';
                                                                                                            $data_important     = '';
                                                                                                            $data_value         = 'color';
                                                                                                            $data_title         = 'Color';

                                                                                                            if(isset($element['important_default']))
                                                                                                            {
                                                                                                                $data_important = trim($element['important_default']);
                                                                                                            }
                                                                                                            if(isset($element['attr_config']))
                                                                                                            {
                                                                                                                $data_value     = trim($element['attr_config']);
                                                                                                                $data_title     = trim(Illuminate\Support\Str::title(str_replace("-", " ", $data_value)));
                                                                                                            }
                                                                                                        @endphp
                                                                                                        data-color="{{$data_color}}"
                                                                                                        data-important="{{trim($data_important)}}"
                                                                                                        value="{{$data_value}}"
                                                                                                        title="{{$data_title}}"
                                                                                                        readonly
                                                                                                        disabled
                                                                                                    >
                                                                                                @else
                                                                                                    <select name="attribute" class="form-control">
                                                                                                        <option
                                                                                                            data-important="@if(isset($element['important_default'])) {{ trim($element['important_default']) }} @endif"
                                                                                                            value="@if(isset($element['attr_config'])) {{ $element['attr_config'] }} @else color @endif">@if(isset($element['attr_config'])) {{ Illuminate\Support\Str::title(str_replace("-", " ", $element['attr_config'])) }} @else Text Color @endif </option>
                                                                                                        <option
                                                                                                            data-important="@if(isset($element['important_default'])) {{ trim($element['important_default']) }} @endif"
                                                                                                            value="@if(isset($element['attr_config'])) {{ $element['attr_config'] }} @else background-color @endif">@if(isset($element['attr_config'])) {{ Illuminate\Support\Str::title(str_replace("-", " ", $element['attr_config'])) }} @else Background Color @endif </option>
                                                                                                    </select>
                                                                                                @endif
                                                                                                @if (Session::get('data') == 0)
                                                                                                    @if ($errors->has('attribute'))
                                                                                                        <p class="mb-0 text-danger">{{$errors->first('attribute')}}</p>
                                                                                                    @endif
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-8">
                                                                                            <div class="row px-0">
                                                                                                <div class="col-lg-8 px-0">
                                                                                                    <div class="form-group">
                                                                                                        <label>Color **</label>
                                                                                                        <input class="jscolor form-control ltr" name="color">
                                                                                                        @if (Session::get('data') == 0)
                                                                                                            @if ($errors->has('color'))
                                                                                                                <p class="mb-0 text-danger">{{$errors->first('color')}}</p>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-lg-4 px-0">
                                                                                                    <div class="form-group">
                                                                                                        <label>Click me!</label>
                                                                                                        <button type="submit" id="displayNotif" class="btn btn-success">Save</button>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            </form>
                                                                        </div>
                                                                        @if(!isset($element['attr_mono']))
                                                                            <div class="col-12">
                                                                                <form action="{{route('admin.colorSettings.store')}}" method="post">
                                                                                    @csrf
                                                                                    <input type="hidden" name="element" value="{{ $element['attr_hover'] }}">
                                                                                    @if ($website_colors_col->where('element', $element['attr_hover'])->count() >= 1 )
                                                                                        @php
                                                                                            $saved_presets  = $website_colors_col->where('element', $element['attr_hover']);
                                                                                            $color_set      = $saved_presets->where('attribute', 'color')->first();
                                                                                            $background_set = $saved_presets->where('attribute', 'background-color')->first();
                                                                                        @endphp
                                                                                        <div class="row">
                                                                                            <div class="col-lg-4">
                                                                                                <div class="form-group">
                                                                                                    <label>Attribute *HOVER*</label>
                                                                                                    <select name="attribute" class="form-control">
                                                                                                        <option @if ($color_set)
                                                                                                                data-color="{{ trim(str_replace('!important', '', $color_set->value)) }}"
                                                                                                                data-important="@if(isset($element['important_hover'])) {{ trim($element['important_hover']) }} @endif"
                                                                                                                @endif value="@if(isset($element['attr_config'])) {{ $element['attr_config'] }} @else color @endif">@if(isset($element['attr_config'])) {{ Illuminate\Support\Str::title(str_replace("-", " ", $element['attr_config'])) }} @else Text Color @endif </option>
                                                                                                        <option @if ($background_set)
                                                                                                                data-color="{{ trim(str_replace('!important', '', $background_set->value)) }}"
                                                                                                                data-important="@if(isset($element['important_hover'])) {{ trim($element['important_hover']) }} @endif"
                                                                                                                @endif value="@if(isset($element['attr_config'])) {{ $element['attr_config'] }} @else background-color @endif">@if(isset($element['attr_config'])) {{ Illuminate\Support\Str::title(str_replace("-", " ", $element['attr_config'])) }} @else Background Color @endif </option>
                                                                                                    </select>
                                                                                                    @if (Session::get('data') == 0)
                                                                                                        @if ($errors->has('attribute'))
                                                                                                            <p class="mb-0 text-danger">{{$errors->first('attribute')}}</p>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-8">
                                                                                                <div class="row px-0">
                                                                                                    <div class="col-lg-8 px-0">
                                                                                                        <div class="form-group">
                                                                                                            <label>Color **</label>
                                                                                                            <input class="jscolor form-control ltr" name="color">
                                                                                                            @if (Session::get('data') == 0)
                                                                                                                @if ($errors->has('color'))
                                                                                                                    <p class="mb-0 text-danger">{{$errors->first('color')}}</p>
                                                                                                                @endif
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-lg-4 px-0">
                                                                                                        <div class="form-group">
                                                                                                            <label>Click me!</label>
                                                                                                            <button type="submit" id="displayNotif" class="btn btn-success">Save</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="row">
                                                                                            <div class="col-lg-4">
                                                                                                <div class="form-group">
                                                                                                    <label>Attribute *HOVER*</label>
                                                                                                    <select name="attribute" class="form-control">
                                                                                                        <option
                                                                                                            data-important="@if(isset($element['important_hover'])) {{ trim($element['important_hover']) }} @endif"
                                                                                                            value="@if(isset($element['attr_config'])) {{ $element['attr_config'] }} @else color @endif">@if(isset($element['attr_config'])) {{ Illuminate\Support\Str::title(str_replace("-", " ", $element['attr_config'])) }} @else Text Color @endif</option>
                                                                                                        <option
                                                                                                            data-important="@if(isset($element['important_hover'])) {{ trim($element['important_hover']) }} @endif"
                                                                                                            value="@if(isset($element['attr_config'])) {{ $element['attr_config'] }} @else background-color @endif">@if(isset($element['attr_config'])) {{ Illuminate\Support\Str::title(str_replace("-", " ", $element['attr_config'])) }} @else Background Color @endif</option>
                                                                                                    </select>
                                                                                                    @if (Session::get('data') == 0)
                                                                                                        @if ($errors->has('attribute'))
                                                                                                            <p class="mb-0 text-danger">{{$errors->first('attribute')}}</p>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-8">
                                                                                                <div class="row px-0">
                                                                                                    <div class="col-lg-8 px-0">
                                                                                                        <div class="form-group">
                                                                                                            <label>Color **</label>
                                                                                                            <input class="jscolor form-control ltr" name="color">
                                                                                                            @if (Session::get('data') == 0)
                                                                                                                @if ($errors->has('color'))
                                                                                                                    <p class="mb-0 text-danger">{{$errors->first('color')}}</p>
                                                                                                                @endif
                                                                                                            @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-lg-4 px-0">
                                                                                                        <div class="form-group">
                                                                                                            <label>Click me!</label>
                                                                                                            <button type="submit" id="displayNotif" class="btn btn-success">Save</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </form>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-second" role="tabpanel" aria-labelledby="nav-second-tab">
                            <div class="row">
                                <div class="col-lg-10 text-center">
                                    <h2>Available Custom UI Colors</h2>
                                </div>
                                <form action="{{route('admin.colorSettings.store')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Element **</label>
                                                        <select id="hard_options" name="element" class="form-control">
                                                            <option value="body">Body</option>
                                                            <option value="header">Header</option>
                                                            <option value="h1">Heading 1</option>
                                                            <option value="h2">Heading 2</option>
                                                            <option value="h3">Heading 3</option>
                                                            <option value="h4">Heading 4</option>
                                                            <option value="h5">Heading 5</option>
                                                            <option value="h6">Heading 6</option>
                                                            <option value="footer">Footer</option>
                                                            <option value="p">Paragraph</option>
                                                            <option value="nav">Navigation Menus</option>
                                                            <option value="li">List Item</option>
                                                            <option value="li:hover">List Item Hover</option>
                                                            <option value="li a:hover">Menu List Item Hover</option>
                                                            <option value="table">Table</option>
                                                            <option value="thead">Table Header</option>
                                                            <option value="tbody">Table Body</option>
                                                            <option value="tr">Table Row</option>
                                                            <option value="a">Link</option>
                                                            <option value="a:hover">Link Hover</option>
                                                            <option value="img">Image</option>
                                                            <option value="span">Span tag</option>
                                                            <option value="button">Button</option>
                                                            <option value=".btn">Button Class</option>
                                                            <option value=".btn-search">Search Button Class</option>
                                                            <option value="button:hover">Button Hover</option>
                                                            <option value=".btn:hover">Button Class Hover</option>
                                                            <option value=".btn-search:hover">Search Button Class Hover</option>
                                                            <option value="form">Form</option>
                                                            <option value="input">Input Field</option>
                                                            <option value="label">Label</option>
                                                            <option value="textarea">Textarea</option>
                                                            <option value="select">Select Dropdown</option>
                                                            <option value="option">Select Option</option>
                                                            <option value="option:hover">Option Hover</option>
                                                        </select>
                                                        @if (Session::get('data') == 0)
                                                            @if ($errors->has('element'))
                                                                <p class="mb-0 text-danger">{{$errors->first('element')}}</p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Attribute **</label>
                                                        <select name="attribute" class="form-control">
                                                            <option value="color">Text Color</option>
                                                            <option value="background-color">Background Color</option>
                                                        </select>
                                                        @if (Session::get('data') == 0)
                                                            @if ($errors->has('attribute'))
                                                                <p class="mb-0 text-danger">{{$errors->first('attribute')}}</p>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Color **</label>
                                                        <input class="jscolor form-control ltr" name="color">
                                                        @if (Session::get('data') == 0)
                                                            @if ($errors->has('color'))
                                                                <p class="mb-0 text-danger">{{$errors->first('color')}}</p>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label>Click me!</label>
                                                        <button type="submit" id="displayNotif" class="btn btn-success">Save</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-lg-10 text-center">
                                    <h2>Create Custom UI Color</h2>
                                </div>
                                <form action="{{route('admin.colorSettings.store1')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Element **</label>
                                                        <input class="form-control" name="element" placeholder="h1 | p | .class_name">
                                                        @if (Session::get('data') == 1)
                                                            @if ($errors->has('element'))
                                                                <p class="mb-0 text-danger">{{$errors->first('element')}}</p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label>Attribute **</label>
                                                        <input class="form-control" name="attribute" placeholder="color | background-color">
                                                        @if (Session::get('data') == 1)
                                                            @if ($errors->has('attribute'))
                                                                <p class="mb-0 text-danger">{{$errors->first('attribute')}}</p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>Color **</label>
                                                        <input class="jscolor form-control ltr" name="color">
                                                        @if (Session::get('data') == 1)
                                                            @if ($errors->has('color'))
                                                                <p class="mb-0 text-danger">{{$errors->first('color')}}</p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <label>Click me!</label>
                                                        <button type="submit" id="displayNotif" class="btn btn-success">Save</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br><br>

                            <div class="row">
                                <div class="col-lg-10 text-center">
                                    <h2>Update Custom UI Colors</h2>
                                </div>
                                @if ($colors->count() > 0)
                                    @foreach ($colors as $color)
                                        <form action="{{route('admin.colorSettings.update', $color->id)}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Element **</label>
                                                                <input class="form-control" disabled name="element" value="{{ $color->element }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Attribute **</label>
                                                                <input class="form-control" disabled name="attribute" value="{{ $color->attribute }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Color **</label>
                                                                <input class="jscolor form-control ltr" name="color" value="{{ str_replace(' ', '', str_replace('!important', '', $color->value)) }}">
                                                                @if (Session::get('data') == 2)
                                                                    @if ($errors->has('color'))
                                                                        <p class="mb-0 text-danger">{{$errors->first('color')}}</p>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-1">
                                                            <div class="form-group">
                                                                <label>Click me!</label>
                                                                <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>Delete</label>
                                                                <a class="btn btn-danger" href="{{route('admin.colorSettings.destroy',$color->id)}}" >
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </form>
                                        {{-- <form id="delete-color" action="{{route('admin.colorSettings.destroy',$color->id)}}" method="POST" style="display: none;">
                                            @csrf
                                        </form> --}}
                                    @endforeach
                                @else
                                    <div class="col-lg-10 text-center mt-5">
                                        <h4>Add custom color by above options</h4>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var forms       = $('.color-presets').find('form');

        forms.on('submit', function(e) {
            e.preventDefault();
            var thisForm    = $(this);
            var initialHtml = $(this).find('button[type="submit"]').html();

            $(this).find('button[type="submit"]').html('<i class="fa fa-spinner fa-spin fa-pulse" aria-hidden="true">&nbsp;</i>');



            var d_important = $(this).find('input[name="attribute"]').length < 1 ? $(this).find('select[name="attribute"]').find('option:selected').attr('data-important') : $(this).find('input[name="attribute"]').attr('data-important');
            var data        = {
                "color"     : $(this).find('input[name="color"]').val()+' '+d_important,
                "element"   : $(this).find('input[name="element"]').val(),
                "attribute" : $(this).find('input[name="attribute"]').length < 1 ? $(this).find('select[name="attribute"]').find('option:selected').val() : $(this).find('input[name="attribute"]').val(),
            };
            $.ajax({
                type: "POST",
                url: "{{ route('admin.colorSettings.presets') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    $(this).find('input[name="attribute"]').attr('data-color', data.color);
                    $(this).find('select[name="attribute"]').find('option:selected').attr('data-color', data.color);
                }
            });

            setTimeout(function() {
                thisForm.find('button[type="submit"]').html(initialHtml);
            }, 2000);


        });

    </script>
    <script>
        $(document).ready(function() {
            var forms       = $('.color-presets').find('form');
            for (let index = 0; index < forms.length; index++) {
                var thisForm    = $('.color-presets').find('form:eq('+index+')');
                var colorDiv    = thisForm.closest('form').find('input[name="color"]');
                var colorSwatch = thisForm.find('input[name="attribute"]').length < 1 ? thisForm.find('option:selected').attr('data-color') : thisForm.find('input[name="attribute"]').attr('data-color');

                if(colorSwatch == undefined) colorSwatch = "f1f1f1";

                colorDiv.val(colorSwatch);
                colorDiv.css({"background-color" : "#"+colorSwatch });

            }
        });
    </script>
    <script>
        $('select[name="attribute"]').on('change', function() {
            var colorDiv    = $(this).closest('form').find('input[name="color"]');
            var colorSwatch = $(this).find('option:selected').attr('data-color');

            if(colorSwatch == undefined) colorSwatch = "f1f1f1";

            colorDiv.val(colorSwatch);
            colorDiv.css({"background-color" : "#"+colorSwatch });
        });
    </script>
    <script>
        var initialHtml = $('.save-all-presets').html();
        var savings = 0;
        $('.save-all-presets').on('click', function(){
            var forms   = $('.color-presets').find('form');


            for (let index = 0; index < forms.length; index++) {
                savings     = index + 1;
                var progress= '<i class="fa fa-spinner fa-spin fa-pulse" aria-hidden="true">&nbsp;</i>'+savings+'/'+forms.length+' - '+parseInt((savings/forms.length)*100)+'% complete';
                savePreset($('.color-presets').find('form:eq('+index+')'), progress);
            }

            setTimeout(function() {
                $('.save-all-presets').html(initialHtml);
            }, 2000);
        });
        $('.clear-all-presets').on('click', function(){
            window.location.assign("{{ route('admin.colorSettings.bulk-destroy') }}");
        });

        function savePreset(f1, progress){
            $('.save-all-presets').html(progress);

            var url     = "{{ route('admin.colorSettings.presets') }}";
            var d_important = f1.find('input[name="attribute"]').length < 1 ? f1.find('select[name="attribute"]').find('option:selected').attr('data-important') : f1.find('input[name="attribute"]').attr('data-important');
            var data        = {
                "color"     : f1.find('input[name="color"]').val()+' '+d_important,
                "element"   : f1.find('input[name="element"]').val(),
                "attribute" : f1.find('input[name="attribute"]').length < 1 ? f1.find('select[name="attribute"]').find('option:selected').val() : f1.find('input[name="attribute"]').val(),
            };

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response) {
                    $(this).find('select[name="attribute"]').find('option:selected').attr('data-color', data.color);
                },
                dataType: 'json'
            });
        }
    </script>
    <script>
        $("#hard_options").html($("#hard_options option").sort(function (a, b) {
            return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
        })).prepend('<option value="" disabled selected>Please choose an element</option>');
    </script>
@endsection
