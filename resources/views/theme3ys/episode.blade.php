@extends('themes::theme3ys.layout')
@section('content')
    <script>
        var body = document.body;
        body.classList.add("view");
        body.classList.add("play");
    </script>
    <style>.scroll-content li {
            display: inline
        }

        .sort-item li {
            display: inline
        }

        .playon {
        }

        .playon a {
            color: #FF8C00 !important;
            background: #000 !important
        }

        .fsxoyo {
            width: 100%;
            padding-bottom: 56.25%;
            height: 0;
            position: relative
        }

        .wupanzhi {
            width: 100%;
            height: 100%;
            background-color: black;
            position: absolute
        }

        .active-server {
            background: #FFF !important;
            color: #0a0d0e !important;
        }

        .playactive {
            color: #FFF !important;
            background: #c92626 !important;
        }

        #streaming-sv {
            cursor: pointer !important;
        }
    </style>
    <main id="main" class="wrapper">
        <div class="player-block">
            <div class="content">
                <div class="player-box">
                    <div class="player-box-main">
                        @if ($currentMovie->notify || $currentMovie->showtimes)
                            <div class="tips-box">
                                <span class="close-btn"><i class="icon-close-o"></i></span>
                                <ul class="tips-list">
                                    <li>@if ($currentMovie->showtimes)
                                            Lịch chiếu : {!! $currentMovie->showtimes !!}
                                        @endif
                                        |
                                        @if ($currentMovie->notify )
                                            Thông báo : {{ strip_tags($currentMovie->notify) }}
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        @endif
                        <div class="fsxoyo">
                            <div class="wupanzhi" id="player-wrapper">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="player-info">
                    <div class="video-info">
                        <div class="video-info-box">
                            <div class="video-info-header"><h1 class="page-title"><a
                                            href="{{ $currentMovie->getUrl() }}"
                                            title="{{ $currentMovie->name }}">{{ $currentMovie->name }} </a>-
                                    Tập {{ $episode->name }}
                                </h1><span
                                        class="btn-pc page-title"></span>
                                <div class="video-info-aux">
                                    @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                                        <a onclick="chooseStreamingServer(this)" data-type="{{ $server->type }}"
                                           id="streaming-sv" data-id="{{ $server->id }}"
                                           data-link="{{ $server->link }}" class="streaming-server tag-link"
                                           style="background: #232328;color: #FFF">
                                            Nguồn #{{ $loop->index + 1 }}
                                        </a>
                                    @endforeach


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="player-box-side">
                    <div class="module-heading"><h2 class="module-title">Tập phim</h2>
                        <div class="module-tab module-player-tab player-side-tab">
                            <input type="hidden" name="tab" id="tab"
                                   class="module-tab-input">
                            <label
                                    class="module-tab-name"><span class="module-tab-value">Server</span><i
                                        class="icon-arrow-bottom-o"></i></label>
                            <div class="module-tab-items">
                                <div class="module-tab-title">Chọn<span class="close-drop"><i
                                                class="icon-close-o"></i></span></div>
                                <div class="module-tab-content">
                                    @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                                        <a class="module-tab-item tab-item @if ($episode->server == $server) selected @endif">
                                            <span
                                                    data-dropdown-value="{{ $server }}">{{ $server }}</span><small></small>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="shortcuts-mobile-overlay"></div>
                    </div>

                    @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
                        <div
                                class="module-list module-player-list tab-list sort-list player-side-playlist @if ($episode->server == $server) selected @endif"
                                itemscope="" itemprop="episode" itemtype="http://schema.org/Episode">
                            <div class="module-tab module-sorttab"><input type="hidden" name="tab-sort" id="tab-sort"
                                                                          class="module-tab-input"><label
                                        class="module-tab-name"><i class="icon-sort"></i></label>
                                <div class="module-tab-items">
                                    <div class="module-tab-title">{{ $server }}<span class="close-drop"><i
                                                    class="icon-close-o"></i></span></div>
                                    <div class="module-tab-content">
                                        <div class="module-blocklist">
                                            <div class="sort-item">
                                                @foreach ($data->sortBy('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                                                    <li><a class="@if ($item->contains($episode)) playactive @endif"
                                                           href="{{ $item->sortByDesc('type')->first()->getUrl() }}">
                                                            {{ $name }}</a></li>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="shortcuts-mobile-overlay"></div>
                            <div class="module-blocklist scroll-box scroll-box-y">
                                <div class="scroll-content">
                                    @foreach ($data->sortBy('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                                        <li><a class="@if ($item->contains($episode)) playactive @endif"
                                               href="{{ $item->sortByDesc('type')->first()->getUrl() }}">
                                                {{ $name }}</a></li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="content">

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
                    <div class="module-heading"><h2 class="module-title" title="">Bình luận</h2>
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
@endsection

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

    <script src="/themes/dy/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/dy/player/js/p2p-media-loader-hlsjs.min.js"></script>

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
                    fake_player.on('complete', function (event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function (event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function (event) {
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
                player.on('ready', function () {
                    if (typeof (Storage) !== 'undefined') {
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
                        player.once('play', function () {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function () {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function () {
                    if (typeof (Storage) !== 'undefined') {
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
        document.addEventListener("DOMContentLoaded", function () {
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
