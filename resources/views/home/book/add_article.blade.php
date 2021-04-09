@extends('modal')

@section('header')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/resources/lib/editor.md-master/css/editormd.css">
@endsection

@section('content')
    <div class="container" style="padding-bottom: 20px;">
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
                <label for="exampleInputEmail1">是否公开</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline1" name="customRadioInline1" value="1" v-model="isPublic"
                           class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline1">是 <span
                            style="font-weight: bold; color: red">（他人将看到你的文章）</span></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="customRadioInline2" name="customRadioInline1" value="0" v-model="isPublic"
                           class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline2">否</label>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">文章标题</label>
                <input name="title" v-model="title" type="text" class="form-control" placeholder="填写标题">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">顶级分类</label>
                <select class="custom-select" v-model="categoryParent">
                    <option v-for="item in categoryMain" :value="item.id" selected>@{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">自定分类</label>
                <div class="input-group">
                    <select class="custom-select" id="inputGroupSelect04" v-model="categoryChildId"
                            aria-label="Example select with button addon">
                        <option v-for="item in categoryChild" :value="item.id">@{{ item.name }}</option>
                    </select>
                    <div class="input-group-append">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                data-target="#exampleModalCenter">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">描述</label>
                <div id="summernote"></div>
                {{--                <textarea name="description" width="100%" style="height: 200px" v-model="description" class="form-control" placeholder="填写备注"></textarea>--}}
                {{--                <script name="description" id="desc-editor" v-model="description" type="text/plain" style="width:100%;height:200px;" data-placement="内容"></script>--}}
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">笔记</label>
                <!--                <script name="content" id="uEditor" type="text/plain" style="width:100%; height: 500px;" data-placement="内容"></script>-->
                <div id="test-editormd">
                <textarea style="display:none;">{{ isset($article) ? $article->markdown : '' }}</textarea>
                </div>
            </div>
            <div style="display: none;" class="text-content">{!! isset($article) ? $article->content : '' !!}</div>
            <div style="display: none;"
                 class="text-des">{!! isset($article) ? str_replace('\n', '<br/>', $article->description) : '' !!}</div>

            <button type="button" class="btn btn-primary" @click="clickToSubmit()">提交</button>
            <button type="button" class="btn btn-secondary" @click="clickToSubmit('save')">保存</button>
        </form>

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">添加分类</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form style="margin-top: 15px;">
                            <div class="form-group">
                                <label for="exampleInputEmail1">标题</label>
                                <input type="text" v-model="category.name" class="form-control" name="name"
                                       placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">描述</label>
                                <input type="text" v-model="category.desc" class="form-control" name="content"
                                       placeholder="">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                        <button type="button" @click="clickToAddCategory()" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    {{--    <script type="text/javascript" charset="utf-8" src="/resources/lib/utf8-php/ueditor.config.js"></script>--}}
    {{--    <script type="text/javascript" charset="utf-8" src="/resources/lib/utf8-php/ueditor.all.js"> </script>--}}
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    {{--    <script type="text/javascript" charset="utf-8" src="/resources/lib/utf8-php/lang/zh-cn/zh-cn.js"></script>--}}
    <script type="text/javascript" charset="utf-8" src="/resources/lib/editor.md-master/editormd.js"></script>
    <script>
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        // var ue     = UE.getEditor('uEditor');
        // var uedesc = UE.getEditor('desc-editor', {
        //     toolbars: [
        //         ['fullscreen', 'source', 'undo', 'redo'],
        //         ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'selectall', 'cleardoc', 'link', 'background', 'inserttable', 'forecolor', 'insertcode']
        //     ],
        //     autoHeightEnabled: true,
        //     autoFloatEnabled: false
        // });
        var testEditor;
        $(function() {
            testEditor = editormd("test-editormd", {
                width: "100%",
                height: 640,
                path : '/resources/lib/editor.md-master/lib/',
                watch : true,
                imageUpload : true,
                saveHTMLToTextarea: true,
                imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL : "/upload-pic",
                placeholder: '赶紧奋笔疾书吧~',
                onload : function(){
                    $("[type=\"file\"]").bind("change", function(){
                        alert($(this).val());
                        testEditor.cm.replaceSelection($(this).val());
                        console.log($(this).val(), testEditor);
                    });
                }
            });
        });

        {{--// var content = '{!! $article ? $article->content : '' !!}';--}}
        var description = $('.text-des').html();
        var title = '{!! isset($article) ? $article->title : '' !!}';
        var isArticle = '{!! $isArticle !!}';

        $(document).ready(function () {
            $('#summernote').summernote('code', description)
            $('#summernote').summernote({
                placeholder: '请填写文章介绍',
                tabsize: 2,
                height: 150,
                code: description
            });
        });

        // UE.getEditor('editor').execCommand('insertHtml', $('.text-content').html())
        // ue.ready(function() {
        //     ue.setContent($('.text-content').html());
        // });
        // uedesc.ready(function() {
        //     uedesc.setContent($('.text-des').html());
        // });
        var v = new Vue({
            el: '.container',
            data: {
                id: '{!! isset($id) ? $id : '' !!}',
                title: title,
                content: null,
                description: description,

                process_parent_id: '{!! isset($pid) ? $pid : '' !!}',
                process_id: '{!! isset($id) ? $id : '' !!}',
                categoryParent: '{!! isset($article) ? $article->parent_category_id : 0 !!}',
                categoryMain: [],
                categoryChild: [],
                categoryChildId: '{!! isset($article) ? $article->child_category_id : 0 !!}',
                isPublic: '{!! isset($article) ? $article->is_public : 1 !!}',
                category: {
                    name: '',
                    desc: '',
                    pid: ''
                },
                first: false,
                wangEditor: null
            },
            mounted() {
                this.requestCategoryMain();
                this.$watch('categoryParent', function (n, o) {
                    if (n) {
                        this.category.pid = n;
                        this.requestCategoryChild();
                    }
                })
                setInterval(function () {
                    v.clickToSubmit('save')
                }, 300000)
            },
            methods: {
                requestCategoryMain() {
                    this.$http.get('/api/category/main').then(function (response) {
                        this.categoryMain = response.body.data;
                        this.category.pid = this.categoryMain[this.categoryMain.length - 1].id;
                        if (!this.categoryParent || this.categoryParent == 0) this.categoryParent = this.category.pid;
                        if (this.categoryMain) {
                            this.requestCategoryChild();
                        }
                    });
                },
                requestCategoryChild() {
                    if (this.categoryParent && !this.first) {
                        this.first = true;
                        this.category.pid = this.categoryParent;
                    }
                    this.$http.get('/api/category/child/' + this.category.pid).then(function (response) {
                        this.categoryChild = response.body.data;
                        if (!this.categoryChildId || this.categoryChildId == 0) this.categoryChildId = this.categoryChild != null && this.categoryChild.length > 0 ? this.categoryChild[0].id : 0;
                    });
                },
                // 添加分类
                clickToAddCategory() {
                    this.$http.post('/api/category/save', this.category).then(function (response) {
                        this.categoryMain = response.body.data;
                        $('#exampleModalCenter').modal('hide');
                        this.requestCategoryMain();
                    });
                },
                clickToSubmit(type) {
                    // this.content     = ue.getAllHtml();
                    this.content = testEditor.getHTML();
                    this.description = $('#summernote').summernote('code');
                    layer.msg('正在保存...', {
                        icon: 16,
                        shade: 0.01
                    });
                    this.$http.post('/book/add/', {
                        title: this.title,
                        content: this.content,
                        description: this.description,
                        id: this.id,
                        markdown: testEditor.getMarkdown(),
                        is_article: '{!! $isArticle !!}',
                        categoryChildId: this.categoryChildId,
                        categoryParent: this.categoryParent,
                        isPublic: this.isPublic,
                        is_markdown: 1
                    }).then(function (response) {
                        var data = response.body;
                        if (data.code === 0) {
                            if (isArticle) setTimeout(function () {
                                if (type === 'save') {
                                    layer.msg('保存成功', {icon: 1});
                                    v.id = data.data;
                                } else {
                                    window.location.href = '/article'
                                }
                            }, 1000); else {
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.layer.close(index);
                            }
                        } else {
                            layer.msg('保存失败', {icon: 6});
                        }
                    })
                }
            }
        })
    </script>
@endsection
