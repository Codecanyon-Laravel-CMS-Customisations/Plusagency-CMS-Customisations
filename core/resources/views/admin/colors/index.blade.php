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
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <div class="card-title">Update Website Color Settings
                        <button data-toggle="modal" data-target="#createModal" class="btn btn-success btn-sm pull-right text-uppercase">
                            <small>
                                <i class="fas fa-tasks mr-2   "></i>
                                <strong>Predefined Additions</strong>
                            </small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body pt-5 pb-5">
            <div class="row">
                <div class="col-lg-10 text-center">
                    <h2>Available Custom UI Colors</h2>
                </div>
                <form action="{{route('admin.colorSettings.store')}}" method="post">
                    @csrf
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Element **</label>
                                    <select name="element" class="form-control">
                                       <option value="" disabled selected>Please choose an element</option>
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
                </form>
            </div>
            <br><br>

            <div class="row">
                <div class="col-lg-10 text-center">
                    <h2>Create Custom UI Color</h2>
                </div>
                <form action="{{route('admin.colorSettings.store1')}}" method="post">
                    @csrf
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
                                        <input class="jscolor form-control ltr" name="color" value="{{ $color->value }}">
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

    <style>
        @media (min-width: 1200px){
            .modal-xl {
                max-width: 1140px;
            }
        }
        .modal-body .nav-pills a {
            border:0px !important;
            display: block;
            padding: .5rem 1rem;
            /* background-color: transparent !important; */
            color: white !important;
            font-weight: bolder !important;

        }
        .modal-body .nav-pills :not(a.active) {
            background-color: transparent !important;
        }
    </style>

  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
      <div class="modal-content">
        {{-- <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"> select your options</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> --}}
        <div class="modal-body">
            <div class="row">
                @php
                    $website_colors_obj = App\WebsiteColors::COLOR_SELECTIONS;
                @endphp
                <div class="col-3">
                  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                      @foreach ($website_colors_obj as $key => $value)
                        <a class="nav-link @if($value['active']) active @endif" id="v-pills-tab-{{ $key }}" data-toggle="pill" href="#v-pills-{{ $key }}" role="tab" aria-controls="v-pills-{{ $key }}" aria-selected="@if($value['active']) true @else false @endif">{{ $value['tab_title'] }}</a>
                      @endforeach
                  </div>
                </div>
                <div class="col-9">
                  <div class="tab-content" id="v-pills-tabContent">
                    @foreach ($website_colors_obj as $key => $value)
                        <a class="nav-link @if($value['active']) active @endif" id="v-pills-tab-{{ $key }}" data-toggle="pill" href="#v-pills-{{ $key }}" role="tab" aria-controls="v-pills-{{ $key }}" aria-selected="@if($value['active']) true @else false @endif">{{ $value['tab_title'] }}</a>
                        <div class="tab-pane fade show active" id="v-pills-0" role="tabpanel" aria-labelledby="v-pills-tab-0">
                            <div class="row">
                                {{-- <div class="col-12 text-center">
                                    <h5>Update Custom UI Colors</h5>
                                </div> --}}
                                @php
                                    $elements = $value['elements'];
                                @endphp
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
                                                            <div class="row">
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
                                                        </form>
                                                    </div>
                                                    <div class="col-12">
                                                        <form action="{{route('admin.colorSettings.store')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="element" value="{{ $element['attr_hover'] }}">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label>Attribute *HOVER*</label>
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
                                                        </form>
                                                    </div>
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
      </div>
    </div>
  </div>

@endsection
