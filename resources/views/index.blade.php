@extends('layout')

@section('header')
    <style>
        .normal-web {
            padding-bottom: 0;
        }
        .normal-web div {
            margin-bottom: 15px;
            width: auto !important;
            padding: 0px 10px;
        }
        body {
            background: #0B0B04;
        }
    </style>
@endsection

@section('content')
    <div class="container" style="position: relative">
        <div class="rel-title"><div></div>常用网站</div>
        <div class="normal-web">
            <a href="http://www.v2ex.com"><div>V2EX</div></a>
            <a href="https://www.linuxidc.com/"><div>LINUX 公社</div></a>
            <a href="https://www.github.com/"><div>GITHUB</div></a>
            <a href="https://juejin.im/"><div>掘金社区</div></a>
            <a href="http://www.htmleaf.com/"><div>JQuery</div></a>
            <a href="https://xueyuanjun.com/"><div>LARAVEL</div></a>
            <a href="https://baidu.com/"><div>百度</div></a>
            <a href="https://tool.lu/favicon/"><div>ICON生成</div></a>
            <a href="http://tool.chinaz.com/tools/urlencode.aspx"><div>URLDECODE</div></a>
            <a href="http://www.16pic.com/"><div>六图网</div></a>
            <a href="https://www.51cto.com/"><div>51CTO</div></a>
            @if(isset($isLogin) && $isLogin)
                <button style="border: 1px solid #ccc;">+</button>
            @endif
        </div>

        <div id="carouselExampleControls" class="carousel slide animate__animated animate__fadeIn" data-ride="carousel">
            <div class="carousel-inner" style="width: 100%; height: 350px; opacity: 0.8; overflow: hidden; margin: 10px 0; border: 1px solid #f3f3f3; box-shadow: #ccc 2px 2px 2px">
                <div class="carousel-item active">
                    <img src="/resources/assets/images/swipe002.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/resources/assets/images/swipe003.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div style="width: 100%; clear: both;">
            <div class="rel-title" style="width: 200px; float: left"><div></div>精品文章</div>
            <div style="clear: both"></div>
            <div style="width: 100%">
                <span style="display: none;">{{ $i = 0 }}</span>
                @foreach($recommand as $item)
                    <span style="display: none;">{{ $i ++ }}</span>
                    <div class="card" style="box-shadow: 2px 2px 2px #ccc;width: 250px; float: left; @if($i % 4 !== 0) margin-right: 26px; @endif @if($i >= 4) margin-bottom: 10px; @endif">
                        <img src="/resources/assets/images/random00{{$i}}.jpeg" class="card-img-top" alt="...">
                        <div class="card-body" style="min-height: 200px; overflow: hidden">
                            <h5 class="card-title"><a style="color: #666666;" target="__blank" href="/book/show/{{ $item->id }}">{{ $item->title }}</a></h5>
                            <p class="card-text">{{ mb_substr(strip_tags($item->description), 0, 60) }}...</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div id="list-content">
            <div style="width: 100%; clear: both;">
                <div class="rel-title" style="width: 200px; float: left"><div></div>推荐链接</div>
                <div style="float: right; width: 100px; text-align: right; line-height: 50px"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;
                    <a style="color: #666666;" href="javascript:void(0)" @click="clickToRefresh">刷新</a>
                </div>
                <div style="clear: both"></div>
            </div>

            <div style="clear: both"></div>
            <div class="list-allens" style="padding-bottom: 20px; background: #f3f3f3;">
                <li class="animate__animated animate__fadeIn" style="list-style: none; padding-top: 10px; padding-left: 10px;" v-for="item in listLinks">
                    <i class="fa fa-bookmark" aria-hidden="true"></i>
                    <a target="_blank" style="color: #000;" :href="item.address">&nbsp;&nbsp;@{{ item.name }}</a>
                    <span style="color: #ccc; font-weight: bold;"></span>
                </li>
            </div>
        </div>


        <div style="width: 100%">
            <div class="rel-title" style="width: 200px; float: left"><div></div>文章推荐</div>
            <div style="float: right; width: 100px; text-align: right; line-height: 50px"><i class="fa fa-bars" aria-hidden="true"></i>&nbsp;<a style="color: #666666;" href="/article">更多</a></div>
        </div>
        <div style="clear: both"></div>
        <div class="list-allens" style="padding-bottom: 20px">
            <div v-if="!showWay">
            @foreach($articles as $item)
                <li class="animate__animated animate__fadeIn">
                    <i class="fa fa-bookmark" aria-hidden="true"></i>
                    <a target="_blank" href="/book/show/{{ $item['id']  }}">
                        {{ $item['title'] }}
                    </a>
                    <span style="color: #ccc; font-weight: bold;">
                        @if(isset($item->categoryName) && $item->categoryName)【{{ $item->categoryName }}】@endif
                    </span>
                    <div style="float: right; padding-right: 20px">{{ $item['browers_num'] }}&nbsp;<i class="fa fa-hand-pointer-o" aria-hidden="true"></i></div>
                </li>
            @endforeach
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        new Vue({
            el: '#list-content',
            mounted() {
                this.requestMarks();
            },
            data: {
                listLinks: []
            },
            methods: {
                clickToRefresh () {
                    this.requestMarks();
                },
                requestMarks () {
                    this.$http.get('/api/article/goodArticles').then(function(data) {
                        this.listLinks = data.body.data
                        console.log(this.listLinks)
                    })
                }
            }
        })
    </script>
@endsection
