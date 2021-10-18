@extends('admin.layout')
@section('content')
<div class="page-header">
   <h4 class="page-title">Conversations</h4>
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
         <a href="#">Tickets</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">Conversations</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="row">
               <div class="col-lg-4">
               <div class="card-title d-inline-block">Ticket Details - #{{$ticket->ticket_number}}</div>
               </div>
               <div class="col-lg-3 offset-lg-5 mt-2 mt-lg-0 text-right">
                  <a href="{{route('admin.tickets.all')}}" class="btn btn-primary btn-md">Back to Lists</a>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="row text-center">
               <div class="col-lg-12">
                  <div class="row">
                     <div class="col-lg-12">
                        <h3 class="text-white">{{$ticket->subject}}</h3>
                        @if($ticket->status != 'close')
                            @if($ticket->user->is_digital_system && $ticket->digital_system_user_id)
                            <button class="close-ticket btn btn-success btn-md" data-href="{{route('admin.ticket.digital_approval', [$ticket->id, 'approve'])}}"><i class="fas fa-user-check mr-1"></i> Approve Client Account</button>
                            <button class="close-ticket btn btn-danger btn-md" data-href="{{route('admin.ticket.digital_approval', [$ticket->id, 'revoke'])}}"><i class="fas fa-user-times mr-1"></i> Revoke Client Account</button>
                            @else
                                <button class="close-ticket btn btn-success btn-md" data-href="{{route('admin.ticket.close',$ticket->id)}}"><i class="fas fa-check mr-1"></i> Close Ticket</button>
                            @endif
                        @endif
                     </div>
                     <div class="col-lg-12 my-3">
                        @if($ticket->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                        @elseif($ticket->status == 'open')
                        <span class="badge badge-primary">Open</span>
                        @else
                        <span class="badge badge-danger">Closed</span>
                        @endif
                        <span class="badge badge-secondary">{{$ticket->created_at->format('d-m-Y')}} {{date("h.i A", strtotime($ticket->created_at))}}</span>
                     </div>
                  </div>
                  <div class="row">
                        @if($ticket->user->is_digital_system)
                            <div class="col-md-7">
                                <p style="font-size: 16px;">{!! replaceBaseUrl($ticket->message) !!}</p>
                                @if($ticket->zip_file)
                                    <a href="{{asset('assets/front/user-suppor-file/'.$ticket->zip_file)}}" download="{{__('support_file')}}" class="btn btn-primary"><i class="fas fa-download"></i> Download Attachment</a>
                                @endif
                            </div>
                            <div class="col-md-5 woocommerce-product-gallery woocommerce-product-gallery--with-images images">
                                {{-- @ foreach ($ticket->digital_system_stack_trace as $field)
                                    <li>{-{ $field }-}</li>
                                @ endforeach --}}
                                <div class="list-group text-left">
                                    @php
                                        $trace  = explode(",", $ticket->digital_system_stack_trace);

                                        foreach ($trace as $tr)
                                        {
                                            $td = explode(":", $tr);
                                            if (Illuminate\Support\Str::startsWith($td[0], "\"_")) continue;
                                            if (isset($td[0]) && strlen($td[0]) > 25)
                                            {
                                                $td_x  = null;
                                            }
                                            else {
                                                $td_x  = " : ".$td[1];
                                            }
                                            $str = $td[0].$td_x;
                                            echo "<a href='javascript:;' class='list-group-item list-group-item-action active'>$str</a>";
                                        }
                                    @endphp
                                </div>
                                {!!
                                trim(
                                    json_decode($ticket->digital_system_stack_trace)
                                )
                                !!}
                            </div>
                        @elseif($ticket->products && $ticket->products->count() >= 1)
                            <div class="col-md-7">
                                <div class="text-left" style="font-weight: bold">
                                    <p style="font-size: 16px;">Email: {!! replaceBaseUrl($ticket->products()->first()->pivot->email) !!}</p>
                                    <p style="font-size: 16px;">Phone: {!! replaceBaseUrl($ticket->products()->first()->pivot->whatsapp_number) !!}</p>
                                    <p style="font-size: 16px;">Preferred Communication: {!! replaceBaseUrl($ticket->products()->first()->pivot->preferred_communication) !!}</p>
                                </div>
                                <p style="font-size: 16px;" class="text-justify">{!! replaceBaseUrl($ticket->message) !!}</p>
                                @if($ticket->zip_file)
                                    <a href="{{asset('assets/front/user-suppor-file/'.$ticket->zip_file)}}" download="{{__('support_file')}}" class="btn btn-primary"><i class="fas fa-download"></i> Download Attachment</a>
                                @endif
                            </div>
                            <div class="col-md-5 woocommerce-product-gallery woocommerce-product-gallery--with-images images">
                                @foreach ($ticket->products as $product)
                                    @if($product->id)
                                        <div class="d-flex py-3 text-left">
                                            <div class="d-flex col-md-5 woocommerce-product-gallery woocommerce-product-gallery--with-images images">
                                                <img src="{{trim($product->feature_image)}}" alt="" class="mx-auto img-fluid" width="250">
                                            </div>
                                            <div class="d-block">
                                                <p class="lead">PRODUCT::<br/> <a href="{{ route('admin.product.edit', $product->id) }}">
                                                    {{ $product->title }}</a>
                                                </p>
                                                <div class="price d-flex lead">
                                                    <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}</span>{{ $product->current_price }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                          <div class="col-lg-8 offset-lg-2">
                              <p style="font-size: 16px;">{!! replaceBaseUrl($ticket->message) !!}</p>
                              @if($ticket->zip_file)
                                  <a href="{{asset('assets/front/user-suppor-file/'.$ticket->zip_file)}}" download="{{__('support_file')}}" class="btn btn-primary"><i class="fas fa-download"></i> Download Attachment</a>
                              @endif
                          </div>
                      @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="{{$ticket->status == 'close' ? 'col-lg-12' : 'col-lg-6'}}">
    <div class="card card-round">
        <div class="card-body">
           <div class="card-title fw-mediumbold">Replies</div>
           <div class="card-list">
               <div class="messages-container">
                @if(count($ticket->messages) > 0)
                @foreach ($ticket->messages as $reply)
                    @if(!$reply->user_id)
                    @php
                        $admin = App\Admin::find($ticket->admin_id);
                    @endphp
                   <div class="item-list">
                      <div class="avatar">
                         <img src="{{$admin->image ? asset('assets/admin/img/propics/'.$admin->image) : asset('assets/admin/img/propics/blank_user.jpg')}}" alt="..." class="avatar-img rounded-circle">
                      </div>
                      <div class="info-user ml-3">
                         <div class="username">{{$admin->username}}</div>
                         <div class="status">{{$admin->id == 1 ? 'Super Admin' : $admin->role->name}}</div>
                         <p>{!! replaceBaseUrl($reply->reply) !!}</p>
                         @if($reply->file)
                         <a href="{{asset('assets/front/user-suppor-file/'.$ticket->zip_file)}}" download="support_file" class="btn btn-rounded btn-info btn-sm">Download</a>
                         @endif
                      </div>
                   </div>
                  @else
                  @php
                  $user = App\User::findOrFail($ticket->user_id);
                   @endphp
                   <div class="item-list">
                      <div class="avatar">
                        @if (strpos($user->photo, 'facebook') !== false || strpos($user->photo, 'google'))
                            <img class="avatar-img rounded-circle" src="{{$user->photo ? $user->photo : asset('assets/front/img/user/profile.jpg')}}" alt="user-photo">
                        @else
                            <img class="avatar-img rounded-circle" src="{{$user->photo ? asset('assets/front/img/user/'.$user->photo) : ''}}" alt="user-photo">
                        @endif
                      </div>
                      <div class="info-user ml-3">
                         <div class="username">{{$user->username}}</div>
                         <div class="status">{{__('Customer')}}</div>
                         <p>{!! replaceBaseUrl($reply->reply) !!}</p>
                         @if($reply->file)
                         <a href="{{asset('assets/front/user-suppor-file/'.$ticket->zip_file)}}" download="support_file" class="btn btn-rounded btn-info btn-sm">Download</a>
                         @endif
                      </div>
                   </div>
                  @endif
                  @endforeach
                  @endif
               </div>
           </div>
        </div>
     </div>
   </div>


 @if($ticket->status != 'close')
 <div class="col-lg-6 message-type">
   <div class="card card-round">
       <div class="card-body">
           <div class="card-title fw-mediumbold mb-2">Reply to Ticket</div>
           <form action="{{route('admin.ticket.reply',$ticket->id)}}" id="ajaxform" method="POST" enctype="multipart/form-data">@csrf
               <div class="form-group">
                   <label for="">Message **</label>
                   <textarea name="reply" class="summernote" data-height="200"></textarea>
                   <p class="em text-danger mb-0" id="errreply"></p>
                 </div>
               <div class="form-group">
                   <label for="">Attachment</label>
                   <div class="input-group">
                       <div class="custom-file">
                         <input type="file" name="file" class="custom-file-input" data-href="{{route('admin.zip_file.upload')}}" name="file" id="zip_file">
                         <label class="custom-file-label" for="zip_file">Choose file</label>
                       </div>
                   </div>
                   <p class="em text-danger mb-0" id="errfile"></p>
                   <p class="mb-0 show-name"><small></small></p>
                   <div class="progress progress-sm d-none">
                       <div class="progress-bar bg-success " role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax=""></div>
                   </div>
                   <p class="text-warning">Upload only ZIP Files, Max File Size is 5 MB</p>
               </div>
               <div class="form-group">
                   <button type="submit" class="btn btn-success">Message</button>
               </div>
           </form>
       </div>
    </div>
  </div>
 @endif
</div>
@endsection
@section('scripts')
    <script>
            $(document).on('change','#zip_file', function(){
      var formdata = new FormData();
      var file = event.target.files[0];
      var name = event.target.files[0].name;
        formdata.append('file', file);
      $.ajax({
            url: $(this).attr('data-href'),
            type: 'post',
            data: formdata,
            xhr: function() {
                var appXhr = $.ajaxSettings.xhr();
                if (appXhr.upload) {
                    if ('#zip_file') {
                        appXhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                currentMainProgress = (e.loaded / e.total) * 100;
                                currentMainProgress = parseInt(currentMainProgress);
                                $(".progress").removeClass('d-none');
                                $(".progress-bar").html(currentMainProgress + '%');
                                $(".progress-bar").width(currentMainProgress + '%');
                                if (currentMainProgress == 100)
                                $(".progress-bar").addClass('bg-success');
                                }
                                $('.show-name small').text(name);
                        }, false);
                    }
                  }

                return appXhr;
            },
            success: function(data) {
                if(data.errors){
                    $(".progress").addClass('d-none');
                    $('#errfile').text(data.errors.file[0]).removeClass('d-none');
                }else{
                    $('#errfile').text('').addClass('d-none');
                }
            },


            contentType: false,
            processData: false
    });

    });

    let redirecturl = '{{url('/')}}';

    $(document).on('click','.close-ticket',function(){
       $('.swal-button--confirm').attr('data-href',$(this).attr('data-href'));
    })
    $(document).on('click','.swal-button--confirm',function(){
       $.get($(this).attr('data-href'),function(res){
         $('.message-type').remove();
         location.reload();
       });
    })
    </script>
@endsection
