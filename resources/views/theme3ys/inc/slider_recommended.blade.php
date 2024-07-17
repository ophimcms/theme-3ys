<script type="text/javascript">
    MyTheme.Other.Headroom();
</script>
<script type="text/javascript" src="{{ asset('/themes/3ys/js/js-slide.js') }}"></script>
<div class="mt10 wrap myui-panel hidden-xs">
    <div class="gray">
        <div class="qy20-h-carousel__inner">
            <ul class="list">
                @foreach ($home_page_slider_poster['data'] as $key=> $movie)
                <li class="sitem show">
                    <a title="{{$movie->name}}" href="{{$movie->getUrl()}}">
                        <img src="{{$movie->getPosterUrl()}}">
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <ul class="pointList">
            @foreach ($home_page_slider_poster['data'] as $key=> $movie)
            <li class="point show" data-index="{{$key++}}">
                <a title="{{$movie->name}}" href="{{$movie->getUrl()}}">
                    <h3>{{$movie->name}}</h3>
                    <p>{{$movie->origin_name}}</p>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="swiper mySwiper visible-xs">
    <div class="swiper-wrapper">
        @foreach ($home_page_slider_poster['data'] as $movie)
        <div class="swiper-slide"><a href="{{$movie->getUrl()}}" target="_blank"><img
                    src="{{$movie->getPosterUrl()}}"></a></div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
</div>
<script>
    var swiper = new Swiper(".mySwiper", {
        autoplay: {
            disableOnInteraction: false,
        },
        loop: true,
        pagination: {
            el: ".swiper-pagination",
        },
    });
</script>
