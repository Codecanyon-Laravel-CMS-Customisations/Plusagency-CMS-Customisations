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
    <h4 class="page-title">Product Child Categories</h4>
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
        <a href="#">Shop Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Manage Products</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Category</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-5">
                    <div class="card-title d-inline-block">Child Categories</div>
                </div>
                {{-- <div class="col-lg-3">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div> --}}
                <div class="col-lg-7  mt-2 mt-lg-0 text-right">
                    <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add Category</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.pcategory.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($pcategories) == 0)
                <h3 class="text-center">NO PRODUCT CATEGORY FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Paret Category</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Visible In Menu</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($pcategories as $key => $category)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$category->id}}">
                          </td>

                          <td>{{convertUtf8($category->parent_category ? $category->parent_category->name: "")}}</td>

                          <td>{{convertUtf8($category->name)}}</td>

                          <td>
                            @if ($category->status == 1)
                              <h2 class="d-inline-block"><span class="badge badge-success">Active</span></h2>
                            @else
                              <h2 class="d-inline-block"><span class="badge badge-danger">Deactive</span></h2>
                            @endif
                          </td>

                          <td>
                            @if ($category->show_in_menu == 1)
                              <h2 class="d-inline-block"><span class="badge badge-success">true</span></h2>
                            @else
                              <h2 class="d-inline-block"><span class="badge badge-danger">false</span></h2>
                            @endif
                          </td>

                          <td>
                            <div class="btn-group">
                                @if($category->show_in_menu == 1)
                                    <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Select Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{route('plugins.category.edit', $category->id) . '?language=' . request()->input('language')}}" class="dropdown-item">
                                            <i class="fas fa-edit"> Edit cateory</i>
                                        </a>
                                        <a onclick="event.preventDefault(); document.getElementById('addtomenuform-{{$category->id}}').submit();" href="javascript:;" class="dropdown-item">
                                            <strong><i class="fab fa-audible"> Remove from menu</i></strong>
                                        </a>
                                        <a onclick="event.preventDefault(); document.getElementById('deleteform-{{$category->id}}').submit();" href="javascript:;" class="dropdown-item">
                                            <i class="fas fa-trash"> Delete category</i>
                                        </a>
                                    </div>
                                @else
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Select Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{route('plugins.category.edit', $category->id) . '?language=' . request()->input('language')}}" class="dropdown-item">
                                            <i class="fas fa-edit"> Edit category</i>
                                        </a>
                                        <a onclick="event.preventDefault(); document.getElementById('addtomenuform-{{$category->id}}').submit();" href="javascript:;" class="dropdown-item">
                                            <strong><i class="fab fa-audible"> Add to menu</i></strong>
                                        </a>
                                        <a onclick="event.preventDefault(); document.getElementById('deleteform-{{$category->id}}').submit();" href="javascript:;" class="dropdown-item">
                                            <i class="fas fa-trash"> Delete category</i>
                                        </a>
                                    </div>
                                @endif
                                <form id="addtomenuform-{{$category->id}}" class="deleteform d-none" action="{{route('admin.category.toggle_show_in_menu', $category->id)}}" method="post">
                                    @csrf
                                    <input type="hidden" name="category_id" value="{{$category->id}}">
                                </form>
                                <form id="deleteform-{{$category->id}}" class="deleteform d-none" action="{{route('plugins.category.destroy')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="category_id" value="{{$category->id}}">
                                </form>
                            </div>
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
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{$pcategories->appends(['language' => request()->input('language')])->links()}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Create Service Category Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Product Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form" action="{{route('plugins.category.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="">Language **</label>
                <select name="language_id" class="form-control">
                    <option value="" selected disabled>Select a language</option>
                    @foreach ($langs as $lang)
                        <option value="{{$lang->id}}">{{$lang->name}}</option>
                    @endforeach
                </select>
                <p id="errlanguage_id" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Parent Category **</label>
              <select name="parent_menu_id" class="form-control">
                  @foreach ($parents as $parent => $id)
                      <option value="{{ $id }}">{{ $parent }}</option>
                  @endforeach
              </select>
              <p id="errparent_menu_id" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
              <label for="">Name **</label>
              <input type="text" class="form-control" name="name" value="" placeholder="Enter name">
              <p id="errname" class="mb-0 text-danger em"></p>
            </div>

            <div class="form-group">
              <label for="">Status **</label>
              <select class="form-control ltr" name="status">
                <option value="" selected disabled>Select a status</option>
                <option value="1">Active</option>
                <option value="0">Deactive</option>
              </select>
              <p id="errstatus" class="mb-0 text-danger em"></p>
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

@endsection

@section('scripts')
<script>
$(document).ready(function() {

    // make input fields RTL
    $("select[name='language_id']").on('change', function() {
        $(".request-loader").addClass("show");
        let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
        console.log(url);
        $.get(url, function(data) {
            $(".request-loader").removeClass("show");
            if (data == 1) {
                $("form.modal-form input").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form.modal-form select").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form.modal-form textarea").each(function() {
                    if (!$(this).hasClass('ltr')) {
                        $(this).addClass('rtl');
                    }
                });
                $("form.modal-form .nicEdit-main").each(function() {
                    $(this).addClass('rtl text-right');
                });

            } else {
                $("form.modal-form input, form.modal-form select, form.modal-form textarea").removeClass('rtl');
                $("form.modal-form .nicEdit-main").removeClass('rtl text-right');
            }
        })
    });
});
</script>
@endsection
