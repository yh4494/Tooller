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
        .collection {
            width: 100%;
            height: auto;
            border: 1px solid #f3f3f3;
            padding: 10px;
            box-shadow: #f3f3f3 2px 2px 2px;
        }
        .collection ul li {
            list-style: none;
            width: 100%;
            height: 40px;
            line-height: 40px;
            border-top: 1px solid #f3f3f3;
            box-shadow: #f3f3f3 2px 2px 2px;
        }
        .allens-slider .title {
            width: 200px;
            height: 57px;
            font-weight: bold;
            text-align: center;
            line-height: 56px;
            border-bottom: 1px solid #f3f3f3;
            background: #0E0E05;
            color: #fff;
            // opacity: 0.8;
            position: fixed;
        }
        .allens-slider .title div {
            font-size: 15px !important;
        }
        .allens-slider .title div {
            color: #fff;
            height: 100%;
            cursor: pointer;
        }
        .allens-slider .title div:hover {
            background: #2D3338;
        }
        .allens-slider .element {
            width: 100%;
            height: 30px;
            font-size: 13px;
            text-align: left;
            line-height: 30px;
            text-indent: 5px;
            border-bottom: 1px solid #f3f3f3;
            cursor: pointer;
            padding-right: 10px;
            display: block; /* 当前元素本身是inline的，因此需要设置成block模式 */
            white-space: nowrap; /* 因为设置了block，所以需要设置nowrap来确保不换行 */
            overflow: hidden; /* 超出隐藏结合width使用截取采用效果*/
            text-overflow: ellipsis; /* 本功能的主要功臣，超出部分的剪裁方式 */
            -o-text-overflow: ellipsis; /* 特定浏览器前缀 */
            text-decoration: none; /* 无用 */
            background: #fff;
            color:#666;
            font-weight: bold;
        }
        .right-bar {
            position: fixed;
            width: 20px;
            left: 200px;
            height: 40px;
            background: #000;
            opacity: 0.5;
            top: 50%;
            text-align: center;
            line-height: 40px;
            border-bottom-right-radius: 5px;
            border-top-right-radius: 5px;
        }
        .desc-content {
            list-style: none;
        }
        ::marker {
            list-style-type: none;
            display: none;
        }
        .desc-content ul > li {
            overflow: hidden;
            padding-left: 15px;
        }
        .operator-line {
            width: 1080px;
            height: 36px;
        }
        .operator-line .search {
            width: 280px;
            height: 100%;
            background: #545F65;
            float: right;
            border-radius: 5px;
            /*margin-right: 0;*/
        }
        #real-content ::-webkit-scrollbar{
            display:none;
        }
        .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
            width: 280px;
        }
        .category-bar {
            line-height: 40px; padding-left: 20px; width: 100%; height: 40px; border-top-left-radius: 20px; border-bottom-left-radius: 20px; background: #fff; margin-bottom: 10px;
            cursor: pointer;
        }
        .category-bar:hover{
            background: #000;
            color: #fff;
        }
        .link {
            width: 100%; clear: both; display: block; padding-top: 5px;
            padding-bottom: 15px;
            overflow: hidden;
        }
        .link .element {
            height: 240px; width: 258px; background: #ccc; margin-right: 15px; flex-grow: 1;
            float: left;
        }
        .link .element:hover img {
            opacity: 1;
        }
        .link .element img {
            width: 100%;
            height: 150px;
            opacity: 0.6;
        }
        .link .element p {
            font-size: 15px;
            font-weight: bold;
            padding: 5px;
        }
        .link .element p a {
            color: #666666;
        }
        .link .element:last-child {
            margin-right: 0;
        }
        .layui-layer-content {
            color: #fff;
        }
    </style>
@endsection

