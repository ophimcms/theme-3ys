<?php

namespace Ophim\Theme3Ys;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class Theme3YsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/3ys')
        ], '3ys-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            '3ys' => [
                'name' => 'Theme 3Ys',
                'author' => 'dev.ohpim.cc',
                'package_name' => 'ophimcms/theme-3ys',
                'publishes' => ['3ys-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'per_page_limit',
                        'label' => 'Pages limit',
                        'type' => 'number',
                        'value' => 24,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'movie_related_limit',
                        'label' => 'Movies related limit',
                        'type' => 'number',
                        'value' => 14,
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4',
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'home_page_slider_poster',
                        'label' => 'Home page slider poster',
                        'type' => 'text',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit',
                        'value' => 'Slide||is_recommended|0|updated_at|desc|5',
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url|show_template (section_thumb|section_side)',
                        'value' => <<<EOT
                        Phim chiếu rạp||is_shown_in_theater|1|updated_at|desc|14|/danh-sach/phim-chieu-rap|section_thumb
                        Phim bộ mới||type|series|updated_at|desc|10|/danh-sach/phim-bo|section_side
                        Phim lẻ mới||type|single|updated_at|desc|10|/danh-sach/phim-le|section_side
                        Hoạt hình|categories|slug|hoat-hinh|updated_at|desc|10|/the-loai/hoat-hinh|section_side
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Sidebar Single',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_template (top_text|top_thumb)',
                        'value' => <<<EOT
                        Sắp chiếu||status|trailer|publish_year|desc|10|top_text
                        Top phim lẻ||type|single|view_week|desc|10|top_thumb
                        Top phim bộ||type|series|view_week|desc|10|top_thumb
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => 'class="active"',
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <div class="myui-foot clearfix">
                            <div class="container min">
                                <div class="row">
                                    <div class="col-pd text-center">
                                        <p>Tất cả thông tin tài nguyên trên trang này được tìm kiếm từ Internet Trang web này không chịu trách nhiệm về nội dung được hiển thị. Nếu bạn cho rằng thông tin trên các trang của trang này vi phạm quyền của bạn, vui lòng đính kèm email chứng nhận bản quyền để thông báo cho chúng tôi trong vòng 48 giờ sau đó. đang nhận email<br>Liên hệ: 123456@gmail.com</p>
                                        <p class="hidden-xs">
                                            <a target="_blank" href="/map.html">Site map</a><span class="split-line"></span>
                                            <a target="_blank" href="/rss/index.xml">RSS</a><span class="split-line"></span>
                                            <a target="_blank" href="/rss/baidu.xml">Baidu</a><span class="split-line"></span>
                                            <a target="_blank" href="/rss/google.xml">Google</a><span class="split-line"></span>
                                            <a target="_blank" href="/rss/bing.xml">Bing</a><span class="split-line"></span>
                                            <a target="_blank" href="/rss/so.xml">360</a><span class="split-line"></span>
                                            <a target="_blank" href="/rss/sogou.xml">Sogou</a><span class="split-line"></span>

                                        </p>
                                        <p class="margin-0">
                                            ©2024 ophim.cc		</p>
                                        <div class="tongji"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
