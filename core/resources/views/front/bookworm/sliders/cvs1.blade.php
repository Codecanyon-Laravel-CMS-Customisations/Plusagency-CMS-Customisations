<link href="{{ asset('assets/front/video-slider/dist/css/jquery.mb.YTPlayer.min.css') }}" rel="stylesheet" />
<div class="hero-slider-with-banners space-bottom-2 mt-4d875">
    <div class="container">
        <div class="row">
            <div class="col-wd-9 mb-4 mb-xl-0">
                <div class="player w-100"
                    style="min-height: 250px !important"
                    data-property="{videoURL:'NccfVQ0HKd4',containment:'self',autoPlay:true, mute:true, startAt:0, ratio:'16/9', opacity:1}">
                    {{-- <i class="fas fa-spinner fa-spin fa-pulse "></i> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/front/video-slider/dist/jquery.mb.YTPlayer.min.js') }}"></script>
<script>
    jQuery(function() {
        jQuery(".player").YTPlayer();
    });
</script>
