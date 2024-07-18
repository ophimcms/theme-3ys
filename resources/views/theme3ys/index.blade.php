@extends('themes::theme3ys.layout')

@php
    use Ophim\Core\Models\Movie;

    $home_page_slider_poster = Cache::remember('site.movies.home_page_slider_poster', setting('site_cache_ttl', 5 * 60), function () {
        $list = get_theme_option('home_page_slider_poster');
		$data = null;
        if(trim($list)) {
			$list = explode('|', $list);
            [$label, $relation, $field, $val, $sortKey, $alg, $limit] = array_merge($list, ['Phim đề cử', '', 'is_recommended', '1', 'updated_at', 'desc', 10]);
            try {
                $data = [
                    'label' => $label,
                    'data' => Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                            $rel->where($field, $val);
                        });
                    })
                    ->when(!$relation, function ($query) use ($field, $val) {
                        $query->where($field, $val);
                    })
                    ->orderBy($sortKey, $alg)
                    ->limit($limit)
                    ->get()
                ];
            } catch (\Exception $e) {
            }
        }
		return $data;
    });

       $data = Cache::remember('site.movies.latest', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('latest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $link, $show_template] = array_merge($list, ['Phim mới cập nhật', '', '', 'type', 'series', 'created_at', 'desc', 8, '/', 'section_thumb']);
                try {
                    $data[] = [
                        'label' => $label,
                        'show_template' => $show_template,
                        'data' => Movie::when($relation, function ($query) use ($relation, $field, $val) {
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
                        'topview' => Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy('view_total', 'desc')
                            ->limit(20)
                            ->get(),
                        'link' => $link ?: '#',
                    ];
                } catch (\Exception $e) {
                }
            }
        }
        return $data;
    });
@endphp
@section('slider_recommended')
    @if(count($home_page_slider_poster['data']))
        @include('themes::theme3ys.inc.slider_recommended')
    @endif
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @foreach($data as $item)
                @include("themes::theme3ys.inc.section." . $item["show_template"])
            @endforeach
        </div>
    </div>
@endsection
