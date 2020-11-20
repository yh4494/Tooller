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
    <div class="container">
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
            <div class="rel-title" style="width: 200px; float: left"><div></div>推荐文章</div>
            <div style="clear: both"></div>
            <div style="width: 100%">
                <div class="card" style="width: 250px; float: left; margin-right: 26px;">
                    <img src="/resources/assets/images/random001.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
                <div class="card" style="width: 250px; float: left; margin-right: 26px;">
                    <img src="/resources/assets/images/random002.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
                <div class="card" style="width: 250px; float: left; margin-right: 26px;">
                    <img src="/resources/assets/images/random003.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
                <div class="card" style="width: 250px; float: left;">
                    <img src="/resources/assets/images/random004.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="clear: both"></div>

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

@endsection
