@if (!empty($sliders))
<div class="hero-slider-with-banners space-bottom-2 mt-4d875">
    <div class="container">
        <div class="row">
            <div class="col-wd-9 mb-4 mb-xl-0">
                <div class="bg-gray-200 px-5 px-md-8 px-xl-0 pl-xl-10 pt-6 min-height-530">
                    <div class="js-slick-carousel u-slick"
                        data-pagi-classes="text-center u-slick__pagination u-slick__pagination mt-7">
                        @foreach($sliders as $key => $slider)
                        <div class="js-slider">
                            <div class="hero-slider">
                                <div class="d-block d-xl-flex media">
                                    <div class="hero__body media-body align-self-center mb-4 mb-xl-0">
                                        <div class="hero__pretitle text-uppercase text-gray-400 font-weight-bold mb-3"
                                            data-scs-animation-in="fadeInUp"
                                            data-scs-animation-delay="200">
                                            {{ $slider->title }}
                                        </div>

                                        <h2 class="hero__title font-size-10 mb-3"
                                            data-scs-animation-in="fadeInUp"
                                            data-scs-animation-delay="300">
                                            <span class="hero__title--1 font-weight-bold d-block">{{ $slider->text }}</span>
                                        </h2>

                                        {{-- <p class="hero__subtitle font-size-2 mb-5"
                                            data-scs-animation-in="fadeInUp"
                                            data-scs-animation-delay="400">Sale Ends Midnight 30th April 2020
                                        </p> --}}
                                        @if (!empty($slider->button_url) && !empty($slider->button_text))
                                        <a href="{{ $slider->button_url }}" class="hero__btn btn btn-primary-green text-white btn-wide"
                                            data-scs-animation-in="fadeInUp"
                                            data-scs-animation-delay="500">{{ $slider->button_text }}
                                        </a>
                                        @endif
                                    </div>

                                    <div
                                        data-scs-animation-in="fadeInUp"
                                        data-scs-animation-delay="600">
                                        <img src="{{asset('assets/front/img/sliders/'.$slider->image)}}" class="img-fluid" alt="image-description" width="500">
                                    </div>
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
@endif
