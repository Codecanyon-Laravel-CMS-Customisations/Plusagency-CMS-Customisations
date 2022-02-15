@if(!empty($sliders))
<section class="space-bottom-3">
    <div class="container-fluid px-3 px-md-5 px-xl-8d75">
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-lg-5 mb-xl-0">
                    <div class="bg-img-hero img-fluid mb-5" style="background-image: url({{ asset('assets/bookworm/img/1076x761/img1.jpg') }});">
                        <div class="js-slick-carousel u-slick"
                            data-arrows-classes="d-none d-lg-block u-slick__arrow u-slick__arrow--v2 u-slick__arrow-centered--y"
                            data-arrow-left-classes="flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-0"
                            data-arrow-right-classes="flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-0">
                            @foreach($sliders as $key => $slider)
                            <div class="">
                                <div class="row mx-2 mx-md-4 mx-lg-7 align-items-center min-height-600">
                                    <div class="col-md-7 col-wd-6">
                                        <div class="media d-block d-lg-flex">
                                            <div class="media-body align-self-center mb-4 mb-lg-0">
                                                <p class="banner__pretitle text-uppercase text-gray-400 font-weight-bold mb-2"
                                                data-scs-animation-in="fadeInUp"
                                                data-scs-animation-delay="200">{{ $slider->title }}</p>
                                                <h2 class="font-size-10 mb-3 pb-1"
                                                data-scs-animation-in="fadeInUp"
                                                data-scs-animation-delay="300">
                                                    <span class="hero__title-line-1 font-weight-bold d-block">{{ $slider->text }}</span>
                                                </h2>
                                                @if (!empty($slider->button_url) && !empty($slider->button_text))
                                                <a href="{{ $slider->button_url }}" class="banner_btn btn btn-wide bg-dark rounded-0 text-white"
                                                data-scs-animation-in="fadeInLeft"
                                                data-scs-animation-delay="400">{{ $slider->button_text }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-wd-6"
                                    data-scs-animation-in="fadeInRight"
                                    data-scs-animation-delay="400">
                                        <img src="{{asset('assets/front/img/sliders/'.$slider->image)}}" class="img-fluid" alt="image-description" width="500">
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
</section>
@endif