@extends('themes::theme3ys.layout')

@php
    $years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
        return \Ophim\Core\Models\Movie::select('publish_year')
            ->distinct()
            ->pluck('publish_year')
            ->sortDesc();
    });
@endphp

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row">
            <div class="myui-panel active myui-panel-bg2 clearfix">
                <div class="myui-panel-box clearfix">
                    <div class="myui-panel_hd">
                        <div class="myui-panel__head active bottom-line clearfix">
                            <a class="slideDown-btn more pull-right" href="javascript:">Rút gọn <i class="fa fa-angle-up"></i></a>
                            <h3 class="title">{{ $section_name ?? 'Danh Sách Phim' }}</h3>

                        </div>
                    </div>
                    @include('themes::theme3ys.inc.catalog_filter')
                </div>
            </div>

            <div class="myui-panel myui-panel-bg clearfix">
                <div class="myui-panel-box clearfix">
                    <div class="myui-panel_bd">
                        <ul class="myui-vodlist clearfix">
                                @if (count($data))
                                    @foreach ($data as $movie)
                                        <li class="col-lg-7 col-md-6 col-sm-4 col-xs-3">
                                        @include('themes::theme3ys.inc.section.movie_card')
                                        </li>
                                    @endforeach
                                @else
                                    <p class="text-danger">Không có dữ liệu cho mục này</p>
                                @endif
                        </ul>
                    </div>
                </div>
            </div>
            {{ $data->appends(request()->all())->links("themes::Theme3ys.inc.pagination") }}

        </div>
    </div>


@endsection
