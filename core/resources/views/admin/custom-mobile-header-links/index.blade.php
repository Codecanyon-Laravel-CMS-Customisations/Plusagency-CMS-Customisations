@extends('admin.layout')

@php
$selLang = \App\Language::where('code', request()->input('language'))->first();
@endphp
@if(!empty($selLang) && $selLang->rtl == 1)
@section('styles')
<style>
    form:not(.modal-form) input,
    form:not(.modal-form) textarea,
    form:not(.modal-form) select,
    select[name='language'] {
        direction: rtl;
    }
    form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">Hyperlinks</h4>
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
        <a href="#">Manage links</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">custom links</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Custom Link</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.pcategory.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($links) == 0)
                <h3 class="text-center">NO LINKS FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="products-datatables">
                    <thead>
                      <tr>
                        <th scope="col" class="no-sort">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">LINK TEXT</th>
                        <th scope="col">LINK URL</th>
                        <th scope="col">RANK</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($links as $link)
                        <tr>
                            <td>
                                <input type="checkbox" class="bulk-check" data-val="{{$link->id}}">
                            </td>
                            <td>
                                {!! $link->link_text !!}
                            </td>
                            <td>
                                {{ $link->link_url }}
                            </td>
                            <td>
                                {{ $link->link_rank }}
                            </td>
                            <td>
                                @if($link->status)
                                    <span class="badge badge-primary">Active</span>
                                @else
                                    <span class="badge badge-warning">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="#" data-toggle="modal" data-target="#editModal{{ $link->id }}" class="dropdown-item">
                                        <i class="fas fa-edit"> Edit link</i>
                                    </a>
                                    @if($link->status)
                                        <a onclick="event.preventDefault(); document.getElementById('deactivateCurrencyForm-{{$link->id}}').submit();" href="javascript:;" class="dropdown-item">
                                            <strong><i class="fab fa-audible"> Deactivate</i></strong>
                                        </a>
                                    @else
                                        <a onclick="event.preventDefault(); document.getElementById('deactivateCurrencyForm-{{$link->id}}').submit();" href="javascript:;" class="dropdown-item">
                                            <strong><i class="fab fa-audible"> Activate</i></strong>
                                        </a>
                                    @endif
                                    <a onclick="event.preventDefault(); document.getElementById('deleteCurrencyForm-{{$link->id}}').submit();" href="javascript:;" class="dropdown-item">
                                        <i class="fas fa-trash"> Delete</i>
                                    </a>
                                </div>

                                <form id="deactivateCurrencyForm-{{$link->id}}" class="deleteform d-none" action="{{route('admin.custom-mobile-header-buttons.toggle_activate', $link->id)}}" method="post">
                                    @csrf
                                    <input type="hidden" name="link" value="{{$link->id}}">
                                </form>
                                <form id="deleteCurrencyForm-{{$link->id}}" class="deleteform d-none" action="{{route('admin.custom-mobile-header-buttons.delete', $link->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="link" value="{{$link->id}}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  <!-- Create Service Category Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Create a new link</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form" action="{{route('admin.custom-mobile-header-buttons.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="">Link Text  **</label>
                <input type="text" name="link_text" class="form-control" value="{{ old('link_text') }}" required>
                <p id="errlink_text" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
                <label for="">Link URL  **</label>
                <input type="text" name="link_url" class="form-control" value="{{ old('link_url') }}" required>
                <p id="errlink_url" class="mb-0 text-danger em"></p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Link Order Number </label>
                        <input type="integer" name="link_order_number" class="form-control" value="{{ old('link_order_number') }}" required>
                        <p id="errlink_order_number" class="mb-0 text-danger em"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Status **</label>
                        <select class="form-control ltr" name="status">
                          <option value="" selected disabled>Select a status</option>
                          <option value="1">Active</option>
                          <option value="0">Deactive</option>
                        </select>
                        <p id="errstatus" class="mb-0 text-danger em"></p>
                      </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Link Description </label>
                <textarea name="link_description" class="form-control">{{ old('link_description') }}</textarea>
                <p id="errlink_description" class="mb-0 text-danger em"></p>
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

  @foreach ($links as $link)
    <!-- Update Service Category Modal -->
        <div class="modal fade" id="editModal{{$link->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <form class="modal-form---not" action="{{route('admin.custom-mobile-header-buttons.update')}}" method="POST">
                    @csrf
                    @method('patch')
                    <input name="link" type="hidden" class="form-control" value="{{$link->id}}">

                    <div class="form-group">
                        <label for="">Link Text  **</label>
                        <input type="text" name="link_text" class="form-control" value="{{ $link->link_text }}" required>
                        <p id="errlink_text" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                        <label for="">Link URL  **</label>
                        <input type="text" name="link_url" class="form-control" value="{{ $link->link_url }}" required>
                        <p id="errlink_url" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Link Order Number </label>
                                <input type="integer" name="link_order_number" class="form-control" value="{{ $link->link_rank }}" required>
                                <p id="errlink_order_number" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Status **</label>
                                <select class="form-control ltr" name="status">
                                    <option value="" selected disabled>Select a status</option>
                                    <option @if($link->status == true) selected @endif value="1">Active</option>
                                    <option @if($link->status == false) selected @endif value="0">Deactive</option>
                                </select>
                                <p id="errstatus" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Link Description </label>
                        <textarea name="link_description" class="form-control">{{ $link->description }}</textarea>
                        <p id="errlink_description" class="mb-0 text-danger em"></p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submitBtn">Submit</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
  @endforeach

@endsection

