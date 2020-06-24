@extends('layout')

@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }
        .btn-light {
            background: #606A71;
            color: #fff;
        }
        .filter-option-inner-inner {
            color: #fff;
        }
        .dropdown-item.active, .dropdown-item:active {
            background: #f3f3f3;
            color: #fff;
        }
        .pagination>li>a, .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            line-height: 1.42857143;
            text-decoration: none;
            color: #666666;
            background-color: #fff;
            border: 1px solid #ddd;
            margin-left: -1px;
        }
        .pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus {
            z-index: 2;
            color: #fff;
            background-color: #343A40;
            border-color: #343A40;
            cursor: default;
        }
    </style>
@endsection

@section('content')
    <div class="container" style="padding-bottom: 20px;">
        <div style="width: 100%; height: auto; margin: 15px 0">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary @if(!isset($type) || !$type) active @endif" @click="clickToJumping('/article')">
                    <input type="radio" name="options" id="option1"> <a style="color: #fff;">PERSONAL &nbsp;<i style="margin-top: 4px; color: #fff" class="fa fa-user-circle-o" aria-hidden="true"></i></a>
                </label>
                <label class="btn btn-secondary @if($type == 'public') active @endif" @click="clickToJumping('/article?type=public')">
                   <input type="radio" name="options" id="option1">  <a style="color: #fff;">文库&nbsp;<i style="margin-top: 4px; color: #fff" class="fa fa-diamond" aria-hidden="true"></i></a>
                </label>
                <label class="btn btn-secondary @if($type == 'collect') active @endif" @click="clickToJumping('/article?type=collect')">
                    <input type="radio" name="options" id="option1">  <a style="color: #fff;">收藏&nbsp;<i style="margin-top: 4px; color: #fff" class="fa fa-star" aria-hidden="true"></i></a>
                </label>
                <label class="btn btn-secondary @if($type == 'collect') active @endif" @click="clickToJumping('/article?type=collect')">
                    <input type="radio" name="options" id="option1">  <a style="color: #fff;">文集&nbsp;<i style="margin-top: 4px; color: #fff" class="fa fa-th-large" aria-hidden="true"></i></a>
                </label>
                <label class="btn btn-secondary" @click="clickToAddArticle">
                    <input type="radio" name="options" id="option1" checked> <i style="margin-top: 4px; color: #fff" class="fa fa-plus" aria-hidden="true"></i>
                </label>
            </div>
            <div style="float: right" data-toggle="buttons">
                <select class="selectpicker" style="background: #606A71;" id="selectCategory" v-model="currentCategory" @change="changeCategory" data-live-search="true">
                    <option value="0">全部</option>
                    @foreach($category as $c)<option data-tokens="ketchup mustard" :value="{{$c->id}}">{{ $c->name }}</option>@endforeach
                </select>
            </div>
        </div>

        <ul id="paginator" class="pagination"></ul>
        <div class="list-allens">

            <ul v-if="!showWay" class="list-of-articles">
                @foreach($articles as $item)
                    <li class="animate__animated animate__fadeIn">
                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                        <a target="_blank" href="/book/show/{{ $item['id']  }}">
                            {{ $item['title'] }}
                        </a>
                        <span style="color: #ccc; font-weight: bold;">
                            @if(isset($item->categoryName) && $item->categoryName)【{{ $item->categoryName }}】@endif
                        </span>
                        @if(!isset($type) || !$type)
                        <div class="element" style="float: right; line-height: 50px; margin-top: 2px; margin-right: 20px;">
                            <a href="javascript:void(0)" @click="clickToDeleteArticle({!! $item['id'] !!})"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                        <div class="element" style="float: right; line-height: 50px; margin-top: 3px; margin-right: 10px;">
                            <a href="javascript:void(0)" @click="clickToEditArticle({!! $item['id'] !!})">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                        </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="/resources/lib/jqPaginator-2.0.2/jq-paginator.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var showWay = '{!! $showWay !!}'
            new Vue({
                el: '.container',
                data: {
                    showWay: showWay,
                    currentCategory: '{!! $currentCategory !!}'
                },
                mounted () {
                    this.showWay = showWay;
                    $('#paginator').jqPaginator({
                        totalPages: parseInt('{!! $visible !!}'),
                        visiblePages: parseInt('{!! $visibleN !!}'),
                        currentPage: parseInt('{!! $page !!}'),
                        onPageChange: function (num, type) {
                            if (type !== 'init') window.location = '/article?type={!! $type !!}&page=' + num
                        }
                    });
                },
                methods: {
                    clickToToggle: function(e) {
                        this.showWay = e
                    },
                    clickToJumping (url) {
                        window.location.href = url;
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
                    },
                    changeCategory () {
                        window.location.href = '/article?category=' + $('#selectCategory').val();
                    }
                }
            })
        })
    </script>
@endsection
