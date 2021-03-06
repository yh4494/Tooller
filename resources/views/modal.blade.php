<!DOCTYPE html>
<html>
<head>
    <title>Allens Tooller</title>
    <link rel="stylesheet" href="/resources/lib/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/resources/lib/css/common.css">
    @yield("header")
    <link rel="shortcut icon" href="/public/favicon.ico">
    <meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/resources/lib/font-awesome-4.7.0/css/font-awesome.css">
    <style type="text/css">
        [v-cloak] {
            display: none;
        }
    </style>
</head>
<body style="height:100%;">
    @yield('content')
</body>
<script src="/resources/lib/js/jquery.slim.min.js"></script>
<script src="/resources/lib/js/jquery-3.3.1.min.js"></script>
<script src="/resources/lib/layer-v3.1.1/layer/layer.js"></script>
<script src="/resources/lib/js/popper.min.js"></script>
<script src="/resources/lib/js/vue.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
@yield("footer")
</html>
