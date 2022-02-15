@php
    $vid    = str_ireplace('https://www.youtube.com/watch?v=', '', $bs->hero_section_video_link);
@endphp
<link href="{{ asset('assets/front/video-slider/dist/jquery.vidbacking.css') }}" type="text/css">
<style>
    .hero-slider-with-banners :is(iframe, video){
        aspect-ratio: 16/9;
        width: 100% !important;
        height: auto !important;
    }
</style>
<div class="hero-slider-with-banners space-bottom-2 mt-4d875">
    <div class="container">
        <div class="row">
            <div class="col-wd-9 mb-4 mb-xl-0">
                @if(\Illuminate\Support\Str::contains($bs->hero_section_video_link, 'youtube.com'))
                    <iframe src="https://www.youtube.com/embed/{{ $vid }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen  class="vidbacking"></iframe><br type="_moz">
                @else
                    <video poster="poster.jpg" autoplay muted loop class="w-100">
                        <source src="{{ $bs->hero_section_video_link }}" type="video/mp4">
                    </video>
                @endif
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/front/video-slider/dist/jquery.vidbacking.js') }}"></script>
<script>
    $('.hero-slider-with-banners').vidbacking();
</script>
