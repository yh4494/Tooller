@extends('modal')

@section('header')

@endsection

@section('content')
    <div class="container">
        @if(!$isModal)
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/article">文章</a></li>
                    <li class="breadcrumb-item active" aria-current="page">添加/编辑文章</li>
                </ol>
            </nav>
        @endif
        <form>
            <h5 style="padding-top: 20px">添加笔记</h5>
            <hr>
            <div class="form-group">
                <label for="exampleInputEmail1">文章标题</label>
                <input name="title" v-model="title" type="text" class="form-control" placeholder="填写标题">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">顶级分类</label>
                <select class="custom-select">
                    <option v-for="item in categoryMain" selected>@{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">自定分类</label>
                <div class="input-group">
                    <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                        <option selected>Choose...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">描述</label>
                <textarea name="description" width="100%" v-model="description" class="form-control" placeholder="填写备注"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">笔记</label>
                <script name="content" id="editor" type="text/plain" style="width:100%;height:500px;" data-placement="内容">
                </script>
            </div>
            <div style="display: none;" class="text-content">{!! isset($article) ? $article->content : '' !!}</div>
            <button type="button" class="btn btn-primary" @click="clickToSubmit()">提交</button>
        </form>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" charset="utf-8" src="/resources/lib/utf8-php/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/resources/lib/utf8-php/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/resources/lib/utf8-php/lang/zh-cn/zh-cn.js"></script>
    <script>
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例

        var ue = UE.getEditor('editor');
        var content     = `{!! $article ? $article->content : '' !!}`;
        var description = '{!! isset($article) ? $article->description : '' !!}';
        var title       = '{!! isset($article) ? $article->title : '' !!}';
        var isArticle   = '{!! $isArticle !!}';

        // UE.getEditor('editor').execCommand('insertHtml', $('.text-content').html())
        ue.ready(function() {
            ue.setContent($('.text-content').html());
        });
        var v = new Vue({
            el: '.container',
            data: {
                id: '{!! isset($id) ? $id : '' !!}',
                title: title,
                content: content,
                description: description,
                process_parent_id: '{!! isset($pid) ? $pid : '' !!}',
                process_id: '{!! isset($id) ? $id : '' !!}',
                categoryMain: []
            },
            mounted () {
                this.requestCategoryMain();
            },
            methods: {
                requestCategoryMain () {
                    this.$http.get('/api/category/main').then( function(response) {
                        console.log(response.body);
                        this.categoryMain = response.body.data;
                    });
                },
                clickToSubmit () {
                    this.content = ue.getAllHtml();
                    this.$http.post('/book/add/', {
                        title: this.title,
                        content: this.content,
                        description: this.description,
                        id: this.id,
                        is_article: '{!! $isArticle !!}'
                    }).then(function(response) {
                        var data = response.body;
                        if (data.code === 0) {
                            if (isArticle) setTimeout(function () {
                                window.location.href = '/article'
                            }, 1000); else {
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.layer.close(index);
                            }
                        } else {
                            layer.msg('操作失败', {icon: 5});
                        }
                    })
                }
            }
        })
    </script>
@endsection
