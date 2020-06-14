@extends('layout')

@section('header')
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }
        .list-allens {
            width: 100%;
        }
        .list-allens ul li {
            margin-top: 10px;
            width: 100%;
            height: 50px;
            border: 1px solid #f3f3f3;
            list-style: none;
            text-decoration: none;
            line-height: 50px;
            box-shadow: #ccc 2px 2px 2px;
            padding-left: 10px;
        }
        .list-allens ul li div.element {
            width: 20px;
            height: 20px;
        }
        .list-allens ul li a {
            color: #1b1e21;
            width: 20px;
            height: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div style="width: 100%; height: auto; margin: 15px 0">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" name="options" id="option1" checked> 全部
                </label>
                <label class="btn btn-secondary" @click="clickToAddArticle">
                    <input type="radio" name="options" id="option1" checked> <i style="margin-top: 4px; color: #fff" class="fa fa-plus" aria-hidden="true"></i>
                </label>
            </div>
            <div class="btn-group btn-group-toggle" style="float: right" data-toggle="buttons">
                <label class="btn btn-secondary active" @click="clickToToggle(false)">
                    <input type="radio" name="options" id="option1" checked> <i style="color: #fff; margin-top: 2px;" class="fa fa-bars" aria-hidden="true"></i>
                </label>
{{--                <label class="btn btn-secondary" @click="clickToToggle(true)">--}}
{{--                    <input type="radio" name="options" id="option1" checked>--}}
{{--                    <i style="color: #fff; margin-top: 2px;" class="fa fa-th-large" aria-hidden="true"></i>--}}
{{--                </label>--}}
            </div>
        </div>

        <div class="list-allens">
            <ul v-if="!showWay" class="list-of-articles">
                @foreach($articles as $item)
                    <li>
                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                        <a target="_blank" href="/book/show/{{ $item['id']  }}">
                            {{ $item['title'] }}
                        </a>
                        <div class="element" style="float: right; line-height: 50px; margin-top: 3px; ">
                            <a href="javascript:void(0)" @click="clickToDeleteArticle({!! $item['id'] !!})"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                        <div class="element" style="float: right; line-height: 50px; margin-top: 3px; margin-right: 20px;">
                            <a href="javascript:void(0)" @click="clickToEditArticle({!! $item['id'] !!})">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="element" style="float: right; padding-right: 20px;">{{ $item->create_time  }}</div>
                    </li>
                @endforeach
            </ul>
{{--            <div style="width: 100%; display: flex; flex-direction: row; justify-content: flex-start; flex-wrap: wrap;">--}}
{{--                @foreach($articles as $item)--}}
{{--                    <div class="card" style="width: 195px; height: 288.3px; align-self: flex-start; margin-right: 20px;" v-if="showWay">--}}
{{--                        <img src="/resources/assets/images/article.jpeg" class="card-img-top" alt="...">--}}
{{--                        <div class="card-body">--}}
{{--                            <p class="card-text" style="word-break: break-all; ">{{ $item['title'] }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        $(document).ready(function(){
            var showWay = '{!! $showWay !!}'
            new Vue({
                el: '.container',
                data: {
                    showWay: showWay
                },
                mounted () {
                    this.showWay = showWay;
                },
                methods: {
                    clickToToggle: function(e) {
                        this.showWay = e
                    },
                    clickToAddArticle () {
                        window.location.href = ('/book/add-note?is_article=true')
                    },
                    clickToDeleteArticle (id) {
                        this.$http.get('/book/delete/' + id).then(function(response) {
                            var data = response.body;
                            if (data.code === 0) {
                                window.location.href = '/article'
                            }
                        })
                    },
                    clickToEditArticle (id) {
                        window.location.href = '/book/add-note?is_article=true&id=' + id
                    }
                }
            })
        })
    </script>
@endsection
