@extends('layout')

@section('content')
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <title></title>

    <script src="/resources/lib/wall/hm.js"></script><script type="text/javascript" src="/resources/lib/wall/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.icon-monitor').addClass('active');

            $(".icon-mobile-3").click(function () {
                $("#by").css("overflow-y", "auto");
                $('#iframe-wrap').removeClass().addClass('mobile-width-3');
                $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });

            $(".icon-mobile-2").click(function () {
                $("#by").css("overflow-y", "auto");
                $('#iframe-wrap').removeClass().addClass('mobile-width-2');
                $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });

            $(".icon-mobile-1").click(function () {
                $("#by").css("overflow-y", "auto");
                $('#iframe-wrap').removeClass().addClass('mobile-width');
                $('.icon-tablet,.icon-mobile,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });

            $(".icon-tablet").click(function () {
                $("#by").css("overflow-y", "auto");
                $('#iframe-wrap').removeClass().addClass('tablet-width');
                $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });

            $(".icon-monitor").click(function () {
                $("#by").css("overflow-y", "hidden");
                $('#iframe-wrap').removeClass().addClass('full-width');
                $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
                $(this).addClass('active');
                return false;
            });
        });
    </script>

    <script type="text/javascript">
        function Responsive($a) {
            if ($a == true) $("#Device").css("opacity", "100");
            if ($a == false) $("#Device").css("opacity", "0");
            $('#iframe-wrap').removeClass().addClass('full-width');
            $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
            $(this).addClass('active');
            return false;
        };
    </script>

    <script type="text/javascript" src="/resources/lib/wall/protect.js"></script>

    <style data-cursor="cursor">body,
        input[type=range]::-webkit-slider-thumb,
        input[type=range]::-webkit-slider-runnable-track {
            cursor: url("data:image/svg+xml,") 0 0, default !important;
        }

        a,
        button,
        .cursorsHover {
            cursor: url("data:image/svg+xml,") 0 0, pointer !important;
        }
    </style></head>
<body id="by">

<div id="iframe-wrap">
    <iframe id="iframe" src="/resources/lib/wall/index.html" frameborder="0" width="100%" height="654px"></iframe>
</div>

</body>
@endsection

