<div class="myui-panel myui-panel-bg clearfix">
    <div class="myui-panel-box clearfix">
        <div class="myui-panel_hd">
            <div class="myui-panel__head clearfix">
                <h3 class="title">{{ $top['label'] }}</h3>
            </div>
        </div>
        <div class="myui-panel_bd">
            <ul class="myui-vodlist__text col-pd clearfix">
                @foreach ($top['data'] as $key => $movie)
                @php
                    switch ($key +1 ) {
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
                        <span class="pull-right  text-muted"> {{$movie->publish_year}}</span>		<span class="badge {{$class_top}}">{{$key +1}}</span>{{$movie->name}}	</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
