@extends("front.$version.layout")

@section('pagename')
 -
 @if (empty($category))
 {{__('All')}}
 @else
 {{convertUtf8($category->name)}}
 @endif
 {{__('Blogs')}}
@endsection

@section('meta-keywords', "$be->blogs_meta_keywords")
@section('meta-description', "$be->blogs_meta_description")

@section('breadcrumb-title', convertUtf8($bs->blog_title))
@section('breadcrumb-subtitle', convertUtf8($bs->blog_subtitle))
@section('breadcrumb-link', __('Latest Blogs'))

@section('content')
<main id="content">
    <div class="mb-5 mb-lg-8 pb-xl-1">
        <div class="mb-5 mb-lg-8 pb-xl-1">
            <div class="page-header border-bottom">
                <div class="container">
                    <div class="d-md-flex justify-content-between align-items-center py-4">
                        <h1 class="page-title font-size-3 font-weight-medium m-0 text-lh-lg">Blog</h1>
                        <nav class="woocommerce-breadcrumb font-size-2">
                            <a href="/" class="h-primary">Home</a>
                            <span class="breadcrumb-separator mx-1"><i class="fas fa-angle-right"></i></span>
                            <span>Blog</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mb-5 mb-lg-9 pb-xl-1">
                <div class="col-lg-4 col-xl-3">
                    <div class="blog-sidebar-widgets">
                        <div class="searchbar-form-section">
                           <form action="{{route('front.blogs', ['category' => request()->input('category'), 'month' => request()->input('month'), 'year' => request()->input('year')])}}" method="GET">
                              <div class="searchbar">
                                 <input name="category" type="hidden" value="{{request()->input('category')}}">
                                 <input name="month" type="hidden" value="{{request()->input('month')}}">
                                 <input name="year" type="hidden" value="{{request()->input('year')}}">
                                 <input name="term" type="text" placeholder="{{__('Search Blogs')}}" value="{{request()->input('term')}}">
                                 <button type="submit"><i class="fa fa-search"></i></button>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="blog-sidebar-widgets category-widget">
                        <div class="category-lists job">
                           <h4>{{__('Categories')}}</h4>
                           <ul>
                              @foreach ($bcats as $key => $bcat)
                                <li class="single-category @if(request()->input('category') == $bcat->slug) active @endif"><a href="{{route('front.blogs', ['term'=>request()->input('term'), 'category'=>$bcat->slug, 'month' => request()->input('month'), 'year' => request()->input('year')])}}">{{convertUtf8($bcat->name)}}</a></li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                     <div class="blog-sidebar-widgets category-widget">
                        <div class="category-lists job">
                           <h4>{{__('Archives')}}</h4>
                           <ul>
                              @foreach ($archives as $key => $archive)
                                @php
                                  $myArr = explode('-', $archive->date);
                                  $monthNum  = $myArr[0];
                                  $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                  $monthName = $dateObj->format('F');
                                @endphp
                                <li class="single-category @if(request()->input('month') == $myArr[0] && request()->input('year') == $myArr[1]) active @endif">
                                    <a href="{{route('front.blogs', ['term'=>request()->input('term'), 'category'=>request()->input('category'),'month'=>$myArr[0], 'year'=>$myArr[1]])}}">

                                        @php
                                            if (!empty($currentLang)) {
                                                $monthName = \Carbon\Carbon::parse($monthName)->locale("$currentLang->code");
                                                $year = \Carbon\Carbon::parse($myArr[1])->locale("$currentLang->code");
                                            } else {
                                                $monthName = \Carbon\Carbon::parse($monthName)->locale("en");
                                                $year = \Carbon\Carbon::parse($myArr[1])->locale("en");
                                            }

                                            $monthName = $monthName->translatedFormat('F');
                                            $year = $year->translatedFormat('Y');
                                        @endphp

                                        {{$monthName}} {{$year}}
                                    </a>
                                </li>
                              @endforeach
                           </ul>
                        </div>
                     </div>
                     <div class="subscribe-section">
                        <span>{{__('SUBSCRIBE')}}</span>
                        <h3>{{__('SUBSCRIBE FOR NEWSLETTER')}}</h3>
                        <form id="subscribeForm" class="subscribe-form" action="{{route('front.subscribe')}}" method="POST">
                           @csrf
                           <div class="form-element"><input name="email" type="email" placeholder="{{__('Email')}}"></div>
                           <p id="erremail" class="text-danger mb-3 err-email"></p>
                           <div class="form-element"><input type="submit" value="{{__('Subscribe')}}"></div>
                        </form>
                     </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="row row-cols-md-2">
                        @if (count($blogs) == 0)
                          <div class="col-md-12">
                            <div class="bg-light py-5">
                              <h3 class="text-center">{{__('NO BLOG FOUND')}}</h3>
                            </div>
                          </div>
                        @else
                        @foreach ($blogs as $key => $blog)
                        <div class="col">
                            <div class="mb-5">
                                <a class="d-block mb-3" href="{{route('front.blogdetails', [$blog->slug])}}">
                                    <img class="img-fluid" src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="Image-Description">
                                </a>
                                <h6 class="font-size-7 crop-text-2 font-weight-medium text-lh-1dot4">
                                    <a href="{{route('front.blogdetails', [$blog->slug])}}">{{ strlen($blog->title) > 40 ? mb_substr($blog->title, 0, 40, 'utf-8') . '...' : $blog->title }}</a>
                                </h6>
                                <p class="font-size-2 text-secondary-gray-700">{!! strlen(strip_tags($blog->content)) > 100 ? mb_substr(strip_tags($blog->content), 0, 100, 'utf-8') . '...' : strip_tags($blog->content) !!}</p>
                                <div class="font-size-2 text-secondary-gray-700">
                                    @php
                                        if (!empty($currentLang)) {
                                            $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("$currentLang->code");
                                        } else {
                                            $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale("en");
                                        }

                                        $blogDate = $blogDate->translatedFormat('jS F, Y');
                                    @endphp
                                    <span>{{ $blogDate }}</span>
                                    {{-- <span class="ml-3">{{ count($blog) }} comments</span> --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @if ($blogs->total() > 6)
                <div class="row">
                   <div class="col-md-12">
                      <nav class="pagination-nav {{$blogs->total() > 6 ? 'mb-4' : ''}}">
                        {{$blogs->appends(['term'=>request()->input('term'), 'month'=>request()->input('month'), 'year'=>request()->input('year'), 'category' => request()->input('category')])->links()}}
                      </nav>
                   </div>
                </div>
              @endif
        </div>
    </div>
</main>
@endsection
