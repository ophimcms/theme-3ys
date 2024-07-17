# THEME - Dy 2024 - OPHIM CMS

## Install

    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/binhnguyen1998822/oPhimTheme3YsLaravel.git"
        }
    ],
    "require": {
    "ophimcms/theme-dy": "*"
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
![Alt text](https://i.ibb.co/YbNYS6j/home.png "Home Page")

### Trang Danh Sách Phim

![Alt text](https://i.ibb.co/zHvKYNS/category.png "Catalog Page")

### Trang Thông Tin Phim

![Alt text](https://i.ibb.co/crwNVLy/image.png "Info Page")

### Trang Xem Phim

![Alt text](https://i.ibb.co/HKHBbfd/image.png "Episode Page")

### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/theme-dy/resources/views/Theme3ys`
- Copy file cần custom đến: `/resources/views/vendor/themes/Theme3ys`
# THEME - Dy 2024 - OPHIM CMS