{{-- 左侧分类导航栏 --}}
@section('exclude')
    @if(isset($isLogin) && $isLogin)
    <div id="real-content" style="width: auto; height: auto;" v-cloak>
        <div class="right-bar animate__animated animate__fadeIn" @click="clickToHiddenBox">
            <i v-if="hiddenBox"   style="color: #fff;" class="fa fa-angle-right" aria-hidden="true"></i>
            <i v-else="hiddenBox" style="color: #fff;" class="fa fa-angle-left" aria-hidden="true"></i>
        </div>
        <div class="allens-slider test-5 animate__animated animate__fadeIn" style="overflow-y: auto;  overflow-x: hidden">
            <div class="title">
                <div style="width: 50%; float: left" @click="clickToShowCategory"><i style="color: #fff;" class="fa fa-th-large" aria-hidden="true"></i>&nbsp;添加分类</div>
                <div style="width: 50%; float: left" v-if="showLinksChild" @click="clickToAddMark" data-toggle="modal" data-target="#exampleModalCenter"><i style="color: #fff;" class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;添加书签</div>
            </div>
            <div style="margin-top: 56px;">
                <div class="element">
                    <div style="float: left; padding-left: 5px">
                        @{{ currentCategoryName || '全部' }}
                    </div>
                    <div style="float: right; padding-right: 5px;" @click="clickToBack" v-if="showLinksChild">
                        <i class="fa fa-angle-left" aria-hidden="true"></i>&nbsp;返回
                    </div>
                </div>
                <template v-if="!showLinksChild">
                    @foreach($category as $item)
                        <div class="element" @click="clickToShowLinks('{{ $item->id }}', '{{ $item->name }}')">
                            <i style="color: #2D3338" class="fa fa-folder" aria-hidden="true"></i>&nbsp;{{ $item['name'] }}
                        </div>
                    @endforeach
                    <div class="element" v-for="item in list">
                        <i class="fa fa-link" aria-hidden="true"></i>&nbsp;
                        <a href="javascript:void(0)" @click="clickToJumping('http://www.163.com')">@{{ item.name }}</a>
                    </div>
                </template>
                <template v-else>
                    <div class="element" v-for="item in list">
                        <i class="fa fa-link" aria-hidden="true"></i>&nbsp;
                        <a href="javascript:void(0)" @click="clickToJumping(item.name, item.address)">@{{ item.name }}</a>
                    </div>
                </template>
            </div>
            <div style="height: 100%; position: absolute; top: 0; z-index: -10000; width: 100%; background: #fff;"></div>
        </div>
    </div>
    @endif
@endsection

@section('dialog')

@endsection

@section('content')
    <div style="width: 200px; height: 100px; position: fixed; top: 70px; right: 0px;">
        @foreach($pCategory as $item)
            <a href="/article?pCategory={{ $item->id }}">
                <div class="category-bar" style="@if($currentParentCategory == $item->id) background: #000; color: #fff; @endif">
                    {{ $item->name }}
                </div>
            </a>
        @endforeach
    </div>

    <div class="container" style="padding-bottom: 20px; position: relative" v-cloak>
        <div id="list-content">
            <div style="width: 100%; clear: both;">
                <div class="rel-title" style="width: 200px; float: left"><div></div>推荐链接</div>
{{--                <div style="float: right; width: 100px; text-align: right; line-height: 50px"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;--}}
{{--                    <a style="color: #666666;" href="javascript:void(0)" @click="clickToRefresh">刷新</a>--}}
{{--                </div>--}}
{{--                <div style="clear: both"></div>--}}
            </div>

