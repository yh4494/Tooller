<!DOCTYPE html>
<html>
    <head>
        <title>Allens Tooller</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="/resources/lib/css/common.css">
        @yield("header")
        <meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">
        <link rel="stylesheet" href="/resources/lib/font-awesome-4.7.0/css/font-awesome.css">
        <style type="text/css">
            [v-cloak] {
                display: none;
            }
            .white-a {
                color: #fff;
            }
            a.white-a :hover {
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div style="position: absolute; height: 56px; width: 100%; background: #343a40;"></div>
        <div class="container">
            @include('nav')
            <!-- Content here -->
            @yield("content")
        </div>
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
