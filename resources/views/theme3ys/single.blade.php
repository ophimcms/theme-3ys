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
@endphp

@section('content')
    <script>
        var body = document.body;
        body.classList.add("view");
        body.classList.add("page");
    </script>

    <main id="main" class="wrapper">
        <div class="content">
            @if ($currentMovie->notify || $currentMovie->showtimes)
                <div class="box view-heading">
                    @if ($currentMovie->showtimes)
                        <p><strong>Lịch chiếu : </strong> {{$currentMovie->showtimes}}</p>
                    @endif
                    @if ($currentMovie->notify )
                        <p><strong>Thông báo : </strong> {{$currentMovie->notify}}</p>
                    @endif
                </div>
            @endif
            <div class="box view-heading">
                <div class="mobile-play">
                    <div class="module-item-cover">
                        <div class="module-item-pic"><img class="lazyload"
                                                          data-src="{{ $currentMovie->getThumbUrl() }}"
                                                          src="{{ asset('/themes/dy/templets/image/loading.gif') }}">
                        </div>
                    </div>
                </div>
                <div class="video-cover">
                    <div class="module-item-cover">
                        <div class="module-item-pic"><a href="{{ $watch_url }}"
                                                        title="Xem phim {{ $currentMovie->name }}"><i
                                        class="icon-play"></i></a><img class="lazyload" alt="{{ $currentMovie->name }}"
                                                                       data-src="{{ $currentMovie->getThumbUrl() }}"
                                                                       src="{{ asset('/themes/dy/templets/image/loading.gif') }}">
                            <div class="loading"></div>
                        </div>
                    </div>
                </div>

                <div class="video-info">
                    <div class="video-info-header">
                        <h1 class="page-title">{{ $currentMovie->name }}</h1>
                        <h2 class="video-subtitle">{{ $currentMovie->originName }}</h2>

                        <div class="video-info-aux">
                            <div class="tag-link">{{ $currentMovie->publish_year }}
                            </div>
                            {!! $currentMovie->regions->map(function ($region) {
                        return '<div class="tag-link"><a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a> </div>';
                    })->implode('') !!}
                        </div>
                        <a href="{{ $watch_url }}" class="btn-important btn-large shadow-drop video-info-play"
                           title="Xem phim {{ $currentMovie->name }}"><i class="icon-play"></i><strong>Xem phim</strong></a>
                        @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
                            @php
                                parse_str( parse_url( $currentMovie->trailer_url, PHP_URL_QUERY ), $my_array_of_vars );
                                $video_id = $my_array_of_vars['v'] ?? null;
                            @endphp
                            <a href="https://www.youtube.com/embed/{{$video_id}}" data-preload="false"
                               class="btn-important btn-large shadow-drop video-info-play fancybox fancybox.iframe"
                               title="{{ $currentMovie->name }}"><i class="icon-play"></i><strong>Trailer</strong></a>
                        @endif

                    </div>
                    <div class="video-info-main">
                        <div class="video-info-items"><span class="video-info-itemtitle" style="min-width: 100px;">Đạo diễn：</span>
                            <div class="video-info-item video-info-actor"><span class="slash">/</span> {!! $currentMovie->directors->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!}
                            </div>
                        </div>
                        <div class="video-info-items"><span class="video-info-itemtitle" style="min-width: 100px;">Diễn viên：</span>
                            <div class="video-info-item video-info-actor"><span class="slash">/</span>{!! $currentMovie->actors->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!}
                            </div>
                        </div>
                        <div class="video-info-items"><span class="video-info-itemtitle">Trạng thái：</span>
                            <div class="video-info-item"> {{$currentMovie->getStatus()}}
                                | {{$currentMovie->episode_current}} | {{$currentMovie->episode_total}} </div>
                        </div>
                        <div class="video-info-items"><span class="video-info-itemtitle">Thời lượng：</span>
                            <div class="video-info-item">{{$currentMovie->episode_time}}</div>
                        </div>
                        <div class="video-info-items"><span class="video-info-itemtitle">Ngôn ngữ：</span>
                            <div class="video-info-item">{{ $currentMovie->language }} {{ $currentMovie->quality }}</div>
                        </div>
                        <div class="video-info-items"><span class="video-info-itemtitle"
                                                            style="width: 100px;">Nội dung：</span>
                            <div class="video-info-item video-info-content">   @if ($currentMovie->content)
                                    {!! strip_tags($currentMovie->content) !!}
                                @endif</div>
                        </div>
                        <p>{!! $currentMovie->tags->map(function ($tag) {
                        return '<a href="' . $tag->getUrl() . '" title="' . $tag->name . '">' . $tag->name . '</a>';
                    })->implode(', ') !!}</p>
                    </div>

                    <div class="video-info-footer display">
                        <a href="{{ $watch_url }}" class="btn-important btn-large shadow-drop"
                           title="{{ $currentMovie->name }}"><i class="icon-play"></i><strong>Xem phim</strong></a>
                        @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
                            @php
                                parse_str( parse_url( $currentMovie->trailer_url, PHP_URL_QUERY ), $my_array_of_vars );
                                $video_id = $my_array_of_vars['v'] ?? null;
                            @endphp
                            <a href="https://www.youtube.com/embed/{{$video_id}}" data-preload="false"
                               class="btn-important btn-large shadow-drop fancybox fancybox.iframe"
                               title="{{ $currentMovie->name }}"><i class="icon-play"></i><strong>Trailer</strong></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="module module-wrapper">
                <div class="module-main">
                    <div class="rating-content">
                        <div id="movies-rating-star" style="height: 18px;"></div>
                        <div>
                            ({{$currentMovie->getRatingStar()}}
                            sao
                            /
                            {{$currentMovie->getRatingCount()}} đánh giá)
                        </div>
                        <div id="movies-rating-msg"></div>
                    </div>
                </div>
            </div>

            <div class="module module-wrapper">
                <div class="module-main">
                    <div class="module-heading"><h2 class="module-title" title="Có thể bạn thích">Bình luận</h2>
                    </div>
                    <div class="module-list module-lines-list">
                        <div style="width: 100%; background-color: #fff">
                            <div class="fb-comments w-full" data-href="{{ $currentMovie->getUrl() }}" data-width="100%"
                                 data-numposts="5" data-colorscheme="light" data-lazy="true">
                            </div>
                        </div>
                    </div>
                    <div class="module-heading" style="margin-top: 10px"><h2 class="module-title"
                                                                             title="Có thể bạn thích">Có thể bạn
                            thích</h2>
                    </div>

                    <div class="module-list module-lines-list">
                        <div class="module-items">
                            @foreach ($movie_related as $movie)
                                @include('themes::theme3ys.inc.section.movie_card')
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="module-side">
                    <div class="module-heading"><h2 class="module-title">Xem nhiều</h2></div>
                    <div class="module-side-list module-bg">
                        <div class="scroll-box">
                            <div class="module-textlist scroll-content">
                                @php
                                    $key = 0;
                                @endphp
                                @foreach ($movie_related_top as $movie)
                                    @php
                                        $key++;
                                    switch ($key) {
                                        case 1:
                                            $class_top = 'top-1';
                                            break;
                                        case 2:
                                            $class_top = 'top-2';
                                            break;
                                        case 3:
                                            $class_top = 'top-3';
                                            break;
                                        default:
                                            $class_top = '';
                                            break;
                                            }
                                    @endphp
                                    <a href="{{$movie->getUrl()}}"
                                       class="text-list-item">
                                        <div class="text-list-num top-main <?= $class_top ?>"><?= $key ?></div>
                                        <div class="text-list-title"><h3>{{$movie->name}}</h3>
                                            <p>Lượt xem : {{$movie->view_total}}</p></div>
                                    </a>
                                @endforeach


                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </main>



    @push('scripts')
        <script src="{{ asset('/themes/dy/plugins/jquery-raty/jquery.raty.js') }}"></script>
        <link href="{{ asset('/themes/dy/plugins/jquery-raty/jquery.raty.css') }}" rel="stylesheet" type="text/css"/>
        <script>
            var rated = false;
            $('#movies-rating-star').raty({
                score: {{$currentMovie->getRatingStar()}},
                number: 10,
                numberMax: 10,
                hints: ['quá tệ', 'tệ', 'không hay', 'không hay lắm', 'bình thường', 'xem được', 'có vẻ hay', 'hay',
                    'rất hay', 'siêu phẩm'
                ],
                starOff: '{{ asset('/themes/dy/plugins/jquery-raty/images/star-off.png') }}',
                starOn: '{{ asset('/themes/dy/plugins/jquery-raty/images/star-on.png') }}',
                starHalf: '{{ asset('/themes/dy/plugins/jquery-raty/images/star-half.png') }}',
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
        <script src="{{ asset('/themes/dy/source/jquery.fancybox.pack.js?v=2.1.5') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('/themes/dy/source/jquery.fancybox.css?v=2.1.5') }}"
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

