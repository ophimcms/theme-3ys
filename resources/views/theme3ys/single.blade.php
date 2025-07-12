@extends('themes::theme3ys.layout')
@php
    $watch_url = '';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watch_url = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
     $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4, 'top_thumb']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }

        return $data;
    });
@endphp
@section('content')
<div class="container" style="margin-top: 10px">
    <div class="row">
        <div class="col-lg-wide-75 col-md-wide-7 col-xs-1 padding-0">
            @if ($currentMovie->notify || $currentMovie->showtimes)
            <div class="myui-panel myui-panel-bg clearfix">
                <div class="myui-panel-box clearfix">
                    <div class="myui-panel_bd">
                        @if ($currentMovie->showtimes)
                            <p><strong>Lịch chiếu : </strong> {{$currentMovie->showtimes}}</p>
                        @endif
                        @if ($currentMovie->notify )
                            <p><strong>Thông báo : </strong> {{$currentMovie->notify}}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            <div class="myui-panel myui-panel-bg clearfix">
                <div class="myui-panel-box clearfix">
                    <div class="col-xs-1">
                        <span class="text-muted">Trang chủ：</span>
                        <a href="">Phim</a> <i class="fa fa-angle-right text-muted"></i>
                        <span class="text-muted">{{ $currentMovie->name }}</span>
                    </div>
                    <div class="col-xs-1">
                        <div class="myui-content__thumb">
                            <a class="myui-vodlist__thumb picture" href="{{ $watch_url }}" title="{{ $currentMovie->name }}">
                                <img class="lazyload" src="{{ asset('/themes/3ys/images/20230123/6dad92d2f.png') }}"
                                     data-original="{{ $currentMovie->getThumbUrl() }}">
                                <span class="play hidden-xs"></span>
                            </a>
                        </div>
                        <div class="myui-content__detail">
                            <h1 class="title">{{ $currentMovie->name }} <span class="year">({{ $currentMovie->publish_year }})</span></h1>
                            <p class="otherbox">{{ $currentMovie->language }} {{ $currentMovie->quality }}</p>
                            <p class="data"><span class="text-muted">Đạo diễn：</span>{!! $currentMovie->directors->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!}</p>
                            <p class="data"><span class="text-muted">Diễn viên：</span>{!! $currentMovie->actors->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!} </p>
                            <p class="data"><span class="text-muted">Quốc gia ：</span>{!! $currentMovie->regions->map(function ($region) {
                        return '<div class="tag-link"><a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a> </div>';
                    })->implode('') !!}</p>
                            <p class="data"><span class="text-muted">Trạng thái ：</span> {{$currentMovie->getStatus()}}  </p>
                            <p class="data"><span class="text-muted">Thời lượng ：</span>{{$currentMovie->episode_time}} | {{$currentMovie->episode_current}}
                                | {{$currentMovie->episode_total}}</p>
                            <p class="data hidden-xs"><span class="text-muted">Tag：{!! $currentMovie->tags->map(function ($tag) {
                        return '<a href="' . $tag->getUrl() . '" title="' . $tag->name . '">' . $tag->name . '</a>';
                    })->implode(', ') !!}</span> </p>
                            <p class="data hidden-xs"><span class="text-muted">Đánh giá：</span>
                            <div class="rating-content">
                                <div id="movies-rating-star"></div>
                                <div>
                                    ({{$currentMovie->getRatingStar()}}
                                    sao
                                    /
                                    {{$currentMovie->getRatingCount()}} đánh giá)
                                </div>
                                <div id="movies-rating-msg"></div>
                            </div>
                            </p>
                        </div>
                        <div class="myui-content__operate" style="padding-left: 0;">
                            @if($watch_url)
                            <a class="btn btn-warm" href="{{ $watch_url }}"><i class="fa fa-play"></i>Xem Phim</a>
                            @endif
                                @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
                                    @php
                                        parse_str( parse_url( $currentMovie->trailer_url, PHP_URL_QUERY ), $my_array_of_vars );
                                        $video_id = $my_array_of_vars['v'] ?? null;
                                    @endphp
                                    <a class="btn btn-warm fancybox fancybox.iframe" href="https://www.youtube.com/embed/{{$video_id}}"><i class="fa fa-play"></i>Trailer</a>
                                @endif


                        </div>
                    </div>
                </div>
            </div>

            <div class="myui-panel myui-panel-bg clearfix" id="desc">
                <div class="myui-panel-box clearfix">
                    <div class="myui-panel_hd">
                        <div class="myui-panel__head active bottom-line clearfix">
                            <h3 class="title">
                                Nội dung
                            </h3>
                        </div>
                    </div>
                    <div class="myui-panel_bd">
                        <div class="col-pd text-collapse content">
                            {!! strip_tags($currentMovie->content) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="myui-panel myui-panel-bg clearfix">
                <div class="myui-panel-box clearfix">
                    <div class="myui-panel_hd">
                        <div class="myui-panel__head active bottom-line clearfix">
                            <h3 class="title">Có thể bạn thích </h3>
                        </div>
                    </div>
                    <div class="tab-content myui-panel_bd">
                        <ul id="type" class="myui-vodlist__bd tab-pane fade in active clearfix">
                                @foreach ($movie_related as $movie)
                                    <li class="col-lg-6 col-md-6 col-sm-4 col-xs-3">
                                    @include('themes::theme3ys.inc.section.movie_card')
                                    </li>
                                @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-wide-25 col-md-wide-3 col-xs-1 myui-sidebar hidden-sm hidden-xs">
            @foreach ($tops as $top)
                @include('themes::theme3ys.inc.sidebar.' . $top['template'])
            @endforeach
        </div>

    </div>


    @push('scripts')
        <script src="{{ asset('/themes/3ys/plugins/jquery-raty/jquery.raty.js') }}"></script>
        <link href="{{ asset('/themes/3ys/plugins/jquery-raty/jquery.raty.css') }}" rel="stylesheet" type="text/css"/>
        <script>
            var rated = false;
            $('#movies-rating-star').raty({
                score: {{$currentMovie->getRatingStar()}},
                number: 10,
                numberMax: 10,
                hints: ['quá tệ', 'tệ', 'không hay', 'không hay lắm', 'bình thường', 'xem được', 'có vẻ hay', 'hay',
                    'rất hay', 'siêu phẩm'
                ],
                starOff: '{{ asset('/themes/3ys/plugins/jquery-raty/images/star-off.png') }}',
                starOn: '{{ asset('/themes/3ys/plugins/jquery-raty/images/star-on.png') }}',
                starHalf: '{{ asset('/themes/3ys/plugins/jquery-raty/images/star-half.png') }}',
                click: function (score, evt) {
                    if (rated) return
                    fetch("{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]')
                                .getAttribute(
                                    'content')
                        },
                        body: JSON.stringify({
                            rating: score
                        })
                    });
                    rated = true;
                    $('#movies-rating-star').data('raty').readOnly(true);
                    $('#movies-rating-msg').html(`Bạn đã đánh giá ${score} sao cho phim này!`);
                }
            });
        </script>
        <script src="{{ asset('/themes/3ys/source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('/themes/3ys/source/jquery.fancybox.css?v=2.1.5') }}"
              media="screen"/>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".fancybox").fancybox({
                    maxWidth: 800,
                    maxHeight: 600,
                    fitToView: false,
                    width: '70%',
                    height: '70%',
                    autoSize: false,
                    closeClick: false,
                    openEffect: 'none',
                    closeEffect: 'none'
                });
            });
        </script>

        {!! setting('site_scripts_facebook_sdk') !!}
    @endpush

@endsection

