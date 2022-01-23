@if(!empty($sliders))
<div class="bg-gray-200 py-5 py-lg-8">
    <div class="container my-lg-1">
        <div class="row">
            <div class="col-sm-12">
                <div class="bg-white mb-6 mb-wd-0 h-100">
                    <div class="px-3 px-lg-8 py-8 py-lg-5 space-top-xl-4">
                        <div class="js-slick-carousel u-slick"
                            data-pagi-classes="text-center u-slick__pagination u-slick__pagination mb-0 mt-3 mt-lg-5"
                            data-arrows-classes="d-none d-lg-block u-slick__arrow u-slick__arrow--v2 u-slick__arrow-centered--y"
                            data-arrow-left-classes="flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n5 ml-xl-n7"
                            data-arrow-right-classes="flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n5 mr-xl-n7">
                            @foreach($sliders as $key => $slider)
                            <div class="pt-xl-2">
                                <div class="row mx-0 mx-md-3">
                                    <div class="col-lg-8 col-wd-6">
                                        <div class="media d-block d-lg-flex">
                                            <div class="media-body align-self-center mb-4 mb-lg-0">
                                                <h6 class="banner__pretitle text-uppercase text-gray-400 font-weight-bold mb-2"
                                                data-scs-animation-in="fadeInUp"
                                                data-scs-animation-delay="200">{{ $slider->title }}</h6>
                                                <h2 class="font-size-12 mb-3 pb-1"
                                                data-scs-animation-in="fadeInUp"
                                                data-scs-animation-delay="300">
                                                    <span class="hero__title-line-1 font-weight-regular d-block text-primary">{{ $slider->text }}</span>
                                                </h2>
                                                @if (!empty($slider->button_url) && !empty($slider->button_text))
                                                <a href="{{ $slider->button_url }}" class="banner_btn btn btn-wide bg-dark rounded-0 text-white"
                                                data-scs-animation-in="fadeInLeft"
                                                data-scs-animation-delay="400">{{ $slider->button_text }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-wd-6"
                                    data-scs-animation-in="fadeInRight"
                                    data-scs-animation-delay="400">
                                        <img src="{{asset('assets/front/img/sliders/'.$slider->image)}}" class="img-fluid" alt="image-description" width="399">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
