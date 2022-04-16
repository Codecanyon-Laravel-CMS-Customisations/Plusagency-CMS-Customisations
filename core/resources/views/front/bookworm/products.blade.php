@extends("front.bookworm.layout")

@php
//$maxprice = App\Product::max('current_price');
//$minprice = 0;
$maxprice = App\Product::all()->max('price');
$minprice = App\Product::all()->min('price');
@endphp


@section('pagename')
    -
    @if (empty($category))
        {{ __('All') }}
    @else
        {{ convertUtf8($category->name) }}
    @endif
    {{ __('Products') }}
@endsection

@section('meta-keywords', "$be->products_meta_keywords")
@section('meta-description', "$be->products_meta_description")


@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/front/css/jquery-ui.min.css') }}">
@endsection


@section('breadcrumb-links')
    <nav class="woocommerce-breadcrumb font-size-2">
        <a href='/' class='h-primary'>Home</a>
        <span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
        <a href='/products' class='h-primary'>Products</a>
        @if (isset($category))
            <span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
            <a href="/products?search=&category_id={{ $category->id }}&type=new" class='h-primary testing'>{{ $category->name }}</a>
            @if (isset($sub_category))
                <span class='breadcrumb-separator mx-1'><i class='fas fa-angle-right'></i></span>
                <a href='#' class='h-primary'>{{ $sub_category->name }}</a>
            @endif
        @endif

    </nav>
@endsection
@section('content')
    @include('front.bookworm.shoplist.' . $be->bookworm_shop_list_version)
@endsection



@section('scripts')
    <script src="{{ asset('assets/front/js/jquery.ui.js') }}"></script>

    @if ($bex->catalog_mode == 0)
        <script src="{{ asset('assets/front/js/cart.js') }}"></script>
        <script>
            var position = "{{ $bex->base_currency_symbol_position }}";
            var symbol = "{{ $bex->base_currency_symbol }}";

            // console.log(position,symbol);
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: '{{ $maxprice }}',
                values: [
                    '{{ !empty(request()->input('minprice '))
                        ? request()->input('minprice')
                        : $minprice }}',
                    {{ !empty(request()->input('maxprice')) ? request()->input('maxprice') : $maxprice }}
                ],
                slide: function(event, ui) {
                    $("#amount").val((position == 'left' ? symbol : '') + ui.values[0] + (position == 'right' ?
                        symbol : '') + " - " + (position == 'left' ? symbol : '') + ui.values[1] + (
                        position == 'right' ? symbol : ''));
                }
            });
            $("#amount").val((position == 'left' ? symbol : '') + $("#slider-range").slider("values", 0) + (position ==
                'right' ? symbol : '') + " - " + (position == 'left' ? symbol : '') + $("#slider-range").slider(
                "values", 1) + (position == 'right' ? symbol : ''));
        </script>
    @endif


    <script>
        let maxprice = 0;
        let minprice = 0;
        let typeSort = '';
        let category = '';
        let tag = '';
        let review = '';
        let search = '';


        $(document).on('click', '.filter-button', function() {
            let filterval = $('#amount').val();
            filterval = filterval.split('-');
            maxprice = filterval[1].replace('$', '');
            minprice = filterval[0].replace('$', '');
            maxprice = parseInt(maxprice);
            minprice = parseInt(minprice);
            $('#maxprice').val(maxprice);
            $('#minprice').val(minprice);
            $('#search-button').click();
        });

        $(document).on('change', '#type_sort', function() {
            typeSort = $(this).val();
            $('#type').val(typeSort);
            $('#search-button').click();
        })
        $(document).ready(function() {
            typeSort = $('#type_sort').val();
            $('#type').val(typeSort);
        })

        $(document).on('click', '.category-id', function() {
            category = '';
            if ($(this).attr('data-href') != 0) {
                category = $(this).attr('data-href');
            }
            $('#category_id').val(category);
            $('#search-button').click();
        })
        $(document).on('click', '.tag-id', function() {
            tag = '';
            if ($(this).attr('data-href') != 0) {
                tag = $(this).attr('data-href');
            }
            $('#tag').val(tag);
            $('#search-button').click();
        })

        $(document).on('click', '.review_val', function() {
            review = $(".review_val:checked").val();
            $('#review').val(review);
            $('#search-button').click();
        })

        $(document).on('click', '.input-search-btn', function() {
            search = $('.input-search').val();
            $('#search').val(search);
            $('#search-button').click();
        })
    </script>

    <script src="https://unpkg.com/shufflejs@5"></script>

    <script>
        var Shuffle = window.Shuffle;



        class Demo {
            constructor(element) {
                this.element = element;
                this.shuffle = new Shuffle(element, {
                    itemSelector: '.searchable-filter-item',
                    //sizer: element.querySelector('.my-sizer-element'),
                });

                // Log events.
                // this.addShuffleEventListeners();
                this._activeFilters = [];
                this.addSearchFilter();
            }

            /**
             * Shuffle uses the CustomEvent constructor to dispatch events. You can listen
             * for them like you normally would (with jQuery for example).
             */
            addShuffleEventListeners() {
                this.shuffle.on(Shuffle.EventType.LAYOUT, (data) => {
                    // console.log('layout. data:', data);
                });
                this.shuffle.on(Shuffle.EventType.REMOVED, (data) => {
                    // console.log('removed. data:', data);
                });
            }

            // Advanced filtering
            addSearchFilter() {
                const searchInput = document.querySelector('.js-shuffle-search');
                if (!searchInput) {
                    return;
                }
                searchInput.addEventListener('keyup', this._handleSearchKeyup.bind(this));
            }

            /**
             * Filter the shuffle instance by items with a title that matches the search input.
             * @param {Event} evt Event object.
             */
            _handleSearchKeyup(evt) {
                const searchText = evt.target.value.toLowerCase();
                this.shuffle.filter((element, shuffle) => {
                    // If there is a current filter applied, ignore elements that don't match it.
                    if (shuffle.group !== Shuffle.ALL_ITEMS) {
                        // Get the item's groups.
                        const groups = JSON.parse(element.getAttribute('data-groups'));
                        const isElementInCurrentGroup = groups.indexOf(shuffle.group) !== -1;
                        // Only search elements in the current group
                        if (!isElementInCurrentGroup) {
                            return false;
                        }
                    }
                    const titleElement = element.querySelector('.product__title');
                    const titleText = titleElement.textContent.toLowerCase().trim();
                    return titleText.indexOf(searchText) !== -1;
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            window.demo = new Demo(document.getElementById('searchable-filter-items-grid'));
        });
    </script>
@endsection
