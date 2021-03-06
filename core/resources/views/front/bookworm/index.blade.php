@extends('front.bookworm.layout')
@section('styles')
@if (!empty($home->css))
<style>
    {!! replaceBaseUrl($home->css) !!}
    .site-branding {
      max-width: 300px;
    }
    footer img {
      max-width: 170px;
      display: block;
    }
</style>
@endif
@endsection
@section('content')
<!-- ====== MAIN CONTENT ====== -->
<!-- // v2 -->
@if(empty($be->bookworm_slider_version))
@include('front.bookworm.sliders.'. $be->bookworm_slider_version )
@else
@include('front.bookworm.sliders.'. $be->bookworm_slider_version )
@endif
@if (!empty($home->html))
{!! convertHtml(convertUtf8($home->html)) !!}
@else
  @includeIf('front.partials.pagebuilder-notice')
@endif

<!-- ====== END MAIN CONTENT ====== -->
@endsection