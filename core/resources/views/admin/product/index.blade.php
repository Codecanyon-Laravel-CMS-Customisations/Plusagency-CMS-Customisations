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
    <h4 class="page-title">Products</h4>
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
        <a href="#">Products</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Products</div>
                </div>
                <div class="col-lg-3">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                    <a href="{{route('admin.product.type')}}" class="btn btn-primary float-right btn-sm"><i class="fas fa-plus"></i> Add Product</a>
                    <button class="btn btn-secondary float-right btn-sm mr-2 d-none bulk-activate" data-href="{{route('admin.product.bulk.activate')}}"><i class="fas fa-tasks"></i> Add to menu</button>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.product.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($products) == 0)
                <h3 class="text-center">NO Products FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="products-datatables">
                    <thead>
                      <tr>
                        <th scope="col" class="no-sort">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col" class="no-sort">Featured Image</th>
                        <th scope="col">Title</th>
                        @if ($bex->catalog_mode == 0)
                            <th>Price ({{$bex->base_currency_text}})</th>
                        @endif
                        <th scope="col">Type</th>
                        <th scope="col">Category</th>
                        <th scope="col" class="no-sort">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($products as $key => $product)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{$product->id}}">
                          </td>
                          {{-- <td><img src="{{asset('assets/front/img/product/featured/'.$product->feature_image)}}" width="80"></td> --}}
                          <td><img src="{{trim($product->feature_image)}}" width="80"></td>
                          <td>
                              {{strlen($product->title) > 30 ? mb_substr($product->title,0,30,'utf-8') . '...' : $product->title}}
                          </td>
                            @if ($bex->catalog_mode == 0)
                                <td>{{$product->current_price}}</td>
                            @endif
                          <td class="text-capitalize">{{$product->type}}</td>
                          <td>
                            @if (!empty($product->category))
                            {{convertUtf8($product->category ? $product->category->name : '')}}
                            @endif
                          </td>

                          <td>
                                <div class="btn-group">
                                    @if($product->show_in_page_builder == '1')
                                        <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{route('admin.product.edit', $product->id) . '?language=' . request()->input('language')}}" class="dropdown-item">
                                                <i class="fas fa-edit"> Edit product</i>
                                            </a>
                                            <a onclick="event.preventDefault(); document.getElementById('addtopagebuilderform-{{$product->id}}').submit();" href="javascript:;" class="dropdown-item">
                                                <strong><i class="fab fa-audible"> Remove from page-builder</i></strong>
                                            </a>
                                            <a onclick="event.preventDefault(); document.getElementById('deleteform-{{$product->id}}').submit();" href="javascript:;" class="dropdown-item">
                                                <i class="fas fa-trash"> Delete product</i>
                                            </a>
                                        </div>
                                    @else
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="{{route('admin.product.edit', $product->id) . '?language=' . request()->input('language')}}" class="dropdown-item">
                                                <i class="fas fa-edit"> Edit product</i>
                                            </a>
                                            <a onclick="event.preventDefault(); document.getElementById('addtopagebuilderform-{{$product->id}}').submit();" href="javascript:;" class="dropdown-item">
                                                <strong><i class="fas fa-tasks"> Add to menu-builder</i></strong>
                                            </a>
                                            <a onclick="event.preventDefault(); document.getElementById('deleteform-{{$product->id}}').submit();" href="javascript:;" class="dropdown-item">
                                                <i class="fas fa-trash"> Delete product</i>
                                            </a>
                                        </div>
                                    @endif
                                    <form id="addtopagebuilderform-{{$product->id}}" class="deleteform d-none" action="{{route('admin.product.page-builder', $product->id)}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                    </form>
                                    <form id="deleteform-{{$product->id}}" class="deleteform d-none" action="{{route('admin.product.delete')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
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

      </div>
    </div>
  </div>

@endsection

