@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp
<header class="myui-header__top clearfix" id="header-top">
    <div class="container">
        <div class="row">
            <div class="myui-header_bd clearfix">
                <div class="myui-header__logo">
                    <a href="/" class="logo" title="{{ $title }}">
                        @if ($logo)
                            {!! $logo !!}
                        @else
                            {!! $brand !!}
                        @endif
                    </a>
                </div>

                <!-- Mobile menu toggle button -->
                <button class="mobile-menu-toggle visible-xs" id="mobile-menu-toggle">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>

                <!-- Mobile search toggle button -->
                <button class="mobile-search-toggle visible-xs" id="mobile-search-toggle">
                    <i class="fa fa-search"></i>
                </button>

                <ul class="myui-header__menu nav-menu" id="main-menu">
                    @foreach ($menu as $item)
                        @if (count($item['children']))
                            <li class="dropdown-hover">
                                <a href="javascript:" class="dropdown-toggle" data-dropdown="dropdown-{{ $loop->index }}">
                                    {{ $item['name'] }} <i class="fa fa-angle-down"></i>
                                </a>
                                <div class="dropdown-box bottom fadeInDown clearfix" id="dropdown-{{ $loop->index }}">
                                    <ul class="item nav-list clearfix">
                                        @foreach ($item['children'] as $children)
                                            <li class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                                <a class="btn btn-sm btn-block btn-warm" href="{{ $children['link'] }}">
                                                    {{ $children['name'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @else
                            <li><a href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                        @endif
                    @endforeach
                </ul>

                <div class="myui-header__search search-box" id="search-box">
                    <form id="" name="search" method="get" action="/">
                        <input type="text" id="search" name="search" class="search_wd form-control"
                            value="{{ request('search') }}" placeholder="Tìm kiếm" autocomplete="off"
                            style=" padding-left: 12px; ">
                        <button class="submit search_submit" id="searchbutton" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                    <a class="search-close visible-xs" href="javascript:" id="search-close">
                        <i class="fa fa-close"></i>
                    </a>

                    <div class="" id="result"></div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

<script type="text/javascript">
    // Search functionality
    $('#search').on('keyup', function() {
        $("#result").html('');
        $value = $(this).val();
        if (!$value) {
            $("#result").html('');
            return;
        }
        $.ajax({
            type: 'get',
            url: '{{ URL::to('search') }}',
            data: {
                'search': $value
            },
            success: function(data) {
                $("#result").html('')
                $.each(data, function(key, value) {
                    $('#result').append('<a href="' + value.slug +
                        '"><div class="rowsearch"> <div class="column left"> <img src="' +
                        value.image +
                        '" width="50" /> </div> <div class="column right"><p> ' + value
                        .title + ' ' + '</p><p> ' + value.original_title + '| ' + value
                        .year + ' </p></div> </div></a>')
                });
            }
        });
    })

    // Close search results when clicking outside
    document.body.addEventListener("click", function(event) {
        $("#result").html('');
    });

    // Mobile menu toggle
    $('#mobile-menu-toggle').on('click', function() {
        $('#main-menu').toggleClass('mobile-menu-active');
        $('#mobile-menu-overlay').toggleClass('active');
        $(this).toggleClass('menu-open');
        $('body').toggleClass('menu-open');
    });

    // Mobile search toggle
    $('#mobile-search-toggle').on('click', function() {
        $('#search-box').toggleClass('search-active');
        if ($('#search-box').hasClass('search-active')) {
            $('#search').focus();
        }
    });

    // Close mobile search
    $('#search-close').on('click', function() {
        $('#search-box').removeClass('search-active');
    });

    // Mobile dropdown toggles
    $('.dropdown-toggle').on('click', function(e) {
        if ($(window).width() <= 767) {
            e.preventDefault();
            var target = $(this).data('dropdown');
            $('#' + target).toggleClass('mobile-dropdown-active');
            $(this).parent().toggleClass('mobile-dropdown-open');
        }
    });

    // Close mobile menu when clicking overlay
    $('#mobile-menu-overlay').on('click', function() {
        $('#main-menu').removeClass('mobile-menu-active');
        $('#mobile-menu-overlay').removeClass('active');
        $('#mobile-menu-toggle').removeClass('menu-open');
        $('body').removeClass('menu-open');
    });

    // Close mobile menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.myui-header__menu, .mobile-menu-toggle').length) {
            $('#main-menu').removeClass('mobile-menu-active');
            $('#mobile-menu-overlay').removeClass('active');
            $('#mobile-menu-toggle').removeClass('menu-open');
            $('body').removeClass('menu-open');
        }
    });

    $.ajaxSetup({
        headers: {
            'csrftoken': '{{ csrf_token() }}'
        }
    });
</script>
