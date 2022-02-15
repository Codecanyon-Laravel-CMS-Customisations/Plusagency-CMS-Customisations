@php
    $language_id    = 'en';
    if(request()->has('language')) $language_id = request()->has('language');
    $lang           = App\Language::where('code', $language_id)->first();
    $sliders_v2     = App\Models\SliderV2::where('language_id', $lang->id)->orderBy('id', 'ASC')->get();


@endphp

<div class="hero-slider-with-banners space-bottom-2 mt-4d875 abh-hero-slider-v2">
    <div class="container">
        <div class="row">
            <div class="@if ($sliders_v2->whereIn('slider_category', ['side1', 'side2'])->count() >= 1) col-md-9 @else col-md-12 @endif mb-4 mb-xl-0 abh-hero-slider-v2-main">
                <div class="bg-gray-200 px-5 px-md-8 px-xl-0 pl-xl-10 pt-6 min-height-530">
                    <div class="js-slick-carousel u-slick"
                        data-pagi-classes="text-center u-slick__pagination u-slick__pagination mt-7">
                        @foreach ($sliders_v2->where('slider_category', 'main') as $slider)
                            <div class="js-slider">
                                <div class="hero-slider">
                                    <div class="d-block d-xl-flex media">
                                        <div class="hero__body media-body align-self-center mb-4 mb-xl-0">
                                            <h2 class="hero__title font-size-10 mb-3" data-scs-animation-in="fadeInUp"
                                                data-scs-animation-delay="300">
                                                <span class="hero__title--1 font-weight-bold d-block" @if(!empty($slider->title_font_size)) style="font-size: {{ $slider->title_font_size }} !important;"@endif>{{ $slider->title }}</span>
                                                <span class="hero__title--2 d-block font-weight-normal" @if(!empty($slider->text_font_size)) style="font-size: {{ $slider->text_font_size }} !important;"@endif>{{ $slider->text }}</span>
                                            </h2>
                                            @if (!empty($slider->button_text))
                                                <a href="{{ $slider->button_url }}"
                                                    class="hero__btn btn btn-primary-green text-white btn-wide"
                                                    data-scs-animation-in="fadeInUp" data-scs-animation-delay="500">
                                                    {{ $slider->button_text }}
                                                </a>
                                            @endif
                                        </div>
                                        <div data-scs-animation-in="fadeInUp" data-scs-animation-delay="600">
                                            <img loading="lazy" src="{{ asset('assets/front/img/sliders/' . $slider->image) }}" class="img-fluid"
                                                alt="{{ $slider->title }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @if ($sliders_v2->whereIn('slider_category', ['side1', 'side2'])->count() >= 1)
                <div class="col-md-3 d-none-----naaaah d-md-block-----naaaah">
                    <div class="banners">
                        @if ($sliders_v2->where('slider_category', 'side1')->count() >= 1)
                            <div class="slider-banner flex-grow-1 mr-md-3 mr-xl-0 bg-gray-200 p-6 mb-4d875 position-relative overflow-hidden abh-hero-slider-v2-s1"
                            style="height:250px;">
                                <div class="z-index-2 position-relative">
                                    <h2 class="slider-banner__title font-size-4 text-lh-md">
                                        <span class="slider-banner__title--1 d-block font-weight-bold">{{ $sliders_v2->where('slider_category', 'side1')->first()->title }}</span>
                                        <span class="slider-banner__title--2">{{ $sliders_v2->where('slider_category', 'side1')->first()->text }}</span>
                                    </h2>
                                </div>
                                <img src="{{ asset('assets/front/img/sliders/' . $sliders_v2->where('slider_category', 'side1')->first()->image) }}"
                                    class="img-fluid position-absolute bottom-n60 right-n60" alt="$slider->image">
                            </div>
                        @endif
                        @if ($sliders_v2->where('slider_category', 'side2')->count() >= 1)
                            <div class="slider-banner flex-grow-1 ml-md-3 ml-xl-0 bg-gray-200 p-6 position-relative overflow-hidden abh-hero-slider-v2-s2"
                                style="height:250px;">
                                <div class="z-index-2 position-relative">
                                    <h2 class="slider-banner__title font-size-4 text-lh-md">
                                        <span class="slider-banner__title--1 d-block font-weight-bold">{{ $sliders_v2->where('slider_category', 'side2')->first()->title }}</span>
                                        <span class="slider-banner__title--2">{{ $sliders_v2->where('slider_category', 'side2')->first()->text }}</span>
                                    </h2>
                                </div>
                                <img src="{{ asset('assets/front/img/sliders/' . $sliders_v2->where('slider_category', 'side2')->first()->image) }}"
                                    class="img-fluid position-absolute bottom-0 right-n60" alt="$slider->image">
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
