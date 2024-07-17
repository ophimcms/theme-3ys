<div class="myui-panel_bd">

    <div class="slideDown-box">

        <ul class="myui-screen__list nav-slide clearfix" data-align="left">
            <li>
                <a class="btn text-muted" href="">Danh mục</a>
            </li>
            <li>
                <a class="btn @if (request('types') == 'series')) btn-warm @endif"
                   href="/?search={{request('search')}}&regions={{request('regions')}}&categorys={{request('categorys')}}&years={{request('years')}}&sorts={{request('sorts')}}&types=series">Phim bộ</a>
                <a class="btn @if (request('types') == 'single')) btn-warm @endif"
                   href="/?search={{request('search')}}&regions={{request('regions')}}&categorys={{request('categorys')}}&years={{request('years')}}&sorts={{request('sorts')}}&types=single">Phim lẻ</a>
            </li>
        </ul>
        <ul class="myui-screen__list nav-slide clearfix" data-align="left">
            <li>
                <a class="btn text-muted" href="">Thể loại</a>
            </li>
            <li>
                @foreach (\Ophim\Core\Models\Category::fromCache()->all() as $item)
                    <a class="btn @if (request('categorys') == $item->id)) btn-warm @endif"
                       href="/?search={{request('search')}}&regions={{request('regions')}}&years={{request('years')}}&types={{request('types')}}&sorts={{request('sorts')}}&categorys={{$item->id}}">{{ $item->name }}</a>
                @endforeach
            </li>
        </ul>
        <ul class="myui-screen__list nav-slide clearfix" data-align="left">
            <li>
                <a class="btn text-muted" href="">Quốc gia</a>
            </li>
            <li>
                @foreach (\Ophim\Core\Models\Region::fromCache()->all() as $item)
                    <a class="btn @if (request('regions') == $item->id)) btn-warm @endif"
                       href="/?search={{request('search')}}&regions={{$item->id}}&years={{request('years')}}&types={{request('types')}}&sorts={{request('sorts')}}&categorys={{request('categorys')}}">{{ $item->name }}</a>
                @endforeach
            </li>

        </ul>
        <ul class="myui-screen__list nav-slide clearfix" data-align="left">
            <li>
                <a class="btn text-muted" href="">Năm</a>
            </li>
            <li>
                @foreach ($years as $year)
                    <a class="btn @if (request('years') == $year)) btn-warm @endif"
                       href="/?search={{request('search')}}&regions={{request('regions')}}&categorys={{request('categorys')}}&types={{request('types')}}&sorts={{request('sorts')}}&years={{ $year }}">{{ $year }}</a>
                @endforeach
            </li>
        </ul>
        <ul class="myui-screen__list nav-slide clearfix" data-align="left">
            <li>
                <a class="btn text-muted" href="">Sắp xếp</a>
            </li>
            <li>
                <a class="btn @if (request('sorts') == 'update')) btn-warm @endif"
                   href="/?search={{request('search')}}&regions={{request('regions')}}&categorys={{request('categorys')}}&years={{request('years')}}&types={{request('types')}}&sorts=update">Thời gian cập nhật</a>
                <a class="btn @if (request('sorts') == 'create')) btn-warm @endif"
                   href="/?search={{request('search')}}&regions={{request('regions')}}&categorys={{request('categorys')}}&years={{request('years')}}&types={{request('types')}}&sorts=create">Thời gian đăng</a>
                <a class="btn @if (request('sorts') == 'year')) btn-warm @endif"
                   href="/?search={{request('search')}}&regions={{request('regions')}}&categorys={{request('categorys')}}&years={{request('years')}}&types={{request('types')}}&sorts=year">Năm sản xuất</a>
                <a class="btn @if (request('sorts') == 'view')) btn-warm @endif"
                   href="/?search={{request('search')}}&regions={{request('regions')}}&categorys={{request('categorys')}}&years={{request('years')}}&types={{request('types')}}&sorts=view">Lượt xem</a>
            </li>
        </ul>
    </div>
</div>

