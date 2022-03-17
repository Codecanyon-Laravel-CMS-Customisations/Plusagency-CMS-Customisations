   @php
        $colors = \App\WebsiteColors::all();
    @endphp
 <style>
        .height-5.form-control,
        .widget-content select,
        footer .widget select,
        .widget_search .search-field,
        .height-5.custom-select,
        .widget-content select.custom-select,
        footer .widget select.custom-select,
        .widget_search .custom-select.search-field,
        header select[id="category_id"] {
            /*height: calc( 1.5em + ( 1rem * 1.5 ) + 10px);*/
            height: 50px;
        }

        .site-branding img {
            max-height: 4rem;
        }

        @if (!empty($colors))@foreach ($colors as $color){!! $color->element !!} {
            {!! $color->attribute !!}: #{{ $color->value }};
        }

        @endforeach @endif
        .site-navigation>ul>li ul>li:hover .dropdown-toggle::after {
            transform: rotate(-90deg);
            transition-duration: .5s;
        }

        .site-navigation>ul>li ul>li>a:hover .dropdown-toggle::after {
            transform: rotate(-90deg);
            transition-duration: .5s;
        }

        .u-sidebar-bg-overlay {
            position: fixed;
            top: 0px;
            left: 0px;
            z-index: 1001;
            display: none;
            width: 100%;
            height: 100%;
        }

        .u-sidebar {
            z-index: 1002;
        }

        .btn-primary-green:focus,
        .btn-primary-green.focus,
        .btn-primary-green:not(:disabled):not(.disabled):active:focus {
            box-shadow: none !important;
        }

        #site-header .btn-search {
            border: 0px solid transparent !important;
        }

        .hc-offcanvas-nav .nav-close-button span::before {
            margin-left: 2px;
            margin-top: -3px;
        }
      
        .hc-offcanvas-nav .nav-close-button span::before, .hc-offcanvas-nav .nav-close-button span::after{
            border:none; 
            content:'x';
            transform: none;
            position:unset;
        }
        .hc-offcanvas-nav .nav-next span::before, .hc-offcanvas-nav .nav-back span::before {
            border-left-color: #FFF0CE;
        }

        .hc-offcanvas-nav .nav-next span::before, .hc-offcanvas-nav .nav-back span::before {
            border-top-color: #FFF0CE;
        }

        #site-header :is(a, button)[data-target='#headerProductInquiryModal'] {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        #site-header .dropdown-unfold {
            padding-bottom: 0px !important;
            padding-top: 0px !important;
        }

    </style>