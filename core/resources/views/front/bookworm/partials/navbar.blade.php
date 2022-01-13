@php
//$categories = \App\Language::where('code', 'en')->first()->pcategories;
$lang = \App\Language::where('code', 'en')->first();
$categories = \App\Pcategory::with('childs');
$categories = \App\Pcategory::all() //;
    ->where('language_id', $lang->id)
    ->where('status', 1); //->get();
$products = \App\Product::withoutGlobalScope('variation')->where('status', 1);
$categories1 = $categories->where('menu_level', '1');
$categories2 = $categories->where('menu_level', '2');
$categories3 = $categories->where('menu_level', '3');

$c1 = App\Models\Unscoped\Pcategory::query()
    ->where('language_id', $lang->id)
    ->where('show_in_menu', 1)
    ->where('menu_level', 1)
    ->where('status', 1); //->get();
$c2 = App\Models\Unscoped\Pcategory::query()
    ->where('language_id', $lang->id)
    ->where('show_in_menu', 1)
    ->where('menu_level', 2)
    ->where('status', 1); //->get();
$c3 = App\Models\Unscoped\Pcategory::query()
    ->where('language_id', $lang->id)
    ->where('show_in_menu', 1)
    ->where('menu_level', 3)
    ->where('status', 1); //->get();

function getCurrentC2(App\Models\Unscoped\Pcategory $pcategory)
{
    $lang = \App\Language::where('code', 'en')->first();
    return App\Models\Unscoped\Pcategory::query()
        ->where('parent_menu_id', $pcategory->id)
        ->where('language_id', $lang->id)
        ->where('show_in_menu', 1)
        ->where('menu_level', 2)
        ->where('status', 1)
        ->get();
}
function getCurrentC3(App\Models\Unscoped\Pcategory $pcategory)
{
    $lang = \App\Language::where('code', 'en')->first();
    return App\Models\Unscoped\Pcategory::query()
        ->where('name', '!=', 'Default Category')
        ->where('parent_menu_id', $pcategory->id)
        ->where('language_id', $lang->id)
        ->where('show_in_menu', 1)
        ->where('menu_level', 3)
        ->where('status', 1)
        ->get();
}
@endphp
@include('front.bookworm.header.' . $be->bookworm_header_version )



<aside id="main-nav" style="display:none">
    <div class="sidebar-nav-header">
        <h2 class="font-size-3 mb-0">SHOP BY CATEGORY</h2>
    </div>
    <ul class="">
        @foreach ($c1->get() as $cat1)
            <li class="">
                <a href="#" data-submenu="cat1-{{ $cat1->id }}">{{ $cat1->name }}</a>
                <ul>
                    @foreach (getCurrentC2($cat1) as $cat2)
                        @if (count(getCurrentC3($cat2)) >= 1)
                            <li class="has-submenu">
                                <a href="#" data-submenu="cat2-{{ $cat2->id }}">{{ $cat2->name }}</a>
                                <ul class="">
                                    @foreach (getCurrentC3($cat2) as $cat3)
                                        <li>
                                            <a
                                                href="/products?search=&scc-id={{ $cat3->id }}&type=new">{{ $cat3->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a
                                    href="/products?search=&sc-id={{ $cat2->id }}&type=new" class="h-primary">{{ $cat2->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @endforeach
        <li>
            <a href="{{ route('front.product-categories') }}" class="h-primary">All Categories</a>
        </li>
    </ul>
</aside>
