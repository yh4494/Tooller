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
            <h2 style="text-align: left; margin-bottom: 20px;">{{ isset($article) ? $article->title : ''  }}</h2>
            <hr>
            <div style="margin-bottom: 20px;">
                @if(!isset($self) || !$self)
                    <i class="fa fa-star fa-2x" v-if="collect == true" @click="clickToCollect" style="cursor:pointer; color:#CCCC00" aria-hidden="true"></i>
                    <i class="fa fa-star-o fa-2x" v-else @click="clickToCollect" style="cursor:pointer; color:#CCCC00" aria-hidden="true"></i>
                @endif
                <i class="fa fa-share-alt fa-2x" style="cursor:pointer; color:#0099CC; margin-left: 10px;" aria-hidden="true"></i>
                <a href="/article"><i class="fa fa-reply fa-2x" style="cursor:pointer; color:#ccc; margin-left: 10px; float: right" aria-hidden="true"></i></a>
            </div>
            <div style="">
                <p>作者: {{ $article->user->name }}</p>
                <p>时间: {{ date('Y-m-d H:i:s', $article->create_at)  }}</p>
            </div>
            <div style="width: 100%; height: auto; border: 2px dashed #f3f3f3; padding: 20px; margin-bottom: 20px;"><xmp class="none">{{ isset($article) ? str_replace('\n', '<br/>',$article->description) : '' }}</xmp></div>
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
        $(function() {
            new Vue({
                el: '.container',
                data: {
                    collect: '{!! $article->collect !!}'
                },
                methods: {
                    clickToCollect () {
                        this.$http.get('/api/article/collect?articleId=' + '{!! $article->id !!}').then(function(response) {
                            this.collect = !this.collect;
                        })
                    }
                }
            })
        })
    </script>
@endsection
