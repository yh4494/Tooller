$(window).scroll(function () {
    var scrollHeight = $(document).scrollTop();
    if (scrollHeight > 100) {
        $('#navigation-allens').css({'position': 'fixed', 'width': '100%', 'z-index': '10000'})
    } else if (scrollHeight === 0) {
        //删除类名样式
        $('#navigation-allens').css('position', 'relative')
    }
});
