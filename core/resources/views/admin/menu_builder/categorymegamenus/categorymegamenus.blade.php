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
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                  <div class="card-footer text-center">
                      <button class="btn btn-success" type="submit" form="megaMenuForm">Add to Products Mega Menu</button>
                  </div>
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
                            $cat2           = $cat->child_cats;
                        @endphp
                        <div class="form-group">
                          <label>
                            {{ $cat->name }}
                          </label>
                        </div>
                        <div class="form-group ml-5">
                            @foreach ($cat2 as $item)
                            Select Sub category
                            <br><br>
                            <div class="selectgroup selectgroup-pills">
                              <label class="selectgroup-item">
                                <input type="checkbox" name="subcat[]" value="{!! json_encode([$item->id]) !!}" class="selectgroup-input" {{!empty($subcat) ? in_array(array($item->id), $subcat) ? 'checked' : '' : ''}}>
                                <span class="selectgroup-button">{{strlen($item->name) > 30 ? mb_substr($item->name,0,30,'utf-8') . '...' : $item->name}}</span>
                              </label>
                              <br>
                            </div>
                            @php
                                $cat3 = $item->child_sub_cats;
                            @endphp
                            @if ($cat3->count() > 0)
                              <div class="ml-5">
                                  @if (!empty($cat3))
                                    Choose Sub Sub Category
                                    <br><br>
                                  @endif
                                  <div class="selectgroup selectgroup-pills">
                                
                                    @foreach ($cat3 as $item3)
                                        <label class="selectgroup-item">
                                            <input type="checkbox" name="items[]" value="{!! json_encode([$item->id, $item3->id]) !!}" class="selectgroup-input" {{array_key_exists("$item->id", $mmenus) && in_array($item3->id, $mmenus["$item->id"]) ? 'checked' : ''}}>
                                            <span class="selectgroup-button">{{strlen($item3->name) > 30 ? mb_substr($item3->name,0,30,'utf-8') . '...' : $item3->name}}</span>
                                        </label>
                                    @endforeach
                                  </div>
                              </div>
                            @endif
                            @endforeach
                        </div>
                    @endforeach

                </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
