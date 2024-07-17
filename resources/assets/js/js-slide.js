window.onload = function () {
    var points = document.querySelectorAll('.point');
    var items = document.querySelectorAll('.sitem')
    var list = document.querySelector('.list');
    var warp = document.querySelector('.wrap')
    // 声明变量
    var index = 0;
    var len = items.length;

    // 清除
    var clearShow = function () {
        for (var i = 0; i < items.length; i++) {
            items[i].className = 'sitem';
        }

        for (var i = 0; i < points.length; i++) {
            points[i].className = 'point';
        }
    }

    // 显示当前的index
    var goIndex = function () {
        clearShow()
        items[index].className = 'sitem show';
        points[index].className = 'point show';
    }

    // 下一张
    var goNext = function () {
        if (index < len - 1) {
            index++
        } else {
            index = 0
        }
        goIndex();
    }

    // 上一张
    var goPre = function () {
        if (index == 0) {
            index = len - 1
        } else {
            index--
        }
        goIndex();
    }

    // 圆点
    for (var i = 0; i < points.length; i++) {
        points[i].addEventListener('mouseover', function () {
            var pointIndex = this.getAttribute('data-index');
            index = pointIndex;
            goIndex()
        })
    }

    // 自动轮播
    var timer;
    timer = setInterval(goNext, 5000)

}
