<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title> User Dashboard </title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    {{-- <link rel="shortcut icon" href="{{ asset('assets/front/img/' . $bs->logo) }}"> --}}
    <link rel="shortcut icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}" type="image/x-icon">


    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/font-awesome/css/fontawesome-all.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/flaticon/font/flaticon.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/animate.css/animate.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/slick-carousel/slick/slick.css') }} "/>
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }} ">

    {{-- New Style --}}
    <link rel="stylesheet" href="{{asset('assets/user/css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/common-style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">


    <link rel="stylesheet" href="{{ asset('assets/bookworm/css/theme.css') }}">
    <style>
        .toast-container {
            background-color: green !important;
        }

        .toast-success {
            background-color: green !important;
        }

        .hc-nav-trigger {
            width: 160px !important;
        }

    </style>

   @include('front.bookworm.partials.custom_style')

    <link
      rel="stylesheet"
      href="{{asset('assets/user/css/datatables.min.css')}}"
    >
    <link
      rel="stylesheet"
      href="{{asset('assets/user/css/dataTables.bootstrap4.css')}}"
    >

    {{-- New Style --}}

    <!-- CSS Bookworm Template -->
    <link rel="stylesheet" href="{{ asset('assets/assets/css/theme.css') }}">
</head>
<body>
    <!--===== HEADER CONTENT =====-->
     {{-- <header id="site-header" class="site-header__v2 site-header__white-text">
        <div class="masthead">
            <div class="bg-secondary-gray-800">
                <div class="container pt-3 pt-md-4 pb-3 pb-md-5">
                    <div class="d-flex align-items-center position-relative flex-wrap">
                        <div class="offcanvas-toggler mr-4">
                            <a id="sidebarNavToggler2" href="javascript:;" role="button" class="cat-menu"
                            aria-controls="sidebarContent2"
                            aria-haspopup="true"
                            aria-expanded="false"
                            data-unfold-event="click"
                            data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarContent2"
                            data-unfold-type="css-animation"
                            data-unfold-overlay='{
                                "className": "u-sidebar-bg-overlay",
                                "background": "rgba(0, 0, 0, .7)",
                                "animationSpeed": 100
                            }'
                            data-unfold-animation-in="fadeInLeft"
                            data-unfold-animation-out="fadeOutLeft"
                            data-unfold-duration="100">
                                <svg width="20px" height="18px">
                                    <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                                    <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                                    <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                                </svg>
                            </a>
                        </div>
                        <div class="site-branding pr-7">
                                <a href="{{ route('front.index') }}" class="d-block mb-1">
                                    <img src="{{ asset('assets/front/img/' . $bs->logo) }}" style="height:50px" class="img-fluid lazy" alt="">
                                </a>
                        </div>
                        <div class="site-search ml-xl-0 ml-md-auto w-r-100 flex-grow-1 mr-md-5 mt-2 mt-md-0 order-1 order-md-0">
                            <form class="form-inline my-2 my-xl-0">
                                <div class="input-group input-group-borderless w-100">
                                    <div class="input-group-prepend mr-0 d-none d-xl-block">
                                        <select class="custom-select pr-7 pl-4 rounded-right-0 height-5 shadow-none border-0 text-dark" id="inputGroupSelect01">
                                            <option selected>All Categories</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                    <input type="text" class="form-control border-left rounded-left-1 rounded-left-xl-0 px-3" placeholder="Search for books by keyword" aria-label="Amount (to the nearest dollar)">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary-green px-3 py-2" type="submit"><i class="mx-1 glph-icon flaticon-loupe text-white"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex align-items-center">
                            <a id="sidebarNavToggler" href="javascript:;" role="button"
                                aria-controls="sidebarContent"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-unfold-event="click"
                                data-unfold-hide-on-scroll="false"
                                data-unfold-target="#sidebarContent"
                                data-unfold-type="css-animation"
                                data-unfold-overlay='{
                                    "className": "u-sidebar-bg-overlay",
                                    "background": "rgba(0, 0, 0, .7)",
                                    "animationSpeed": 500
                                }'
                                data-unfold-animation-in="fadeInRight"
                                data-unfold-animation-out="fadeOutRight"
                                data-unfold-duration="500">
                                <div class="d-flex align-items-center text-white font-size-2 text-lh-sm">
                                    <div class="ml-2 d-none d-lg-block">

                                        @auth
                                    
                                        <div class="language dashboard">
                                        <a class="language-btn" href="#">
                                            <i class="far fa-user"></i> {{Auth::user()->username}}
                                        </a>
                                        <ul class="language-dropdown">
                                            <li>
                                                <a href="{{route('user-dashboard')}}">{{__('Dashboard')}}</a>
                                            </li>

                                            @if ($bex->recurring_billing == 1)
                                                <li><a href="{{route('user-packages')}}">{{__('Packages')}}</a></li>
                                            @endif

                                            @if ($bex->is_shop == 1 && $bex->catalog_mode == 0)
                                                <li><a href="{{route('user-orders')}}">{{__('Product Orders')}} </a></li>
                                            @endif

                                            @if ($bex->recurring_billing == 0)
                                                <li><a href="{{route('user-package-orders')}}">{{__('Package Orders')}} </a></li>
                                            @endif

                                            @if ($bex->is_course == 1)
                                            <li>
                                                <a href="{{route('user.course_orders')}}" >{{__('Courses')}}</a>
                                            </li>
                                            @endif

                                            @if ($bex->is_event == 1)
                                            <li>
                                                <a href="{{route('user-events')}}">{{__('Event Bookings')}}</a>
                                            </li>
                                            @endif


                                            @if ($bex->is_donation == 1)
                                            <li>
                                                <a href="{{route('user-donations')}}" >{{__('Donations')}}</a>
                                            </li>
                                            @endif

                                            @if ($bex->is_ticket == 1)
                                            <li>
                                                <a href="{{route('user-tickets')}}">{{__('Support Tickets')}}</a>
                                            </li>
                                            @endif

                                            <li>
                                                <a href="{{route('user-profile')}}">{{__('Edit Profile')}}</a>
                                            </li>

                                            @if ($bex->is_shop == 1 && $bex->catalog_mode == 0)
                                                <li>
                                                    <a href="{{route('shpping-details')}}">{{__('Shipping Details')}}</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('billing-details')}}">{{__('Billing Details')}}</a>
                                                </li>
                                                <li>
                                                    <a href="{{route('user-reset')}}">{{__('Change Password')}}</a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{route('user-logout')}}" target="_self">{{__('Logout')}}</a>
                                            </li>
                                        </ul>
                                        </div>
                                    @endauth
                                    </div>
                                </div>
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-secondary-black-200 d-none d-md-block">
                <div class="container">
                    <div class="d-flex align-items-center justify-content-center position-relative">
                        <div class="site-navigation mr-auto d-none d-xl-block">
                            <ul class="nav">
                                <li class="nav-item dropdown">
                                    <a id="homeDropdownInvoker" href="{{ route('front.index') }}" class="nav-link link-black-100 mx-3 px-0 py-3 font-size-2 font-weight-medium d-flex align-items-center"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        data-unfold-event="hover"
                                        data-unfold-target="#homeDropdownMenu"
                                        data-unfold-type="css-animation"
                                        data-unfold-duration="200"
                                        data-unfold-delay="50"
                                        data-unfold-hide-on-scroll="true"
                                        data-unfold-animation-in="slideInUp"
                                        data-unfold-animation-out="fadeOut">
                                        Home
                                    </a>
                                    
                                </li>
                                <li class="nav-item"><a href="{{ route('front.product-categories') }}" class="nav-link link-black-100 mx-3 px-0 py-3 font-size-2 font-weight-medium">Categories</a></li>
                                
                            </ul>
                        </div>

                        <div class="secondary-navigation">
                            <ul class="nav">
                                <li class="nav-item"><a href="#" class="nav-link link-black-100 mx-2 px-0 py-3 font-size-2 font-weight-medium">Today's Deals</a></li>
                                <li class="nav-item"><a href="#" class="nav-link link-black-100 mx-2 px-0 py-3 font-size-2 font-weight-medium">Best Seller</a></li>
                                <li class="nav-item"><a href="#" class="nav-link link-black-100 mx-2 px-0 py-3 font-size-2 font-weight-medium">Trending Books</a></li>
                                <li class="nav-item"><a href="#" class="nav-link link-black-100 mx-2 px-0 py-3 font-size-2 font-weight-medium">Gift Cards</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header> --}}

    @include('user.dashboard.navbar')
   {{--  <div class="u-sidebar-bg-overlay" style="background-color: rgba(0, 0, 0, 0.7); display: none;"></div>
    @if (!request()->routeIs('front.index') && !request()->routeIs('front.packageorder.confirmation'))
        <div class="page-header border-bottom">
            <div class="container">
                <div class="d-md-flex justify-content-between align-items-center py-4">
                    @yield('breadcrumb-links')
                    </nav>
                </div>
            </div>
        </div>
    @endif --}}



    <!-- Account Sidebar Navigation - Mobile -->
    <aside id="sidebarContent9" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler9">
        <div class="u-sidebar__scroller">
            <div class="u-sidebar__container">
                <div class="u-header-sidebar__footer-offset">
                    <!-- Toggle Button -->
                    <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                        <button type="button" class="close ml-auto"
                            aria-controls="sidebarContent9"
                            aria-haspopup="true"
                            aria-expanded="false"
                            data-unfold-event="click"
                            data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarContent9"
                            data-unfold-type="css-animation"
                            data-unfold-animation-in="fadeInRight"
                            data-unfold-animation-out="fadeOutRight"
                            data-unfold-duration="500">
                            <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                        </button>
                    </div>
                    <!-- End Toggle Button -->

                    <!-- Content -->
                    <div class="js-scrollbar u-sidebar__body">
                        <div class="u-sidebar__content u-header-sidebar__content">
                            <form class="">
                                <!-- Login -->
                                <div id="login1" data-target-group="idForm1">
                                    <!-- Title -->
                                    <header class="border-bottom px-4 px-md-6 py-4">
                                        <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-user mr-3 font-size-5"></i>Account</h2>
                                    </header>
                                    <!-- End Title -->

                                    <div class="p-4 p-md-6">
                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinEmailLabel9" class="form-label" for="signinEmail9">Username or email *</label>
                                                <input type="email" class="form-control rounded-0 height-4 px-4" name="email" id="signinEmail9" placeholder="creativelayers088@gmail.com" aria-label="creativelayers088@gmail.com" aria-describedby="signinEmailLabel9" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinPasswordLabel9" class="form-label" for="signinPassword9">Password *</label>
                                                <input type="password" class="form-control rounded-0 height-4 px-4" name="password" id="signinPassword9" placeholder="" aria-label="" aria-describedby="signinPasswordLabel9" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <div class="d-flex justify-content-between mb-5 align-items-center">
                                            <!-- Checkbox -->
                                            <div class="js-form-message">
                                                <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                    <input type="checkbox" class="custom-control-input" id="termsCheckbox1" name="termsCheckbox1" required>
                                                    <label class="custom-control-label" for="termsCheckbox1">
                                                        <span class="font-size-2 text-secondary-gray-700">
                                                            Remember me
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- End Checkbox -->

                                            <a class="js-animation-link text-dark font-size-2 t-d-u link-muted font-weight-medium" href="javascript:;"
                                            data-target="#forgotPassword1"
                                            data-link-group="idForm1"
                                            data-animation-in="fadeIn">Forgot Password?</a>
                                        </div>

                                        <div class="mb-4d75">
                                            <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Sign In</button>
                                        </div>

                                        <div class="mb-2">
                                            <a href="javascript:;" class="js-animation-link btn btn-block py-3 rounded-0 btn-outline-dark font-weight-medium"
                                            data-target="#signup1"
                                            data-link-group="idForm1"
                                            data-animation-in="fadeIn">Create Account</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Signup -->
                                <div id="signup1" style="display: none; opacity: 0;" data-target-group="idForm1">
                                    <!-- Title -->
                                    <header class="border-bottom px-4 px-md-6 py-4">
                                        <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-resume mr-3 font-size-5"></i>Create Account</h2>
                                    </header>
                                    <!-- End Title -->

                                    <div class="p-4 p-md-6">
                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinEmailLabel11" class="form-label" for="signinEmail11">Email *</label>
                                                <input type="email" class="form-control rounded-0 height-4 px-4" name="email" id="signinEmail11" placeholder="creativelayers088@gmail.com" aria-label="creativelayers088@gmail.com" aria-describedby="signinEmailLabel11" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinPasswordLabel11" class="form-label" for="signinPassword11">Password *</label>
                                                <input type="password" class="form-control rounded-0 height-4 px-4" name="password" id="signinPassword11" placeholder="" aria-label="" aria-describedby="signinPasswordLabel11" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signupConfirmPasswordLabel9" class="form-label" for="signupConfirmPassword9">Confirm Password *</label>
                                                <input type="password" class="form-control rounded-0 height-4 px-4" name="confirmPassword" id="signupConfirmPassword9" placeholder="" aria-label="" aria-describedby="signupConfirmPasswordLabel9" required>
                                            </div>
                                        </div>
                                        <!-- End Input -->

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Create Account</button>
                                        </div>

                                        <div class="text-center mb-4">
                                            <span class="small text-muted">Already have an account?</span>
                                            <a class="js-animation-link small" href="javascript:;"
                                                data-target="#login1"
                                                data-link-group="idForm1"
                                                data-animation-in="fadeIn">Login
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Signup -->

                                <!-- Forgot Password -->
                                <div id="forgotPassword1" style="display: none; opacity: 0;" data-target-group="idForm1">
                                    <!-- Title -->
                                    <header class="border-bottom px-4 px-md-6 py-4">
                                        <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-question mr-3 font-size-5"></i>Forgot Password?</h2>
                                    </header>
                                    <!-- End Title -->

                                    <div class="p-4 p-md-6">
                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinEmailLabel33" class="form-label" for="signinEmail33">Email *</label>
                                                <input type="email" class="form-control rounded-0 height-4 px-4" name="email" id="signinEmail33" placeholder="creativelayers088@gmail.com" aria-label="creativelayers088@gmail.com" aria-describedby="signinEmailLabel33" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Recover Password</button>
                                        </div>

                                        <div class="text-center mb-4">
                                            <span class="small text-muted">Remember your password?</span>
                                            <a class="js-animation-link small" href="javascript:;"
                                                data-target="#login1"
                                                data-link-group="idForm1"
                                                data-animation-in="fadeIn">Login
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Forgot Password -->
                            </form>
                        </div>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
    </aside>
    <!-- End Account Sidebar Navigation - Mobile -->

    <!-- Account Sidebar Navigation - Desktop -->
    <aside id="sidebarContent" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler">
        <div class="u-sidebar__scroller">
            <div class="u-sidebar__container">
                <div class="u-header-sidebar__footer-offset">
                    <!-- Toggle Button -->
                    <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                        <button type="button" class="close ml-auto"
                            aria-controls="sidebarContent"
                            aria-haspopup="true"
                            aria-expanded="false"
                            data-unfold-event="click"
                            data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarContent"
                            data-unfold-type="css-animation"
                            data-unfold-animation-in="fadeInRight"
                            data-unfold-animation-out="fadeOutRight"
                            data-unfold-duration="500">
                            <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                        </button>
                    </div>
                    <!-- End Toggle Button -->

                    <!-- Content -->
                    <div class="js-scrollbar u-sidebar__body">
                        <div class="u-sidebar__content u-header-sidebar__content">
                            <form class="">
                                <!-- Login -->
                                <div id="login" data-target-group="idForm">
                                    <!-- Title -->
                                    <header class="border-bottom px-4 px-md-6 py-4">
                                        <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-user mr-3 font-size-5"></i>Account</h2>
                                    </header>
                                    <!-- End Title -->

                                    <div class="p-4 p-md-6">
                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinEmailLabel" class="form-label" for="signinEmail">Username or email *</label>
                                                <input type="email" class="form-control rounded-0 height-4 px-4" name="email" id="signinEmail" placeholder="creativelayers088@gmail.com" aria-label="creativelayers088@gmail.com" aria-describedby="signinEmailLabel" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinPasswordLabel" class="form-label" for="signinPassword">Password *</label>
                                                <input type="password" class="form-control rounded-0 height-4 px-4" name="password" id="signinPassword" placeholder="" aria-label="" aria-describedby="signinPasswordLabel" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <div class="d-flex justify-content-between mb-5 align-items-center">
                                            <!-- Checkbox -->
                                            <div class="js-form-message">
                                                <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                                                    <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox" required>
                                                    <label class="custom-control-label" for="termsCheckbox">
                                                        <span class="font-size-2 text-secondary-gray-700">
                                                            Remember me
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- End Checkbox -->

                                            <a class="js-animation-link text-dark font-size-2 t-d-u link-muted font-weight-medium" href="javascript:;"
                                            data-target="#forgotPassword"
                                            data-link-group="idForm"
                                            data-animation-in="fadeIn">Forgot Password?</a>
                                        </div>

                                        <div class="mb-4d75">
                                            <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Sign In</button>
                                        </div>

                                        <div class="mb-2">
                                            <a href="javascript:;" class="js-animation-link btn btn-block py-3 rounded-0 btn-outline-dark font-weight-medium"
                                            data-target="#signup"
                                            data-link-group="idForm"
                                            data-animation-in="fadeIn">Create Account</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Signup -->
                                <div id="signup" style="display: none; opacity: 0;" data-target-group="idForm">
                                    <!-- Title -->
                                    <header class="border-bottom px-4 px-md-6 py-4">
                                        <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-resume mr-3 font-size-5"></i>Create Account</h2>
                                    </header>
                                    <!-- End Title -->

                                    <div class="p-4 p-md-6">
                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinEmailLabel1" class="form-label" for="signinEmail1">Email *</label>
                                                <input type="email" class="form-control rounded-0 height-4 px-4" name="email" id="signinEmail1" placeholder="creativelayers088@gmail.com" aria-label="creativelayers088@gmail.com" aria-describedby="signinEmailLabel1" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinPasswordLabel1" class="form-label" for="signinPassword1">Password *</label>
                                                <input type="password" class="form-control rounded-0 height-4 px-4" name="password" id="signinPassword1" placeholder="" aria-label="" aria-describedby="signinPasswordLabel1" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signupConfirmPasswordLabel" class="form-label" for="signupConfirmPassword">Confirm Password *</label>
                                                <input type="password" class="form-control rounded-0 height-4 px-4" name="confirmPassword" id="signupConfirmPassword" placeholder="" aria-label="" aria-describedby="signupConfirmPasswordLabel" required>
                                            </div>
                                        </div>
                                        <!-- End Input -->

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Create Account</button>
                                        </div>

                                        <div class="text-center mb-4">
                                            <span class="small text-muted">Already have an account?</span>
                                            <a class="js-animation-link small" href="javascript:;"
                                                data-target="#login"
                                                data-link-group="idForm"
                                                data-animation-in="fadeIn">Login
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Signup -->

                                <!-- Forgot Password -->
                                <div id="forgotPassword" style="display: none; opacity: 0;" data-target-group="idForm">
                                    <!-- Title -->
                                    <header class="border-bottom px-4 px-md-6 py-4">
                                        <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-question mr-3 font-size-5"></i>Forgot Password?</h2>
                                    </header>
                                    <!-- End Title -->

                                    <div class="p-4 p-md-6">
                                        <!-- Form Group -->
                                        <div class="form-group mb-4">
                                            <div class="js-form-message js-focus-state">
                                                <label id="signinEmailLabel3" class="form-label" for="signinEmail3">Email *</label>
                                                <input type="email" class="form-control rounded-0 height-4 px-4" name="email" id="signinEmail3" placeholder="creativelayers088@gmail.com" aria-label="creativelayers088@gmail.com" aria-describedby="signinEmailLabel3" required>
                                            </div>
                                        </div>
                                        <!-- End Form Group -->

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark">Recover Password</button>
                                        </div>

                                        <div class="text-center mb-4">
                                            <span class="small text-muted">Remember your password?</span>
                                            <a class="js-animation-link small" href="javascript:;"
                                                data-target="#login"
                                                data-link-group="idForm"
                                                data-animation-in="fadeIn">Login
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Forgot Password -->
                            </form>
                        </div>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
    </aside>
    <!-- End Account Sidebar Navigation - Desktop -->

    <!-- Cart Sidebar Navigation -->
    <aside id="sidebarContent1" class="u-sidebar u-sidebar__xl" aria-labelledby="sidebarNavToggler1">
        <div class="u-sidebar__scroller js-scrollbar">
            <div class="u-sidebar__container">
                <div class="u-header-sidebar__footer-offset">
                    <!-- Toggle Button -->
                    <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                        <button type="button" class="close ml-auto"
                            aria-controls="sidebarContent1"
                            aria-haspopup="true"
                            aria-expanded="false"
                            data-unfold-event="click"
                            data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarContent1"
                            data-unfold-type="css-animation"
                            data-unfold-animation-in="fadeInRight"
                            data-unfold-animation-out="fadeOutRight"
                            data-unfold-duration="500">
                            <span aria-hidden="true">Close <i class="fas fa-times ml-2"></i></span>
                        </button>
                    </div>
                    <!-- End Toggle Button -->

                    <!-- Content -->
                    <div class="u-sidebar__body">
                        <div class="u-sidebar__content u-header-sidebar__content">
                            <!-- Title -->
                            <header class="border-bottom px-4 px-md-6 py-4">
                                <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-icon-126515 mr-3 font-size-5"></i>Your shopping bag (3)</h2>
                            </header>
                            <!-- End Title -->

                            <div class="px-4 py-5 px-md-6 border-bottom">
                                <div class="media">
                                    <a href="#" class="d-block"><img src="https://placehold.it/100x153" class="img-fluid" alt="image-description"></a>
                                    <div class="media-body ml-4d875">
                                        <div class="text-primary text-uppercase font-size-1 mb-1 text-truncate"><a href="#">Hard Cover</a></div>
                                        <h2 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                            <a href="#" class="text-dark">The Ride of a Lifetime: Lessons Learned  from 15 Years as CEO</a>
                                        </h2>
                                        <div class="font-size-2 mb-1 text-truncate"><a href="#" class="text-gray-700">Robert Iger</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount">1 x <span class="woocommerce-Price-currencySymbol">$</span>125.30</span>
                                        </div>
                                    </div>
                                    <div class="mt-3 ml-3">
                                        <a href="#" class="text-dark"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-5 px-md-6 border-bottom">
                                <div class="media">
                                    <a href="#" class="d-block"><img src="https://placehold.it/100x153" class="img-fluid" alt="image-description"></a>
                                    <div class="media-body ml-4d875">
                                        <div class="text-primary text-uppercase font-size-1 mb-1 text-truncate"><a href="#">Hard Cover</a></div>
                                        <h2 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                            <a href="#" class="text-dark">The Rural Diaries: Love, Livestock, and  Big Life Lessons Down</a>
                                        </h2>
                                        <div class="font-size-2 mb-1 text-truncate"><a href="#" class="text-gray-700">Hillary Burton</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount">2 x <span class="woocommerce-Price-currencySymbol">$</span>200</span>
                                        </div>
                                    </div>
                                    <div class="mt-3 ml-3">
                                        <a href="#" class="text-dark"><i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-5 px-md-6 border-bottom">
                                <div class="media">
                                    <a href="#" class="d-block"><img src="https://placehold.it/100x153" class="img-fluid" alt="image-description"></a>
                                    <div class="media-body ml-4d875">
                                        <div class="text-primary text-uppercase font-size-1 mb-1 text-truncate"><a href="#">Paperback</a></div>
                                        <h2 class="woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2">
                                            <a href="#" class="text-dark">Russians Among Us: Sleeper Cells,  Ghost Stories, and the Hunt.</a>
                                        </h2>
                                        <div class="font-size-2 mb-1 text-truncate"><a href="#" class="text-gray-700">Gordon Corera</a></div>
                                        <div class="price d-flex align-items-center font-weight-medium font-size-3">
                                            <span class="woocommerce-Price-amount amount">6 x <span class="woocommerce-Price-currencySymbol">$</span>100</span>
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
                                <button type="submit" class="btn btn-block py-4 rounded-0 btn-outline-dark mb-4">View Cart</button>
                                <button type="submit" class="btn btn-block py-4 rounded-0 btn-dark">Checkout</button>
                            </div>
                        </div>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
    </aside>
    <!-- End Cart Sidebar Navigation -->

    <!-- Categories Sidebar Navigation -->
    <aside id="sidebarContent2" class="u-sidebar u-sidebar__md u-sidebar--left" aria-labelledby="sidebarNavToggler2">
        <div class="u-sidebar__scroller js-scrollbar">
            <div class="u-sidebar__container">
                <div class="u-header-sidebar__footer-offset">
                    <!-- Content -->
                    <div class="u-sidebar__body">
                        <div class="u-sidebar__content u-header-sidebar__content">
                            <!-- Title -->
                            <header class="border-bottom px-4 px-md-5 py-4 d-flex align-items-center justify-content-between">
                                <h2 class="font-size-3 mb-0">SHOP BY CATEGORY</h2>

                                <!-- Toggle Button -->
                                <div class="d-flex align-items-center">
                                    <button type="button" class="close ml-auto"
                                        aria-controls="sidebarContent2"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        data-unfold-event="click"
                                        data-unfold-hide-on-scroll="false"
                                        data-unfold-target="#sidebarContent2"
                                        data-unfold-type="css-animation"
                                        data-unfold-animation-in="fadeInLeft"
                                        data-unfold-animation-out="fadeOutLeft"
                                        data-unfold-duration="500">
                                        <span aria-hidden="true"><i class="fas fa-times ml-2"></i></span>
                                    </button>
                                </div>
                                <!-- End Toggle Button -->
                            </header>
                            <!-- End Title -->

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
                                                            <div class="submenu-header" data-submenu-close="off-single-product">
                                                                <a href="#">Single Product</a>
                                                            </div>

                                                            <ul class="">
                                                                <li>
                                                                    <a href="../shop/single-product-v1.html">Single Product v1</a>
                                                                </li>

                                                                <li>
                                                                    <a href="../shop/single-product-v2.html">Single Product v2</a>
                                                                </li>

                                                                <li>
                                                                    <a href="../shop/single-product-v3.html">Single Product v3</a>
                                                                </li>

                                                                <li>
                                                                    <a href="../shop/single-product-v4.html">Single Product v4</a>
                                                                </li>

                                                                <li>
                                                                    <a href="../shop/single-product-v5.html">Single Product v5</a>
                                                                </li>

                                                                <li>
                                                                    <a href="../shop/single-product-v6.html">Single Product v6</a>
                                                                </li>

                                                                <li>
                                                                    <a href="../shop/single-product-v7.html">Single Product v7</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                    <li class="has-submenu">
                                                        <a href="#" data-submenu="off-shop-pages">Shop Pages</a>

                                                        <div id="off-shop-pages" class="submenu js-scrollbar">
                                                            <div class="submenu-header" data-submenu-close="off-shop-pages">
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
                                                                    <a href="../shop/order-received.html">Shop Order Received</a>
                                                                </li>

                                                                <li>
                                                                    <a href="../shop/order-tracking.html">Shop Order Tracking</a>
                                                                </li>

                                                                <li>
                                                                    <a href="../shop/store-location.html">Shop Store Location</a>
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
                                                                    <a href="../others/authors-single.html">Authors Single</a>
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
                                                                    <a href="../others/terms-conditions.html">Terms Conditions</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                    <li class="px-5">
                                                        <a href="../../documentation/index.html" class="btn btn-primary mb-3 mb-md-0 mb-xl-3 mt-4 font-size-2 btn-block">Documentation</a>
                                                    </li>

                                                    <li class="px-5 mb-4">
                                                        <a href="../../starter/index.html" class="btn btn-secondary font-size-2 btn-block mb-2">Starter</a>
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
                                            <a href="#" data-submenu="sciencemath">Education & Teaching</a>

                                            <div id="sciencemath" class="submenu">
                                                <div class="submenu-header" data-submenu-close="sciencemath">
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
                                    <li class="list-group-item px-0 py-2 border-0"><a href="#" class="h-primary">Your Account</a></li>
                                    <li class="list-group-item px-0 py-2 border-0"><a href="#" class="h-primary">Help</a></li>
                                    <li class="list-group-item px-0 py-2 border-0"><a href="#" class="h-primary">Sign In</a></li>
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
                                <!-- Social Networks -->
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
                                <!-- End Social Networks -->
                            </div>
                        </div>
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
    </aside>
    <!-- End Categories Sidebar Navigation -->

    <!--===== END HEADER CONTENT =====-->

    <!-- ====== MAIN CONTENT ===== -->
    <main id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-3 border-right">
                    <h6 class="font-weight-medium font-size-7 pt-5 pt-lg-8  mb-5 mb-lg-7">My account</h6>
                    <div class="tab-wrapper">
                        <ul class="my__account-nav nav flex-column mb-0" role="tablist" id="pills-tab">
                            {{-- <li class="nav-item mx-0">
                                <a class="nav-link d-flex align-items-center px-0 active" id="pills-one-example1-tab" data-toggle="pill" href="{{route('user-dashboard')}}" role="tab" aria-controls="pills-one-example1" aria-selected="false">
                                    <span class="font-weight-normal text-gray-600">Dashboard</span>
                                </a>
                            </li> --}}
                            
                            <li class="nav-item mx-0">
                                <a class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/dashboard') active 
                                    @endif" href="{{route('user-dashboard')}}"
                                ><span class="font-weight-normal text-gray-600"> {{__('Dashboard')}}</span></a>
                            </li>

                            @if ($bex->recurring_billing == 1)
                            <li class="nav-item mx-0">
                                <a class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/packages') active @endif" href="{{route('user-packages')}}">
                                    <span class="font-weight-normal text-gray-600">{{__('Packages')}}</span></a>
                            </li>
                            @endif

                            @if ($bex->is_shop == 1 && $bex->catalog_mode == 0)
                            <li class="nav-item mx-0">
                                <a class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/orders') active
                                    @elseif(request()->is('user/order/*')) active
                                    @endif"
                                    href="{{route('user-orders')}}">
                                    <span class="font-weight-normal text-gray-600">{{__('Product Orders')}} </span> </a>
                            </li>
                            @endif

                            @if ($bex->recurring_billing == 0)
                            <li class="nav-item mx-0">
                                <a class="nav-link d-flex align-items-center px-0
                                @if(request()->path() == 'user/package/orders') active
                                @elseif(request()->is('user/package/order/*')) active
                                @endif"
                                href="{{route('user-package-orders')}}">
                                <span class="font-weight-normal text-gray-600">{{__('Package Orders')}}</span> </a>
                            </li>
                            @endif

                            @if ($bex->is_course == 1)
                            <li class="nav-item mx-0">
                                <a class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/course_orders') active @endif"
                                    href="{{route('user.course_orders')}}"
                                    ><span class="font-weight-normal text-gray-600">{{__('Courses')}}</span></a>
                            </li>
                            @endif

                            @if ($bex->is_event == 1)
                            <li class="nav-item mx-0">
                                <a class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/events') active
                                    @elseif(request()->is('user/event/*')) active
                                    @endif"
                                    href="{{route('user-events')}}"
                                    ><span class="font-weight-normal text-gray-600">{{__('Event Bookings')}}</span></a>
                            </li>
                            @endif

                            @if ($bex->is_donation == 1)
                            <li class="nav-item mx-0">
                                <a
                                    class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/donations') active @endif"
                                    href="{{route('user-donations')}}"
                                    ><span class="font-weight-normal text-gray-600">{{__('Donations')}}</span></a>
                            </li>
                            @endif

                            @if ($bex->is_ticket == 1)
                            <li class="nav-item mx-0">
                                <a
                                class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/tickets') active
                                @elseif(request()->is('user/ticket/*')) active
                                @endif"
                                href="{{route('user-tickets')}}"
                              ><span class="font-weight-normal text-gray-600">{{__('Support Tickets')}}</span></a>
                            </li>
                            @endif

                            <li class="nav-item mx-0">
                                <a
                                  class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/profile') active @endif"
                                  href="{{route('user-profile')}}"
                                ><span class="font-weight-normal text-gray-600">{{__('Edit Profile')}}</span></a>
                            </li>

                            @if ($bex->is_shop == 1 && $bex->catalog_mode == 0)
                            <li class="nav-item mx-0">
                                <a 
                                    class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/shipping/details') active @endif"
                                    href="{{route('shpping-details')}}"
                                  ><span class="font-weight-normal text-gray-600">{{__('Shipping Details')}}</span></a>
                            </li>
                            
                            <li class="nav-item mx-0">
                                <a
                                    class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/billing/details') active @endif"
                                    href="{{route('billing-details')}}"
                                  ><span class="font-weight-normal text-gray-600">{{__('Billing Details')}}</span></a>
                            </li>

                            @endif
                            
                            <li class="nav-item mx-0">
                                <a
                                    class="nav-link d-flex align-items-center px-0 @if(request()->path() == 'user/reset') active @endif"
                                    href="{{route('user-reset')}}"
                                    ><span class="font-weight-normal text-gray-600">{{__('Change Password')}}</span></a>
                            </li>

                            <li><a href="{{route('user-logout')}}" class="nav-link d-flex align-items-center px-0"><span class="font-weight-normal text-gray-600">{{__('Logout')}}</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    @yield('content')

                    {{-- <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab">
                            <div class="pt-5 pt-lg-8 pl-md-5 pl-lg-9 space-bottom-2 space-bottom-lg-3 mb-xl-1">
                                <h6 class="font-weight-medium font-size-7 ml-lg-1 mb-lg-8 pb-xl-1">Dashboard</h6>
                                <div class="ml-lg-1 mb-4">
                                    <span class="font-size-22">Hello alitfn58</span>
                                    <span class="font-size-2"> (not alitfn58? <a class="link-black-100" href="#">Log out</a>)</span>
                                </div>
                                <div class="mb-4">
                                    <p class="mb-0 font-size-2 ml-lg-1 text-gray-600">From your account dashboard you can view your <span class="text-dark">recent orders,</span> manage your <span class="text-dark">shipping and billing addresses,</span> and edit your <span class="text-dark">password and account details.</span></p>
                                </div>
                                <div class="row no-gutters row-cols-1 row-cols-md-2 row-cols-lg-3">
                                    <div class="col">
                                        <div class="border py-6 text-center">
                                            <a href="#" class="btn btn-primary rounded-circle px-4 mb-2">
                                              <span class="flaticon-order font-size-10 btn-icon__inner"></span>
                                            </a>
                                            <div class="font-size-3 mb-xl-1">Orders</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="border border-left-0 py-6 text-center">
                                            <a href="#" class="btn bg-gray-200 rounded-circle px-4 mb-2">
                                              <span class="flaticon-cloud-computing font-size-10 btn-icon__inner text-primary"></span>
                                            </a>
                                            <div class="font-size-3 mb-xl-1">Downloads</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="border border-left-0 py-6 text-center">
                                            <a href="#" class="btn bg-gray-200 rounded-circle px-4 mb-2">
                                              <span class="flaticon-place font-size-10 btn-icon__inner text-primary"></span>
                                            </a>
                                            <div class="font-size-3 mb-xl-1">Addresses</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="border py-6 text-center">
                                            <a href="#" class="btn bg-gray-200 rounded-circle px-4 mb-2">
                                              <span class="flaticon-user-1 font-size-10 btn-icon__inner text-primary"></span>
                                            </a>
                                            <div class="font-size-3 mb-xl-1">Account Details</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="border border-left-0 py-6 text-center">
                                            <a href="#" class="btn bg-gray-200  rounded-circle px-4 mb-2">
                                              <span class="flaticon-heart font-size-10 btn-icon__inner text-primary"></span>
                                            </a>
                                            <div class="font-size-3 mb-xl-1">Wishlist</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="border border-left-0 py-6 text-center">
                                            <a href="#" class="btn bg-gray-200 rounded-circle px-4 mb-2">
                                              <span class="flaticon-exit font-size-10 btn-icon__inner text-primary"></span>
                                            </a>
                                            <div class="font-size-3 mb-xl-1">Orders</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-two-example1" role="tabpanel" aria-labelledby="pills-two-example1-tab">
                            <div class="pt-5 pl-md-5 pt-lg-8 pl-lg-9 space-bottom-lg-2 mb-lg-4">
                                <h6 class="font-weight-medium font-size-7 ml-lg-1 mb-lg-8 pb-xl-1">orders</h6>
                                <table class="table">
                                    <thead>
                                        <tr class="border">
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium pl-3 pl-lg-5">Order</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Date</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Staus</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Total</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr class="border">
                                            <th class="pl-3 pl-md-5 font-weight-normal align-middle py-6">#30785</th>
                                            <td class="align-middle py-5">March 26, 2020</td>
                                            <td class="align-middle py-5">On hold</td>
                                            <td class="align-middle py-5">
                                                <span class="text-primary">$1,855.00</span> for 5 items</td>
                                            <td class="align-middle py-5">
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-dark rounded-0 btn-wide font-weight-medium">View
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <th class="pl-3 pl-md-5 font-weight-normal align-middle py-6">#30785</th>
                                            <td class="align-middle py-5">March 26, 2020</td>
                                            <td class="align-middle py-5">On hold</td>
                                            <td class="align-middle py-5">
                                                <span class="text-primary">$1,855.00</span> for 5 items</td>
                                            <td class="align-middle py-5">
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-dark rounded-0 btn-wide font-weight-medium">View
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <th class="pl-3 pl-md-5 font-weight-normal align-middle py-6">#30785</th>
                                            <td class="align-middle py-5">March 26, 2020</td>
                                            <td class="align-middle py-5">On hold</td>
                                            <td class="align-middle py-5">
                                                <span class="text-primary">$1,855.00</span> for 5 items</td>
                                            <td class="align-middle py-5">
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-dark rounded-0 btn-wide font-weight-medium">View
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-three-example1" role="tabpanel" aria-labelledby="pills-three-example1-tab">
                            <div class="pt-5 pl-md-5 pt-lg-8 pl-lg-9 space-bottom-lg-2 mb-lg-4">
                                <h6 class="font-weight-medium font-size-7 ml-lg-1 mb-lg-8 pb-xl-1">Downloads</h6>
                                <table class="table">
                                    <thead>
                                        <tr class="border">
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium pl-3 pl-md-5">Order</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Date</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Staus</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Total</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr class="border">
                                            <th class="pl-3 pl-md-5 font-weight-normal align-middle py-6">#30785</th>
                                            <td class="align-middle py-5">March 26, 2020</td>
                                            <td class="align-middle py-5">On hold</td>
                                            <td class="align-middle py-5">
                                                <span class="text-primary">$1,855.00</span> for 5 items</td>
                                            <td class="align-middle py-5">
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-dark rounded-0 btn-wide font-weight-medium">View
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-four-example1" role="tabpanel" aria-labelledby="pills-four-example1-tab">
                            <div class="pt-5 pl-md-5 pt-lg-8 pl-lg-9 space-bottom-2 mb-lg-4">
                                <h6 class="font-weight-medium font-size-7 ml-lg-1 mb-5 mb-lg-8 pb-xl-1">Addresses</h6>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div class="col">
                                        <div class="mb-6 mb-md-0">
                                            <h6 class="font-weight-medium font-size-22 mb-3">Billing Address
                                            </h6>
                                            <address class="d-flex flex-column mb-4">
                                                <span class="text-gray-600 font-size-2">Ali Tufan</span>
                                                <span class="text-gray-600 font-size-2">Bedford St,</span>
                                                <span class="text-gray-600 font-size-2">Covent Garden, </span>
                                                <span class="text-gray-600 font-size-2">London WC2E 9ED</span>
                                                <span class="text-gray-600 font-size-2">United Kingdom</span>
                                            </address>
                                            <div class="d-flex">
                                                <button type="submit" class="btn btn-dark width-150 rounded-0 btn-wide font-weight-medium">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="font-weight-medium font-size-22 mb-3">Shipping Address
                                        </h6>
                                        <address class="d-flex flex-column mb-4">
                                            <span class="text-gray-600 font-size-2">Ali Tufan</span>
                                            <span class="text-gray-600 font-size-2">Bedford St,</span>
                                            <span class="text-gray-600 font-size-2">Covent Garden, </span>
                                            <span class="text-gray-600 font-size-2">London WC2E 9ED</span>
                                            <span class="text-gray-600 font-size-2">United Kingdom</span>
                                        </address>
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-dark width-150 rounded-0 btn-wide font-weight-medium">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-five-example1" role="tabpanel" aria-labelledby="pills-five-example1-tab">
                            <div class="border-bottom mb-6 pb-6 mb-lg-8 pb-lg-9">
                                <div class="pt-5 pl-md-5 pt-lg-8 pl-lg-9">
                                    <h6 class="font-weight-medium font-size-7 ml-lg-1 mb-lg-8 pb-xl-1">Account Details</h6>
                                    <div class="font-weight-medium font-size-22 mb-4 pb-xl-1">Edit Account</div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="js-form-message">
                                                <label for="exampleFormControlInput1">First name *</label>
                                                <input type="text" class="form-control rounded-0 pl-3 placeholder-color-3" id="exampleFormControlInput1" name="name" aria-label="Jack Wayley" placeholder="Ali" required="" data-error-class="u-has-error" data-msg="Please enter your name." data-success-class="u-has-success">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="js-form-message">
                                                <label for="exampleFormControlInput2">Last name *</label>
                                                <input type="text" class="form-control rounded-0 pl-3 placeholder-color-3" id="exampleFormControlInput2" name="name" aria-label="Jack Wayley" placeholder="TUF.." required="" data-error-class="u-has-error" data-msg="Please enter your name." data-success-class="u-has-success">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="js-form-message">
                                                <label for="exampleFormControlInput3">Display name</label>
                                                <input type="text" class="form-control rounded-0" name="name" aria-label="Jack Wayley" id="exampleFormControlInput3" required="" data-error-class="u-has-error" data-msg="Please enter your name." data-success-class="u-has-success">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-4 mb-md-0">
                                            <div class="js-form-message">
                                                <label for="exampleFormControlInput4">Email address</label>
                                                <input type="email" class="form-control rounded-0" name="name" id="exampleFormControlInput4" aria-label="Jack Wayley" required="" data-error-class="u-has-error" data-msg="Please enter your name." data-success-class="u-has-success">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-md-5 pl-lg-9 space-bottom-2 space-bottom-lg-3">
                                <div class="font-weight-medium font-size-22 mb-4 pb-xl-1">Password Change</div>
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="js-form-message">
                                            <label for="exampleFormControlInput5">Current Password</label>
                                            <input type="password" class="form-control rounded-0" name="name" id="exampleFormControlInput5" aria-label="Jack Wayley" required="" data-error-class="u-has-error" data-msg="Please enter your name." data-success-class="u-has-success">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="js-form-message">
                                            <label for="exampleFormControlInput6">New Password</label>
                                            <input type="password" class="form-control rounded-0" name="name" id="exampleFormControlInput6" aria-label="Jack Wayley" required="" data-error-class="u-has-error" data-msg="Please enter your name." data-success-class="u-has-success">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-5">
                                        <div class="js-form-message">
                                            <label for="exampleFormControlInput7">Confirm new password</label>
                                            <input type="password" class="form-control rounded-0" name="name" id="exampleFormControlInput7" aria-label="Jack Wayley" required="" data-error-class="u-has-error" data-msg="Please enter your name." data-success-class="u-has-success">
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <button type="submit" class="btn btn-wide btn-dark text-white rounded-0 transition-3d-hover height-60 width-390">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-six-example1" role="tabpanel" aria-labelledby="pills-six-example1-tab">
                            <div class="pt-5 pl-md-5 pt-lg-8 pl-lg-9 space-bottom-lg-3">
                                <h6 class="font-weight-medium font-size-7 ml-lg-1 mb-lg-8 pb-xl-1">Wishlist</h6>
                                <table class="table mb-0">
                                    <thead>
                                        <tr class="border">
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium pl-3 pl-md-5">Prouct</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Price</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Stock Staus</th>
                                            <th scope="col" class="py-3 border-bottom-0 font-weight-medium">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr class="border">
                                            <th class="pl-3 pl-md-5 font-weight-normal align-middle py-6">
                                                <div class="d-flex align-items-center">
                                                    <a class="d-block" href="#">
                                                        <img class="img-fluid" src="https://placehold.it/80x120" alt="Image-Description">
                                                    </a>
                                                    <div class="ml-xl-4">
                                                        <div class="font-weight-normal">
                                                            <a href="#">The Overdue Life of Amy Byler</a>
                                                        </div>
                                                        <div class="font-size-2"><a href="#" class="text-gray-700" tabindex="0">Jay Shetty</a></div>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="align-middle py-5">$37</td>
                                            <td class="align-middle py-5">In Stock</td>
                                            <td class="align-middle py-5">
                                                <span class="product__add-to-cart">ADD TO CART</span>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <th class="pl-3 pl-md-5 font-weight-normal align-middle py-6">
                                                <div class="d-flex align-items-center">
                                                    <a class="d-block" href="#">
                                                        <img class="img-fluid" src="https://placehold.it/80x120" alt="Image-Description">
                                                    </a>
                                                    <div class="ml-xl-4">
                                                        <div class="font-weight-normal">
                                                            <a href="#">The Overdue Life of Amy Byler</a>
                                                        </div>
                                                        <div class="font-size-2"><a href="#" class="text-gray-700" tabindex="0">Jay Shetty</a></div>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="align-middle py-5">$37</td>
                                            <td class="align-middle py-5">In Stock</td>
                                            <td class="align-middle py-5">
                                                <span class="product__add-to-cart">ADD TO CART</span>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <th class="pl-5 font-weight-normal align-middle py-6">
                                                <div class="d-flex align-items-center">
                                                    <a class="d-block" href="#">
                                                        <img class="img-fluid" src="https://placehold.it/80x120" alt="Image-Description">
                                                    </a>
                                                    <div class="ml-xl-4">
                                                        <div class="font-weight-normal">
                                                            <a href="#">The Overdue Life of Amy Byler</a>
                                                        </div>
                                                        <div class="font-size-2"><a href="#" class="text-gray-700" tabindex="0">Jay Shetty</a></div>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="align-middle py-5">$37</td>
                                            <td class="align-middle py-5">In Stock</td>
                                            <td class="align-middle py-5">
                                                <span class="product__add-to-cart">ADD TO CART</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </main>
    <!-- ====== END MAIN CONTENT ===== -->

    <!-- ========== FOOTER ========== -->
    {{-- <footer>
        <div class="border-top space-top-3">
            <div class="border-bottom pb-5 space-bottom-lg-3">
                <div class="container">
                    <div class="space-bottom-2 space-bottom-md-3">
                        <div class="text-center mb-5">
                            <h5 class="font-size-7 font-weight-medium">Join Our Newsletter</h5>
                            <p class="text-gray-700">Signup to be the first to hear about exclusive deals, special offers and upcoming collections</p>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="col-md-5 mb-3 mb-md-2">
                                <div class="js-form-message">
                                    <div class="input-group">
                                        <input type="text" class="form-control px-5 height-60 border-dark" name="name" id="signupSrName" placeholder="Enter email for weekly newsletter." aria-label="Your name" required="" data-msg="Name must contain only letters." data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 ml-md-2">
                                <button type="submit" class="btn btn-dark rounded-0 btn-wide py-3 font-weight-medium">Subscribe
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-6 mb-lg-0">
                            <div class="pb-6">
                                <a href="{{ route('front.index') }}" class="d-inline-block mb-5">
                                    <img src="{{ asset('assets/front/img/' . $bs->logo) }}" style="height:50px" class="img-fluid lazy" alt="">
                                </a>
                                <address class="font-size-2 mb-5">
                                    <span class="mb-2 font-weight-normal text-dark">
                                        1516-17, Gali Pataudi House, Daryaganj
                                    </span>
                                </address>
                                <div class="mb-4">
                                    <a href="mailto:sale@bookworm.com" class="font-size-2 d-block link-black-100 mb-1">info@ibsbookstore.com</a>
                                    <a href="tel:+911123286551" class="font-size-2 d-block link-black-100"> +911123286551</a>
                                </div>
                                <ul class="list-unstyled mb-0 d-flex">
                                    <li class="btn pl-0">
                                        <a class="link-black-100" href="#">
                                            <span class="fab fa-instagram"></span>
                                        </a>
                                    </li>
                                    <li class="btn">
                                        <a class="link-black-100" href="#">
                                            <span class="fab fa-facebook-f"></span>
                                        </a>
                                    </li>
                                    <li class="btn">
                                        <a class="link-black-100" href="#">
                                            <span class="fab fa-youtube"></span>
                                        </a>
                                    </li>
                                    <li class="btn">
                                        <a class="link-black-100" href="#">
                                            <span class="fab fa-twitter"></span>
                                        </a>
                                    </li>
                                    <li class="btn">
                                        <a class="link-black-100" href="#">
                                            <span class="fab fa-pinterest"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 mb-6 mb-lg-0">
                            <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1">Explore</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="pb-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">About as</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Sitemap</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Bookmarks</a>
                                </li>
                                <li class="pt-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Sign in/Join</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 mb-6 mb-lg-0">
                            <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1">Customer Service</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="pb-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Help Center</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Returns</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Product Recalls</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Accessibility</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Contact Us</a>
                                </li>
                                <li class="pt-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Store Pickup</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 mb-6 mb-lg-0">
                            <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1">Policy</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="pb-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Return Policy</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Terms Of Use</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Security</a>
                                </li>
                                <li class="pt-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Privacy</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 mb-6 mb-lg-0">
                            <h4 class="font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1">Categories</h4>
                            <ul class="list-unstyled mb-0">
                                <li class="pb-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Action</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Comedy</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Drama</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Horror</a>
                                </li>
                                <li class="py-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Kids</a>
                                </li>
                                <li class="pt-2">
                                    <a class="widgets-hover transition-3d-hover font-size-2 link-black-100" href="#">Romantic Comedy</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-1">
                <div class="container">
                    <div class="d-lg-flex text-center text-lg-left justify-content-between align-items-center">
                        <p class="mb-3 mb-lg-0 font-size-2">©2022 All rights reserved by ibsbookstore.com</p>

                        <div class="ml-auto d-lg-flex align-items-center">
                            <div class="mb-4 mb-lg-0 mr-5">
                               <img class="img-fluid" src="{{ asset('assets/assets/img/324x38/img1.png') }}" alt="Image-Description">
                            </div>

                            <select class="js-select selectpicker dropdown-select mb-3 mb-lg-0"
                                data-style="border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2"
                                data-dropdown-align-right="true">
                                <option value="one" selected>English (United States)</option>
                                <option value="two">Deutsch</option>
                                <option value="three">Français</option>
                                <option value="four">Español</option>
                            </select>

                            <select class="js-select selectpicker dropdown-select ml-md-3"
                                data-style="border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2"
                                data-dropdown-align-right="true"
                                data-width="fit">
                                <option value="one" selected>$ USD</option>
                                <option value="two">€ EUR</option>
                                <option value="three">₺ TL</option>
                                <option value="four">₽ RUB</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
 --}}
    @include('front.bookworm.footer.v2')

    <!-- ========== END FOOTER ========== -->

   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('assets/assets/vendor/jquery/dist/jquery.min.js') }} "></script>
    <script src="{{ asset('assets/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js') }} "></script>
    <script src="{{ asset('assets/assets/vendor/popper.js/dist/umd/popper.min.js') }} "></script>
    <script src="{{ asset('assets/assets/vendor/bootstrap/bootstrap.min.js') }} "></script>
    <script src="{{ asset('assets/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }} "></script>
    <script src="{{ asset('assets/assets/vendor/slick-carousel/slick/slick.min.js') }} "></script>
    <script src="{{ asset('assets/assets/vendor/multilevel-sliding-mobile-menu/dist/jquery.zeynep.js') }} "></script>
    <script src="{{ asset('assets/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }} "></script>


    <!-- JS HS Components -->
    <script src="{{ asset('assets/assets/js/hs.core.js') }} "></script>
    <script src="{{ asset('assets/assets/js/components/hs.unfold.js') }} "></script>
    <script src="{{ asset('assets/assets/js/components/hs.malihu-scrollbar.js') }} "></script>
    <script src="{{ asset('assets/assets/js/components/hs.header.js') }} "></script>
    <script src="{{ asset('assets/assets/js/components/hs.slick-carousel.js') }} "></script>
    <script src="{{ asset('assets/assets/js/components/hs.selectpicker.js') }} "></script>
    <script src="{{ asset('assets/assets/js/components/hs.show-animation.js') }} "></script>

    {{-- Bootstrap Datatables --}}
    <script src="{{asset('assets/user/js/datatables.min.js')}}"></script>
    <script src="{{asset('assets/user/js/dataTables.bootstrap4.js')}}"></script>
    {{-- Bootstrap Datatables --}}

    <!-- JS Bookworm -->
    <!-- <script src="../../assets/js/bookworm.js"></script> -->
    <script>
        $(document).on('ready', function () {
            // initialization of unfold component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'));

            // initialization of slick carousel
            $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');

            // initialization of header
            $.HSCore.components.HSHeader.init($('#header'));

            // initialization of malihu scrollbar
            $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

            // initialization of show animations
            $.HSCore.components.HSShowAnimation.init('.js-animation-link');

            // init zeynepjs
            var zeynep = $('.zeynep').zeynep({
                onClosed: function () {
                    // enable main wrapper element clicks on any its children element
                    $("body main").attr("style", "");

                    console.log('the side menu is closed.');
                },
                onOpened: function () {
                    // disable main wrapper element clicks on any its children element
                    $("body main").attr("style", "pointer-events: none;");

                    console.log('the side menu is opened.');
                }
            });

            // handle zeynep overlay click
            $(".zeynep-overlay").click(function () {
                zeynep.close();
            });

            // open side menu if the button is clicked
            $(".cat-menu").click(function () {
                if ($("html").hasClass("zeynep-opened")) {
                    zeynep.close();
                } else {
                    zeynep.open();
                }
            });
        });
    </script>

    <script src="{{asset('assets/user/js/main.js')}}"></script>

    <script>
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    </script>

    <script>
      var imgupload = "{{route('user.summernote.upload')}}";
    </script>

    <!-- custom js -->
    <script src="{{asset('assets/user/js/custom.js')}}"></script>

    @yield('scripts')

    @if (session()->has('success'))
      <script>
        toastr["success"]("{{__(session()->get('success'))}}");
      </script>
    @endif

    @if (session()->has('error'))
      <script>
        toastr["error"]("{{__(session('error'))}}");
      </script>
    @endif

    <script>
      $(document).ready(function() {
        $('#example').DataTable({
          responsive: true
        });
      });
    </script>
</body>
</html>
