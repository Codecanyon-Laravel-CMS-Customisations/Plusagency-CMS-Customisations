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
    <h4 class="page-title">Currency</h4>
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
        <a href="#">Manage currencies</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">currencies</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">

      <div class="card">
        <div class="card-header">
            <div class="row">
{{--                <div class="col-lg-4">--}}
{{--                    <div class="card-title d-inline-block">currencyies</div>--}}
{{--                </div>--}}
                <div class="col-lg-5">
                    @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($currencies) == 0)
                <h3 class="text-center">NO Currencies FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="products-datatables">
                    <thead>
                      <tr>
                        <th scope="col" class="no-sort">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">NAME</th>
                        <th scope="col">ACRONYM</th>
                        <th scope="col">SYMBOL</th>
                        <th scope="col">SYMBOL POSITION</th>
                        <th scope="col">TEXT POSITION</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($currencies as $currency)
                        <tr>
                            <td>
                                <input type="checkbox" class="bulk-check" data-val="{{$currency->id}}">
                            </td>
                            <td>
                                {{ $currency->name }}
                            </td>
                            <td>{{ $currency->acronym }}</td>
                            <td>{{ $currency->symbol }}</td>
                            <td>{{ $currency->symbol_position }}</td>
                            <td>{{ $currency->text_position }}</td>
                            <td>
                                @if($currency->status)
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
                                    <a href="{{ route('admin.currency.currencies.edit', $currency->id) }}" class="dropdown-item">
                                        <i class="fas fa-edit"> Edit currency</i>
                                    </a>
                                    @if($currency->status)
                                        <a onclick="event.preventDefault(); document.getElementById('deactivateCurrencyForm-{{$currency->id}}').submit();" href="javascript:;" class="dropdown-item">
                                            <strong><i class="fab fa-audible"> Deactivate</i></strong>
                                        </a>
                                    @else
                                        <a onclick="event.preventDefault(); document.getElementById('deactivateCurrencyForm-{{$currency->id}}').submit();" href="javascript:;" class="dropdown-item">
                                            <strong><i class="fab fa-audible"> Activate</i></strong>
                                        </a>
                                    @endif
                                    <a onclick="event.preventDefault(); document.getElementById('deleteCurrencyForm-{{$currency->id}}').submit();" href="javascript:;" class="dropdown-item">
                                        <i class="fas fa-trash"> Delete</i>
                                    </a>
                                </div>

                                <form id="deactivateCurrencyForm-{{$currency->id}}" class="deleteform d-none" action="{{route('admin.currency.currencies.toggle_activate', $currency->id)}}" method="post">
                                    @csrf
                                    <input type="hidden" name="currency_id" value="{{$currency->id}}">
                                </form>
                                <form id="deleteCurrencyForm-{{$currency->id}}" class="deleteform d-none" action="{{route('admin.currency.currencies.delete')}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="currency_id" value="{{$currency->id}}">
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

@endsection

