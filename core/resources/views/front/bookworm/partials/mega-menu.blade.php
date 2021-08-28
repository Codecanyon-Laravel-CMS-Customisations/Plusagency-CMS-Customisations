
@php
$catAvailable = true;

if ($link["type"] == 'services-megamenu' && serviceCategory()) {
    $data = $currentLang->megamenus()->where('type', 'services')->where('category', 1);
    $cats = $currentLang->scategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();
    $catModel = '\App\Scategory';
    $itemModel = '\App\Service';
    $allUrl = route("front.services");
} elseif ($link["type"] == 'products-megamenu') {
    $data = $currentLang->megamenus()->where('type', 'products')->where('category', 1);
    $cats = $currentLang->pcategories()->where('status', 1)->get();
    $catModel = '\App\Pcategory';
    $itemModel = '\App\Product';
    $allUrl = route("front.product");
} elseif ($link["type"] == 'product_categories-megamenu') {
    $data = $currentLang->megamenus()->where('type', 'product_categories')->where('category', 1);
    $cats = $currentLang->pcategories()->where('status', 1)->get();
    $catModel = '\App\Pcategory';
    $itemModel = '\App\Product';
    $allUrl = route("front.product");
} elseif ($link["type"] == 'portfolios-megamenu' && serviceCategory()) {
    $data = $currentLang->megamenus()->where('type', 'portfolios')->where('category', 1);
    $cats = $currentLang->scategories()->where('status', 1)->get();
    $catModel = '\App\Scategory';
    $itemModel = '\App\Portfolio';
    $allUrl = route('front.portfolios');
} elseif ($link["type"] == 'services-megamenu' && !serviceCategory()) {
    $data = $currentLang->megamenus()->where('type', 'services')->where('category', 0);
    $itemModel = '\App\Service';
    $catAvailable = false;
} elseif ($link["type"] == 'portfolios-megamenu' && !serviceCategory()) {
    $data = $currentLang->megamenus()->where('type', 'portfolios')->where('category', 0);
    $itemModel = '\App\Portfolio';
    $catAvailable = false;
} elseif ($link["type"] == 'courses-megamenu') {
    $data = $currentLang->megamenus()->where('type', 'courses')->where('category', 1);
    $cats = $currentLang->course_categories()->where('status', 1)->get();
    $catModel = '\App\CourseCategory';
    $itemModel = '\App\Course';
    $allUrl = route("courses");
} elseif ($link["type"] == 'causes-megamenu') {
    $data = $currentLang->megamenus()->where('type', 'causes')->where('category', 0);
    $itemModel = '\App\Donation';
    $catAvailable = false;
} elseif ($link["type"] == 'events-megamenu') {
    $data = $currentLang->megamenus()->where('type', 'events')->where('category', 1);
    $cats = $currentLang->event_categories()->where('status', 1)->get();
    $catModel = '\App\EventCategory';
    $itemModel = '\App\Event';
    $allUrl = route("front.events");
} elseif ($link["type"] == 'blogs-megamenu') {
    $data = $currentLang->megamenus()->where('type', 'blogs')->where('category', 1);
    $cats = $currentLang->bcategories()->where('status', 1)->get();
    $catModel = '\App\Bcategory';
    $itemModel = '\App\Blog';
    $allUrl = route("front.blogs");
}
if ($data->count() > 0) {
    $megaMenus = $data->first()->menus;
    $megaMenus = json_decode($megaMenus, true);
} else {
    $megaMenus = [];
}
// dd($megaMenus);
@endphp

<li class="nav-item dropdown">
    <a id="{{ \Str::slug($link['text']) }}DropdownInvoker" href="#" class="dropdown-toggle nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium d-flex align-items-center" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($link['text']) }}DropdownMenu" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="50" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
        {{ $link['text'] }}
    </a>
    <ul id="{{ \Str::slug($link['text']) }}DropdownMenu" class="dropdown-unfold dropdown-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--hidden" aria-labelledby="{{ \Str::slug($link['text']) }}DropdownInvoker" style="animation-duration: 200ms; left: 0px;">
        @foreach ($megaMenus as $mItemId)
            @php
                $mItem = $itemModel::where('id', $mItemId);
                if ($mItem->count() == 0) {
                    continue;
                } else {
                    $mItem = $mItem->first();
                }
                if ($link['type'] == 'services-megamenu') {
                    $detailsUrl = route('front.servicedetails', [$mItem->slug]);
                    $imgSrc = asset('assets/front/img/services/' . $mItem->main_image);
                } elseif ($link['type'] == 'portfolios-megamenu') {
                    $detailsUrl = route('front.portfoliodetails',[$mItem->slug]);
                    $imgSrc = asset('assets/front/img/portfolios/featured/' . $mItem->featured_image);
                } elseif ($link["type"] == 'causes-megamenu') {
                    $detailsUrl = route('front.cause_details',[$mItem->slug]);
                    $imgSrc = asset('assets/front/img/donations/' . $mItem->image);
                } elseif ($link["type"] == 'products-megamenu') {
                    $detailsUrl = route('front.product.details',[$mItem->slug]);
                    $imgSrc = asset('assets/front/img/donations/' . $mItem->image);
                }
                 else {
                    $detailsUrl = '#';
                }
            @endphp
        <li><a href="{{$detailsUrl}}" class="dropdown-item link-black-100">{{strlen($mItem->title) > 30 ? mb_substr($mItem->title,0,30,'utf-8') . '...' : $mItem->title}}</a></li>
        @endforeach
        
    </ul>
</li>