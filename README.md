# THEME - 3YS 2024 - OPHIM CMS

## Install

    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/ophimcms/theme-3ys.git"
        }
    ],
    "require": {
    "ophimcms/theme-3ys": "*"
    }
1. Tại thư mục của Project: `composer update`
2. Kích hoạt giao diện trong Admin Panel
## Requirements
https://github.com/hacoidev/ophim-core
## Note
- Một vài lưu ý quan trọng của các nút chức năng:
    + `Activate` và `Re-Activate` sẽ publish toàn bộ file js,css trong themes ra ngoài public của laravel.
    + `Reset` reset lại toàn bộ cấu hình của themes
## Demo
### Trang Chủ
![Alt text](https://i.ibb.co/1fncyTJ/image.png "Home Page")

### Trang Danh Sách Phim

![Alt text](https://i.ibb.co/7QPxXks/image.png "Catalog Page")

### Trang Thông Tin Phim

![Alt text](https://i.ibb.co/ZXxqXQJ/image.png "Info Page")

### Trang Xem Phim

![Alt text](https://i.ibb.co/5TjLQ4k/image.png "Episode Page")

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/theme-3ys/resources/views/theme3ys`
- Copy file cần custom đến: `/resources/views/vendor/themes/theme3ys`
# THEME - 3ys 2024 - OPHIM CMS
