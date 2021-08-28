@if(!empty($sliders))
<div class="bg-img-hero img-fluid" style="background-image: url({{ asset('assets/bookworm/img/1920x600/img1.jpg') }});">
    <div class="px-3 px-lg-10 py-3 py-lg-10 space-top-xl-3 space-bottom-xl-1">
        <div class="js-slick-carousel u-slick" data-pagi-classes="text-center u-slick__pagination u-slick__pagination mb-0 mt-5" data-arrows-classes="d-none d-lg-block u-slick__arrow u-slick__arrow--v2 u-slick__arrow-centered--y" data-arrow-left-classes="flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n9 ml-xl-n10" data-arrow-right-classes="flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n9 mr-xl-n10">
            @foreach($sliders as $key => $slider)
            <div class="pt-xl-3">
                <div class="row p-md-6 p-lg-0">
                    <div class="col-md-8">
                        <div class="media d-block d-lg-flex ml-lg-6">
                            <div class="media-body align-self-center mb-4 mb-lg-0">
                                <p class="banner__pretitle text-uppercase text-gray-400 font-weight-bold mb-2"
                                data-scs-animation-in="fadeInUp"
                                data-scs-animation-delay="200">{{ $slider->title }}</p>
                                <h2 class="font-size-12 mb-1"
                                data-scs-animation-in="fadeInUp"
                                data-scs-animation-delay="300">
                                    <span class="hero__title-line-1 font-weight-regular d-block">{{ $slider->text }}</span>
                                </h2>
                                {{-- <div class="font-size-2 text-secondary-gray-700"
                                data-scs-animation-in="fadeInUp"
                                data-scs-animation-delay="300">Discount</div>
                                <div class="font-size-26 font-weight-medium text-primary mb-2" data-scs-animation-in="fadeInUp"
                                data-scs-animation-delay="300">40% Off</div> --}}
                                <div>
                                    @if (!empty($slider->button_url) && !empty($slider->button_text))
                                    <a href="{{ $slider->button_url }}" class="banner_btn btn btn-wide btn-dark rounded-0 text-white"
                                    data-scs-animation-in="fadeInLeft"
                                    data-scs-animation-delay="400">{{ $slider->button_text }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"
                    data-scs-animation-in="fadeInRight"
                    data-scs-animation-delay="500">
                        <img src="{{asset('assets/front/img/sliders/'.$slider->image)}}" class="img-fluid" alt="image-description">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif