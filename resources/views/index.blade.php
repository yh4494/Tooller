@extends('layout')

@section('header')

@endsection

@section('content')
    <div class="container">
        <div class="rel-title"><div></div>常用网站</div>
        <div class="normal-web">
            <a href="http://www.v2ex.com"><div>V2EX</div></a>
            <a href="https://www.linuxidc.com/"><div>LINUX 公社</div></a>
            <a href="https://www.github.com/"><div>GITHUB</div></a>
            <a href="https://juejin.im/"><div>掘金社区</div></a>
        </div>

{{--        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">--}}
{{--            <div class="carousel-inner" style="width: 100%; height: 450px; overflow: hidden; margin: 10px 0; border: 1px solid #f3f3f3; box-shadow: #ccc 2px 2px 2px">--}}
{{--                <div class="carousel-item active">--}}
{{--                    <img src="/resources/assets/images/swipe001.png" class="d-block w-100" alt="...">--}}
{{--                </div>--}}
{{--                <div class="carousel-item">--}}
{{--                    <img src="/resources/assets/images/swipe002.png" class="d-block w-100" alt="...">--}}
{{--                </div>--}}
{{--                <div class="carousel-item">--}}
{{--                    <img src="/resources/assets/images/swipe003.jpg" class="d-block w-100" alt="...">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">--}}
{{--                <span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
{{--                <span class="sr-only">Previous</span>--}}
{{--            </a>--}}
{{--            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">--}}
{{--                <span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
{{--                <span class="sr-only">Next</span>--}}
{{--            </a>--}}
{{--        </div>--}}

        <div class="rel-title"><div></div>文章推荐</div>
        <div style="clear: both"></div>
        <div class="list-allens">
            <div v-if="!showWay">
                @foreach($articles as $item)
                    <li>
                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                        <a target="_blank" href="/book/show/{{ $item['id']  }}">
                            {{ $item['title'] }}
                        </a>
                        <span style="color: #ccc; font-weight: bold;">
                            @if(isset($item->categoryName) && $item->categoryName)【{{ $item->categoryName }}】@endif
                        </span>
                    </li>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('footer')

@endsection
