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
                <ul class="myui-header__menu nav-menu">
                    @foreach ($menu as $item)
                        @if (count($item['children']))
                            <li class="dropdown-hover">
                                <a href="javascript:">{{$item['name']}} <i class="fa fa-angle-down"></i></a>
                                <div class="dropdown-box bottom fadeInDown clearfix">
                                    <ul class="item nav-list clearfix">
                                        @foreach ($item['children'] as $children)
                                            <li class="col-lg-5 col-md-5 col-sm-5 col-xs-3"><a
                                                    class="btn btn-sm btn-block btn-warm"
                                                    href="{{$children['link']}}">{{$children['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @else
                            <li class="hidden-sm hidden-xs"><a href="{{$item['link']}}">{{$item['name']}}</a></li>
                        @endif
                    @endforeach
                </ul>
                <div class="myui-header__search search-box">
                    <form id="" name="search" method="get" action="/">
                        <input type="text" id="search" name="search" class="search_wd form-control"
                               value="{{ request('search') }}"
                               placeholder="Tìm kiếm"
                               autocomplete="off" style=" padding-left: 12px; ">
                        <button class="submit search_submit" id="searchbutton" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                    <a class="search-close visible-xs" href="javascript:"><i class="fa fa-close"></i></a>

                    <div class="" id="result"></div>
                </div>
            </div>
        </div>
    </div>
</header>
<script type="text/javascript">
    $('#search').on('keyup', function () {
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
            success: function (data) {
                $("#result").html('')
                $.each(data, function (key, value) {
                    $('#result').append('<a href="' + value.slug + '"><div class="rowsearch"> <div class="column left"> <img src="' + value.image + '" width="50" /> </div> <div class="column right"><p> ' + value.title + ' ' + '</p><p> ' + value.original_title + '| ' + value.year + ' </p></div> </div></a>')
                });
            }
        });
    })
    document.body.addEventListener("click", function (event) {
        $("#result").html('');
    });
    $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});
</script>