{{--            列表形式图文链接--}}
{{--            <div style="clear: both"></div>--}}
{{--            <div class="list-allens" style="padding-bottom: 20px; background: #f3f3f3;">--}}
{{--                <li class="animate__animated animate__fadeIn" style="list-style: none; padding-top: 10px; padding-left: 10px;" v-for="item in listLinks">--}}
{{--                    <i class="fa fa-bookmark" aria-hidden="true"></i>--}}
{{--                    <a target="_blank" style="color: #666666; font-weight: bold;" :href="item.address">&nbsp;&nbsp;@{{ item.name }}</a>--}}
{{--                    <div style="float: right; padding-right: 20px">--}}
{{--                        <span style="color: #ccc; font-weight: bold; text-align: right">【@{{ item.category.name }}】</span>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--            </div>--}}
            <!-- 图文形式链接 -->
            <div style="" class="link" v-for="item in links">
                <div class="element" v-for="i in item">
                    <img :src="'/resources/assets/images/linkimage/link00' + Math.ceil(Math.random() * 10) + '.jpeg'"  alt="">
                    <p><a :href="i.address" target="__blank">@{{ i.name }}</a></p>
                </div>
            </div>
        </div>

        @if(isset($isLogin) && $isLogin)
        <div style="width: 100%; height: auto; padding: 15px 0">
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
                <label class="btn btn-secondary @if($type == 'collection') active @endif" @click="clickToJumping('/article?type=collection')">
                    <input type="radio" name="options" id="option1">  <a style="color: #fff;">文集&nbsp;<i style="margin-top: 4px; color: #fff" class="fa fa-th-large" aria-hidden="true"></i></a>
                </label>
                <label class="btn btn-secondary" @click="clickToAddArticle">
                    <input type="radio" name="options" id="option1" checked> <i style="margin-top: 4px; color: #fff" class="fa fa-plus" aria-hidden="true"></i>
                </label>
            </div>
            @if(isset($type) && $type === 'collection')
                <button class="btn btn-primary"><i class="fa fa-plus-circle" style="color: #fff;" aria-hidden="true"></i>&nbsp;添加文集</button>
            @endif
            <div style="float: right; width: 280px;" data-toggle="buttons">
                <select class="selectpicker" style="background: #606A71; width: 280px;" id="selectCategory" v-model="currentCategory" @change="changeCategory" data-live-search="true">
                    <option style="width: 280px;" value="0">全部</option>
                    @foreach($category as $c)<option style="width: 280px;" data-tokens="ketchup mustard" :value="{{$c->id}}">{{ $c->name }}</option>@endforeach
                </select>
            </div>
        </div>
        @else
            <div style="padding-top: 15px"></div>
        @endif

        <div class="operator-line">
            <ul id="paginator" style="float: left;" class="pagination"></ul>
            <div class="search">
                <div class="form-group" style="width: 200px; height: 30px; margin-top: 3px;margin-left: 3px; float: left">
                    <input type="text" style="height: 30px;" @keyup.enter="clickToSearch" placeholder="请输入查询内容" class="form-control" v-model="searchValue">
                </div>
                <div
                    style="cursor: pointer; color: #fff; text-align: center; line-height: 34px; width: 36px; height: 36px; float: right"
                    @click="clickToRest"
                >
                    <i class="fa fa-reply" style="color: #fff;" aria-hidden="true"></i>
                </div>
                <div
                    style="cursor: pointer; color: #fff; text-align: center; line-height: 34px; width: 36px; height: 36px; float: right"
                    @click="clickToSearch"
                >
                    <i class="fa fa-search" style="color: #fff;" aria-hidden="true"></i>
                </div>
            </div>
        </div>

        <div class="list-allens">
            <ul v-if="!showWay" class="list-of-articles">
                @foreach($articles as $item)
                    <li class="animate__animated animate__fadeIn" style="overflow: hidden; min-height: 50px; height: auto !important; padding-right: 10px; padding-bottom: 10px;">
                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                        <span style="color: #6699CC; font-weight: bold;">
                            @if(isset($item->categoryName) && $item->categoryName)【{{ $item->categoryName }}】@endif
                        </span>
                        <a target="_blank" href="/book/show/{{ $item['id']  }}">
                            <span style="color: #666666; font-weight: bold;">{{ $item['title'] }}</span>
                        </a>
                        @if((!isset($type) || !$type) && isset($isLogin) && $isLogin)
                        <div class="element" style="float: right; line-height: 50px; margin-top: 2px; margin-right: 20px;">
                            <a href="javascript:void(0)" @click="clickToDeleteArticle({!! $item['id'] !!})"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                        <div class="element" style="float: right; line-height: 50px; margin-top: 3px; margin-right: 10px;">
                            <a href="javascript:void(0)" @click="clickToEditArticle({!! $item['id'] !!}, {!! $item['is_markdown'] !!})">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                        </div>
                        @endif
                        <div v-if="showArticleList" class="description desc-content" style="max-height:500px; width: 100%; overflow: hidden; color: #ccc; font-size: 12px !important; line-height: normal; padding-bottom: 10px; padding-right: 10px;">
                            {!! $item->description !!}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        @if(isset($type) && $type == 'collection')
            <div class="collection">
                <h3>Spring看这篇文集就够了</h3>
                <div class="elements">
                    <ul>
                        <li><a href=""><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;Spring 源码解析</a></li>
                        <li><a href=""><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;搞懂Spring Bean 生命周期</a></li>
                    </ul>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="/resources/lib/jqPaginator-2.0.2/jq-paginator.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var showWay = '{!! $showWay !!}'
            var vue2 = new Vue({
                el: '#real-content',
                data: {
                    list: [],
                    realUrl: '',
                    showLinksChild: false,
                    currentCategoryId: 0,
                    currentCategoryName: null,
                    name: '',
                    address: '',
                    category: {
                        name: '',
                        desc: '',
                        pid: '1'
                    },
                    hiddenBox: false,
                },
                mounted () {
                    if (localStorage.getItem('hiddenLeftSlider')) {
                        this.hiddenBox = true;
                        $('.allens-slider').css({'left': '-200px'})
                        $('.right-bar').css({'left': '0'})
                    }
                },
                activated: function () {
                },
                methods: {
                    // 点击进行跳转
                    clickToJumping(title, url) {
                        //加载层-默认风格
                        // window.open(url)
                        layer.open({
                            title: title,
                            type: 2,
                            area: ['90%', '90%'],
                            fixed: true, //不固定
                            maxmin: true,
                            content: '/mark/detail?url=' + url
                        });
                    },
                    // 点击查看链接详情
                    clickToShowLinks(categoryId, categoryName = null) {
                        this.showLinksChild = true;
                        this.currentCategoryName = categoryName;
                        this.currentCategoryId = categoryId;
                        console.log(this.currentCategoryId)
                        this.$http.get('/api/mark/links?categoryId=' + categoryId).then(function (response) {
                            var data = response.body;
                            this.list = data.data;
                        })
                    },
                    clickToShowCategory () {
                        layer.open({
                            title: '',
                            type: 2,
                            area: ['40%', '400px'],
                            fixed: true, //不固定
                            maxmin: true,
                            content: '/modal/category?is_modal=true',
                            end: function() {
                                window.location.href='/article'
                            }
                        });
                    },
                    clickToBack() {
                        this.showLinksChild = false;
                        this.currentCategoryId = 0;
                        this.currentCategoryName = null;
                        this.list = [];
                    },
                    clickToHiddenBox () {
                        this.hiddenBox = !this.hiddenBox;
                        if (this.hiddenBox) {
                            $('.allens-slider').animate({'left': '-200px'})
                            $('.right-bar').animate({'left': '0'})
                            localStorage.setItem('hiddenLeftSlider', true);
                        } else {
                            $('.allens-slider').animate({'left': '0'})
                            $('.right-bar').animate({'left': '200px'})
                            localStorage.removeItem('hiddenLeftSlider')
                        }
                    },
                    clickToAddMark() {
                        layer.open({
                            title: '',
                            type: 2,
                            area: ['40%', '400px'],
                            fixed: true, //不固定
                            maxmin: true,
                            content: '/modal/mark?currentCategoryId=' + vue2.currentCategoryId,
                            end: function() {
                                vue2.clickToShowLinks(vue2.currentCategoryId);
                            }
                        });
                    },
                    // 添加分类
                    clickToAddCategory () {
                        this.$http.post('/api/category/save', this.category).then( function(response) {
                            this.categoryMain = response.body.data;
                            window.localtion.href = '/article'
                        });
                    },
                }
            })
            var vue = new Vue({
                el: '.container',
                data: {
                    showWay: showWay,
                    currentCategory: '{!! $currentCategory !!}',
                    showArticleList: false,
                    searchValue: '{!! $searchV !!}',
                    listLinks: [],
                    links: []
                },
                mounted () {
                    this.showWay = showWay;
                    $('#paginator').jqPaginator({
                        totalPages: parseInt('{!! $visible !!}') || 1,
                        visiblePages: 4,
                        currentPage: parseInt('{!! $page !!}'),
                        onPageChange: function (num, type) {
                            if (type !== 'init') window.location = '/article?type={!! $type !!}&page=' + num
                        }
                    });
                    this.requestMarks();
                    setTimeout(function () {
                        vue.showArticleList = true;
                    }, 600);
                },
                methods: {
                    clickToRefresh () {
                        this.requestMarks();
                    },
                    requestMarks () {
                        this.$http.get('/api/article/goodArticles').then(function(data) {
                            this.listLinks = data.body.data
                            console.log(this.listLinks)
                            var tempArr = []
                            for (var i = 0; i < this.listLinks.length; i ++) {
                                if ((i + 1) % 4 === 0) {
                                    tempArr.push(this.listLinks[i])
                                    this.links.push(tempArr)
                                    tempArr = []
                                } else {
                                    tempArr.push(this.listLinks[i])
                                }
                            }
                        })
                    },
                    clickToSearch () {
                        window.location.href = '/article?type=' + '{!! $type !!}&page=' + '{!! $page !!}' + '&searchValue=' + this.searchValue;
                    },
                    clickToRest () {
                        window.location.href = '/article?type=' + '{!! $type !!}&page=' + '{!! $page !!}';
                    },
                    clickToToggle: function(e) {
                        this.showWay = e
                    },
                    clickToJumping (url) {
                        window.location.href = url;
                    },
                    clickToAddArticle () {
                        layer.msg('请选择何种编辑器进行编辑文章？', {
                            time: 0 //不自动关闭
                            ,btn: ['MARKDOWN', '富文本']
                            ,yes: function(index){
                                layer.close(index);
                                window.location.href = ('/book/add-note?is_article=true')
                            },cancel: function(index){
                                layer.close(index);
                                window.location.href = ('/book/add-note-u?is_article=true')
                            },btn2: function(index, layero){
                                layer.close(index);
                                window.location.href = ('/book/add-note-u?is_article=true')
                            },
                        });
                    },
                    clickToDeleteArticle (id) {
                        layer.confirm('是否删除该文章？', {
                            btn: ['删除','取消'] //按钮
                        }, function(index){
                            layer.close(index);
                            vue.$http.get('/book/delete/' + id).then(function(response) {
                                var data = response.body;
                                if (data.code === 0) {
                                    window.location.href = '/article'
                                }
                            })
                        }, function(){

                        });

                    },
                    clickToEditArticle (id, isMarkDown) {
                        isMarkDown === 1 ? window.location.href = '/book/add-note?is_article=true&id=' + id : window.location.href = '/book/add-note-u?is_article=true&id=' + id
                    },
                    changeCategory () {
                        window.location.href = '/article?category=' + $('#selectCategory').val();
                    }
                }
            })
        })
    </script>
@endsection
