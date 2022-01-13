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
    <h4 class="page-title">Edit Currency</h4>
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
        <a href="#">Currency Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Currency</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Currency</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.currency.currencies.index')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form id="ajaxForm"  action="{{route('admin.currency.currencies.update')}}" method="POST">
                @csrf
                <input type="hidden" name="currency_id" value="{{$currency->id}}">
                <div class="form-group">
                  <label for="">Name **</label>
                  <input type="text" class="form-control text-left" name="name" value="{{$currency->name}}" placeholder="Enter name">
                  <p id="errname" class="mb-0 text-danger em"></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Acronym **</label>
                            <input type="text" class="form-control text-left" name="acronym" value="{{$currency->acronym}}" placeholder="Enter acronym">
                            <p id="erracronym" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Symbol **</label>
                            <input type="text" class="form-control text-left" name="symbol" value="{{$currency->symbol}}" placeholder="Enter symbol">
                            <p id="errsymbol" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Symbol Position **</label>
                            <select class="form-control text-left ltr" name="symbol_position">
                                <option value="" selected disabled>Select a symbol position</option>
                                <option value="L" {{$currency->symbol_position == 'L' ? 'selected' : ''}}>Left</option>
                                <option value="R" {{$currency->symbol_position == 'R' ? 'selected' : ''}}>Right</option>
                            </select>
                            <p id="errsymbol_position" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Text Position **</label>
                            <select class="form-control text-left ltr" name="text_position">
                                <option value="" selected disabled>Select a symbol position</option>
                                <option value="L" {{$currency->text_position == 'L' ? 'selected' : ''}}>Left</option>
                                <option value="R" {{$currency->text_position == 'R' ? 'selected' : ''}}>Right</option>
                            </select>
                            <p id="errsymbol_position" class="mb-0 text-danger em"></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                  <label for="">Status **</label>
                  <select class="form-control text-left ltr" name="status">
                    <option value="" selected disabled>Select a status</option>
                    <option value="1" {{$currency->status ==1 ? 'selected' : ''}}>Active</option>
                    <option value="0" {{$currency->status ==0 ? 'selected' : ''}}>Deactive</option>
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
