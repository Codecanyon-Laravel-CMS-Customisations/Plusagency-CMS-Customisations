<div class="js-slick-carousel u-slick"
    data-pagi-classes="text-center u-slick__pagination position-absolute right-0 left-0 mb-n8 mb-lg-4 bottom-0">
    @if(!empty($sliders))
        @foreach ($sliders as $key => $slider)
            <div class="js-slide">
                <div class="hero row min-height-588 align-items-center">
                    <div class="col-lg-7 col-wd-6 mb-4 mb-lg-0">
                        <div class="media-body mr-wd-4 align-self-center mb-4 mb-md-0">
                            <p class="hero__pretitle text-uppercase font-weight-bold text-gray-400 mb-2"
                            data-scs-animation-in="fadeInUp"
                            data-scs-animation-delay="200">{{$slider->title}}</p>
                            <h2 class="hero__title font-size-14 mb-4"
                            data-scs-animation-in="fadeInUp"
                            data-scs-animation-delay="300">
                                <span class="hero__title-line-1 font-weight-regular d-block">{{$slider->text}}</span>
                            </h2>
                            @if (!empty($slider->button_url) && !empty($slider->button_text))
                                <a href="{{$slider->button_url}}" class="btn btn-dark btn-wide rounded-0 hero__btn"
                                data-scs-animation-in="fadeInLeft"
                                data-scs-animation-delay="400">{{$slider->button_text}}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-5 col-wd-6"
                    data-scs-animation-in="fadeInRight"
                    data-scs-animation-delay="500">
                        <img class="img-fluid" src="{{asset('assets/front/img/sliders/'.$slider->image)}}" alt="image-description">
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>