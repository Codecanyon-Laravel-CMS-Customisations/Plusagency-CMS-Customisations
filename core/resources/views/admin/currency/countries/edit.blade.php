@extends('admin.layout')
@section('styles')
<style>
    /* form input,
    form textarea,
    form select {
        direction: rtl;
    }
    .nicEdit-main {
        direction: rtl;
        text-align: right;
    } */
</style>
@endsection

@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit Country</h4>
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
        <a href="#">Country Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Country</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Country</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.currency.countries.index')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form id="ajaxForm"  action="{{route('admin.currency.countries.update')}}" method="POST">
                @csrf
                <input type="hidden" name="country_id" value="{{$country->id}}">
                <div class="form-group">
                  <label for="">Name **</label>
                  <input type="text" class="form-control text-left" name="name" value="{{$country->name}}" placeholder="Enter name">
                  <p id="errname" class="mb-0 text-danger em"></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Apha Code 2 **</label>
                            <input type="text" class="form-control text-left" name="alpha_2_code" value="{{$country->alpha_2_code}}" placeholder="Enter acronym">
                            <p id="erralpha_2_code" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Apha Code 3 **</label>
                            <input type="text" class="form-control text-left" name="alpha_3_code" value="{{$country->alpha_3_code}}" placeholder="Enter acronym">
                            <p id="erralpha_3_code" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Calling codes **</label>
                            <input type="text" class="form-control text-left" name="calling_codes" value="{{ implode(', ', $country->calling_codes) }}" placeholder="Enter symbol">
                            <p id="errcalling_codes" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Region **</label>
                            <input type="text" class="form-control text-left" name="region" value="{{ $country->region }}" placeholder="Enter symbol">
                            <p id="errregion" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Sub Region **</label>
                            <input type="text" class="form-control text-left" name="sub_region" value="{{ $country->sub_region }}" placeholder="Enter symbol">
                            <p id="errsub_region" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Demonym **</label>
                            <input type="text" class="form-control text-left" name="demonym" value="{{ $country->demonym }}" placeholder="Enter symbol">
                            <p id="errdemonym" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                  <label for="">Status **</label>
                  <select class="form-control text-left ltr" name="status">
                    <option value="" selected disabled>Select a status</option>
                    <option value="1" {{$country->status ==1 ? 'selected' : ''}}>Active</option>
                    <option value="0" {{$country->status ==0 ? 'selected' : ''}}>Deactive</option>
                  </select>
                  <p id="errstatus" class="mb-0 text-danger em"></p>
                </div>

              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
