@extends("front.$version.layout")

@section('pagename')
 - {{convertUtf8($blog->title)}}
@endsection

@section('meta-keywords', "$blog->meta_keywords")
@section('meta-description', "$blog->meta_description")

@section('breadcrumb-title', convertUtf8($bs->blog_details_title))
@section('breadcrumb-subtitle', strlen($blog->title) > 30 ? mb_substr($blog->title, 0, 30, 'utf-8') . '...' : $blog->title)
@section('breadcrumb-link', __('Blog Details'))

@section('content')

<main id="content" role="main">
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
            <div>
                <img class="img-fluid" src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}" alt="Image-Description">

                <div class="max-width-940 mx-auto bg-white position-relative">
                    <div class=" mt-n10 mt-md-n13 pt-5 pt-lg-7 px-3 px-md-5 pl-xl-10 pr-xl-8">
                        <div class="ml-xl-4">
                            <div class="mb-5 mb-lg-7">
                                <h6 class="font-size-10 crop-text-2 font-weight-medium text-lh-1dot4">
                                    {{convertUtf8($blog->title)}}
                                </h6>
                                <div class="font-size-2 text-secondary-gray-700">
                                    {{date('F d, Y', strtotime($blog->created_at))}}  -  {{__('BY')}} {{__('Admin')}}
                                </div>
                            </div>
                            
                            {!! replaceBaseUrl(convertUtf8($blog->content)) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 mx-auto">
                    <div class="px-3 px-md-5 pl-xl-10 pr-xl-4">
                        <div class="blog-share mb-5">
                        <ul>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" class="facebook-share"><i class="fab fa-facebook-f"></i> {{__('Share')}}</a></li>
                            <li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}" class="twitter-share"><i class="fab fa-twitter"></i> {{__('Tweet')}}</a></li>
                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title={{convertUtf8($blog->title)}}" class="linkedin-share"><i class="fab fa-linkedin-in"></i> {{__('Linkedin')}}</a></li>
                         </ul>
                        </div>

                        <div class="comment-lists">
                            <div id="disqus_thread"></div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
@if($bs->is_disqus == 1)
{!! $bs->disqus_script !!}
@endif
@endsection
