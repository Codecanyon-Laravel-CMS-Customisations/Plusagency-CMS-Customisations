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
                <div class="col-lg-10">
                    <div class="card-title">Update Website Color Settings</div>
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
                                       <option value="button:hover">Button Hover</option>
                                       <option value=".btn:hover">Button Class Hover</option>
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

@endsection
