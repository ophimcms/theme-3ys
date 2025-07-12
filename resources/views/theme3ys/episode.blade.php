@extends('themes::theme3ys.layout')
@php
    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, [
                    'Phim hot',
                    '',
                    'type',
                    'series',
                    'view_total',
                    'desc',
                    4,
                    'top_thumb',
                ]);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use (
                            $relation,
                            $field,
                            $val
                        ) {
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
    <div class="visible-xs col-pd" style="padding: 0px;height: 100%;overflow: hidden;">
    </div>
    <div class="myui-player clearfix" style="background-color: #191a20;">
        <div class="container">
            <div class="row">
                <div class="myui-player__item clearfix" style="background-color: #24252B;">
                    <div class="col-lg-wide-75 col-md-wide-65 clearfix padding-0 relative" id="player-left">
                        <div class="myui-player__box player-fixed">
                            <a class="player-fixed-off" href="javascript:" style="display: none;">
                                <i class="fa fa-close"></i></a>
                            <div class="embed-responsive clearfix" id="player-wrapper">

                            </div>
                        </div>
                        <style type="text/css">
                            .embed-responsive {
                                padding-bottom: 56.25%;
                            }
                        </style>
                        <a class="is-btn hidden-sm hidden-xs" id="player-sidebar-is" href="javascript:"><i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="col-lg-wide-25 col-md-wide-35 padding-0" id="player-sidebar">
                        <div class="video-info-aux">
                            @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                                <a onclick="chooseStreamingServer(this)" data-type="{{ $server->type }}" id="streaming-sv"
                                    data-id="{{ $server->id }}" data-link="{{ $server->link }}"
                                    class="streaming-server tag-link" style="background: #232328;color: #FFF">
                                    Nguồn #{{ $loop->index + 1 }}
                                </a>
                            @endforeach
                        </div>
                        <div class="myui-panel active clearfix">
                            <div class="myui-panel-box clearfix">
                                <div class="col-pd clearfix">
                                    <div class="myui-panel__head active clearfix">
                                        <h3 class="title text-fff">Danh sách</h3>
                                    </div>
                                    <div class="text-muted">
                                        <ul class="nav nav-tabs pull-right">
                                            <li class="dropdown pb10 margin-0">
                                                <a href="javascript:" class="padding-0 text-fff" data-toggle="dropdown">Chọn
                                                    Server <i class="fa fa-angle-down"></i></a>
                                                <div class="dropdown-box bottom">
                                                    <ul class="item">
                                                        @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                                                            <li @if ($episode->server == $server) class="active" @endif><a
                                                                    href="#player{{ $server }}"
                                                                    data-toggle="tab">{{ $server }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                            <a class="more sort-button pull-right" style="margin-left: 10px;"
                                                href="javascript:"><i class="fa fa-sort-amount-asc"></i> Sắp xếp</a>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                                            <div id="player{{ $server }}"
                                                class="tab-pane fade in clearfix @if ($episode->server == $server) active @endif">
                                                <ul class="myui-content__list sort-list clearfix" id="playlist">
                                                    @foreach ($data->sortBy('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                                                        <li class="col-md-2 col-sm-5 col-xs-3">
                                                            <a class="btn btn-min @if ($item->contains($episode)) btn-warm @else btn-gray @endif "
                                                                href="{{ $item->sortByDesc('type')->first()->getUrl() }}">
                                                                {{ $name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="myui-player__data clearfix">
                    <h3>
                        <a class="text-fff" href="{{ $currentMovie->getUrl() }}">{{ $currentMovie->name }}</a>
                        <small class="text-muted"> - Tập {{ $episode->name }}</small>
                    </h3>
                    <p class="text-muted margin-0">
                        {{ $currentMovie->origin_name }} / {{ $currentMovie->publish_year }} /
                        {{ $currentMovie->language }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-wide-75 col-md-wide-7 col-xs-1 padding-0">
                @if ($currentMovie->notify || $currentMovie->showtimes)
                    <div class="myui-panel myui-panel-bg clearfix">
                        <div class="myui-panel-box clearfix">
                            <div class="myui-panel_bd">
                                @if ($currentMovie->showtimes)
                                    <p><strong>Lịch chiếu : </strong> {{ $currentMovie->showtimes }}</p>
                                @endif
                                @if ($currentMovie->notify)
                                    <p><strong>Thông báo : </strong> {{ $currentMovie->notify }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <div class="myui-panel myui-panel-bg clearfix" id="desc">
                    <div class="myui-panel-box clearfix">
                        <div class="myui-panel_hd">
                            <div class="myui-panel__head active bottom-line clearfix">
                                <h3 class="title">
                                    Tóm tắt
                                </h3>
                            </div>
                        </div>
                        <div class="myui-panel_bd">
                            <div class="col-pd text-collapse content">
                                <p><span class="text-muted">Đạo diễn：</span>{!! $currentMovie->directors->map(function ($director) {
                                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                                    })->implode(', ') !!} </p>
                                <p><span class="text-muted">Diễn viên：</span>{!! $currentMovie->actors->map(function ($director) {
                                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                                    })->implode(', ') !!} </p>
                                {!! strip_tags($currentMovie->content) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="myui-panel myui-panel-bg clearfix" >
                    <div class="myui-panel-box clearfix">
                        <div class="myui-panel_hd">
                            <div class="myui-panel__head active bottom-line clearfix">
                                <h3 class="title">
                                    Bình luận
                                </h3>
                            </div>
                        </div>
                        <div class="myui-panel_bd">
                            <div class="col-pd text-collapse content">
                                <div style="width: 100%; background-color: #fff">
                                    <div class="fb-comments w-full" data-href="{{ $currentMovie->getUrl() }}"
                                         data-width="100%"
                                         data-numposts="5" data-colorscheme="light" data-lazy="true">
                                    </div>
                                </div>
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
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/themes/3ys/plugins/jquery-raty/jquery.raty.js') }}"></script>
    <link href="{{ asset('/themes/3ys/plugins/jquery-raty/jquery.raty.css') }}" rel="stylesheet" type="text/css" />
    <script>
        var rated = false;
        $('#movies-rating-star').raty({
            score: {{ $currentMovie->getRatingStar() }},
            number: 10,
            numberMax: 10,
            hints: ['quá tệ', 'tệ', 'không hay', 'không hay lắm', 'bình thường', 'xem được', 'có vẻ hay', 'hay',
                'rất hay', 'siêu phẩm'
            ],
            starOff: '{{ asset('/themes/3ys/plugins/jquery-raty/images/star-off.png') }}',
            starOn: '{{ asset('/themes/3ys/plugins/jquery-raty/images/star-on.png') }}',
            starHalf: '{{ asset('/themes/3ys/plugins/jquery-raty/images/star-half.png') }}',
            click: function(score, evt) {
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

    <script src="/themes/3ys/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/3ys/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        var episode_id = {{ $episode->id }};
        const wrapper = document.getElementById('player-wrapper');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;


            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('active-server');
            })
            el.classList.add('active-server');

            link.replace('http://', 'https://');
            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/vung/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    image: "{{ $currentMovie->getPosterUrl() }}",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }


                const resumeData = 'OPCMS-PlayerPosition-' + id;
                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{ $episode->id }}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
