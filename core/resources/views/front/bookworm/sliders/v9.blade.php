@if(!empty($sliders))
<section class="mb-8">
    <div class="container">
        <div class="pt-5 pb-5">
            <div class="bg-img-hero img-fluid rounded-md" style="background-image:url({{ asset('assets/bookworm/img/1076x761/img1.jpg') }});">
                <div class="js-slick-carousel u-slick"
                    data-pagi-classes="d-lg-none text-center u-slick__pagination mt-5 position-absolute left-0 right-0"
                    data-arrows-classes="d-none d-lg-block u-slick__arrow u-slick__arrow--v4 u-slick__arrow-centered--y"
                    data-arrow-left-classes="flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left text-gray-360 ml-lg-3"
                    data-arrow-right-classes="flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right text-dark mr-lg-3">
                    @foreach($sliders as $key => $slider)
                    <div class="px-4 px-md-6 px-lg-7 px-xl-10 d-flex min-height-530">
                        <div class="max-width-565 my-auto">
                            <div class="media">
                                <div class="media-body align-self-center mb-4 mb-lg-0">
                                    <p class="banner__pretitle text-uppercase text-gray-400 font-weight-bold mb-2"
                                    data-scs-animation-in="fadeInUp"
                                    data-scs-animation-delay="200">{{ $slider->title }}</p>
                                    <h2 class="font-size-15 mb-3 pb-1"
                                    data-scs-animation-in="fadeInUp"
                                    data-scs-animation-delay="300">
                                        <span class="hero__title-line-1 font-weight-normal d-block">{{ $slider->text }}</span>
                                    </h2>
                                    @if (!empty($slider->button_url) && !empty($slider->button_text))
                                    <a href="{{ $slider->button_url }}" class="banner_btn btn btn-wide bg-dark text-white rounded-xs"
                                    data-scs-animation-in="fadeInLeft"
                                    data-scs-animation-delay="400">{{ $slider->button_text }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif