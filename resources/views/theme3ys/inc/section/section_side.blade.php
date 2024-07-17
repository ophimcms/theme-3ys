<div class="myui-panel myui-panel-bg clearfix">
    <div class="myui-panel-box clearfix">
        <div class="myui-panel_bd clearfix">
            <div class="col-lg-wide-75 col-md-wide-75 col-xs-1 padding-0">
                <div class="myui-panel_hd">
                    <div class="myui-panel__head clearfix">
                        <h3 class="title">{{$item['label']}}</h3>
                        @if($item['link'])
                        <a class="more text-muted" href="{{$item['link']}}">
                            Xem thêm
                            <i class="fa fa-angle-right"></i>
                        </a>
                        @endif
                    </div>
                </div>
                <ul class="myui-vodlist clearfix">
                        @foreach ($item['data'] as $movie)
                            <li class="col-lg-5 col-md-6 col-sm-4 col-xs-3">
                            @include('themes::theme3ys.inc.section.movie_card')
                            </li>
                        @endforeach
                </ul>
            </div>
            <div class="col-lg-wide-25 col-md-wide-25 hidden-sm hidden-xs">
                <div class="myui-panel_hd">
                    <div class="myui-panel__head clearfix">
                        <h3 class="title">Top view</h3>
                    </div>
                </div>
                <ul class="myui-vodlist__text active clearfix" style="padding: 0 10px;">
                        @php $key =0; @endphp
                        @foreach ($item['topview'] as $movie)
                            @php
                                $key++;
                            switch ($key) {
                                case 1:
                                    $class_top = 'badge-first';
                                    break;
                                case 2:
                                    $class_top = 'badge-second';
                                    break;
                                case 3:
                                    $class_top = 'badge-third';
                                    break;
                                default:
                                    $class_top = '';
                                    break;
                            }
                            @endphp
                            <li>
                                <a href="{{$movie->getUrl()}}" title="{{$movie->name}}">
                                    <span class="pull-right  text-muted"> {{ $movie->quality }}</span>		<span class="badge {{$class_top}}">{{$key}}</span>{{$movie->name}}	</a>
                            </li>
                        @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
