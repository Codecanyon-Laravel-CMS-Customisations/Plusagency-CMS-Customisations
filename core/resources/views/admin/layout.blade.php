<!DOCTYPE html>
<html lang="en">

<head>
    <meta
    http-equiv="Content-Type"
    content="text/html; charset=UTF-8"
    >
    <meta
    http-equiv="X-UA-Compatible"
    content="IE=edge"
    />
    <meta
    name="csrf-token"
    content="{{ csrf_token() }}"
    >
    <meta
    content='width=device-width, initial-scale=1.0, shrink-to-fit=no'
    name='viewport'
    />
    <title>{{$bs->website_title}}</title>
    <link
    rel="icon"
    href="{{asset('assets/front/img/'.$bs->favicon)}}"
    >
    @includeif('admin.partials.styles')
    @php
    $selLang = \App\Language::where('code', request()->input('language'))->first();
    @endphp
    @if (!empty($selLang) && $selLang->rtl == 1)
    <style>
        #editModal form input,
        #editModal form textarea,
        #editModal form select {
            direction: rtl;
        }

        #editModal form .note-editor.note-frame .note-editing-area .note-editable {
            direction: rtl;
            text-align: right;
        }
    </style>
    @endif

    @yield('styles')

</head>

<body data-background-color="dark">

    <div class="wrapper
    @if(request()->routeIs('admin.file-manager'))
    overlay-sidebar
    @endif">

        {{-- top navbar area start --}}
        @includeif('admin.partials.top-navbar')
        {{-- top navbar area end --}}

        {{-- home page anchor start --}}
        @includeif('admin.themeHome.homePageAnchor')
        {{-- home page anchor end --}}

        {{-- side navbar area start --}}
        @includeif('admin.partials.side-navbar')
        {{-- side navbar area end --}}


        <div class="main-panel">
            <div class="content">
                <div class="page-inner @if(request()->routeIs('admin.file-manager')) p-0 @endif">
                    @yield('content')
                </div>
            </div>
            @includeif('admin.partials.footer')
        </div>

    </div>

    @includeif('admin.partials.scripts')

    {{-- Loader --}}
    <div class="request-loader">
        <img
        src="{{asset('assets/admin/img/loader.gif')}}"
        alt=""
        >
    </div>
    {{-- Loader --}}


    <!-- LFM Modal -->
    <div class="modal fade lfm-modal" id="lfmModalSummernote" tabindex="-1" role="dialog" aria-labelledby="lfmModalSummernoteTitle" aria-hidden="true">
        <i class="fas fa-times-circle"></i>
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <iframe src="" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>

        // start: script to handle sidebar
        var sideBarClicked = sidebarNavToggler.onclick = function(e) {
            
            const menu = document.getElementById('hc-nav-1');
            menu.classList.add("nav-open");
            menu.style.visibility = "visible";
            e.stopPropagation();
        };

        $('.nav-close-button').on('click',function(){
            $( "li" ).removeClass( 'level-open');

            if($('#hc-nav-1').hasClass('nav-open')){
                $('#hc-nav-1').attr("aria-hidden", "true");
                $('body').removeAttr( 'class' );
                $('#hc-nav-1').removeAttr( 'style' ).removeClass('nav-open');
                $('html').removeClass('hc-nav-yscroll');
                $('#sidebarNavToggler').removeClass('toggle-open');
                $('.nav-wrapper').removeClass('sub-level-open');
            }
            
        });
        // end: script to handle sidebar
    </script>


    <script>
        $('body').on('click',function() {
            $( "li" ).removeClass( 'level-open');
        
            if($('#hc-nav-1').hasClass('nav-open')){
                $( "li" ).removeClass( 'level-open');
                $('#hc-nav-1').attr("aria-hidden", "true");
                $('body').removeAttr( 'class' );
                $('#hc-nav-1').removeAttr( 'style' ).removeClass('nav-open');
                $('html').removeClass('hc-nav-yscroll');
                $('#sidebarNavToggler').removeClass('toggle-open');
                $('.nav-wrapper').removeClass('sub-level-open');
            }
            
        });
    </script>

</body>
</html>
