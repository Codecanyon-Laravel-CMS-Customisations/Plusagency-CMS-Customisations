<ul class="nav">
    @foreach (json_decode($menus, true) as $link)
        @php
            $href = getHref($link);
        @endphp

        @if (strpos($link["type"], '-megamenu') !==  false)
            @includeIf('front.bookworm.partials.mega-menu')

        @else

            @if (!array_key_exists("children",$link))
                {{--- Level1 links which doesn't have dropdown menus ---}}
                {{--                                        <!--TODO add dynamic actve class-->--}}
                <li class="nav-item"><a href="{{ $href }}" target="{{ $link["target"] }}"class="nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium">{{ $link["text"] }}</a></li>

            @else
                <li class="nav-item dropdown">
                    <a id="{{ \Str::slug($link['text']) }}DropdownInvoker" href="{{ $href }}" target="{{ $link['target'] }}" class="dropdown-toggle nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium d-flex align-items-center"
                       aria-haspopup="true"
                       aria-expanded="false"
                       data-unfold-event="hover"
                       data-unfold-target="#{{ \Str::slug($link['text']) }}DropdownMenu"
                       data-unfold-type="css-animation"
                       data-unfold-duration="200"
                       data-unfold-delay="50"
                       data-unfold-hide-on-scroll="true"
                       data-unfold-animation-in="slideInUp"
                       data-unfold-animation-out="fadeOut">
                        {{ $link['text'] }}
                    </a>
                    <ul id="{{ \Str::slug($link['text']) }}DropdownMenu" class="dropdown-unfold dropdown-menu font-size-2 rounded-0 border-gray-900" aria-labelledby="{{ \Str::slug($link['text']) }}DropdownInvoker">
                        {{-- START: 2nd level links --}}
                        @foreach ($link["children"] as $level2)
                            @php
                                $l2Href = getHref($level2);
                            @endphp

                            <li @if(array_key_exists("children", $level2)) class="submenus" @endif>


                            {{-- START: 3rd Level links --}}
                            @if(array_key_exists("children", $level2))
                                <li class="position-relative">
                                    <a id="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($level2['text']) }}DropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $level2['text'] }}
                                    </a>
                                    <ul id="{{ \Str::slug($level2['text']) }}DropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--hidden u-unfold--reverse-y" aria-labelledby="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker" style="animation-duration: 200ms;">
                                        @foreach ($level2["children"] as $level3)
                                            @php
                                                $l3Href = getHref($level3);
                                            @endphp
                                            <li>
                                                <a href="{{$l3Href}}" target="{{$level3["target"]}}" class="dropdown-item link-black-100">{{ $level3['text'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <a href="{{$l2Href}}" target="{{$level2["target"]}}" class="dropdown-item link-black-100">{{ $level2['text'] }}</a>
                                @endif
                                {{-- END: 3rd Level links --}}

                                </li>
                                @endforeach
                                {{-- END: 2nd level links --}}
                    </ul>
                </li>
            @endif

        @endif

    @endforeach
    {{--                            @foreach ($categories1 as $item)--}}
    @foreach ($productmenus as $link)
        <?php
        $item = $categories1->where('name', $link['text'])->first();
        if($item->id == '') continue;
        ?>
        <li class="nav-item dropdown">
            <a id="{{ \Str::slug($item->name) }}DropdownInvoker" href="#" class="dropdown-toggle nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium d-flex align-items-center" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($item->name) }}DropdownMenu" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="50" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">
                {{ $item->name }}
            </a>
            @php
                $products_m1 = \App\Product::query()->where('category_id', '=', $item->id);
                $subcats = $item->child_cats()->whereIn('id', $ids)->whereNotIn('id', $indexes2)->get();
                $subcatchilds = $item->child_cats()->WhereHas('childs')->whereIn('id', $ids)->get();
            @endphp
            @if (!empty($subcats))
                <ul id="{{ \Str::slug($item->name) }}DropdownMenu" class="dropdown-unfold dropdown-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--hidden" aria-labelledby="{{ \Str::slug($item->name) }}DropdownInvoker" style="animation-duration: 200ms; left: 0px;">
                    @foreach ($subcatchilds as $subcat)
                        @php
                            $products_m2 = \App\Product::query()->where('sub_category_id', '=', $subcat->id);
                            $subsubcats = $subcat->child_sub_cats()->WhereIn('id', $ids2)->get();
                        @endphp
                        @if ($subsubcats->count() >= 1 || !empty($products_m2))
                            @if(!empty($products_m2))
                                @if ($subsubcats->count() >= 1)



                                    <li  class="submenus" >
                                    <li class="position-relative">
                                        <a id="child-cat-{{ \Str::slug($subcat->id) }}DropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#child-cat-{{ \Str::slug($subcat->id) }}DropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $subcat->name }}
                                        </a>
                                        <ul id="child-cat-{{ \Str::slug($subcat->id) }}DropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--hidden u-unfold--reverse-y" aria-labelledby="child-cat-{{ \Str::slug($subcat->id) }}DropdownsubmenuoneInvoker" style="animation-duration: 200ms;">                                                                                                                                        <li>
                                            @foreach ($subsubcats as $subsubcat)
                                                @php
                                                    $products_m3 = \App\Product::query()->where('sub_child_category_id', '=', $subsubcat->id)
                                                @endphp
                                                <li class="submenu"></li>
                                                <li class="position-relative">
                                                    <a id="{{ \Str::slug($subsubcat->id) }}CDropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="true" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($subsubcat->id) }}CDropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $subsubcat->name }}
                                                    </a>
                                                    <ul id="{{ \Str::slug($subsubcat->id) }}CDropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--reverse-y fadeOut" aria-labelledby="{{ \Str::slug($subsubcat->id) }}CDropdownsubmenuoneInvoker" style="animation-duration: 200ms;">
                                                        @foreach ($products_m3->get() as $product3)
                                                            <li>
                                                                <a class="dropdown-item link-black-100" href="{{route('front.product.details',$product3->slug)}}">{{ $product3->title }}</a>
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    </li>








                                @endif
                            @endif
                        @endif
                        @if ($subsubcats->count() == 0 && $subcat->child_cats->count() === 0)
                            @if ($subsubcats->count() == 0)
                                <li class="submenu"></li>
                                <li class="position-relative">
                                    <a id="{{ \Str::slug($subcat->id) }}MDropdownsubmenuoneInvoker" href="#" class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between" aria-haspopup="true" aria-expanded="true" data-unfold-event="hover" data-unfold-target="#{{ \Str::slug($subcat->id) }}MDropdownsubMenuone" data-unfold-type="css-animation" data-unfold-duration="200" data-unfold-delay="100" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">{{ $subcat->name }}
                                    </a>
                                    <ul id="{{ \Str::slug($subcat->id) }}MDropdownsubMenuone" class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--reverse-y fadeOut" aria-labelledby="{{ \Str::slug($subcat->id) }}MDropdownsubmenuoneInvoker" style="animation-duration: 200ms;">
                                        @foreach ($products_m2->get() as $product3)
                                            <li>
                                                <a class="dropdown-item link-black-100" href="{{route('front.product.details',$product3->slug)}}">{{ $product3->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endforeach

                </ul>
            @endif
        </li>
    @endforeach
</ul>
