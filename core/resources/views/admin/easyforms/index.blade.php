@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Easy Forms Settings</h4>
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
        <a href="#">Settings</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Easy Forms</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="" action="{{route('admin.easy-forms.update')}}" method="post">
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
              <div class="col-12">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                          <label>Easy Forms Server URL **</label>
                          <input class="form-control" name="easy_form_server_url" value="{{$easyForms->easy_form_server_url}}">
                          @if ($errors->has('easy_form_server_url'))
                            <p class="mb-0 text-danger">{{$errors->first('easy_form_server_url')}}</p>
                          @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Easy Forms For Digital Products (in LMS) **</label>
                          <textarea class="form-control" name="easy_form_digital" placeholder="Enter form code here" style="min-height: 250px;">{!! $easyForms->easy_form_digital !!}</textarea>
                          @if ($errors->has('easy_form_digital'))
                            <p class="mb-0 text-danger">{{$errors->first('easy_form_digital')}}</p>
                          @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Easy Forms For Restricted Products (in Product Inquiries) **</label>
                          <textarea class="form-control" name="easy_form_restricted" placeholder="Enter form code here" style="min-height: 250px;">{!! $easyForms->easy_form_restricted !!}</textarea>
                          @if ($errors->has('easy_form_restricted'))
                            <p class="mb-0 text-danger">{{$errors->first('easy_form_restricted')}}</p>
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
