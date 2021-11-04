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
    <h4 class="page-title">World Currencies</h4>
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
        <a href="#">world currencies</a>
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
                <div class="col-md-12 text-right">
                    <a href="#" class="btn btn-primary float-right btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Add a Currency</a>
                    <button class="btn btn-danger float-right btn-sm mr-2 d-none bulk-delete" data-href="{{route('admin.pcategory.bulk.delete')}}"><i class="flaticon-interface-5"></i> Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($world_currencies) == 0)
                <h3 class="text-center">NO World Currencies FOUND</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="products-datatables">
                    <thead>
                      <tr>
                        <th scope="col" class="no-sort">
                            <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">COUNTRY DETAILS</th>
                        <th scope="col">AVAILABLE CURRENCIES</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($world_currencies as $world_currency)
                            <tr>
                                <td>
                                    <input type="checkbox" class="bulk-check" data-val="{{$world_currency->id}}">
                                </td>
                                <td>
                                    {{ $world_currency->name }}<br/>({{ $world_currency->alpha_2_code }})
                                </td>
                                <td>
                                    @foreach ($world_currency->currencies as $pc)
                                        {{ $pc->acronym }} @if(!$loop->last) {{ ", " }} @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if($world_currency->status)
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
                                        <a href="#" data-toggle="modal" data-target="#editModal{{ $world_currency->id }}" class="dropdown-item">
                                            <i class="fas fa-edit"> Edit currency</i>
                                        </a>
                                        @if($world_currency->status)
                                            <a onclick="event.preventDefault(); document.getElementById('deactivateCurrencyForm-{{$world_currency->id}}').submit();" href="javascript:;" class="dropdown-item">
                                                <strong><i class="fab fa-audible"> Deactivate</i></strong>
                                            </a>
                                        @else
                                            <a onclick="event.preventDefault(); document.getElementById('deactivateCurrencyForm-{{$world_currency->id}}').submit();" href="javascript:;" class="dropdown-item">
                                                <strong><i class="fab fa-audible"> Activate</i></strong>
                                            </a>
                                        @endif
                                        <a onclick="event.preventDefault(); document.getElementById('deleteCurrencyForm-{{$world_currency->id}}').submit();" href="javascript:;" class="dropdown-item">
                                            <i class="fas fa-trash"> Delete</i>
                                        </a>
                                    </div>

                                    <form id="deactivateCurrencyForm-{{$world_currency->id}}" class="deleteform d-none" action="{{route('admin.currency.world-currencies.toggle_activate', $world_currency->id)}}" method="post">
                                        @csrf
                                        <input type="hidden" name="country_id" value="{{$world_currency->id}}">
                                    </form>
                                    <form id="deleteCurrencyForm-{{$world_currency->id}}" class="deleteform d-none" action="{{route('admin.currency.world-currencies.delete')}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="country_id" value="{{$world_currency->id}}">
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
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add a Currency</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="ajaxForm" class="modal-form" action="{{route('admin.currency.world-currencies.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="">Country  **</label>
                <select name="country" class="form-control">
                    <option value="" selected disabled>Select a country</option>
                    @foreach ($countries as $country)
                        <option value="{{$country->id}}">{{$country->name}} ({{$country->alpha_2_code}})</option>
                    @endforeach
                </select>
                <p id="errcountry" class="mb-0 text-danger em"></p>
            </div>
            <div class="form-group">
                <label for="">Currencies  **</label>
                <select multiple name="currencies[]" class="form-control">
                    <option value="" selected disabled>Select currencies</option>
                    @foreach ($currencies as $currency)
                        <option value="{{$currency->id}}">{{$currency->name}} ({{$currency->acronym}})</option>
                    @endforeach
                </select>
                <p id="errcurrencies" class="mb-0 text-danger em"></p>
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

  @foreach ($world_currencies as $world_currency)
    <!-- Update Service Category Modal -->
        <div class="modal fade" id="editModal{{$world_currency->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Edit a Currencies for {{ $world_currency->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <form class="modal-form---not" action="{{route('admin.currency.world-currencies.update')}}" method="POST">
                    @csrf
                    @method('patch')
                    <input name="country" type="hidden" value="{{ $world_currency->id }}">
                    <div class="form-group">
                        <label for="">Country  **</label>
                        <input name="country" class="form-control" disabled value="{{ $world_currency->name }}">
                        <p id="errcountry" class="mb-0 text-danger em"></p>
                    </div>
                    <div class="form-group">
                        <label for="">Currencies  **</label>
                        <select multiple name="currencies[]" class="form-control">
                            <option value="" selected disabled>Select currencies</option>
                            <?php
                                $currency_ids   = [];
                                foreach ($world_currency->currencies as $wc) {
                                    array_push($currency_ids, $wc->id);
                                }
                            ?>
                            @foreach ($currencies as $currency)
                                <option @if(in_array($currency->id, $currency_ids)) selected @endif value="{{$currency->id}}">{{$currency->name}} ({{$currency->acronym}})</option>
                            @endforeach
                        </select>
                        <p id="errcurrencies" class="mb-0 text-danger em"></p>
                    </div>

                    <div class="form-group">
                    <label for="">Status **</label>
                    <select class="form-control ltr" name="status">
                        <option value="" selected disabled>Select a status</option>
                        <option @if($world_currency->status == 1) selected @endif value="1">Active</option>
                        <option @if($world_currency->status == 0) selected @endif value="0">Deactive</option>
                    </select>
                    <p id="errstatus" class="mb-0 text-danger em"></p>
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

