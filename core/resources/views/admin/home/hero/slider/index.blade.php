@extends('admin.layout')

@section('content')
    <div class="page-header">
        <h4 class="page-title">Sliders</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Home Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Hero Section</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Sliders</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            @if (!empty($langs))
                                <select name="language" class="form-control"
                                    onchange="window.location='{{ url()->current() . '?language=' }}'+this.value">
                                    <option value="" selected disabled>Select a Language</option>
                                    @foreach ($langs as $lang)
                                        <option value="{{ $lang->code }}"
                                            {{ $lang->code == request()->input('language') ? 'selected' : '' }}>
                                            {{ $lang->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="col-lg-4 mt-2 mt-lg-0">
                            <a href="#" class="btn btn-primary float-lg-right float-left py-2" data-toggle="modal"
                                data-target="#createModal">
                                <i class="fas fa-plus"></i>
                                <strong>Add General Slider</strong>
                            </a>
                        </div>
                    </div>

















                    <style>
                        .nav-pills.flex-column .nav-link:first-child,
                        .nav-pills.flex-column .nav-link:last-child,
                        .nav-pills.flex-column .nav-link {
                            border-radius: 4px 4px !important;
                        }

                        .predefined-tabs-wrapper .nav-pills a {
                            border: 0px !important;
                            display: block;
                            padding: .5rem 1rem;
                            /* background-color: transparent !important; */
                            color: white !important;
                            font-weight: bolder !important;
                        }

                        .predefined-tabs-wrapper .nav-pills :not(a.active) {
                            background-color: transparent !important;
                        }

                        /* .predefined-tabs-wrapper .nav-pills a:first-child {
                                margin-top: 2rem !important;
                            } */

                    </style>
                    <div class="row pt-5 predefined-tabs-wrapper">
                        <div class="col-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab1" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link my-1 text-left pl-2 active" id="v-pills-tab-general" data-toggle="pill"
                                    href="#v-pills-general" role="tab" aria-controls="v-pills-general"
                                    aria-selected="true">General</a>
                                <a class="nav-link my-1 text-left pl-2 " id="v-pills-tab-s2" data-toggle="pill"
                                    href="#v-pills-s2" role="tab" aria-controls="v-pills-s2" aria-selected="false">Slider
                                    V2</a>
                                <button class="my-2 btn btn-block btn-success save-all-presets">
                                    <strong>SAVE ALL</strong>
                                </button>
                                <button class="my-2 btn btn-block btn-danger clear-all-presets">
                                    <strong>RESET ALL</strong>
                                </button>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content color-presets pt-4" id="v-pills-tabContent1">
                                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel"
                                    aria-labelledby="v-pills-general-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if (count($sliders) == 0)
                                                <h3 class="text-center">NO SLIDER FOUND</h3>
                                            @else
                                                <div class="row">
                                                    @foreach ($sliders as $key => $slider)
                                                        <div class="col-md-4">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <img src="{{ asset('assets/front/img/sliders/' . $slider->image) }}"
                                                                        alt="" style="width:100%;">
                                                                </div>
                                                                <div class="card-footer text-center">
                                                                    <a class="btn btn-secondary btn-sm mr-2"
                                                                        href="{{ route('admin.slider.edit', $slider->id) . '?language=' . request()->input('language') }}">
                                                                        <span class="btn-label">
                                                                            <i class="fas fa-edit"></i>
                                                                        </span>
                                                                        Edit
                                                                    </a>
                                                                    <form class="deleteform d-inline-block"
                                                                        action="{{ route('admin.slider.delete') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="slider_id"
                                                                            value="{{ $slider->id }}">
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm deletebtn">
                                                                            <span class="btn-label">
                                                                                <i class="fas fa-trash"></i>
                                                                            </span>
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="v-pills-s2" role="tabpanel"
                                    aria-labelledby="v-pills-s2-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <nav>
                                                        <div class="nav nav-pills" id="nav-tab-slider-v2" role="tablist">
                                                            <a class="nav-link mx-2 active" id="nav-first-tab-v2"
                                                                data-toggle="tab" href="#nav-first-v2" role="tab"
                                                                aria-controls="nav-first-v2" aria-selected="true">
                                                                <strong>Main Sliders</strong>
                                                            </a>
                                                            <a class="nav-link mx-2" id="nav-second-tab-v2"
                                                                data-toggle="tab" href="#nav-second-v2" role="tab"
                                                                aria-controls="nav-second-v2" aria-selected="false">
                                                                <strong>
                                                                    Side Sliders
                                                                </strong>
                                                            </a>
                                                        </div>
                                                    </nav>
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-first-v2"
                                                            role="tabpanel" aria-labelledby="nav-first-tab-v2">
                                                            <div class="row">
                                                                <div
                                                                    class="col-md-12 pt-2 pl-1 d-flex justify-content-start pl-4">
                                                                    <a href="#"
                                                                        class="btn btn-primary float-lg-right float-left"
                                                                        data-toggle="modal" data-target="#createModal2">
                                                                        <i class="fas fa-plus"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                @foreach ($sliders_v2->where('slider_category', 'main') as $main_slider)
                                                                    <div class="col-md-4">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <img src="{{ asset("assets/front/img/sliders/$main_slider->image") }}"
                                                                                    alt="" style="width:100%;">
                                                                            </div>
                                                                            <div class="card-footer text-center">
                                                                                <a class="btn btn-secondary btn-sm mr-2"
                                                                                    href="{{ route('admin.slider-v2.edit', $main_slider->id) . '?language=' . request()->input('language') }}">
                                                                                    <span class="btn-label">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </span>
                                                                                    Edit
                                                                                </a>
                                                                                <form class="deleteform d-inline-block"
                                                                                    action="{{ route('admin.slider-v2.delete') }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    <input type="hidden" name="slider_id"
                                                                                        value="{{ $main_slider->id }}">
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger btn-sm deletebtn">
                                                                                        <span class="btn-label">
                                                                                            <i class="fas fa-trash"></i>
                                                                                        </span>
                                                                                        Delete
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-second-v2" role="tabpanel"
                                                            aria-labelledby="nav-second-tab-v2">
                                                            <div class="row">
                                                                <div
                                                                    class="col-md-12 pt-2 pl-1 d-flex justify-content-start pl-4">
                                                                    @if ($sliders_v2->where('slider_category', 'side1')->count() < 1)
                                                                        <a href="#"
                                                                            class="btn btn-primary py-2 px-3 float-lg-right float-left mx-2"
                                                                            data-toggle="modal" data-target="#createModal3">
                                                                            <i class="fas fa-plus"></i> <strong class="pl-1">sliders 1</strong>
                                                                        </a>
                                                                    @endif
                                                                    @if ($sliders_v2->where('slider_category', 'side2')->count() < 1)
                                                                        <a href="#"
                                                                            class="btn btn-primary py-2 px-3 float-lg-right float-left  mx-1"
                                                                            data-toggle="modal" data-target="#createModal4">
                                                                            <i class="fas fa-plus"></i> <strong class="pl-1">sliders 2</strong>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                @foreach ($sliders_v2->whereIn('slider_category', ['side1', 'side2']) as $side_slider)
                                                                    <div class="col-md-4">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <img src="{{ asset("assets/front/img/sliders/$side_slider->image") }}"
                                                                                    alt="" style="width:100%;">
                                                                            </div>
                                                                            <div class="card-footer text-center">
                                                                                <a class="btn btn-secondary btn-sm mr-2"
                                                                                    href="{{ route('admin.slider-v2.edit', $side_slider->id) . '?language=' . request()->input('language') }}">
                                                                                    <span class="btn-label">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </span>
                                                                                    Edit
                                                                                </a>
                                                                                <form class="deleteform d-inline-block"
                                                                                    action="{{ route('admin.slider-v2.delete') }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    <input type="hidden" name="slider_id"
                                                                                        value="{{ $side_slider->id }}">
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger btn-sm deletebtn">
                                                                                        <span class="btn-label">
                                                                                            <i class="fas fa-trash"></i>
                                                                                        </span>
                                                                                        Delete
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




































                </div>
            </div>
        </div>
    </div>


    <!-- Create Slider Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="modal-form" id="ajaxForm" action="{{ route('admin.slider.store') }}" method="post">
                        @csrf

                        {{-- Image Part --}}
                        <div class="form-group">
                            <label for="">Image ** </label>
                            <br>
                            <div class="thumb-preview" id="thumbPreview1">
                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="Slider Image">
                            </div>
                            <br>
                            <br>


                            <input id="fileInput1" type="hidden" name="image">
                            <button id="chooseImage1" class="choose-image btn btn-primary" type="button"
                                data-multiple="false" data-toggle="modal" data-target="#lfmModal1">Choose Image</button>


                            <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                            <p class="em text-danger mb-0" id="errimage"></p>

                        </div>

                        <div class="form-group">
                            <label for="">Language **</label>
                            <select name="language_id" class="form-control">
                                <option value="" selected disabled>Select a language</option>
                                @foreach ($langs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Title </label>
                                    <input type="text" class="form-control" name="title" value=""
                                        placeholder="Enter Title">
                                    <p id="errtitle" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Title Font Size **</label>
                                    <input type="number" class="form-control ltr" name="title_font_size" value="">
                                    <p id="errtitle_font_size" class="em text-danger mb-0"></p>
                                </div>
                            </div>
                        </div>


                        @if ($be->theme_version == 'gym' || $be->theme_version == 'car' || $be->theme_version == 'cleaning')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Bold Text </label>
                                        <input type="text" class="form-control" name="bold_text" value=""
                                            placeholder="Enter Bold Text">
                                        <p id="errbold_text" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Bold Text Font Size **</label>
                                        <input type="number" class="form-control ltr" name="bold_text_font_size" value="">
                                        <p id="errbold_text_font_size" class="em text-danger mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        @endif



                        @if ($be->theme_version == 'cleaning')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Bold Text Color **</label>
                                        <input type="text" class="form-control jscolor" name="bold_text_color"
                                            value="#13287e">
                                        <p id="errbold_text_color" class="em text-danger mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @if ($be->theme_version != 'cleaning')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Text </label>
                                        <input type="text" class="form-control" name="text" value=""
                                            placeholder="Enter Text">
                                        <p id="errtext" class="mb-0 text-danger em"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Text Font Size **</label>
                                        <input type="number" class="form-control ltr" name="text_font_size" value="">
                                        <p id="errtext_font_size" class="em text-danger mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        @endif


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Button Text </label>
                                    <input type="text" class="form-control" name="button_text" value=""
                                        placeholder="Enter Button Text">
                                    <p id="errbutton_text" class="mb-0 text-danger em"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Button Text Font Size **</label>
                                    <input type="number" class="form-control ltr" name="button_text_font_size" value="">
                                    <p id="errbutton_text_font_size" class="em text-danger mb-0"></p>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="">Button URL </label>
                            <input type="text" class="form-control ltr" name="button_url" value=""
                                placeholder="Enter Button URL">
                            <p id="errbutton_url" class="mb-0 text-danger em"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Serial Number **</label>
                            <input type="number" class="form-control ltr" name="serial_number" value=""
                                placeholder="Enter Serial Number">
                            <p id="errserial_number" class="mb-0 text-danger em"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the slider will be
                                    shown.</small></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle2"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="modal-form" id="ajaxFormV2M" action="{{ route('admin.slider-v2.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="category" value="main">

                        {{-- Image Part --}}
                        <div class="form-group">
                            <label for="">Image **</label>
                            <br>
                            <div class="thumb-preview" id="thumbPreview2">
                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="Slider Image">
                            </div>
                            <br>
                            <br>


                            <input id="fileInput2" type="hidden" name="image">
                            <button id="chooseImage2" class="choose-image btn btn-primary" type="button"
                                data-multiple="false" data-toggle="modal" data-target="#lfmModal2">Choose Image</button>


                            <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                            <p class="em text-danger mb-0 errimage" data-id="errimage"></p>

                        </div>

                        <div class="form-group">
                            <label for="">Language **</label>
                            <select name="language_id" class="form-control">
                                <option value="" selected disabled>Select a language</option>
                                @foreach ($langs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <p data-id="errlanguage_id" class="mb-0 text-danger em errlanguage_id"></p>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Title </label>
                                    <input type="text" class="form-control" name="title" value=""
                                        placeholder="Enter Title">
                                    <p data-id="errtitle" class="mb-0 text-danger em errtitle"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Title Font Size **</label>
                                    <input type="number" class="form-control ltr" name="title_font_size" value="">
                                    <p data-id="errtitle_font_size" class="em text-danger mb-0 errtitle_font_size"></p>
                                </div>
                            </div>
                        </div>

                        @if ($be->theme_version == 'gym' || $be->theme_version == 'car' || $be->theme_version == 'cleaning')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Bold Text </label>
                                        <input type="text" class="form-control" name="bold_text" value=""
                                            placeholder="Enter Bold Text">
                                        <p data-id="errbold_text" class="mb-0 text-danger em errbold_text"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Bold Text Font Size **</label>
                                        <input type="number" class="form-control ltr" name="bold_text_font_size" value="">
                                        <p data-id="errbold_text_font_size" class="em text-danger mb-0 errbold_text_font_size"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($be->theme_version == 'cleaning')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Bold Text Color **</label>
                                        <input type="text" class="form-control jscolor" name="bold_text_color"
                                            value="#13287e">
                                        <p data-id="errbold_text_color" class="em text-danger mb-0 errbold_text_color"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($be->theme_version != 'cleaning')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Text </label>
                                        <input type="text" class="form-control" name="text" value=""
                                            placeholder="Enter Text">
                                        <p data-id="errtext" class="mb-0 text-danger em errtext"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Text Font Size **</label>
                                        <input type="number" class="form-control ltr" name="text_font_size" value="">
                                        <p data-id="errtext_font_size" class="em text-danger mb-0 errtext_font_size"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Button Text </label>
                                    <input type="text" class="form-control" name="button_text" value=""
                                        placeholder="Enter Button Text">
                                    <p data-id="errbutton_text" class="mb-0 text-danger em errbutton_text"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Button Text Font Size **</label>
                                    <input type="number" class="form-control ltr" name="button_text_font_size" value="">
                                    <p data-id="errbutton_text_font_size" class="em text-danger mb-0 errbutton_text_font_size"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Button URL </label>
                            <input type="text" class="form-control ltr" name="button_url" value=""
                                placeholder="Enter Button URL">
                            <p data-id="errbutton_url" class="mb-0 text-danger em errbutton_url"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Serial Number **</label>
                            <input type="number" class="form-control ltr" name="serial_number" value=""
                                placeholder="Enter Serial Number">
                            <p data-id="errserial_number" class="mb-0 text-danger em errserial_number"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the slider will be
                                    shown.</small></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitBtnV2M" type="button" class="btn btn-primary submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle3"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="modal-form" id="ajaxFormV2S1" action="{{ route('admin.slider-v2.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="category" value="side1">

                        {{-- Image Part --}}
                        <div class="form-group">
                            <label for="">Image **</label>
                            <br>
                            <div class="thumb-preview" id="thumbPreview3">
                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="Slider Image">
                            </div>
                            <br>
                            <br>


                            <input id="fileInput3" type="hidden" name="image">
                            <button id="chooseImage3" class="choose-image btn btn-primary" type="button"
                                data-multiple="false" data-toggle="modal" data-target="#lfmModal3">Choose Image</button>


                            <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                            <p class="em text-danger mb-0 errimage" data-id="errimage"></p>

                        </div>

                        <div class="form-group">
                            <label for="">Language **</label>
                            <select name="language_id" class="form-control">
                                <option value="" selected disabled>Select a language</option>
                                @foreach ($langs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <p data-id="errlanguage_id" class="mb-0 text-danger em errlanguage_id"></p>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Title </label>
                                    <input type="text" class="form-control" name="title" value=""
                                        placeholder="Enter Title">
                                    <p data-id="errtitle" class="mb-0 text-danger em errtitle"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Title Font Size **</label>
                                    <input type="number" class="form-control ltr" name="title_font_size" value="">
                                    <p data-id="errtitle_font_size" class="em text-danger mb-0 errtitle_font_size"></p>
                                </div>
                            </div>
                        </div>

                        @if ($be->theme_version == 'gym' || $be->theme_version == 'car' || $be->theme_version == 'cleaning')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Bold Text </label>
                                        <input type="text" class="form-control" name="bold_text" value=""
                                            placeholder="Enter Bold Text">
                                        <p data-id="errbold_text" class="mb-0 text-danger em errbold_text"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Bold Text Font Size **</label>
                                        <input type="number" class="form-control ltr" name="bold_text_font_size" value="">
                                        <p data-id="errbold_text_font_size" class="em text-danger mb-0 errbold_text_font_size"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($be->theme_version == 'cleaning')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Bold Text Color **</label>
                                        <input type="text" class="form-control jscolor" name="bold_text_color"
                                            value="#13287e">
                                        <p data-id="errbold_text_color" class="em text-danger mb-0 errbold_text_color"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($be->theme_version != 'cleaning')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Text </label>
                                        <input type="text" class="form-control" name="text" value=""
                                            placeholder="Enter Text">
                                        <p data-id="errtext" class="mb-0 text-danger em errtext"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Text Font Size **</label>
                                        <input type="number" class="form-control ltr" name="text_font_size" value="">
                                        <p data-id="errtext_font_size" class="em text-danger mb-0 errtext_font_size"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Button Text </label>
                                    <input type="text" class="form-control" name="button_text" value=""
                                        placeholder="Enter Button Text">
                                    <p data-id="errbutton_text" class="mb-0 text-danger em errbutton_text"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Button Text Font Size **</label>
                                    <input type="number" class="form-control ltr" name="button_text_font_size" value="">
                                    <p data-id="errbutton_text_font_size" class="em text-danger mb-0 errbutton_text_font_size"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Button URL </label>
                            <input type="text" class="form-control ltr" name="button_url" value=""
                                placeholder="Enter Button URL">
                            <p data-id="errbutton_url" class="mb-0 text-danger em errbutton_url"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Serial Number **</label>
                            <input type="number" class="form-control ltr" name="serial_number" value=""
                                placeholder="Enter Serial Number">
                            <p data-id="errserial_number" class="mb-0 text-danger em errserial_number"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the slider will be
                                    shown.</small></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitBtnV2S1" type="button" class="btn btn-primary submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle4"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="modal-form" id="ajaxFormV2S2" action="{{ route('admin.slider-v2.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="category" value="side2">

                        {{-- Image Part --}}
                        <div class="form-group">
                            <label for="">Image **</label>
                            <br>
                            <div class="thumb-preview" id="thumbPreview4">
                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="Slider Image">
                            </div>
                            <br>
                            <br>


                            <input id="fileInput4" type="hidden" name="image">
                            <button id="chooseImage4" class="choose-image btn btn-primary" type="button"
                                data-multiple="false" data-toggle="modal" data-target="#lfmModal4">Choose Image</button>


                            <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                            <p class="em text-danger mb-0 errimage" data-id="errimage"></p>

                        </div>

                        <div class="form-group">
                            <label for="">Language **</label>
                            <select name="language_id" class="form-control">
                                <option value="" selected disabled>Select a language</option>
                                @foreach ($langs as $lang)
                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                @endforeach
                            </select>
                            <p data-id="errlanguage_id" class="mb-0 text-danger em errlanguage_id"></p>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Title </label>
                                    <input type="text" class="form-control" name="title" value=""
                                        placeholder="Enter Title">
                                    <p data-id="errtitle" class="mb-0 text-danger em errtitle"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Title Font Size **</label>
                                    <input type="number" class="form-control ltr" name="title_font_size" value="">
                                    <p data-id="errtitle_font_size" class="em text-danger mb-0 errtitle_font_size"></p>
                                </div>
                            </div>
                        </div>

                        @if ($be->theme_version == 'gym' || $be->theme_version == 'car' || $be->theme_version == 'cleaning')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Bold Text </label>
                                        <input type="text" class="form-control" name="bold_text" value=""
                                            placeholder="Enter Bold Text">
                                        <p data-id="errbold_text" class="mb-0 text-danger em errbold_text"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Bold Text Font Size **</label>
                                        <input type="number" class="form-control ltr" name="bold_text_font_size" value="">
                                        <p data-id="errbold_text_font_size" class="em text-danger mb-0 errbold_text_font_size"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($be->theme_version == 'cleaning')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Bold Text Color **</label>
                                        <input type="text" class="form-control jscolor" name="bold_text_color"
                                            value="#13287e">
                                        <p data-id="errbold_text_color" class="em text-danger mb-0 errbold_text_color"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($be->theme_version != 'cleaning')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Text </label>
                                        <input type="text" class="form-control" name="text" value=""
                                            placeholder="Enter Text">
                                        <p data-id="errtext" class="mb-0 text-danger em errtext"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Text Font Size **</label>
                                        <input type="number" class="form-control ltr" name="text_font_size" value="">
                                        <p data-id="errtext_font_size" class="em text-danger mb-0 errtext_font_size"></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Button Text </label>
                                    <input type="text" class="form-control" name="button_text" value=""
                                        placeholder="Enter Button Text">
                                    <p data-id="errbutton_text" class="mb-0 text-danger em errbutton_text"></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Button Text Font Size **</label>
                                    <input type="number" class="form-control ltr" name="button_text_font_size" value="">
                                    <p data-id="errbutton_text_font_size" class="em text-danger mb-0 errbutton_text_font_size"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Button URL </label>
                            <input type="text" class="form-control ltr" name="button_url" value=""
                                placeholder="Enter Button URL">
                            <p data-id="errbutton_url" class="mb-0 text-danger em errbutton_url"></p>
                        </div>
                        <div class="form-group">
                            <label for="">Serial Number **</label>
                            <input type="number" class="form-control ltr" name="serial_number" value=""
                                placeholder="Enter Serial Number">
                            <p data-id="errserial_number" class="mb-0 text-danger em errserial_number"></p>
                            <p class="text-warning"><small>The higher the serial number is, the later the slider will be
                                    shown.</small></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitBtnV2S2" type="button" class="btn btn-primary submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image LFM Modal -->
    <div class="modal fade lfm-modal" id="lfmModal1" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle"
    aria-hidden="true">
        <i class="fas fa-times-circle"></i>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <iframe src="{{ url('laravel-filemanager') }}?serial=1"
                        style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade lfm-modal" id="lfmModal2" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle"
        aria-hidden="true">
        <i class="fas fa-times-circle"></i>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <iframe src="{{ url('laravel-filemanager') }}?serial=2"
                        style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade lfm-modal" id="lfmModal3" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle"
        aria-hidden="true">
        <i class="fas fa-times-circle"></i>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <iframe src="{{ url('laravel-filemanager') }}?serial=3"
                        style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade lfm-modal" id="lfmModal4" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle"
        aria-hidden="true">
        <i class="fas fa-times-circle"></i>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <iframe src="{{ url('laravel-filemanager') }}?serial=4"
                        style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $("#ajaxFormV2M").attr('onsubmit', 'return false');
            $("#ajaxFormV2S1").attr('onsubmit', 'return false');
            $("#ajaxFormV2S2").attr('onsubmit', 'return false');

            $("#submitBtnV2M").on('click', function (e) {
                $(e.target).attr('disabled', true);
                $(".request-loader").addClass("show");
                let ajaxForm    = document.getElementById('ajaxFormV2M');
                let fd          = new FormData(ajaxForm);
                let url         = $("#ajaxFormV2M").attr('action');
                let method      = $("#ajaxFormV2M").attr('method');
                // console.log(url);
                // console.log(method);

                if ($("#ajaxFormV2M .summernote").length > 0) {
                    $("#ajaxFormV2M .summernote").each(function (i) {
                        let content = $(this).summernote('code');

                        fd.delete($(this).attr('name'));
                        fd.append($(this).attr('name'), content);
                    });
                }

                $.ajax({
                url: url,
                method: method,
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);

                    $(e.target).attr('disabled', false);
                    $(".request-loader").removeClass("show");

                    $(".em").each(function () {
                    $(this).html('');
                    })

                    if (data == "success") {
                    location.reload();
                    }

                    // if error occurs
                    else if (typeof data.error != 'undefined') {
                    for (let x in data) {
                        console.log(x);
                        if (x == 'error') {
                        continue;
                        }
                        $('#ajaxFormV2M').find('.err' + x).html(data[x][0]);
                    }
                    }

                },
                error: function (error){
                    $(".em").each(function () {
                    $(this).html('');
                    })
                    for (let x in error.responseJSON.errors) {
                    console.log('err'+x);
                    $('#ajaxFormV2M').find('.err' + x).html(error.responseJSON.errors[x][0]);
                    }
                    $(".request-loader").removeClass("show");
                    $(e.target).attr('disabled', false);
                }
                });
            });
            $("#submitBtnV2S1").on('click', function (e) {
                $(e.target).attr('disabled', true);
                $(".request-loader").addClass("show");
                let ajaxForm    = document.getElementById('ajaxFormV2S1');
                let fd          = new FormData(ajaxForm);
                let url         = $("#ajaxFormV2S1").attr('action');
                let method      = $("#ajaxFormV2S1").attr('method');
                // console.log(url);
                // console.log(method);

                if ($("#ajaxFormV2S1 .summernote").length > 0) {
                    $("#ajaxFormV2S1 .summernote").each(function (i) {
                        let content = $(this).summernote('code');

                        fd.delete($(this).attr('name'));
                        fd.append($(this).attr('name'), content);
                    });
                }

                $.ajax({
                url: url,
                method: method,
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);

                    $(e.target).attr('disabled', false);
                    $(".request-loader").removeClass("show");

                    $(".em").each(function () {
                    $(this).html('');
                    })

                    if (data == "success") {
                    location.reload();
                    }

                    // if error occurs
                    else if (typeof data.error != 'undefined') {
                    for (let x in data) {
                        console.log(x);
                        if (x == 'error') {
                        continue;
                        }
                        $('#ajaxFormV2S1').find('.err' + x).html(data[x][0]);
                    }
                    }

                },
                error: function (error){
                    $(".em").each(function () {
                    $(this).html('');
                    })
                    for (let x in error.responseJSON.errors) {
                    console.log('err'+x);
                    $('#ajaxFormV2S1').find('.err' + x).html(error.responseJSON.errors[x][0]);
                    }
                    $(".request-loader").removeClass("show");
                    $(e.target).attr('disabled', false);
                }
                });
            });
            $("#submitBtnV2S2").on('click', function (e) {
                $(e.target).attr('disabled', true);
                $(".request-loader").addClass("show");
                let ajaxForm    = document.getElementById('ajaxFormV2S2');
                let fd          = new FormData(ajaxForm);
                let url         = $("#ajaxFormV2S2").attr('action');
                let method      = $("#ajaxFormV2S2").attr('method');
                // console.log(url);
                // console.log(method);

                if ($("#ajaxFormV2S2 .summernote").length > 0) {
                    $("#ajaxFormV2S2 .summernote").each(function (i) {
                        let content = $(this).summernote('code');

                        fd.delete($(this).attr('name'));
                        fd.append($(this).attr('name'), content);
                    });
                }

                $.ajax({
                url: url,
                method: method,
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);

                    $(e.target).attr('disabled', false);
                    $(".request-loader").removeClass("show");

                    $(".em").each(function () {
                    $(this).html('');
                    })

                    if (data == "success") {
                    location.reload();
                    }

                    // if error occurs
                    else if (typeof data.error != 'undefined') {
                    for (let x in data) {
                        console.log(x);
                        if (x == 'error') {
                        continue;
                        }
                        $('#ajaxFormV2S2').find('.err' + x).html(data[x][0]);
                    }
                    }

                },
                error: function (error){
                    $(".em").each(function () {
                    $(this).html('');
                    })
                    for (let x in error.responseJSON.errors) {
                    console.log('err'+x);
                    $('#ajaxFormV2S2').find('.err' + x).html(error.responseJSON.errors[x][0]);
                    }
                    $(".request-loader").removeClass("show");
                    $(e.target).attr('disabled', false);
                }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            // make input fields RTL
            $("select[name='language_id']").on('change', function() {
                $(".request-loader").addClass("show");
                let url = "{{ url('/') }}/admin/rtlcheck/" + $(this).val();
                console.log(url);
                $.get(url, function(data) {
                    $(".request-loader").removeClass("show");
                    if (data == 1) {
                        $("form input").each(function() {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form select").each(function() {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form textarea").each(function() {
                            if (!$(this).hasClass('ltr')) {
                                $(this).addClass('rtl');
                            }
                        });
                        $("form .nicEdit-main").each(function() {
                            $(this).addClass('rtl text-right');
                        });

                    } else {
                        $("form input, form select, form textarea").removeClass('rtl');
                        $("form .nicEdit-main").removeClass('rtl text-right');
                    }
                })
            });
        });
    </script>
@endsection
