<div class="myui-vodlist__box">
    <a class="myui-vodlist__thumb lazyload" href="{{$movie->getUrl()}}" title="{{$movie->name}}"
       data-original="{{$movie->getThumbUrl()}}">
        <span class="play hidden-xs"></span>
        <span class="pic-text text-right">{{$movie->episode_current}}</a>
    <div class="myui-vodlist__detail">
        <h4 class="title text-overflow"><a href="{{$movie->getUrl()}}"
                                           title="{{$movie->name}}">{{$movie->name}}</a></h4>
        <p class="text text-overflow text-muted hidden-xs">{{ $movie->origin_name }}</p></div>
</div>
