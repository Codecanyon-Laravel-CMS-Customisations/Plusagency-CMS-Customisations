@if (!empty($sliders))
<section class="space-bottom-2 space-bottom-xl-3">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="bg-img-hero img-fluid bg-gradient-dark-1 mb-6 mb-xl-0 ml-xl-2d75 ml-wd-11" style="background-image: url({{ asset('assets/bookworm/img/900x506/img1.jpg') }});">
                    <div class="space-top-2 space-top-xl-4 px-4 px-md-5 px-lg-7 pb-3">
                        <ul class="js-slick-carousel u-slick pl-0 mb-0"
                            data-pagi-classes="text-center u-slick__pagination u-slick__pagination--v2 mt-6 mb-3">
                            @foreach($sliders as $key => $slider)
                            <li class="hero-slider">
                                <div class="d-block d-md-flex media">
                                    <div class="hero__body media-body align-self-center mb-4 mb-xl-0">
                                        <p class="hero__pretitle text-uppercase text-gray-400 font-weight-bold">{{ $slider->title }}</p>
                                        <h2 class="hero__title font-size-15 d-flex mb-4">
                                            <span class="hero__title--1 font-weight-normal d-block text-white">{{ $slider->text }}</span>
                                        </h2>
                                        @if (!empty($slider->button_url) && !empty($slider->button_text))
                                        <a href="{{ $slider->button_url }}" class="btn height-50 hero__btn bg-white text-dark rounded-0 btn-wide">{{ $slider->button_text }}</a>
                                        @endif
                                    </div>
                                    <img src="{{asset('assets/front/img/sliders/'.$slider->image)}}" class="img-fluid" alt="image-description" width="250">
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
