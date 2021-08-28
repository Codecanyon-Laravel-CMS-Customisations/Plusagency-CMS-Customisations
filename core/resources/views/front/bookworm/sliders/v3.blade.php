@if(!empty($sliders))
<section class="space-bottom-3 mt-5">
    <div class="container">
        <div class="js-slick-carousel u-slick"
            data-pagi-classes="d-xl-none text-center u-slick__pagination u-slick__pagination mt-7"
            data-arrows-classes="d-none d-xl-block u-slick__arrow u-slick__arrow--v1 u-slick__arrow-centered--y rounded-circle"
            data-arrow-left-classes="flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-2"
            data-arrow-right-classes="flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-2">
            @foreach($sliders as $key => $slider)
            <div class="bg-primary-yellow rounded-md px-5 px-xl-11 space-2" style="height: 500px;">
                <div class="hero-slider">
                    <div class="media row">
                        <div class="col-md-6 hero__body media-body align-self-center mb-5 mb-lg-0">
                            <p class="hero__pretitle text-uppercase text-primary-home-v3 opacity-md font-weight-bold mb-2 pb-1">{{ $slider->title }} </p>
                            <h2 class="hero__title text-primary-home-v3 font-size-15 mb-4">
                                <span class="hero__title--1 font-weight-regular d-block">{{ $slider->text }}</span>
                            </h2>
                            @if (!empty($slider->button_url) && !empty($slider->button_text))
                            <a href="{{ $slider->button_url }}" class="hero__btn btn btn-primary-home-v3 text-primary-yellow btn-wide rounded-md">{{ $slider->button_text }}</a>
                            @endif
                        </div>
                        <div class="col-md-6 position-relative mb-5 mb-lg-0 align-self-center">
                            <img src="{{asset('assets/front/img/sliders/'.$slider->image)}}" class="img-fluid" alt="image-description" width="350">
                            {{-- <div class="d-none badge badge-lg badge-primary-home-v3 position-absolute badge-pos--top-right text-primary-yellow rounded-circle d-xl-flex flex-column align-items-center justify-content-center">
                                <h6 class="font-weight-medium mb-n2">save</h6>
                                <span class="font-size-5 font-weight-medium">$49</span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif