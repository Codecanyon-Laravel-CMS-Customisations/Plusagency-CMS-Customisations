@php
if (Session::has('cart')) {
    $cart = Session::get('cart');
} else {
    $cart = null;
}
@endphp
<link rel="stylesheet" href="https://demo2.madrasthemes.com/bookworm-html/redesigned-octo-fiesta/assets/css/theme.css">
<!--===== HEADER CONTENT =====-->
<header id="site-header" class="site-header__v4">
    <div class="masthead">
        <div class="bg-white">
            <div class="container py-3">
                <div class="d-flex align-items-center position-relative flex-wrap">
                    <div class="site-branding pr-md-7 mx-auto mx-md-0">
                        <a href="{{ route('front.index') }}" class="d-block mb-2">
                            {{-- <img src="{{asset('assets/front/img/'.$bs->logo)}}" class="img-fluid lazy" alt=""> --}}
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="170px" height="30px">
                                <path fill-rule="evenodd" fill="rgb(25, 17, 11)"
                                    d="M166.225,28.691 L165.065,15.398 L160.598,28.691 L158.229,28.691 L153.762,15.398 L152.590,28.691 L148.928,28.691 L150.405,11.052 L155.629,11.052 L159.389,22.124 L163.198,11.052 L168.422,11.052 L169.875,28.691 L166.225,28.691 ZM142.641,28.691 L138.051,20.928 L136.989,20.928 L136.989,28.691 L133.327,28.691 L133.327,11.052 L139.724,11.052 C140.692,11.052 141.546,11.189 142.287,11.461 C143.028,11.734 143.620,12.112 144.063,12.596 C144.507,13.081 144.840,13.636 145.064,14.263 C145.288,14.889 145.400,15.577 145.400,16.326 C145.400,17.506 145.078,18.472 144.436,19.225 C143.793,19.978 142.869,20.484 141.665,20.745 L146.975,28.691 L142.641,28.691 ZM141.896,16.204 C141.896,15.544 141.673,15.028 141.225,14.653 C140.777,14.279 140.086,14.092 139.150,14.092 L136.989,14.092 L136.989,18.303 L139.150,18.303 C140.981,18.303 141.896,17.603 141.896,16.204 ZM125.570,27.831 C124.206,28.567 122.666,28.936 120.949,28.936 C119.224,28.936 117.680,28.567 116.317,27.831 C114.953,27.094 113.881,26.034 113.100,24.651 C112.319,23.267 111.928,21.672 111.928,19.866 C111.928,18.051 112.319,16.454 113.100,15.074 C113.881,13.695 114.953,12.639 116.317,11.907 C117.680,11.174 119.224,10.808 120.949,10.808 C122.674,10.808 124.217,11.174 125.576,11.907 C126.935,12.639 128.005,13.695 128.786,15.074 C129.567,16.454 129.958,18.051 129.958,19.866 C129.958,21.672 129.567,23.267 128.786,24.651 C128.005,26.034 126.933,27.094 125.570,27.831 ZM124.807,15.715 C123.797,14.690 122.512,14.177 120.949,14.177 C119.387,14.177 118.101,14.690 117.092,15.715 C116.083,16.741 115.578,18.124 115.578,19.866 C115.578,21.616 116.083,23.005 117.092,24.034 C118.101,25.064 119.387,25.579 120.949,25.579 C122.512,25.579 123.797,25.064 124.807,24.034 C125.816,23.005 126.320,21.616 126.320,19.866 C126.320,18.124 125.816,16.741 124.807,15.715 ZM66.872,28.691 L61.391,21.196 L60.097,21.196 L60.097,28.691 L56.435,28.691 L56.435,11.052 L60.097,11.052 L60.097,17.986 L61.342,17.986 L66.872,11.052 L71.340,11.052 L64.504,19.487 L71.547,28.691 L66.872,28.691 ZM48.677,27.831 C47.314,28.567 45.774,28.936 44.057,28.936 C42.332,28.936 40.788,28.567 39.425,27.831 C38.061,27.094 36.989,26.034 36.208,24.651 C35.427,23.267 35.036,21.672 35.036,19.866 C35.036,18.051 35.427,16.454 36.208,15.074 C36.989,13.695 38.061,12.639 39.425,11.907 C40.788,11.174 42.332,10.808 44.057,10.808 C45.782,10.808 47.324,11.174 48.684,11.907 C50.043,12.639 51.113,13.695 51.894,15.074 C52.675,16.454 53.066,18.051 53.066,19.866 C53.066,21.672 52.675,23.267 51.894,24.651 C51.113,26.034 50.040,27.094 48.677,27.831 ZM47.915,15.715 C46.905,14.690 45.620,14.177 44.057,14.177 C42.495,14.177 41.209,14.690 40.200,15.715 C39.191,16.741 38.686,18.124 38.686,19.866 C38.686,21.616 39.191,23.005 40.200,24.034 C41.209,25.064 42.495,25.579 44.057,25.579 C45.620,25.579 46.905,25.064 47.915,24.034 C48.924,23.005 49.428,21.616 49.428,19.866 C49.428,18.124 48.924,16.741 47.915,15.715 ZM28.487,27.831 C27.124,28.567 25.584,28.936 23.867,28.936 C22.141,28.936 20.597,28.567 19.234,27.831 C17.871,27.094 16.799,26.034 16.018,24.651 C15.236,23.267 14.846,21.672 14.846,19.866 C14.846,18.051 15.236,16.454 16.018,15.074 C16.799,13.695 17.871,12.639 19.234,11.907 C20.597,11.174 22.141,10.808 23.867,10.808 C25.592,10.808 27.134,11.174 28.493,11.907 C29.852,12.639 30.922,13.695 31.704,15.074 C32.485,16.454 32.875,18.051 32.875,19.866 C32.875,21.672 32.485,23.267 31.704,24.651 C30.922,26.034 29.850,27.094 28.487,27.831 ZM27.724,15.715 C26.715,14.690 25.429,14.177 23.867,14.177 C22.304,14.177 21.018,14.690 20.009,15.715 C19.000,16.741 18.496,18.124 18.496,19.866 C18.496,21.616 19.000,23.005 20.009,24.034 C21.018,25.064 22.304,25.579 23.867,25.579 C25.429,25.579 26.715,25.064 27.724,24.034 C28.733,23.005 29.238,21.616 29.238,19.866 C29.238,18.124 28.733,16.741 27.724,15.715 ZM11.672,27.367 C10.736,28.250 9.361,28.691 7.546,28.691 L0.283,28.691 L0.283,11.052 L5.996,11.052 C7.875,11.052 9.314,11.478 10.311,12.328 C11.308,13.178 11.806,14.365 11.806,15.886 C11.806,16.676 11.633,17.374 11.287,17.980 C10.941,18.586 10.431,19.052 9.755,19.377 C11.969,19.988 13.076,21.445 13.076,23.748 C13.076,25.278 12.608,26.484 11.672,27.367 ZM7.827,14.647 C7.420,14.277 6.821,14.092 6.032,14.092 L3.811,14.092 L3.811,18.242 L6.191,18.242 C6.940,18.242 7.501,18.047 7.875,17.656 C8.250,17.266 8.437,16.753 8.437,16.118 C8.437,15.508 8.233,15.018 7.827,14.647 ZM8.876,21.709 C8.445,21.278 7.749,21.062 6.789,21.062 L3.811,21.062 L3.811,25.554 L6.862,25.554 C7.782,25.554 8.455,25.347 8.883,24.932 C9.310,24.517 9.523,23.988 9.523,23.345 C9.523,22.686 9.308,22.140 8.876,21.709 Z">
                                </path>
                                <path class="fill-primary" fill-rule="evenodd"
                                    d="M105.996,23.499 C105.995,26.752 103.950,29.265 100.748,29.950 C100.713,29.958 100.681,29.983 100.647,30.000 C100.588,30.000 100.529,30.000 100.471,30.000 C100.467,28.585 100.460,27.171 100.466,25.756 C100.467,25.675 100.550,25.565 100.626,25.518 C101.352,25.068 101.714,24.425 101.711,23.571 C101.707,22.020 101.710,20.469 101.710,18.892 C103.133,18.892 104.546,18.892 105.996,18.892 C105.996,18.989 105.996,19.093 105.996,19.196 C105.996,20.630 105.997,22.065 105.996,23.499 ZM101.715,17.089 C101.715,15.990 101.683,14.917 101.724,13.847 C101.767,12.679 102.761,11.806 103.931,11.838 C105.060,11.869 105.978,12.794 105.993,13.940 C106.005,14.954 105.995,15.969 105.995,16.983 C105.995,17.011 105.987,17.040 105.980,17.089 C104.569,17.089 103.157,17.089 101.715,17.089 ZM96.421,29.234 C94.322,27.983 93.199,26.136 93.155,23.703 C93.108,21.138 93.145,18.571 93.146,16.005 C93.146,15.957 93.153,15.910 93.159,15.841 C94.572,15.841 95.976,15.841 97.426,15.841 C97.426,15.948 97.426,16.060 97.426,16.172 C97.426,18.602 97.430,21.031 97.423,23.461 C97.421,24.364 97.757,25.066 98.548,25.540 C98.629,25.589 98.688,25.740 98.689,25.844 C98.699,27.122 98.695,28.401 98.696,29.679 C98.696,29.786 98.703,29.893 98.707,30.000 C98.648,30.000 98.590,30.000 98.531,30.000 C97.799,29.823 97.075,29.624 96.421,29.234 ZM93.145,14.043 C93.145,13.935 93.145,13.823 93.145,13.711 C93.145,11.318 93.137,8.926 93.149,6.534 C93.154,5.625 92.818,4.928 92.023,4.460 C91.961,4.424 91.894,4.332 91.894,4.265 C91.886,2.850 91.888,1.436 91.888,0.000 C93.423,0.232 94.703,0.889 95.731,2.009 C96.833,3.209 97.413,4.630 97.421,6.261 C97.433,8.791 97.426,11.319 97.427,13.849 C97.427,13.906 97.421,13.964 97.416,14.043 C96.005,14.043 94.599,14.043 93.145,14.043 ZM89.588,4.782 C89.034,5.128 88.866,5.768 88.868,6.431 C88.875,8.061 88.870,9.692 88.869,11.322 C88.869,12.143 88.869,12.963 88.867,13.783 C88.867,13.869 88.857,13.954 88.851,14.051 C87.434,14.051 86.035,14.051 84.587,14.051 C84.587,13.958 84.587,13.866 84.587,13.774 C84.588,11.294 84.579,8.814 84.590,6.334 C84.605,3.158 86.853,0.543 90.000,0.018 C90.028,0.013 90.058,0.017 90.125,0.017 C90.125,0.639 90.125,1.243 90.125,1.848 C90.125,2.405 90.109,2.962 90.130,3.518 C90.149,4.032 90.126,4.447 89.588,4.782 ZM84.585,15.837 C86.015,15.837 87.420,15.837 88.868,15.837 C88.868,15.951 88.868,16.065 88.868,16.179 C88.868,18.608 88.849,21.039 88.873,23.468 C88.908,27.007 86.358,29.493 83.589,29.955 C83.552,29.961 83.518,29.985 83.482,30.000 C83.424,30.000 83.365,30.000 83.306,30.000 C83.310,28.634 83.319,27.268 83.313,25.902 C83.311,25.691 83.376,25.580 83.559,25.467 C84.268,25.031 84.587,24.371 84.587,23.549 C84.587,21.099 84.586,18.650 84.585,16.201 C84.585,16.085 84.585,15.970 84.585,15.837 ZM81.366,30.000 C80.875,29.844 80.360,29.740 79.897,29.524 C77.435,28.380 76.120,26.440 76.027,23.732 C75.974,22.192 76.017,20.649 76.016,19.107 C76.016,19.040 76.016,18.973 76.016,18.886 C77.447,18.886 78.859,18.886 80.303,18.886 C80.303,19.000 80.303,19.104 80.303,19.209 C80.303,20.663 80.308,22.117 80.302,23.571 C80.298,24.427 80.666,25.065 81.387,25.518 C81.463,25.566 81.547,25.675 81.547,25.756 C81.553,27.171 81.546,28.585 81.542,30.000 C81.484,30.000 81.425,30.000 81.366,30.000 ZM76.017,17.097 C76.017,16.540 76.017,15.997 76.017,15.453 C76.017,14.965 76.012,14.478 76.017,13.990 C76.030,12.831 76.911,11.892 78.032,11.838 C79.203,11.781 80.217,12.619 80.282,13.797 C80.341,14.885 80.294,15.978 80.294,17.097 C78.857,17.097 77.452,17.097 76.017,17.097 Z">
                                </path>
                            </svg>
                        </a>
                    </div>
                    <div class="site-navigation mr-auto d-none d-xl-block">
                        <ul class="nav">
                            @foreach (json_decode($menus, true) as $link)
                                @php
                                    $href = getHref($link);
                                @endphp

                                @if (strpos($link['type'], '-megamenu') !== false)
                                    @includeIf('front.bookworm.partials.mega-menu')

                                @else

                                    @if (!array_key_exists('children', $link))
                                        {{-- - Level1 links which doesn't have dropdown menus - --}}
                                        <!--TODO add dynamic actve class-->
                                        <li class="nav-item"><a href="{{ $href }}"
                                                target="{{ $link['target'] }}"
                                                class="nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium border-bottom border-primary border-width-2">{{ $link['text'] }}</a>
                                        </li>

                                    @else
                                        <li class="nav-item dropdown">
                                            <a id="{{ \Str::slug($link['text']) }}DropdownInvoker"
                                                href="{{ $href }}" target="{{ $link['target'] }}"
                                                class="dropdown-toggle nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium d-flex align-items-center"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#{{ \Str::slug($link['text']) }}DropdownMenu"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="slideInUp"
                                                data-unfold-animation-out="fadeOut">
                                                {{ $link['text'] }}
                                            </a>
                                            <ul id="{{ \Str::slug($link['text']) }}DropdownMenu"
                                                class="dropdown-unfold dropdown-menu font-size-2 rounded-0 border-gray-900"
                                                aria-labelledby="{{ \Str::slug($link['text']) }}DropdownInvoker">
                                                {{-- START: 2nd level links --}}
                                                @foreach ($link['children'] as $level2)
                                                    @php
                                                        $l2Href = getHref($level2);
                                                    @endphp

                                                    <li @if (array_key_exists('children', $level2)) class="submenus" @endif>


                                                        {{-- START: 3rd Level links --}}
                                                        @if (array_key_exists('children', $level2))
                                                    <li class="position-relative">
                                                        <a id="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker"
                                                            href="#"
                                                            class="dropdown-toggle dropdown-item dropdown-item__sub-menu link-black-100 d-flex align-items-center justify-content-between"
                                                            aria-haspopup="true" aria-expanded="false"
                                                            data-unfold-event="hover"
                                                            data-unfold-target="#{{ \Str::slug($level2['text']) }}DropdownsubMenuone"
                                                            data-unfold-type="css-animation" data-unfold-duration="200"
                                                            data-unfold-delay="100" data-unfold-hide-on-scroll="true"
                                                            data-unfold-animation-in="slideInUp"
                                                            data-unfold-animation-out="fadeOut">{{ $level2['text'] }}
                                                        </a>
                                                        <ul id="{{ \Str::slug($level2['text']) }}DropdownsubMenuone"
                                                            class="dropdown-unfold dropdown-menu dropdown-sub-menu font-size-2 rounded-0 border-gray-900 u-unfold--css-animation u-unfold--hidden u-unfold--reverse-y"
                                                            aria-labelledby="{{ \Str::slug($level2['text']) }}DropdownsubmenuoneInvoker"
                                                            style="animation-duration: 200ms;">
                                                            @foreach ($level2['children'] as $level3)
                                                                @php
                                                                    $l3Href = getHref($level3);
                                                                @endphp
                                                                <li>
                                                                    <a href="{{ $l3Href }}"
                                                                        target="{{ $level3['target'] }}"
                                                                        class="dropdown-item link-black-100">{{ $level3['text'] }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <a href="{{ $l2Href }}" target="{{ $level2['target'] }}"
                                                        class="dropdown-item link-black-100">{{ $level2['text'] }}</a>
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
                        </ul>
                    </div>
                    <div class="d-none d-md-flex align-items-center mt-3 mt-md-0 ml-md-auto">

                        <a href="mailto:info@bookworm.com" class="mr-4 mb-4 mb-md-0">
                            <div class="d-flex align-items-center text-dark font-size-2 text-lh-sm">
                                <i class="flaticon-question font-size-5 mt-2 mr-1"></i>
                                <div class="ml-2">
                                    <span class="text-secondary-gray-1090 font-size-1">info@bookworm.com</span>
                                    <div class="h6 mb-0">Any questions</div>
                                </div>
                            </div>
                        </a>


                        <a href="tel:+1246-345-0695">
                            <div class="d-flex align-items-center text-dark font-size-2 text-lh-sm">
                                <i class="flaticon-phone font-size-5 mt-2 mr-1"></i>
                                <div class="ml-2">
                                    <span class="text-secondary-gray-1090 font-size-1">+1 246-345-0695</span>
                                    <div class="h6 mb-0">Call toll-free</div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="container">
                <div class="d-md-flex position-relative">
                    <div
                        class="offcanvas-toggler align-self-center mr-md-5 d-xl-none d-flex d-md-block align-items-center">
                        <a id="sidebarNavToggler2" href="javascript:;" role="button" class="cat-menu text-dark"
                            aria-controls="sidebarContent2" aria-haspopup="true" aria-expanded="false"
                            data-unfold-event="click" data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarContent2" data-unfold-type="css-animation" data-unfold-overlay='{
                                        "className": "u-sidebar-bg-overlay",
                                        "background": "rgba(0, 0, 0, .7)",
                                        "animationSpeed": 100
                                    }' data-unfold-animation-in="fadeInLeft" data-unfold-animation-out="fadeOutLeft"
                            data-unfold-duration="100">
                            <svg width="20px" height="18px">
                                <path fill-rule="evenodd" fill="rgb(0, 0, 0)"
                                    d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z" />
                                <path fill-rule="evenodd" fill="rgb(0, 0, 0)"
                                    d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z" />
                                <path fill-rule="evenodd" fill="rgb(0, 0, 0)"
                                    d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z" />
                            </svg>
                            <span class="ml-3">Browse categories</span>
                        </a>
                        <ul class="nav d-md-none ml-auto">
                            <li class="nav-item">

                                <a id="sidebarNavToggler9" href="javascript:;" role="button"
                                    class="px-2 nav-link h-primary" aria-controls="sidebarContent9" aria-haspopup="true"
                                    aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                                    data-unfold-target="#sidebarContent9" data-unfold-type="css-animation"
                                    data-unfold-overlay='{
                                                "className": "u-sidebar-bg-overlay",
                                                "background": "rgba(0, 0, 0, .7)",
                                                "animationSpeed": 500
                                            }' data-unfold-animation-in="fadeInRight"
                                    data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                                    <i class="glph-icon flaticon-user"></i>
                                </a>

                            </li>
                        </ul>
                    </div>

                    <div id="basicsAccordion" class="mr-5 d-none d-xl-block">

                        <div class="position-relative">
                            <div class="bg-dark py-3 px-5 card-collapse" id="basicsHeadingOne">
                                <button type="button"
                                    class="btn btn-link btn-block p-0 d-flex align-items-center card-btn"
                                    data-toggle="collapse" data-target="#basicsCollapseOne" aria-expanded="true"
                                    aria-controls="basicsCollapseOne">
                                    <svg width="20px" height="18px">
                                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                            d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                            d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z" />
                                        <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                                            d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z" />
                                    </svg>
                                    <span class="ml-3 text-white">Browse categories</span>
                                    <i class="fas fa-chevron-down ml-5 text-white font-size-2"></i>
                                </button>
                            </div>
                            <div id="basicsCollapseOne"
                                class="z-index-2 bg-white collapse show position-absolute right-0 left-0 border"
                                aria-labelledby="basicsHeadingOne" data-parent="#basicsAccordion">
                                <div class="card-body p-0">
                                    <ul class="list-unstyled vertical-menu position-relative mb-0">
                                        <li>
                                            <a id="basicDropdownHoverInvoker"
                                                class="text-dark dropdown-nav-link dropdown-toggle d-flex align-items-center border-bottom"
                                                href="javascript:;" role="button" aria-controls="basicDropdownHover"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#basicDropdownHover"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                                                <div class="width-30 mr-2 text-lh-sm">
                                                    <i class="flaticon-gallery font-size-5"></i>
                                                </div>
                                                <div class="mr-auto">Arts &amp; Photography</div>
                                            </a>
                                            <div id="basicDropdownHover"
                                                class="px-5 py-3 dropdown-menu dropdown-unfold top-0 right-auto left-100 bottom-0 mt-0 rounded-0"
                                                style="width: 700px;" aria-labelledby="basicDropdownHoverInvoker">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Categories</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Arts
                                                                    &amp; Photography</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Biographies
                                                                    &amp; Memoirs</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Business &amp;
                                                                    Money</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Calendars</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Children's
                                                                    Books</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Christian Books
                                                                    &amp; Bibles</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Cookbooks, Food
                                                                    &amp; Wine</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Romance</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Science
                                                                    &amp; Math</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Self-Help</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sports
                                                                    &amp; Outdoors</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Travel</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Top
                                                                    Authors</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">J. K.
                                                                    Rowling</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Roald
                                                                    Dahl</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Julia
                                                                    Donaldson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Stephen
                                                                    King</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">David
                                                                    Walliams</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Dr.
                                                                    Seuss</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Andy
                                                                    Griffiths</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">James
                                                                    Patterson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sarah
                                                                    J. Maas</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Enid
                                                                    Blyton</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">John
                                                                    Green</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Brandon
                                                                    Sanderson</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Popular
                                                                    Features</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">New
                                                                    Releases</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Best
                                                                    Books Ever</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Book
                                                                    Club Classics</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Our
                                                                    Bookmarks</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Bargain
                                                                    Shop</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Bestselling
                                                                    Series</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Harry
                                                                    Potter</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Game Of
                                                                    Thrones</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Lego</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Throne
                                                                    Of Glass</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Star
                                                                    Wars</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a id="basicDropdownHoverInvoker1"
                                                class="text-dark dropdown-nav-link dropdown-toggle d-flex align-items-center border-bottom"
                                                href="javascript:;" role="button" aria-controls="basicDropdownHover1"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#basicDropdownHover1"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                                                <div class="width-30 mr-2 text-lh-sm">
                                                    <i class="flaticon-resume font-size-5"></i>
                                                </div>
                                                <div class="mr-auto">Biography</div>
                                            </a>
                                            <div id="basicDropdownHover1"
                                                class="px-5 py-3 dropdown-menu dropdown-unfold top-0 right-auto left-100 bottom-0 mt-0 rounded-0"
                                                style="width: 700px;" aria-labelledby="basicDropdownHoverInvoker1">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Top
                                                                    Authors</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">J. K.
                                                                    Rowling</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Roald
                                                                    Dahl</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Julia
                                                                    Donaldson</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Stephen
                                                                    King</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">David
                                                                    Walliams</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Dr.
                                                                    Seuss</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Andy
                                                                    Griffiths</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">James
                                                                    Patterson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sarah
                                                                    J. Maas</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Enid
                                                                    Blyton</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">John
                                                                    Green</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Brandon
                                                                    Sanderson</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Popular
                                                                    Features</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">New
                                                                    Releases</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Best
                                                                    Books Ever</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Book
                                                                    Club Classics</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Our
                                                                    Bookmarks</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Bargain
                                                                    Shop</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Bestselling
                                                                    Series</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Harry
                                                                    Potter</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Game
                                                                    Of Thrones</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Lego</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Throne
                                                                    Of Glass</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Star
                                                                    Wars</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Categories</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Arts
                                                                    &amp; Photography</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Biographies
                                                                    &amp; Memoirs</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Business &amp;
                                                                    Money</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Calendars</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Children's
                                                                    Books</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Christian
                                                                    Books &amp; Bibles</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Cookbooks,
                                                                    Food &amp; Wine</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Romance</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Science &amp;
                                                                    Math</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Self-Help</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sports
                                                                    &amp; Outdoors</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Travel</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a id="basicDropdownHoverInvoker2"
                                                class="text-dark dropdown-nav-link dropdown-toggle d-flex align-items-center border-bottom"
                                                href="javascript:;" role="button" aria-controls="basicDropdownHover2"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#basicDropdownHover2"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                                                <div class="width-30 mr-2 text-lh-sm">
                                                    <i class="flaticon-cook font-size-5"></i>
                                                </div>
                                                <div class="mr-auto">Food & Drink</div>
                                            </a>
                                            <div id="basicDropdownHover2"
                                                class="px-5 py-3 dropdown-menu dropdown-unfold top-0 right-auto left-100 bottom-0 mt-0 rounded-0"
                                                style="width: 700px;" aria-labelledby="basicDropdownHoverInvoker2">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Categories</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Arts
                                                                    &amp; Photography</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Biographies
                                                                    &amp; Memoirs</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Business &amp;
                                                                    Money</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Calendars</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Children's
                                                                    Books</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Christian
                                                                    Books &amp; Bibles</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Cookbooks,
                                                                    Food &amp; Wine</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Romance</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Science &amp;
                                                                    Math</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Self-Help</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sports
                                                                    &amp; Outdoors</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Travel</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Top
                                                                    Authors</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">J. K.
                                                                    Rowling</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Roald
                                                                    Dahl</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Julia
                                                                    Donaldson</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Stephen
                                                                    King</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">David
                                                                    Walliams</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Dr.
                                                                    Seuss</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Andy
                                                                    Griffiths</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">James
                                                                    Patterson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sarah
                                                                    J. Maas</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Enid
                                                                    Blyton</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">John
                                                                    Green</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Brandon
                                                                    Sanderson</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Popular
                                                                    Features</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">New
                                                                    Releases</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Best
                                                                    Books Ever</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Book
                                                                    Club Classics</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Our
                                                                    Bookmarks</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Bargain
                                                                    Shop</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Bestselling
                                                                    Series</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Harry
                                                                    Potter</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Game
                                                                    Of Thrones</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Lego</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Throne
                                                                    Of Glass</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Star
                                                                    Wars</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a id="basicDropdownHoverInvoker3"
                                                class="text-dark dropdown-nav-link dropdown-toggle d-flex align-items-center border-bottom"
                                                href="javascript:;" role="button" aria-controls="basicDropdownHover3"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#basicDropdownHover3"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                                                <div class="width-30 mr-2 text-lh-sm">
                                                    <i class="flaticon-doctor font-size-5"></i>
                                                </div>
                                                <div class="mr-auto">Health</div>
                                            </a>
                                            <div id="basicDropdownHover3"
                                                class="px-5 py-3 dropdown-menu dropdown-unfold top-0 right-auto left-100 bottom-0 mt-0 rounded-0"
                                                style="width: 700px;" aria-labelledby="basicDropdownHoverInvoker3">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Top
                                                                    Authors</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">J. K.
                                                                    Rowling</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Roald
                                                                    Dahl</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Julia
                                                                    Donaldson</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Stephen
                                                                    King</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">David
                                                                    Walliams</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Dr.
                                                                    Seuss</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Andy
                                                                    Griffiths</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">James
                                                                    Patterson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sarah
                                                                    J. Maas</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Enid
                                                                    Blyton</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">John
                                                                    Green</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Brandon
                                                                    Sanderson</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Popular
                                                                    Features</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">New
                                                                    Releases</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Best
                                                                    Books Ever</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Book
                                                                    Club Classics</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Our
                                                                    Bookmarks</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Bargain
                                                                    Shop</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Bestselling
                                                                    Series</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Harry
                                                                    Potter</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Game
                                                                    Of Thrones</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Lego</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Throne
                                                                    Of Glass</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Star
                                                                    Wars</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Categories</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Arts
                                                                    &amp; Photography</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Biographies
                                                                    &amp; Memoirs</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Business &amp;
                                                                    Money</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Calendars</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Children's
                                                                    Books</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Christian
                                                                    Books &amp; Bibles</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Cookbooks,
                                                                    Food &amp; Wine</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Romance</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Science &amp;
                                                                    Math</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Self-Help</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sports
                                                                    &amp; Outdoors</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Travel</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a id="basicDropdownHoverInvoker4"
                                                class="text-dark dropdown-nav-link dropdown-toggle d-flex align-items-center border-bottom"
                                                href="javascript:;" role="button" aria-controls="basicDropdownHover4"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#basicDropdownHover4"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                                                <div class="width-30 mr-2 text-lh-sm">
                                                    <i class="flaticon-jogging font-size-5"></i>
                                                </div>
                                                <div class="mr-auto">Sports</div>
                                            </a>
                                            <div id="basicDropdownHover4"
                                                class="px-5 py-3 dropdown-menu dropdown-unfold top-0 right-auto left-100 bottom-0 mt-0 rounded-0"
                                                style="width: 700px;" aria-labelledby="basicDropdownHoverInvoker4">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Categories</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Arts
                                                                    &amp; Photography</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Biographies
                                                                    &amp; Memoirs</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Business &amp;
                                                                    Money</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Calendars</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Children's
                                                                    Books</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Christian
                                                                    Books &amp; Bibles</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Cookbooks,
                                                                    Food &amp; Wine</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Romance</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Science &amp;
                                                                    Math</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Self-Help</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sports
                                                                    &amp; Outdoors</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Travel</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Top
                                                                    Authors</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">J. K.
                                                                    Rowling</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Roald
                                                                    Dahl</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Julia
                                                                    Donaldson</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Stephen
                                                                    King</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">David
                                                                    Walliams</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Dr.
                                                                    Seuss</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Andy
                                                                    Griffiths</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">James
                                                                    Patterson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sarah
                                                                    J. Maas</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Enid
                                                                    Blyton</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">John
                                                                    Green</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Brandon
                                                                    Sanderson</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Popular
                                                                    Features</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">New
                                                                    Releases</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Best
                                                                    Books Ever</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Book
                                                                    Club Classics</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Our
                                                                    Bookmarks</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Bargain
                                                                    Shop</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Bestselling
                                                                    Series</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Harry
                                                                    Potter</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Game
                                                                    Of Thrones</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Lego</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Throne
                                                                    Of Glass</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Star
                                                                    Wars</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a id="basicDropdownHoverInvoker5"
                                                class="text-dark dropdown-nav-link dropdown-toggle d-flex align-items-center border-bottom"
                                                href="javascript:;" role="button" aria-controls="basicDropdownHover5"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#basicDropdownHover5"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                                                <div class="width-30 mr-2 text-lh-sm">
                                                    <i class="flaticon-like font-size-5"></i>
                                                </div>
                                                <div class="mr-auto">Romance</div>
                                            </a>
                                            <div id="basicDropdownHover5"
                                                class="px-5 py-3 dropdown-menu dropdown-unfold top-0 right-auto left-100 bottom-0 mt-0 rounded-0"
                                                style="width: 700px;" aria-labelledby="basicDropdownHoverInvoker5">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Top
                                                                    Authors</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">J. K.
                                                                    Rowling</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Roald
                                                                    Dahl</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Julia
                                                                    Donaldson</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Stephen
                                                                    King</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">David
                                                                    Walliams</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Dr.
                                                                    Seuss</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Andy
                                                                    Griffiths</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">James
                                                                    Patterson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sarah
                                                                    J. Maas</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Enid
                                                                    Blyton</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">John
                                                                    Green</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Brandon
                                                                    Sanderson</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Popular
                                                                    Features</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">New
                                                                    Releases</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Best
                                                                    Books Ever</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Book
                                                                    Club Classics</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Our
                                                                    Bookmarks</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Bargain
                                                                    Shop</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Bestselling
                                                                    Series</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Harry
                                                                    Potter</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Game
                                                                    Of Thrones</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Lego</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Throne
                                                                    Of Glass</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Star
                                                                    Wars</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Categories</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Arts
                                                                    &amp; Photography</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Biographies
                                                                    &amp; Memoirs</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Business &amp;
                                                                    Money</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Calendars</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Children's
                                                                    Books</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Christian
                                                                    Books &amp; Bibles</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Cookbooks,
                                                                    Food &amp; Wine</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Romance</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Science &amp;
                                                                    Math</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Self-Help</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sports
                                                                    &amp; Outdoors</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Travel</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a id="basicDropdownHoverInvoker6"
                                                class="text-dark dropdown-nav-link dropdown-toggle d-flex align-items-center border-bottom"
                                                href="javascript:;" role="button" aria-controls="basicDropdownHover6"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#basicDropdownHover6"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                                                <div class="width-30 mr-2 text-lh-sm">
                                                    <i class="flaticon-baby-boy font-size-5"></i>
                                                </div>
                                                <div class="mr-auto">Children</div>
                                            </a>
                                            <div id="basicDropdownHover6"
                                                class="px-5 py-3 dropdown-menu dropdown-unfold top-0 right-auto left-100 bottom-0 mt-0 rounded-0"
                                                style="width: 700px;" aria-labelledby="basicDropdownHoverInvoker6">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Categories</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Arts
                                                                    &amp; Photography</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Biographies
                                                                    &amp; Memoirs</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Business &amp;
                                                                    Money</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Calendars</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Children's
                                                                    Books</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Christian
                                                                    Books &amp; Bibles</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Cookbooks,
                                                                    Food &amp; Wine</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Romance</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Science &amp;
                                                                    Math</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Self-Help</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sports
                                                                    &amp; Outdoors</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Travel</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Top
                                                                    Authors</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">J. K.
                                                                    Rowling</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Roald
                                                                    Dahl</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Julia
                                                                    Donaldson</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Stephen
                                                                    King</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">David
                                                                    Walliams</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Dr.
                                                                    Seuss</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Andy
                                                                    Griffiths</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">James
                                                                    Patterson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sarah
                                                                    J. Maas</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Enid
                                                                    Blyton</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">John
                                                                    Green</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Brandon
                                                                    Sanderson</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Popular
                                                                    Features</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">New
                                                                    Releases</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Best
                                                                    Books Ever</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Book
                                                                    Club Classics</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Our
                                                                    Bookmarks</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Bargain
                                                                    Shop</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Bestselling
                                                                    Series</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Harry
                                                                    Potter</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Game
                                                                    Of Thrones</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Lego</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Throne
                                                                    Of Glass</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Star
                                                                    Wars</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a id="basicDropdownHoverInvoker7"
                                                class="text-dark dropdown-nav-link dropdown-toggle d-flex align-items-center border-bottom"
                                                href="javascript:;" role="button" aria-controls="basicDropdownHover7"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#basicDropdownHover7"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                                                <div class="width-30 mr-2 text-lh-sm">
                                                    <i class="flaticon-history font-size-5"></i>
                                                </div>
                                                <div class="mr-auto">History</div>
                                            </a>
                                            <div id="basicDropdownHover7"
                                                class="px-5 py-3 dropdown-menu dropdown-unfold top-0 right-auto left-100 bottom-0 mt-0 rounded-0"
                                                style="width: 700px;" aria-labelledby="basicDropdownHoverInvoker7">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Top
                                                                    Authors</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">J. K.
                                                                    Rowling</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Roald
                                                                    Dahl</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Julia
                                                                    Donaldson</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Stephen
                                                                    King</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">David
                                                                    Walliams</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Dr.
                                                                    Seuss</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Andy
                                                                    Griffiths</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">James
                                                                    Patterson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sarah
                                                                    J. Maas</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Enid
                                                                    Blyton</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">John
                                                                    Green</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Brandon
                                                                    Sanderson</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Popular
                                                                    Features</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">New
                                                                    Releases</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Best
                                                                    Books Ever</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Book
                                                                    Club Classics</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Our
                                                                    Bookmarks</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Bargain
                                                                    Shop</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Bestselling
                                                                    Series</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Harry
                                                                    Potter</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Game
                                                                    Of Thrones</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Lego</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Throne
                                                                    Of Glass</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Star
                                                                    Wars</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Categories</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Arts
                                                                    &amp; Photography</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Biographies
                                                                    &amp; Memoirs</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Business &amp;
                                                                    Money</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Calendars</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Children's
                                                                    Books</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Christian
                                                                    Books &amp; Bibles</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Cookbooks,
                                                                    Food &amp; Wine</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Romance</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Science &amp;
                                                                    Math</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Self-Help</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sports
                                                                    &amp; Outdoors</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Travel</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a id="basicDropdownHoverInvoker8"
                                                class="text-dark dropdown-nav-link dropdown-toggle d-flex align-items-center"
                                                href="javascript:;" role="button" aria-controls="basicDropdownHover8"
                                                aria-haspopup="true" aria-expanded="false" data-unfold-event="hover"
                                                data-unfold-target="#basicDropdownHover8"
                                                data-unfold-type="css-animation" data-unfold-duration="200"
                                                data-unfold-delay="50" data-unfold-hide-on-scroll="true"
                                                data-unfold-animation-in="fadeIn" data-unfold-animation-out="fadeOut">
                                                <div class="width-30 mr-2 text-lh-sm">
                                                    <i class="flaticon-airplane font-size-5"></i>
                                                </div>
                                                <div class="mr-auto">Travel & Holiday Guides</div>
                                            </a>
                                            <div id="basicDropdownHover8"
                                                class="px-5 py-3 dropdown-menu dropdown-unfold top-0 right-auto left-100 bottom-0 mt-0 rounded-0"
                                                style="width: 700px;" aria-labelledby="basicDropdownHoverInvoker8">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Categories</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Arts
                                                                    &amp; Photography</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Biographies
                                                                    &amp; Memoirs</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Business &amp;
                                                                    Money</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Calendars</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Children's
                                                                    Books</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Christian
                                                                    Books &amp; Bibles</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Cookbooks,
                                                                    Food &amp; Wine</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Romance</a>
                                                            </li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Science &amp;
                                                                    Math</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Self-Help</a>
                                                            </li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sports
                                                                    &amp; Outdoors</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Travel</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Top
                                                                    Authors</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">J. K.
                                                                    Rowling</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Roald
                                                                    Dahl</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Julia
                                                                    Donaldson</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Stephen
                                                                    King</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">David
                                                                    Walliams</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Dr.
                                                                    Seuss</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Andy
                                                                    Griffiths</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">James
                                                                    Patterson</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Sarah
                                                                    J. Maas</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Enid
                                                                    Blyton</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">John
                                                                    Green</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Brandon
                                                                    Sanderson</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4">
                                                        <ul class="menu list-unstyled">
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Popular
                                                                    Features</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">New
                                                                    Releases</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Best
                                                                    Books Ever</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Book
                                                                    Club Classics</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Our
                                                                    Bookmarks</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Bargain
                                                                    Shop</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-3 font-size-3 font-weight-medium">Bestselling
                                                                    Series</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Harry
                                                                    Potter</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Game
                                                                    Of Thrones</a></li>
                                                            <li><a href="#"
                                                                    class=" d-block link-black-100 py-1">Lego</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Throne
                                                                    Of Glass</a></li>
                                                            <li><a href="#" class=" d-block link-black-100 py-1">Star
                                                                    Wars</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="site-search ml-xl-0 ml-md-auto w-r-100 flex-grow-1 mr-md-5 mt-2 mt-md-0 py-2 py-md-0">
                        <form class="form-inline my-2 my-xl-0">
                            <div class="input-group w-100">
                                <div class="input-group-prepend d-none d-xl-block z-index-2">
                                    <select
                                        class="d-none d-lg-block custom-select pr-7 pl-4 rounded-0 height-5 shadow-none text-dark"
                                        id="inputGroupSelect01">
                                        <option selected>All Categories</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <input type="text" class="form-control border-right-0 px-3"
                                    placeholder="Search for books by keyword"
                                    aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append border-left">
                                    <button class="btn btn-dark px-3 rounded-0 py-2" type="submit"><i
                                            class="mx-1 glph-icon flaticon-loupe "></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <ul class="d-none d-md-flex nav align-self-center">
                        <li class="nav-item"><a href="#" class="nav-link text-dark"><i
                                    class="glph-icon flaticon-heart font-size-4"></i></a></li>
                        <li class="nav-item">

                            <a id="sidebarNavToggler" href="javascript:;" role="button" class="nav-link text-dark"
                                aria-controls="sidebarContent" aria-haspopup="true" aria-expanded="false"
                                data-unfold-event="click" data-unfold-hide-on-scroll="false"
                                data-unfold-target="#sidebarContent" data-unfold-type="css-animation"
                                data-unfold-overlay='{
                                            "className": "u-sidebar-bg-overlay",
                                            "background": "rgba(0, 0, 0, .7)",
                                            "animationSpeed": 500
                                        }' data-unfold-animation-in="fadeInRight"
                                data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                                <i class="glph-icon flaticon-user font-size-4"></i>
                            </a>

                        </li>
                        <li class="nav-item">

                            <a id="sidebarNavToggler1" href="javascript:;" role="button"
                                class="nav-link pr-0 text-dark position-relative" aria-controls="sidebarContent1"
                                aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                                data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent1"
                                data-unfold-type="css-animation" data-unfold-overlay='{
                                            "className": "u-sidebar-bg-overlay",
                                            "background": "rgba(0, 0, 0, .7)",
                                            "animationSpeed": 500
                                        }' data-unfold-animation-in="fadeInRight"
                                data-unfold-animation-out="fadeOutRight" data-unfold-duration="500">
                                <span
                                    class="position-absolute bg-dark width-16 height-16 rounded-circle d-flex align-items-center justify-content-center text-white font-size-n9 left-0">3</span>
                                <i class="glph-icon flaticon-icon-126515 font-size-4"></i>
                                <span class="d-none d-xl-inline h6 mb-0 ml-1">$40.93</span>
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<aside id="sidebarContent9" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler9">
    <div class="u-sidebar__scroller">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">

                <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                    <button type="button" class="close ml-auto" aria-controls="sidebarContent9" aria-haspopup="true"
                        aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                        data-unfold-target="#sidebarContent9" data-unfold-type="css-animation"
                        data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                        data-unfold-duration="500">
                        <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                    </button>
                </div>


                <div class="js-scrollbar u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">
                        <form class="">

                            <div id="login1" data-target-group="idForm1">

                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                            class="flaticon-user mr-3 font-size-5"></i>Account</h2>
                                </header>

                                <div class="p-4 p-md-6">

                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinEmailLabel9" class="form-label"
                                                for="signinEmail9">Username or email *</label>
                                            <input type="email" class="form-control rounded-0 height-4 px-4"
                                                name="email" id="signinEmail9" placeholder="creativelayers088@gmail.com"
                                                aria-label="creativelayers088@gmail.com"
                                                aria-describedby="signinEmailLabel9" required>
                                        </div>
                                    </div>


                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinPasswordLabel9" class="form-label"
                                                for="signinPassword9">Password *</label>
                                            <input type="password" class="form-control rounded-0 height-4 px-4"
                                                name="password" id="signinPassword9" placeholder="" aria-label=""
                                                aria-describedby="signinPasswordLabel9" required>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mb-5 align-items-center">

                                        <div class="js-form-message">
                                            <div
                                                class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                <input type="checkbox" class="custom-control-input" id="termsCheckbox1"
                                                    name="termsCheckbox1" required>
                                                <label class="custom-control-label" for="termsCheckbox1">
                                                    <span class="font-size-2 text-secondary-gray-700">
                                                        Remember me
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        <a class="js-animation-link text-dark font-size-2 t-d-u link-muted font-weight-medium"
                                            href="javascript:;" data-target="#forgotPassword1" data-link-group="idForm1"
                                            data-animation-in="fadeIn">Forgot Password?</a>
                                    </div>
                                    <div class="mb-4d75">
                                        <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Sign
                                            In</button>
                                    </div>
                                    <div class="mb-2">
                                        <a href="javascript:;"
                                            class="js-animation-link btn btn-block py-3 rounded-0 btn-outline-dark font-weight-medium"
                                            data-target="#signup1" data-link-group="idForm1"
                                            data-animation-in="fadeIn">Create Account</a>
                                    </div>
                                </div>
                            </div>

                            <div id="signup1" style="display: none; opacity: 0;" data-target-group="idForm1">

                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                            class="flaticon-resume mr-3 font-size-5"></i>Create Account</h2>
                                </header>

                                <div class="p-4 p-md-6">

                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinEmailLabel11" class="form-label"
                                                for="signinEmail11">Email *</label>
                                            <input type="email" class="form-control rounded-0 height-4 px-4"
                                                name="email" id="signinEmail11"
                                                placeholder="creativelayers088@gmail.com"
                                                aria-label="creativelayers088@gmail.com"
                                                aria-describedby="signinEmailLabel11" required>
                                        </div>
                                    </div>


                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinPasswordLabel11" class="form-label"
                                                for="signinPassword11">Password *</label>
                                            <input type="password" class="form-control rounded-0 height-4 px-4"
                                                name="password" id="signinPassword11" placeholder="" aria-label=""
                                                aria-describedby="signinPasswordLabel11" required>
                                        </div>
                                    </div>


                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signupConfirmPasswordLabel9" class="form-label"
                                                for="signupConfirmPassword9">Confirm Password *</label>
                                            <input type="password" class="form-control rounded-0 height-4 px-4"
                                                name="confirmPassword" id="signupConfirmPassword9" placeholder=""
                                                aria-label="" aria-describedby="signupConfirmPasswordLabel9" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Create
                                            Account</button>
                                    </div>
                                    <div class="text-center mb-4">
                                        <span class="small text-muted">Already have an account?</span>
                                        <a class="js-animation-link small" href="javascript:;" data-target="#login1"
                                            data-link-group="idForm1" data-animation-in="fadeIn">Login
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div id="forgotPassword1" style="display: none; opacity: 0;" data-target-group="idForm1">

                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                            class="flaticon-question mr-3 font-size-5"></i>Forgot Password?</h2>
                                </header>

                                <div class="p-4 p-md-6">

                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinEmailLabel33" class="form-label"
                                                for="signinEmail33">Email *</label>
                                            <input type="email" class="form-control rounded-0 height-4 px-4"
                                                name="email" id="signinEmail33"
                                                placeholder="creativelayers088@gmail.com"
                                                aria-label="creativelayers088@gmail.com"
                                                aria-describedby="signinEmailLabel33" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Recover
                                            Password</button>
                                    </div>
                                    <div class="text-center mb-4">
                                        <span class="small text-muted">Remember your password?</span>
                                        <a class="js-animation-link small" href="javascript:;" data-target="#login1"
                                            data-link-group="idForm1" data-animation-in="fadeIn">Login
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</aside>


<aside id="sidebarContent" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler">
    <div class="u-sidebar__scroller">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">

                <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                    <button type="button" class="close ml-auto" aria-controls="sidebarContent" aria-haspopup="true"
                        aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                        data-unfold-target="#sidebarContent" data-unfold-type="css-animation"
                        data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                        data-unfold-duration="500">
                        <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                    </button>
                </div>


                <div class="js-scrollbar u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">
                        <form class="">

                            <div id="login" data-target-group="idForm">

                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                            class="flaticon-user mr-3 font-size-5"></i>Account</h2>
                                </header>

                                <div class="p-4 p-md-6">

                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinEmailLabel" class="form-label"
                                                for="signinEmail">Username or email *</label>
                                            <input type="email" class="form-control rounded-0 height-4 px-4"
                                                name="email" id="signinEmail" placeholder="creativelayers088@gmail.com"
                                                aria-label="creativelayers088@gmail.com"
                                                aria-describedby="signinEmailLabel" required>
                                        </div>
                                    </div>


                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinPasswordLabel" class="form-label"
                                                for="signinPassword">Password *</label>
                                            <input type="password" class="form-control rounded-0 height-4 px-4"
                                                name="password" id="signinPassword" placeholder="" aria-label=""
                                                aria-describedby="signinPasswordLabel" required>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mb-5 align-items-center">

                                        <div class="js-form-message">
                                            <div
                                                class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                <input type="checkbox" class="custom-control-input" id="termsCheckbox"
                                                    name="termsCheckbox" required>
                                                <label class="custom-control-label" for="termsCheckbox">
                                                    <span class="font-size-2 text-secondary-gray-700">
                                                        Remember me
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        <a class="js-animation-link text-dark font-size-2 t-d-u link-muted font-weight-medium"
                                            href="javascript:;" data-target="#forgotPassword" data-link-group="idForm"
                                            data-animation-in="fadeIn">Forgot Password?</a>
                                    </div>
                                    <div class="mb-4d75">
                                        <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Sign
                                            In</button>
                                    </div>
                                    <div class="mb-2">
                                        <a href="javascript:;"
                                            class="js-animation-link btn btn-block py-3 rounded-0 btn-outline-dark font-weight-medium"
                                            data-target="#signup" data-link-group="idForm"
                                            data-animation-in="fadeIn">Create Account</a>
                                    </div>
                                </div>
                            </div>

                            <div id="signup" style="display: none; opacity: 0;" data-target-group="idForm">

                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                            class="flaticon-resume mr-3 font-size-5"></i>Create Account</h2>
                                </header>

                                <div class="p-4 p-md-6">

                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinEmailLabel1" class="form-label"
                                                for="signinEmail1">Email *</label>
                                            <input type="email" class="form-control rounded-0 height-4 px-4"
                                                name="email" id="signinEmail1" placeholder="creativelayers088@gmail.com"
                                                aria-label="creativelayers088@gmail.com"
                                                aria-describedby="signinEmailLabel1" required>
                                        </div>
                                    </div>


                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinPasswordLabel1" class="form-label"
                                                for="signinPassword1">Password *</label>
                                            <input type="password" class="form-control rounded-0 height-4 px-4"
                                                name="password" id="signinPassword1" placeholder="" aria-label=""
                                                aria-describedby="signinPasswordLabel1" required>
                                        </div>
                                    </div>


                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signupConfirmPasswordLabel" class="form-label"
                                                for="signupConfirmPassword">Confirm Password *</label>
                                            <input type="password" class="form-control rounded-0 height-4 px-4"
                                                name="confirmPassword" id="signupConfirmPassword" placeholder=""
                                                aria-label="" aria-describedby="signupConfirmPasswordLabel" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Create
                                            Account</button>
                                    </div>
                                    <div class="text-center mb-4">
                                        <span class="small text-muted">Already have an account?</span>
                                        <a class="js-animation-link small" href="javascript:;" data-target="#login"
                                            data-link-group="idForm" data-animation-in="fadeIn">Login
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div id="forgotPassword" style="display: none; opacity: 0;" data-target-group="idForm">

                                <header class="border-bottom px-4 px-md-6 py-4">
                                    <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                            class="flaticon-question mr-3 font-size-5"></i>Forgot Password?</h2>
                                </header>

                                <div class="p-4 p-md-6">

                                    <div class="form-group mb-4">
                                        <div class="js-form-message js-focus-state">
                                            <label id="signinEmailLabel3" class="form-label"
                                                for="signinEmail3">Email *</label>
                                            <input type="email" class="form-control rounded-0 height-4 px-4"
                                                name="email" id="signinEmail3" placeholder="creativelayers088@gmail.com"
                                                aria-label="creativelayers088@gmail.com"
                                                aria-describedby="signinEmailLabel3" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Recover
                                            Password</button>
                                    </div>
                                    <div class="text-center mb-4">
                                        <span class="small text-muted">Remember your password?</span>
                                        <a class="js-animation-link small" href="javascript:;" data-target="#login"
                                            data-link-group="idForm" data-animation-in="fadeIn">Login
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</aside>


<aside id="sidebarContent1" class="u-sidebar u-sidebar__xl" aria-labelledby="sidebarNavToggler1">
    <div class="u-sidebar__scroller js-scrollbar">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">

                <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                    <button type="button" class="close ml-auto" aria-controls="sidebarContent1" aria-haspopup="true"
                        aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                        data-unfold-target="#sidebarContent1" data-unfold-type="css-animation"
                        data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                        data-unfold-duration="500">
                        <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                    </button>
                </div>


                <div class="u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">

                        <header class="border-bottom px-4 px-md-6 py-4">
                            <h2 class="font-size-3 mb-0 d-flex align-items-center"><i
                                    class="flaticon-icon-126515 mr-3 font-size-5"></i>Your shopping bag (3)</h2>
                        </header>

                        <div class="px-4 py-5 px-md-6 border-bottom">
                            <div class="media">
                                <a href="#" class="d-block"><img src="../../assets/img/120x180/img6.jpg"
                                        class="img-fluid" alt="image-description"></a>
                                <div class="media-body ml-4d875">
                                    <div class="text-primary text-uppercase font-size-1 mb-1 text-truncate"><a
                                            href="#">Hard Cover</a></div>
                                    <h2
                                        class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                        <a href="#" class="text-dark">The Ride of a Lifetime: Lessons Learned from
                                            15 Years as CEO</a>
                                    </h2>
                                    <div class="font-size-2 mb-1 text-truncate"><a href="#"
                                            class="text-gray-700">Robert Iger</a></div>
                                    <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                        <span class="woocommerce-Price-amount amount">1 x <span
                                                class="woocommerce-Price-currencySymbol">$</span>125.30</span>
                                    </div>
                                </div>
                                <div class="mt-3 ml-3">
                                    <a href="#" class="text-dark"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 px-md-6 border-bottom">
                            <div class="media">
                                <a href="#" class="d-block"><img src="../../assets/img/120x180/img6.jpg"
                                        class="img-fluid" alt="image-description"></a>
                                <div class="media-body ml-4d875">
                                    <div class="text-primary text-uppercase font-size-1 mb-1 text-truncate"><a
                                            href="#">Hard Cover</a></div>
                                    <h2
                                        class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                        <a href="#" class="text-dark">The Rural Diaries: Love, Livestock, and Big
                                            Life Lessons Down</a>
                                    </h2>
                                    <div class="font-size-2 mb-1 text-truncate"><a href="#"
                                            class="text-gray-700">Hillary Burton</a></div>
                                    <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                        <span class="woocommerce-Price-amount amount">2 x <span
                                                class="woocommerce-Price-currencySymbol">$</span>200</span>
                                    </div>
                                </div>
                                <div class="mt-3 ml-3">
                                    <a href="#" class="text-dark"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 px-md-6 border-bottom">
                            <div class="media">
                                <a href="#" class="d-block"><img src="../../assets/img/120x180/img6.jpg"
                                        class="img-fluid" alt="image-description"></a>
                                <div class="media-body ml-4d875">
                                    <div class="text-primary text-uppercase font-size-1 mb-1 text-truncate"><a
                                            href="#">Paperback</a></div>
                                    <h2
                                        class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                        <a href="#" class="text-dark">Russians Among Us: Sleeper Cells, Ghost
                                            Stories, and the Hunt.</a>
                                    </h2>
                                    <div class="font-size-2 mb-1 text-truncate"><a href="#"
                                            class="text-gray-700">Gordon Corera</a></div>
                                    <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                        <span class="woocommerce-Price-amount amount">6 x <span
                                                class="woocommerce-Price-currencySymbol">$</span>100</span>
                                    </div>
                                </div>
                                <div class="mt-3 ml-3">
                                    <a href="#" class="text-dark"><i class="fas fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 px-md-6 d-flex justify-content-between align-items-center font-size-3">
                            <h4 class="mb-0 font-size-3">Subtotal:</h4>
                            <div class="font-weight-medium">$750.00</div>
                        </div>
                        <div class="px-4 mb-8 px-md-6">
                            <a href="../shop/cart.html" class="btn btn-block py-4 rounded-0 btn-outline-dark mb-4">View
                                Cart</a>
                            <a href="../shop/checkout.html" class="btn btn-block py-4 rounded-0 btn-dark">Checkout</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</aside>


<aside id="sidebarContent2" class="u-sidebar u-sidebar__md u-sidebar--left" aria-labelledby="sidebarNavToggler2">
    <div class="u-sidebar__scroller js-scrollbar">
        <div class="u-sidebar__container">
            <div class="u-header-sidebar__footer-offset">

                <div class="u-sidebar__body">
                    <div class="u-sidebar__content u-header-sidebar__content">

                        <header
                            class="border-bottom px-4 px-md-5 py-4 d-flex align-items-center justify-content-between">
                            <h2 class="font-size-3 mb-0">SHOP BY CATEGORY</h2>

                            <div class="d-flex align-items-center">
                                <button type="button" class="close ml-auto" aria-controls="sidebarContent2"
                                    aria-haspopup="true" aria-expanded="false" data-unfold-event="click"
                                    data-unfold-hide-on-scroll="false" data-unfold-target="#sidebarContent2"
                                    data-unfold-type="css-animation" data-unfold-animation-in="fadeInLeft"
                                    data-unfold-animation-out="fadeOutLeft" data-unfold-duration="500">
                                    <span aria-hidden="true"><i class="fas fa-times ml-2"></i></span>
                                </button>
                            </div>

                        </header>

                        <div class="border-bottom">
                            <div class="zeynep pt-4">
                                <ul>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="off-pages">Pages</a>
                                        <div id="off-pages" class="submenu">
                                            <div class="submenu-header" data-submenu-close="off-pages">
                                                <a href="#">Pages</a>
                                            </div>
                                            <ul>
                                                <li class="has-submenu">
                                                    <a href="#" data-submenu="off-home">Home Pages</a>
                                                    <div id="off-home" class="submenu js-scrollbar">
                                                        <div class="submenu-header" data-submenu-close="off-home">
                                                            <a href="#">Home Pages</a>
                                                        </div>
                                                        <ul class="">
                                                            <li>
                                                                <a href="../home/index.html">Home v1</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v2.html">Home v2</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v3.html">Home v2</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v3.html">Home v3</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v4.html">Home v4</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v5.html">Home v5</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v6.html">Home v6</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v7.html">Home v7</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v8.html">Home v8</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v9.html">Home v9</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v10.html">Home v10</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v11.html">Home v11</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v12.html">Home v12</a>
                                                            </li>
                                                            <li>
                                                                <a href="../home/home-v13.html">Home v13</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="has-submenu">
                                                    <a href="#" data-submenu="off-single-product">Single Product</a>
                                                    <div id="off-single-product" class="submenu js-scrollbar">
                                                        <div class="submenu-header"
                                                            data-submenu-close="off-single-product">
                                                            <a href="#">Single Product</a>
                                                        </div>
                                                        <ul class="">
                                                            <li>
                                                                <a href="../shop/single-product-v1.html">Single Product
                                                                    v1</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/single-product-v2.html">Single Product
                                                                    v2</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/single-product-v3.html">Single Product
                                                                    v3</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/single-product-v4.html">Single Product
                                                                    v4</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/single-product-v5.html">Single Product
                                                                    v5</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/single-product-v6.html">Single Product
                                                                    v6</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/single-product-v7.html">Single Product
                                                                    v7</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="has-submenu">
                                                    <a href="#" data-submenu="off-shop-pages">Shop Pages</a>
                                                    <div id="off-shop-pages" class="submenu js-scrollbar">
                                                        <div class="submenu-header"
                                                            data-submenu-close="off-shop-pages">
                                                            <a href="#">Shop Pages</a>
                                                        </div>
                                                        <ul class="">
                                                            <li>
                                                                <a href="../shop/cart.html">Shop cart</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/checkout.html">Shop checkout</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/my-account.html">Shop My Account</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/order-received.html">Shop Order
                                                                    Received</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/order-tracking.html">Shop Order
                                                                    Tracking</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/store-location.html">Shop Store
                                                                    Location</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="has-submenu">
                                                    <a href="#" data-submenu="off-shop-list">Shop List</a>
                                                    <div id="off-shop-list" class="submenu js-scrollbar">
                                                        <div class="submenu-header" data-submenu-close="off-shop-list">
                                                            <a href="#">Shop List</a>
                                                        </div>
                                                        <ul class="">
                                                            <li>
                                                                <a href="../shop/v1.html">Shop List v1</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/v2.html">Shop List v2</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/v3.html">Shop List v3</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/v4.html">Shop List v4</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/v5.html">Shop List v5</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/v6.html">Shop List v6</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/v7.html">Shop List v7</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/v8.html">Shop List v8</a>
                                                            </li>
                                                            <li>
                                                                <a href="../shop/v9.html">Shop List v9</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="has-submenu">
                                                    <a href="#" data-submenu="off-blog">Blog</a>
                                                    <div id="off-blog" class="submenu js-scrollbar">
                                                        <div class="submenu-header" data-submenu-close="off-blog">
                                                            <a href="#">Blog</a>
                                                        </div>
                                                        <ul class="">
                                                            <li>
                                                                <a href="../blog/blog-v1.html">Blog v1</a>
                                                            </li>
                                                            <li>
                                                                <a href="../blog/blog-v2.html">Blog v2</a>
                                                            </li>
                                                            <li>
                                                                <a href="../blog/blog-v3.html">Blog v3</a>
                                                            </li>
                                                            <li>
                                                                <a href="../blog/blog-single.html">Blog Single</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="has-submenu">
                                                    <a href="#" data-submenu="off-others">Others</a>
                                                    <div id="off-others" class="submenu js-scrollbar">
                                                        <div class="submenu-header" data-submenu-close="off-others">
                                                            <a href="#">Others</a>
                                                        </div>
                                                        <ul class="">
                                                            <li>
                                                                <a href="../others/404.html">404</a>
                                                            </li>
                                                            <li>
                                                                <a href="../others/about.html">About Us</a>
                                                            </li>
                                                            <li>
                                                                <a href="../others/authors-list.html">Authors List</a>
                                                            </li>
                                                            <li>
                                                                <a href="../others/authors-single.html">Authors
                                                                    Single</a>
                                                            </li>
                                                            <li>
                                                                <a href="../others/coming-soon.html">Coming Soon</a>
                                                            </li>
                                                            <li>
                                                                <a href="../others/contact.html">Contact Us</a>
                                                            </li>
                                                            <li>
                                                                <a href="../others/faq.html">FAQ</a>
                                                            </li>
                                                            <li>
                                                                <a href="../others/pricing-table.html">Pricing Table</a>
                                                            </li>
                                                            <li>
                                                                <a href="../others/terms-conditions.html">Terms
                                                                    Conditions</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="px-5">
                                                    <a href="../../documentation/index.html"
                                                        class="btn btn-primary mb-3 mb-md-0 mb-xl-3 mt-4 font-size-2 btn-block">Documentation</a>
                                                </li>
                                                <li class="px-5 mb-4">
                                                    <a href="../../starter/index.html"
                                                        class="btn btn-secondary font-size-2 btn-block mb-2">Starter</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="art-photo">Arts & Photography</a>
                                        <div id="art-photo" class="submenu">
                                            <div class="submenu-header" data-submenu-close="art-photo">
                                                <a href="#">Arts & Photography</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Architecture</a>
                                                </li>
                                                <li>
                                                    <a href="#">Business of Art</a>
                                                </li>
                                                <li>
                                                    <a href="#">Collections, Catalogs & Exhibitions</a>
                                                </li>
                                                <li>
                                                    <a href="#">Decorative Arts & Design</a>
                                                </li>
                                                <li>
                                                    <a href="#">Drawing</a>
                                                </li>
                                                <li>
                                                    <a href="#">Fashion</a>
                                                </li>
                                                <li>
                                                    <a href="#">Graphic Design</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="biography">Biographies & Memoirs</a>
                                        <div id="biography" class="submenu">
                                            <div class="submenu-header" data-submenu-close="biography">
                                                <a href="#">Biographies & Memoirs</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Istanbul</a>
                                                </li>
                                                <li>
                                                    <a href="#">Mardin</a>
                                                </li>
                                                <li>
                                                    <a href="#">Amed</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="children">Children's Books</a>
                                        <div id="children" class="submenu">
                                            <div class="submenu-header" data-submenu-close="children">
                                                <a href="#">Children's Books</a>
                                            </div>
                                            <ul>
                                                <li class="has-submenu">
                                                    <a href="#" data-submenu="electronics">Electronics</a>
                                                    <div id="electronics" class="submenu js-scrollbar">
                                                        <div class="submenu-header" data-submenu-close="electronics">
                                                            <a href="#">Electronics</a>
                                                        </div>
                                                        <ul class="">
                                                            <li>
                                                                <a href="#">Camera & Photo</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Home Audio</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Tv & Video</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Computers & Accessories</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Car & Vehicle Electronics</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Portable Audio & Video</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Headphones</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Accessories & Supplies</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Video Projectors</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Office Electronics</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Wearable Technology</a>
                                                            </li>
                                                            <li>
                                                                <a href="#">Service Plans</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li>
                                                    <a href="#">Books</a>
                                                </li>
                                                <li>
                                                    <a href="#">Video Games</a>
                                                </li>
                                                <li>
                                                    <a href="#">Computers</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="computers">Computers & Technology</a>
                                        <div id="computers" class="submenu">
                                            <div class="submenu-header" data-submenu-close="computers">
                                                <a href="#">Computers & Technology</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Istanbul</a>
                                                </li>
                                                <li>
                                                    <a href="#">Mardin</a>
                                                </li>
                                                <li>
                                                    <a href="#">Amed</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="cookbook">Cookbooks, Food & Wine</a>
                                        <div id="cookbook" class="submenu">
                                            <div class="submenu-header" data-submenu-close="cookbook">
                                                <a href="#">Cookbooks, Food & Wine</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Istanbul</a>
                                                </li>
                                                <li>
                                                    <a href="#">Mardin</a>
                                                </li>
                                                <li>
                                                    <a href="#">Amed</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="education">Education & Teaching</a>
                                        <div id="education" class="submenu">
                                            <div class="submenu-header" data-submenu-close="education">
                                                <a href="#">Education & Teaching</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Istanbul</a>
                                                </li>
                                                <li>
                                                    <a href="#">Mardin</a>
                                                </li>
                                                <li>
                                                    <a href="#">Amed</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="health">Health, Fitness & Dieting</a>
                                        <div id="health" class="submenu">
                                            <div class="submenu-header" data-submenu-close="health">
                                                <a href="#">Health, Fitness & Dieting</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Istanbul</a>
                                                </li>
                                                <li>
                                                    <a href="#">Mardin</a>
                                                </li>
                                                <li>
                                                    <a href="#">Amed</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="history">History</a>
                                        <div id="history" class="submenu">
                                            <div class="submenu-header" data-submenu-close="history">
                                                <a href="#">History</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Istanbul</a>
                                                </li>
                                                <li>
                                                    <a href="#">Mardin</a>
                                                </li>
                                                <li>
                                                    <a href="#">Amed</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="romance">Romance</a>
                                        <div id="romance" class="submenu">
                                            <div class="submenu-header" data-submenu-close="romance">
                                                <a href="#">Romance</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Istanbul</a>
                                                </li>
                                                <li>
                                                    <a href="#">Mardin</a>
                                                </li>
                                                <li>
                                                    <a href="#">Amed</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="sports">Sports & Outdoors</a>
                                        <div id="sports" class="submenu">
                                            <div class="submenu-header" data-submenu-close="sports">
                                                <a href="#">Sports & Outdoors</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Istanbul</a>
                                                </li>
                                                <li>
                                                    <a href="#">Mardin</a>
                                                </li>
                                                <li>
                                                    <a href="#">Amed</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="has-submenu">
                                        <a href="#" data-submenu="travel">Travel</a>
                                        <div id="travel" class="submenu">
                                            <div class="submenu-header" data-submenu-close="travel">
                                                <a href="#">Travel</a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <a href="#">Istanbul</a>
                                                </li>
                                                <li>
                                                    <a href="#">Mardin</a>
                                                </li>
                                                <li>
                                                    <a href="#">Amed</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="px-4 px-md-5 pt-5 pb-4 border-bottom">
                            <h2 class="font-size-3 mb-3">HELP & SETTINGS </h2>
                            <ul class="list-group list-group-flush list-group-borderless">
                                <li class="list-group-item px-0 py-2 border-0"><a href="#" class="h-primary">Your
                                        Account</a></li>
                                <li class="list-group-item px-0 py-2 border-0"><a href="#"
                                        class="h-primary">Help</a></li>
                                <li class="list-group-item px-0 py-2 border-0"><a href="#" class="h-primary">Sign
                                        In</a></li>
                            </ul>
                        </div>
                        <div class="px-4 px-md-5 py-5">
                            <select class="custom-select mb-4 rounded-0 pl-4 height-4 shadow-none text-dark">
                                <option selected>English (United States)</option>
                                <option value="1">English (UK)</option>
                                <option value="2">Arabic (Saudi Arabia)</option>
                                <option value="3">Deutsch</option>
                            </select>
                            <select class="custom-select mb-4 rounded-0 pl-4 height-4 shadow-none text-dark">
                                <option selected>$ USD</option>
                                <option value="1">د.إ AED</option>
                                <option value="2">¥ CNY</option>
                                <option value="3">€ EUR</option>
                            </select>

                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a class="h-primary pr-2 font-size-2" href="#">
                                        <span class="fab fa-facebook-f btn-icon__inner"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h-primary pr-2 font-size-2" href="#">
                                        <span class="fab fa-google btn-icon__inner"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h-primary pr-2 font-size-2" href="#">
                                        <span class="fab fa-twitter btn-icon__inner"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="h-primary pr-2 font-size-2" href="#">
                                        <span class="fab fa-github btn-icon__inner"></span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</aside>



<section class="space-bottom-2 space-bottom-xl-3">
    <div class="container">
        <div class="row">
            <div class="offset-xl-3 offset-wd-2 col-lg-8 col-xl-9 col-wd-7">
                <div class="bg-img-hero img-fluid bg-gradient-dark-1 mb-6 mb-xl-0 ml-xl-2d75 ml-wd-11"
                    style="background-image: url(../../assets/img/900x506/img1.jpg);">
                    <div class="space-top-2 space-top-xl-4 px-4 px-md-5 px-lg-7 pb-3">
                        <ul class="js-slick-carousel u-slick pl-0 mb-0"
                            data-pagi-classes="text-center u-slick__pagination u-slick__pagination--v2 mt-6 mb-3">
                            <li class="hero-slider">
                                <div class="d-block d-md-flex media">
                                    <div class="hero__body media-body align-self-center mb-4 mb-xl-0">
                                        <p class="hero__pretitle text-uppercase text-gray-400 font-weight-bold">ONLY
                                            THIS WEEK</p>
                                        <h2 class="hero__title font-size-15 d-flex mb-4">
                                            <span
                                                class="hero__title--1 font-weight-normal d-block text-white">Big</span>
                                            <span class="hero__title--2 font-weight-bold d-block text-white ml-3">
                                                Sales</span>
                                        </h2>
                                        <a href="../shop/v4.html"
                                            class="btn height-50 hero__btn bg-white text-dark rounded-0 btn-wide">Shop
                                            Now</a>
                                    </div>
                                    <img src="../../assets/img/250x293/img1.png" class="mr-xl-10 mr-wd-6 img-fluid"
                                        alt="image-description">
                                </div>
                            </li>
                            <li class="hero-slider">
                                <div class="d-block d-md-flex media">
                                    <div class="hero__body media-body align-self-center mb-4 mb-xl-0">
                                        <p class="hero__pretitle text-uppercase text-gray-400 font-weight-bold">ONLY
                                            THIS WEEK</p>
                                        <h2 class="hero__title font-size-15 d-flex mb-4">
                                            <span
                                                class="hero__title--1 font-weight-normal d-block text-white">Big</span>
                                            <span class="hero__title--2 font-weight-bold d-block text-white ml-3">
                                                Sales</span>
                                        </h2>
                                        <a href="../shop/v4.html"
                                            class="btn height-50 hero__btn bg-white text-dark rounded-0 btn-wide">Shop
                                            Now</a>
                                    </div>
                                    <img src="../../assets/img/250x293/img1.png" class="mr-xl-10 mr-wd-6 img-fluid"
                                        alt="image-description">
                                </div>
                            </li>
                            <li class="hero-slider">
                                <div class="d-block d-md-flex media">
                                    <div class="hero__body media-body align-self-center mb-4 mb-xl-0">
                                        <p class="hero__pretitle text-uppercase text-gray-400 font-weight-bold">ONLY
                                            THIS WEEK</p>
                                        <h2 class="hero__title font-size-15 d-flex m-4">
                                            <span
                                                class="hero__title--1 font-weight-normal d-block text-white">Big</span>
                                            <span class="hero__title--2 font-weight-bold d-block text-white ml-3">
                                                Sales</span>
                                        </h2>
                                        <a href="../shop/v4.html"
                                            class="btn height-50 hero__btn bg-white text-dark rounded-0 btn-wide">Shop
                                            Now</a>
                                    </div>
                                    <img src="../../assets/img/250x293/img1.png" class="mr-xl-10 mr-wd-6 img-fluid"
                                        alt="image-description">
                                </div>
                            </li>
                            <li class="hero-slider">
                                <div class="d-block d-md-flex media">
                                    <div class="hero__body media-body align-self-center mb-4 mb-xl-0">
                                        <p class="hero__pretitle text-uppercase text-gray-400 font-weight-bold">ONLY
                                            THIS WEEK</p>
                                        <h2 class="hero__title font-size-15 d-flex mb-4">
                                            <span
                                                class="hero__title--1 font-weight-normal d-block text-white">Big</span>
                                            <span class="hero__title--2 font-weight-bold d-block text-white ml-3">
                                                Sales</span>
                                        </h2>
                                        <a href="../shop/v4.html"
                                            class="btn height-50 hero__btn bg-white text-dark rounded-0 btn-wide">Shop
                                            Now</a>
                                    </div>
                                    <img src="../../assets/img/250x293/img1.png" class="mr-xl-10 mr-wd-6 img-fluid"
                                        alt="image-description">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-wd-3 col-lg-4 d-xl-none d-wd-block">
                <div class="border border-dark border-width-2 h-100">
                    <ul class="js-slick-carousel u-slick mb-0 p-0 h-100"
                        data-arrows-classes="d-none d-lg-block u-slick__arrow u-slick__arrow--v3 border-0 u-slick__arrow-centered--y mt-lg-n12 text-dark"
                        data-arrow-left-classes="flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-3"
                        data-arrow-right-classes="flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-3">
                        <li class="media p-5">
                            <img src="../../assets/img/190x222/img1.jpg" class="img-fluid mx-auto mb-5"
                                alt="image-description">
                            <div class="media-body">
                                <div class="text-uppercase font-size-1 mb-1 text-truncate"><a
                                        href="../shop/single-product-v4.html">Kindle Edition</a></div>
                                <h2
                                    class="woocommerce-loop-product__title product__title font-size-3 font-weight-normal text-lh-md mb-1 crop-text-2">
                                    <a href="../shop/single-product-v4.html">Beneath a Scarlet Sky: A Novel</a>
                                </h2>
                                <div class="font-size-2  mb-1 text-truncate">
                                    <a href="../others/authors-single.html" class="text-gray-700">Donna Kauffman </a>
                                </div>
                                <div class="price d-flex align-items-center font-weight-medium font-size-3 mb-4 mb-4">
                                    <ins class="text-decoration-none mr-2"><span
                                            class="woocommerce-Price-amount amount font-size-22 font-weight-medium text-dark"><span
                                                class="woocommerce-Price-currencySymbol">$</span>37</span></ins>
                                    <del class="font-size-1 font-weight-regular text-gray-700"><span
                                            class="woocommerce-Price-amount amount font-size-1 text-primary-home-v3 opacity-md"><span
                                                class="woocommerce-Price-currencySymbol">$</span>78,96</span></del>
                                </div>
                                <div class="deal-progress">
                                    <div class="d-flex justify-content-between font-size-2 mb-2d75">
                                        <span>Already Sold: 14</span>
                                        <span>Available: 3</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:82%"
                                            aria-valuenow="14" aria-valuemin="0" aria-valuemax="17"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media p-5">
                            <img src="../../assets/img/190x222/img1.jpg" class="img-fluid mx-auto mb-5"
                                alt="image-description">
                            <div class="media-body">
                                <div class="text-uppercase font-size-1 mb-1 text-truncate"><a
                                        href="../shop/single-product-v4.html">Kindle Edition</a></div>
                                <h2
                                    class="woocommerce-loop-product__title product__title font-size-3 font-weight-normal text-lh-md mb-1 crop-text-2">
                                    <a href="../shop/single-product-v4.html">Beneath a Scarlet Sky: A Novel</a>
                                </h2>
                                <div class="font-size-2  mb-1 text-truncate">
                                    <a href="../others/authors-single.html" class="text-gray-700">Donna Kauffman </a>
                                </div>
                                <div class="price d-flex align-items-center font-weight-medium font-size-3 mb-4 mb-4">
                                    <ins class="text-decoration-none mr-2"><span
                                            class="woocommerce-Price-amount amount font-size-22 font-weight-medium text-dark"><span
                                                class="woocommerce-Price-currencySymbol">$</span>37</span></ins>
                                    <del class="font-size-1 font-weight-regular text-gray-700"><span
                                            class="woocommerce-Price-amount amount font-size-1 text-primary-home-v3 opacity-md"><span
                                                class="woocommerce-Price-currencySymbol">$</span>78,96</span></del>
                                </div>
                                <div class="deal-progress">
                                    <div class="d-flex justify-content-between font-size-2 mb-2d75">
                                        <span>Already Sold: 14</span>
                                        <span>Available: 3</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:82%"
                                            aria-valuenow="14" aria-valuemin="0" aria-valuemax="17"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media p-5">
                            <img src="../../assets/img/190x222/img1.jpg" class="img-fluid mx-auto mb-5"
                                alt="image-description">
                            <div class="media-body">
                                <div class="text-uppercase font-size-1 mb-1 text-truncate"><a
                                        href="../shop/single-product-v4.html">Kindle Edition</a></div>
                                <h2
                                    class="woocommerce-loop-product__title product__title font-size-3 font-weight-normal text-lh-md mb-1 crop-text-2">
                                    <a href="../shop/single-product-v4.html">Beneath a Scarlet Sky: A Novel</a>
                                </h2>
                                <div class="font-size-2  mb-1 text-truncate">
                                    <a href="../others/authors-single.html" class="text-gray-700">Donna Kauffman </a>
                                </div>
                                <div class="price d-flex align-items-center font-weight-medium font-size-3 mb-4 mb-4">
                                    <ins class="text-decoration-none mr-2"><span
                                            class="woocommerce-Price-amount amount font-size-22 font-weight-medium text-dark"><span
                                                class="woocommerce-Price-currencySymbol">$</span>37</span></ins>
                                    <del class="font-size-1 font-weight-regular text-gray-700"><span
                                            class="woocommerce-Price-amount amount font-size-1 text-primary-home-v3 opacity-md"><span
                                                class="woocommerce-Price-currencySymbol">$</span>78,96</span></del>
                                </div>
                                <div class="deal-progress">
                                    <div class="d-flex justify-content-between font-size-2 mb-2d75">
                                        <span>Already Sold: 14</span>
                                        <span>Available: 3</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:82%"
                                            aria-valuenow="14" aria-valuemin="0" aria-valuemax="17"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media p-5">
                            <img src="../../assets/img/190x222/img1.jpg" class="img-fluid mx-auto mb-5"
                                alt="image-description">
                            <div class="media-body">
                                <div class="text-uppercase font-size-1 mb-1 text-truncate"><a
                                        href="../shop/single-product-v4.html">Kindle Edition</a></div>
                                <h2
                                    class="woocommerce-loop-product__title product__title font-size-3 font-weight-normal text-lh-md mb-1 crop-text-2">
                                    <a href="../shop/single-product-v4.html">Beneath a Scarlet Sky: A Novel</a>
                                </h2>
                                <div class="font-size-2  mb-1 text-truncate">
                                    <a href="../others/authors-single.html" class="text-gray-700">Donna Kauffman </a>
                                </div>
                                <div class="price d-flex align-items-center font-weight-medium font-size-3 mb-4 mb-4">
                                    <ins class="text-decoration-none mr-2"><span
                                            class="woocommerce-Price-amount amount font-size-22 font-weight-medium text-dark"><span
                                                class="woocommerce-Price-currencySymbol">$</span>37</span></ins>
                                    <del class="font-size-1 font-weight-regular text-gray-700"><span
                                            class="woocommerce-Price-amount amount font-size-1 text-primary-home-v3 opacity-md"><span
                                                class="woocommerce-Price-currencySymbol">$</span>78,96</span></del>
                                </div>
                                <div class="deal-progress">
                                    <div class="d-flex justify-content-between font-size-2 mb-2d75">
                                        <span>Already Sold: 14</span>
                                        <span>Available: 3</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:82%"
                                            aria-valuenow="14" aria-valuemin="0" aria-valuemax="17"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="space-bottom-3 banner-with-product-carousel">
    <div class="container">
