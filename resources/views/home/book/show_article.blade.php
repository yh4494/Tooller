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
        .menu {
            position: absolute;
            width: 240px;
            right: 20px;
            top: 60px;
            padding: 15px;
            border: 1px solid #ccc;
            box-shadow: #f3f3f3 2px 2px 2px 2px;
            background: #fff;
        }
        body {
            background: #f3f3f3;
        }
        .menu a{
        }
        .description {
            list-style: none;
        }
        .line {
            /*line-height: 24px;*/
            line-height: 18px;
            color: #666666;
            /*display: block; !* 当前元素本身是inline的，因此需要设置成block模式 *!*/
            white-space: nowrap; /* 因为设置了block，所以需要设置nowrap来确保不换行 */
            overflow: hidden; /* 超出隐藏结合width使用截取采用效果*/
            text-overflow: ellipsis; /* 本功能的主要功臣，超出部分的剪裁方式 */
            -o-text-overflow: ellipsis; /* 特定浏览器前缀 */
            text-decoration: none; /* 无用 */
            border-bottom: 1px solid #f3f3f3;
            padding: 10px 0;
        }
        .line a {
            color: #666666;
        }
        .a-1 {
            font-size: 18px;
        }
        .a-2 {
            font-size: 16px;
        }
        .a-3 {
            font-size: 14px;
            padding-left: 10px;
        }
        .a-4 {
            font-size: 12px;
            padding-left: 12px;
        }
        .a-5 {
            font-size: 10px;
            padding-left: 14px;
        }
        * {
            /*list-style-type: none;*/
            /*list-style: none;*/
        }
    </style>
    <link rel="stylesheet" type="text/css" href="/resources/lib/highlight/styles/tomorrow-night-eighties.css">
@endsection

@section('content')
    <div class="menu"></div>
    <div class="container" style="padding-top: 20px; padding-bottom: 20px; background: #fff;" v-cloak>
        <div style="padding: 30px 0 0 0; height: auto">
            <h2 style="text-align: left; margin-bottom: 20px;">{{ isset($article) ? $article->title : ''  }}</h2>
            <hr>
            <div style="margin-bottom: 20px;">
                @if(!isset($self) || !$self)
                    <i class="fa fa-star fa-2x" v-if="collect == true" @click="clickToCollect(1)" style="cursor:pointer; margin-right: 10px; color:#CCCC00" aria-hidden="true"></i>
                    <i class="fa fa-star-o fa-2x" v-else @click="clickToCollect(1)" style="cursor:pointer; margin-right: 10px; color:#CCCC00" aria-hidden="true"></i>
                @endif
                <i class="fa fa-thumbs-up fa-2x" v-if="support == true" @click="clickToCollect(3)" style="color: #0099CC; cursor:pointer;" aria-hidden="true"></i>
                <i class="fa fa-thumbs-o-up fa-2x" v-else style="color: #0099CC; cursor:pointer;" @click="clickToCollect(3)" aria-hidden="true"></i>

                <i class="fa fa-share-alt fa-2x" style="cursor:pointer; color:#0099CC; margin-left: 10px; margin-right: 10px" aria-hidden="true"></i>
                <a href="/article"><i class="fa fa-reply fa-2x" style="cursor:pointer; color:#ccc; margin-left: 10px; float: right" aria-hidden="true"></i></a>
            </div>
            <div style="">
                <p>作者: {{ $article->user->name }}</p>
                <p>时间: {{ date('Y-m-d H:i:s', $article->create_at)  }}</p>
            </div>
            <div style="width: 100%; height: auto; border: 2px dashed #f3f3f3; padding: 20px 0 0 20px; margin-bottom: 20px;" class="description">
                {!! isset($article) ? str_replace('\n', '<br/>',$article->description) : '' !!}
            </div>
            <div style=" padding-top: 1px;" class="content">
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
            $(".content").children().each(function(index, element) {
                var tagName=$(this).get(0).tagName;
                if(tagName.substr(0,1).toUpperCase()=="H"){
                    var indexS    = tagName.substr(1,2);
                    var className = 'a-' + indexS;
                    var insertH   = '';
                    if (indexS <= 2) {
                        insertH = '<i class=\"fa fa-bookmark-o\" aria-hidden=\"true\"></i>';
                    } else {
                        insertH = '<i class="fa fa-circle-o" aria-hidden="true"></i>';
                    }
                    var contentH  = $(this).html();//获取内容
                    var markid    = "mark-"+tagName + "-" + index.toString();
                    $(this).attr("id", markid);//为当前h标签设置id
                    $(".menu").append("<div class='line " + className + "'>" + insertH + "&nbsp;<a href='#"+markid+"'>"+contentH+"</a></div>");//在目标DIV中添加内容
                }
            });
            $('table').attr('class', 'table table-bordered')
            new Vue({
                el: '.container',
                data: {
                    collect: '{!! isset($article) && $article->collect ? true : false !!}',
                    support: '{!! $article->support == 1 ? true : false !!}'
                },
                methods: {
                    clickToCollect (type) {
                        this.$http.get('/api/article/collect?articleId=' + '{!! $article->id !!}' + '&type=' + type).then(function(response) {
                            switch(type) {
                                case 1:
                                    this.collect = !this.collect;
                                    break;
                                case 3:
                                    this.support = !this.support;
                            }
                        })
                    }
                }
            })
        })
    </script>
@endsection
