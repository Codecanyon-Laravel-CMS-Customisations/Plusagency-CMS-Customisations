@if(!empty($sliders))
<section class="position-relative">
    <div class="bg-gray-200 position-absolute bottom-0 right-0 left-0 h-50 h-wd-60 z-index-n1"></div>
    <div class="container-fluid px-3 px-md-5 px-xl-8d75">
        <div class="bg-img-hero img-fluid" style="background-image: url({{ asset('assets/bookworm/img/1800x500/img1.jpg') }});" >
            <div class="space-bottom-xl-1 space-top-xl-4 p-5 p-md-7 px-xl-10">
                <div class="js-slick-carousel u-slick"
                    data-pagi-classes="text-center u-slick__pagination u-slick__pagination mt-5 mt-md-10 mb-0">
                    @foreach ($sliders as $key => $slider)
                    <div class="js-slide">
                        <div class="hero row">
                            <div class="col-lg-7 col-wd-6 mb-4 mb-lg-0">
                                <div class="media-body mr-wd-4 align-self-center mb-4 mb-md-0">
                                    <p class="hero__pretitle text-uppercase font-weight-bold text-gray-400 mb-2"
                                    data-scs-animation-in="fadeInUp"
                                    data-scs-animation-delay="200">{{ $slider->title }}</p>
                                    <h2 class="hero__title font-size-14 mb-4"
                                    data-scs-animation-in="fadeInUp"
                                    data-scs-animation-delay="300">
                                        <span class="hero__title-line-1 font-weight-regular d-block">{{ $slider->text }}</span>
                                    </h2>
                                    @if (!empty($slider->button_url) && !empty($slider->button_text))
                                    <a href="{{ $slider->button_url }}" class="btn btn-primary btn-wide rounded-0 hero__btn"
                                    data-scs-animation-in="fadeInLeft"
                                    data-scs-animation-delay="400">{{ $slider->button_text }}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-5 col-wd-6"
                            data-scs-animation-in="fadeInRight"
                            data-scs-animation-delay="500">
                                <img class="img-fluid" src="{{asset('assets/front/img/sliders/'.$slider->image)}}" alt="image-description" width="800">
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