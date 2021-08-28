@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">Mega Menus Management</h4>
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
        <a href="#">Webiste Menu Builder</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Mega Menus Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Add Products to Mega Menu</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-title d-inline-block">Add Products to Mega Menu</div>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-8 offset-lg-2">

                <form action="{{route('admin.categorymegamenu.update')}}" id="megaMenuForm" method="POST">
                    @csrf

                    <input type="hidden" name="language_id" value="{{$lang->id}}">
                    @foreach ($cats as $cat)
                        @php
                            $items = $cat->where('parent_menu_id', $cat->id)->get();
                        @endphp

                        <div class="form-group">
                            Select Sub category
                            <br><br>
                            <label class="selectgroup-item">
                              <input type="checkbox" name="subcat[]" value="{!! json_encode([$cat->id]) !!}" class="selectgroup-input" {{!empty($subcat) ? in_array(array($cat->id), $subcat) ? 'checked' : '' : ''}}>
                              <span class="selectgroup-button">{{strlen($cat->name) > 30 ? mb_substr($cat->name,0,30,'utf-8') . '...' : $cat->name}}</span>
                            </label>
                            <br>
                            @if ($items->count() > 0)
                              <div class="ml-5">
                                Choose Sub Sub Category
                                <br><br>
                                  <div class="selectgroup selectgroup-pills">
                                
                                    @foreach ($items as $item)
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="items[]" value="{!! json_encode([$cat->id, $item->id]) !!}" class="selectgroup-input" {{array_key_exists("$cat->id", $mmenus) && in_array($item->id, $mmenus["$cat->id"]) ? 'checked' : ''}}>
                                            <span class="selectgroup-button">{{strlen($item->name) > 30 ? mb_substr($item->name,0,30,'utf-8') . '...' : $item->name}}</span>
                                        </label>
                                    @endforeach
                                  </div>
                              </div>
                            @endif
                        </div>
                    @endforeach

                </form>

            </div>
          </div>
        </div>

        <div class="card-footer text-center">
            <button class="btn btn-success" type="submit" form="megaMenuForm">Add to Products Mega Menu</button>
        </div>
      </div>
    </div>
  </div>

@endsection
