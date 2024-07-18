<div class="myui-panel myui-panel-bg clearfix">
    <div class="myui-panel-box clearfix">
        <div class="myui-panel_hd">
            <div class="myui-panel__head active bottom-line clearfix">
                <h3 class="title">
                    {{ $top['label'] }}
                </h3>
            </div>
        </div>
        <div class="myui-panel_bd clearfix">
            <ul class="myui-newslist__text clearfix">
                @foreach ($top['data'] as $key => $movie)
                <li class="col-md-1 col-sm-1 col-xs-1">
                    <span>{{ $key + 1 }}. </span><a href="{{ $movie->getUrl() }}"
                                                target="_blank" rel="nofollow">{{ $movie->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
