@extends('front.lawyer.layout')

@section('pagename')
-
@if (empty($category))
{{__('All')}}
@else
{{convertUtf8($category->name)}}
@endif
{{__('Portfolios')}}
@endsection

@section('meta-keywords', "$be->portfolios_meta_keywords")
@section('meta-description', "$be->portfolios_meta_description")

@section('breadcrumb-title', convertUtf8($bs->portfolio_title))
@section('breadcrumb-subtitle', $bs->portfolio_subtitle)
@section('breadcrumb-link', __('Portfolios'))

@section('content')
<!--    case lists start   -->
<div class="lawyer_project project_v1 pt-115 pb-115" id="masonry-portfolio">
  <div class="container">
    @if (serviceCategory())
      <div class="row">
        <div class="col-xl-12">
          <div class="filter-nav text-center mb-15">
            <ul class="filter-btn">
              <li data-filter="*" class="active">All</li>
              @foreach ($scats as $key => $scat)
                @php
                  $filterValue = '.' . strtolower($scat->name);

                  if (str_contains($filterValue, ' ')) {
                    $filterValue = str_replace(' ', '-', $filterValue);
                  }
                @endphp

                <li data-filter="{{ $filterValue }}">{{ convertUtf8($scat->name) }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    @endif

    <div class="project_slide masonry-row">
      <div class="row">
        @if (count($portfolios) == 0)
          <div class="col-lg-12 py-5 bg-light text-center mb-4">
            <h3>{{__('NO PORTFOLIO FOUND')}}</h3>
          </div>
        @else
          @foreach ($portfolios as $key => $portfolio)
            @php
              if (!empty($portfolio->service->scategory)) {
                $portfolioCategory = $portfolio->service->scategory;

                $categoryName = strtolower($portfolioCategory->name);

                if (str_contains($categoryName, ' ')) {
                  $categoryName = str_replace(' ', '-', $categoryName);
                }
              }
            @endphp

            <div class="col-lg-4 col-md-6 mb-4 portfolio-column {{ $categoryName }}">
              <div class="grid_item mx-0">
                <div class="grid_inner_item">
                  <div class="lawyer_img">
                    <img src="{{asset('assets/front/img/portfolios/featured/'.$portfolio->featured_image)}}" class="img-fluid" alt="">
                    <div class="overlay_img"></div>
                    <div class="overlay_content">
                      <h3><a href="{{route('front.portfoliodetails', [$portfolio->slug, $portfolio->id])}}">{{strlen($portfolio->title) > 25 ? mb_substr($portfolio->title, 0, 25, 'utf-8') . '...' : $portfolio->title}}</a></h3>
                      @if (!empty($portfolio->service))
                        <p>{{convertUtf8($portfolio->service->title)}}</p>
                      @endif
                      <a href="{{route('front.portfoliodetails', [$portfolio->slug])}}" class="lawyer_btn">{{__('View More')}}</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>

  </div>
</div>
<!--    case lists end   -->
@endsection

@section('scripts')
<script>
  $('#masonry-portfolio').imagesLoaded( function() {
    // items on button click
    $('.filter-btn').on('click', 'li', function () {
      var filterValue = $(this).attr('data-filter');
      $grid.isotope({
        filter: filterValue
      });
    });
    // menu active class
    $('.filter-btn li').on('click', function (e) {
      $(this).siblings('.active').removeClass('active');
      $(this).addClass('active');
      e.preventDefault();
    });
    var $grid = $('.masonry-row').isotope({
      itemSelector: '.portfolio-column',
      percentPosition: true,
      masonry: {
        columnWidth: 0
      }
    });
  });
</script>
@endsection
