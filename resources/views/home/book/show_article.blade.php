@extends('modal')

@section('header')
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }
        #mycode{
            font-size: 18px;
            /*width:500px;*/
            white-space: pre; /*不强制换行*/
        }

    </style>
    <link rel="stylesheet" type="text/css" href="/resources/lib/highlight/styles/tomorrow-night-eighties.css">
@endsection

@section('content')
    <div class="container" style="padding-top: 20px">
{{--        <nav aria-label="breadcrumb" style="width: 100%">--}}
{{--            <ol class="breadcrumb" style="width: 100%">--}}
{{--                <li class="breadcrumb-item"><a href="/">Home</a></li>--}}
{{--                <li class="breadcrumb-item"><a href="/article">文章</a></li>--}}
{{--                <li class="breadcrumb-item active" aria-current="page">Data</li>--}}
{{--            </ol>--}}
{{--        </nav>--}}

<!-- 代码高亮显示格式：<pre><code>你的代码</code></pre> -->
        <div style="padding: 30px 0 0 0; height: auto">
            <h2 style="text-align: left; margin-bottom: 50px;">{{ isset($article) ? $article->title : ''  }}</h2>
            <div style="width: 100%; height: auto; border: 2px dashed #f3f3f3; padding: 30px; margin-bottom: 20px;"><xmp class="none">{{ isset($article) ? str_replace('\n', '<br/>',$article->description) : '' }}</xmp></div>
            <div style=" padding-top: 1px;">
                {!! isset($article) ? $article->content : '' !!}
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="/resources/lib/highlight/highlight.pack.js"></script>
    <script>
        hljs.initHighlightingOnLoad();
        var allpre = document.getElementsByTagName("pre");
        for(i = 0; i < allpre.length; i++)
        {
            if (allpre[i].className === 'none') {
                continue;
            }
            var onepre = document.getElementsByTagName("pre")[i];
            var mycode = document.getElementsByTagName("pre")[i].innerHTML;
            onepre.innerHTML = '<code id="mycode">'+mycode+'</code>';
        }
    </script>
@endsection
