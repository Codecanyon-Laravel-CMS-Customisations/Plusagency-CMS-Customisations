@extends('admin.layout')

@section('content')
<div class="page-header">
    <h4 class="page-title">Settings</h4>
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
            <a href="#">Theme & Home</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Settings</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Settings</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <form action="{{route('admin.homeSettings.update')}}" id="themeForm" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Home Page - Page Builder **</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="home_page_pagebuilder" value="1" class="selectgroup-input" {{$abex->home_page_pagebuilder == 1 ? 'checked' : ''}}>
                                                <span class="selectgroup-button">Active</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="home_page_pagebuilder" value="0" class="selectgroup-input" {{$abex->home_page_pagebuilder == 0 ? 'checked' : ''}}>
                                                <span class="selectgroup-button">Deactive</span>
                                            </label>
                                        </div>
                                        <p class="text-warning mb-0">If <strong class="text-success">Active</strong>, then <strong>Content of Home Page Builder</strong> will be shown in <strong>Website's Home Page</strong></p>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Select a Theme **</label>
                                        <select class="form-control" name="theme_version">
                                            <option value="" selected disabled>Select a Theme</option>
                                            <option value="default" {{$abe->theme_version == 'default' ? 'selected' : ''}}>Default</option>
                                            <option value="dark" {{$abe->theme_version == 'dark' ? 'selected' : ''}}>Dark</option>
                                            <option value="gym" {{$abe->theme_version == 'gym' ? 'selected' : ''}}>Gym</option>
                                            <option value="car" {{$abe->theme_version == 'car' ? 'selected' : ''}}>Car</option>
                                            <option value="cleaning" {{$abe->theme_version == 'cleaning' ? 'selected' : ''}}>Cleaning</option>
                                            <option value="construction" {{$abe->theme_version == 'construction' ? 'selected' : ''}}>Construction</option>
                                            <option value="logistic" {{$abe->theme_version == 'logistic' ? 'selected' : ''}}>Logistic</option>
                                            <option value="lawyer" {{$abe->theme_version == 'lawyer' ? 'selected' : ''}}>Lawyer</option>
                                            <option value="bookworm" {{$abe->theme_version == 'bookworm' ? 'selected' : ''}}>Book Worm</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Select a Home Version</label>
                                        <select name="home_version" class="form-control">
                                            <option value="" selected disabled>Select a Home Version</option>
                                            <option value="static" {{$bs->home_version == 'static' ? 'selected' : ''}}>Static</option>
                                            <option value="slider" {{$bs->home_version == 'slider' ? 'selected' : ''}}>Slider</option>
                                            <option value="video" {{$bs->home_version == 'video' ? 'selected' : ''}}>Video</option>
                                            <option value="water" {{$bs->home_version == 'water' ? 'selected' : ''}}>Water</option>
                                            <option value="particles" {{$bs->home_version == 'particles' ? 'selected' : ''}}>Particles</option>
                                            <option value="parallax" {{$bs->home_version == 'parallax' ? 'selected' : ''}}>Parallax</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <h5 class="mt-3">BookWorm Settings</h5>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Select Home Slider Version</label>
                                        <select class="form-control" name="bookworm_slider_version">
                                            <option value="" selected disabled>Select Home Slider Version</option>
                                            {{-- <option value="default" {{$abe->theme_version == 'default' ? 'selected' : ''}}>Default</option> --}}
                                            <option value="v1" {{$abe->bookworm_slider_version == 'v1' ? 'selected' : ''}}>Home v1</option>
                                            <option value="v2" {{$abe->bookworm_slider_version == 'v2' ? 'selected' : ''}}>Home v2</option>
                                            <option value="v3" {{$abe->bookworm_slider_version == 'v3' ? 'selected' : ''}}>Home v3</option>
                                            <option value="v4" {{$abe->bookworm_slider_version == 'v4' ? 'selected' : ''}}>Home v4</option>
                                            <option value="v5" {{$abe->bookworm_slider_version == 'v5' ? 'selected' : ''}}>Home v5</option>
                                            <option value="v6" {{$abe->bookworm_slider_version == 'v6' ? 'selected' : ''}}>Home v6</option>
                                            <option value="v7" {{$abe->bookworm_slider_version == 'v7' ? 'selected' : ''}}>Home v7</option>
                                            <option value="v8" {{$abe->bookworm_slider_version == 'v8' ? 'selected' : ''}}>Home v8</option>
                                            <option value="v9" {{$abe->bookworm_slider_version == 'v9' ? 'selected' : ''}}>Home v9</option>
                                            <option value="v10" {{$abe->bookworm_slider_version == 'v10' ? 'selected' : ''}}>Home v10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Select Shop List Version</label>
                                        <select class="form-control" name="bookworm_shop_list_version">
                                            <option value="" selected disabled>Select Shop List Version</option>
                                            {{-- <option value="default" {{$abe->theme_version == 'default' ? 'selected' : ''}}>Default</option> --}}
                                            <option value="v1" {{$abe->bookworm_shop_list_version == 'v1' ? 'selected' : ''}}>Shop List v1</option>
                                            {{-- <option value="v2" {{$abe->bookworm_shop_list_version == 'v2' ? 'selected' : ''}}>Shop List v2</option>
                                            <option value="v3" {{$abe->bookworm_shop_list_version == 'v3' ? 'selected' : ''}}>Shop List v3</option>
                                            <option value="v4" {{$abe->bookworm_shop_list_version == 'v4' ? 'selected' : ''}}>Shop List v4</option>
                                            <option value="v5" {{$abe->bookworm_shop_list_version == 'v5' ? 'selected' : ''}}>Shop List v5</option>
                                            <option value="v6" {{$abe->bookworm_shop_list_version == 'v6' ? 'selected' : ''}}>Shop List v6</option>
                                            <option value="v7" {{$abe->bookworm_shop_list_version == 'v7' ? 'selected' : ''}}>Shop List v7</option>
                                            <option value="v8" {{$abe->bookworm_shop_list_version == 'v8' ? 'selected' : ''}}>Shop List v8</option>
                                            <option value="v9" {{$abe->bookworm_shop_list_version == 'v9' ? 'selected' : ''}}>Shop List v9</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Select Product Single Version</label>
                                        <select class="form-control" name="bookworm_shop_single_version">
                                            <option value="" selected disabled>Select Shop Single Version</option>
                                            {{-- <option value="default" {{$abe->theme_version == 'default' ? 'selected' : ''}}>Default</option> --}}
                                            <option value="v1" {{$abe->bookworm_shop_single_version == 'v1' ? 'selected' : ''}}>Shop Single v1</option>
                                            <option value="v2" {{$abe->bookworm_shop_single_version == 'v2' ? 'selected' : ''}}>Shop Single v2</option>
                                            <option value="v3" {{$abe->bookworm_shop_single_version == 'v3' ? 'selected' : ''}}>Shop Single v3</option>
                                            <option value="v4" {{$abe->bookworm_shop_single_version == 'v4' ? 'selected' : ''}}>Shop Single v4</option>
                                            <option value="v5" {{$abe->bookworm_shop_single_version == 'v5' ? 'selected' : ''}}>Shop Single v5</option>
                                            <option value="v6" {{$abe->bookworm_shop_single_version == 'v6' ? 'selected' : ''}}>Shop Single v6</option>
                                            <option value="v7" {{$abe->bookworm_shop_single_version == 'v7' ? 'selected' : ''}}>Shop Single v7</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Select Header Version</label>
                                        <select class="form-control" name="bookworm_header_version">
                                            <option value="" selected disabled>Select Header Version</option>
                                            {{-- <option value="default" {{$abe->theme_version == 'default' ? 'selected' : ''}}>Default</option> --}}
                                            <option value="v1" {{$abe->bookworm_header_version == 'v1' ? 'selected' : ''}}>Header v1</option>
                                            <option value="v2" {{$abe->bookworm_header_version == 'v2' ? 'selected' : ''}}>Header v2</option>
                                            <option value="v3" {{$abe->bookworm_header_version == 'v3' ? 'selected' : ''}}>Header v3</option>
                                            {{-- <option value="v4" {{$abe->bookworm_header_version == 'v4' ? 'selected' : ''}}>Header v4</option>
                                            <option value="v5" {{$abe->bookworm_header_version == 'v5' ? 'selected' : ''}}>Header v5</option> --}}
                                            <option value="v6" {{$abe->bookworm_header_version == 'v6' ? 'selected' : ''}}>Header v6</option>
                                            <option value="v7" {{$abe->bookworm_header_version == 'v7' ? 'selected' : ''}}>Header v7</option>
                                            <option value="v8" {{$abe->bookworm_header_version == 'v8' ? 'selected' : ''}}>Header v8</option>
                                            <option value="v9" {{$abe->bookworm_header_version == 'v9' ? 'selected' : ''}}>Header v9</option>
                                            {{-- <option value="v10" {{$abe->bookworm_header_version == 'v10' ? 'selected' : ''}}>Header v10</option>
                                            <option value="v11" {{$abe->bookworm_header_version == 'v11' ? 'selected' : ''}}>Header v11</option> --}}
                                            <option value="v12" {{$abe->bookworm_header_version == 'v12' ? 'selected' : ''}}>Header v12</option>
                                            <option value="v13" {{$abe->bookworm_header_version == 'v13' ? 'selected' : ''}}>Header v13</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="">Select Footer Version</label>
                                        <select class="form-control" name="bookworm_footer_version">
                                            <option value="" selected disabled>Select Footer Version</option>
                                            {{-- <option value="default" {{$abe->theme_version == 'default' ? 'selected' : ''}}>Default</option> --}}
                                            <option value="v1" {{$abe->bookworm_footer_version == 'v1' ? 'selected' : ''}}>Footer v1</option>
                                            <option value="v2" {{$abe->bookworm_footer_version == 'v2' ? 'selected' : ''}}>Footer v2</option>
                                            <option value="v3" {{$abe->bookworm_footer_version == 'v3' ? 'selected' : ''}}>Footer v3</option>
                                            <option value="v4" {{$abe->bookworm_footer_version == 'v4' ? 'selected' : ''}}>Footer v4</option>
                                            <option value="v5" {{$abe->bookworm_footer_version == 'v5' ? 'selected' : ''}}>Footer v5</option>
                                            <option value="v6" {{$abe->bookworm_footer_version == 'v6' ? 'selected' : ''}}>Footer v6</option>
                                            <option value="v7" {{$abe->bookworm_footer_version == 'v7' ? 'selected' : ''}}>Footer v7</option>
                                            <option value="v8" {{$abe->bookworm_footer_version == 'v8' ? 'selected' : ''}}>Footer v8</option>
                                            <option value="v9" {{$abe->bookworm_footer_version == 'v9' ? 'selected' : ''}}>Footer v9</option>
                                            <option value="v10" {{$abe->bookworm_footer_version == 'v10' ? 'selected' : ''}}>Footer v10</option>
                                            <option value="v11" {{$abe->bookworm_footer_version == 'v11' ? 'selected' : ''}}>Footer v11</option>
                                            <option value="v12" {{$abe->bookworm_footer_version == 'v12' ? 'selected' : ''}}>Footer v12</option>
                                            {{-- <option value="v13" {{$abe->bookworm_footer_version == 'v13' ? 'selected' : ''}}>Footer v13</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-success" form="themeForm">Update</button>
            </div>
        </div>

    </div>
</div>



@endsection
