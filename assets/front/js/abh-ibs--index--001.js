// 000
var links = $(".site-navigation ul li ul");
for (var a = 0; a < links.length; a++) {
    var mylink = links[a];
    sortUL(mylink);
}

function sortUL(selector) {
    $(selector).children("li").sort(function(a, b) {
        var upA = $(a).text().toUpperCase();
        var upB = $(b).text().toUpperCase();
        return (upA < upB) ? -1 : (upA > upB) ? 1 : 0;
    }).appendTo(selector);
}


// 001
// language dropdown toggle on clicking button
$('.language-btn').on('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).next('.language-dropdown').toggleClass('open');
});


// 002

$(document).on('ready', function() {
    // initialization of unfold component
    $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
        afterOpen: function() {
            /* $('#sidebarNavToggler').on('click', function(){
                $('.u-sidebar-bg-overlay').css({display : "block"});
            }); */
            $('#sidebarAuthToggler').on('click', function() {
                $('.u-sidebar-bg-overlay').css({
                    display: "block"
                });
            });
            /* $('#sidebarNavToggler1').on('click', function(){
                $('.u-sidebar-bg-overlay').css({display : "block"});
            }); */
        },
        afterClose: function() {
            $('.u-sidebar-bg-overlay').css({
                display: "none"
            });
        }
    });

    // initialization of slick carousel=
    $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');

    // initialization of header
    $.HSCore.components.HSHeader.init($('#header'));

    // initialization of malihu scrollbar
    $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

    // initialization of show animations
    $.HSCore.components.HSShowAnimation.init('.js-animation-link');

    // init zeynepjs
    var zeynep = $('.zeynep').zeynep({
        onClosed: function() {
            // enable main wrapper element clicks on any its children element
            $("body main").attr("style", "");

            console.log('the side menu is closed.');
        },
        onOpened: function() {
            // disable main wrapper element clicks on any its children element
            $("body main").attr("style", "pointer-events: none;");

            console.log('the side menu is opened.');
        }
    });

    // handle zeynep overlay click
    $(".zeynep-overlay").click(function() {
        zeynep.close();
    });

    // open side menu if the button is clicked
    // $(".cat-menu").click(function () {
    //     if ($("html").hasClass("zeynep-opened")) {
    //         zeynep.close();
    //     } else {
    //         zeynep.open();
    //     }
    // });
});


// 003
var myNav = new hcOffcanvasNav('#main-nav', {
    insertClose: true,
    insertBack: true,
    labelClose: 'SHOP BY CATEGORY',
    labelBack: 'Back',
    levelTitleAsBack: true,
    pushContent: false, // default false
    //width: 280 // width & height,
    //height:'auto' // width & height,
    swipeGestures: true, // enable swipe gestures
    expanded: false, // initialize the menu in expanded mode
    levelOpen: 'expand', // overlap / expand / none
    levelSpacing: 40, // in pixels
    levelTitles: false, // shows titles for submenus
    closeOpenLevels: true, // close sub levels when the nav closes
    closeActiveLevel: false, // clear active levels when the nav closes
    navTitle: null, // the title of the first level
    navClass: '', // extra CSS class(es)
    disableBody: true, // disable body scroll
    closeOnClick: true, // close the nav on click
    customToggle: '#sidebarNavToggler', // custom toggle element
    bodyInsert: 'prepend', // prepend or append the menu to body
    keepClasses: true, // should original menus and their items classes be preserved or excluded.
    removeOriginalNav: false, // remove original menu from the DOM
    rtl: false // enable RTL mode
});
$('#sidebarNavToggler').css({
    'position': 'relative',
    'top': '0px'
});


// 004


// 005


// 006


// 007


// 008


// 009


// 0107