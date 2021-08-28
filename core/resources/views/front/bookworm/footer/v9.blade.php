<footer class="site-footer_v5">
    <div class="border-top">
        <div class="container">
            <!-- Newsletter -->
            <form id="footerSubscribeForm" action="{{route('front.subscribe')}}" method="post">
                @csrf
            <div>
                <div class="space-1 space-lg-2">
                    <div class="text-center mb-5">
                        <h5 class="font-size-7 font-weight-medium">Join Our Newsletter</h5>
                        <p class="text-gray-700">Signup to be the first to hear about exclusive deals, special offers and upcoming collections</p>
                    </div>
                    <!-- Form Group -->
                    <div class="form-row justify-content-center">
                        <div class="col-lg-5 mb-2">
                            <div class="js-form-message">
                                <div class="input-group">
                                    <input type="text" class="form-control rounded-0 border-dark font-size-2 px-5 py-4d75" name="name" id="signupSrName" placeholder="Enter email for weekly newsletter." aria-label="Your name" required="" data-msg="Name must contain only letters." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <div class="ml-lg-2">
                            <button type="submit" class="btn btn-dark rounded-0 btn-wide py-3 font-weight-medium">Subscribe
                            </button>
                        </div>
                    </div>
                    <!-- End Form Group -->
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- End  Newsletter -->
    <div class="bg-dark">
        <div class="container space-bottom-3">
            <div class="space-top-2">
                <div class="row">
                    <div class="col-md-8 col-lg-10">
                        <div class="pb-6 pb-lg-0">
                            <a href="/" class="d-inline-block mb-5">
                                <img class="img-fluid" src="{{ asset('assets/bookworm/img/324x38/img1.png') }}" alt="Image-Description">
                            </a>
                            <address class="font-size-2 mb-5">
                                <span class="mb-2 font-weight-normal text-gray-500">
                                    @php
                                    $addresses = explode(PHP_EOL, $bex->contact_addresses);
                                    @endphp
                                    <span>
                                        @foreach ($addresses as $address)
                                        {{$address}}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                        @endforeach
                                    </span>
                                </span>
                            </address>
                            <div class="mb-4 h-white">
                                <a href="" class="font-size-2 d-block text-gray-500 mb-1">
                                    @php
                                     $mails = explode(',', $bex->contact_mails);
                                    @endphp
                                    <span>
                                        @foreach ($mails as $mail)
                                        {{$mail}}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                        @endforeach
                                    </span>
                                </a>
                                <a href="" class="font-size-2 d-block text-gray-500">
                                    @php
                                        $phones = explode(',', $bex->contact_numbers);
                                       @endphp
                                       <span>
                                           @foreach ($phones as $phone)
                                           {{$phone}}
                                           @if (!$loop->last)
                                               ,
                                           @endif
                                           @endforeach
                                       </span>
                                </a>
                            </div>
                            <ul class="list-unstyled mb-0 d-flex">
                                <li class="h-white btn pl-0">
                                    <a class="text-gray-500" href="#">
                                        <span class="fab fa-instagram"></span>
                                    </a>
                                </li>
                                <li class="h-white btn">
                                    <a class="text-gray-500" href="#">
                                        <span class="fab fa-facebook-f"></span>
                                    </a>
                                </li>
                                <li class="h-white btn">
                                    <a class="text-gray-500" href="#">
                                        <span class="fab fa-youtube"></span>
                                    </a>
                                </li>
                                <li class="h-white btn">
                                    <a class="text-gray-500" href="#">
                                        <span class="fab fa-twitter"></span>
                                    </a>
                                </li>
                                <li class="h-white btn">
                                    <a class="text-gray-500" href="#">
                                        <span class="fab fa-pinterest"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="mb-5 mb-md-0">
                            <h4 class="font-size-3 text-white font-weight-medium mb-2 mb-xl-5 pb-xl-1">{{__('Useful Links')}}</h4>
                            <ul class="list-unstyled mb-0">
                                @foreach ($ulinks as $key => $ulink)
                                <li class="h-white pb-2">
                                    <a class="font-size-2 text-gray-500 widgets-hover transition-3d-hover" href="{{$ulink->url}}">{{convertUtf8($ulink->name)}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-1 bg-black">
            <div class=" container">
                <div class="text-center">
                    <!-- Copyright -->
                    <p class="mb-3 mb-lg-0 font-size-2 text-gray-500">{!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}</p>
                    <!-- End Copyright -->
                </div>
            </div>
        </div>
    </div>
</footer>