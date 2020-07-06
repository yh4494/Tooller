@extends('layout')

@section('header')
{{--    <script src="/resources/lib/wangEditor/wangEditor.css"></script>--}}
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        .w-e-text-container {
            height: 500px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container" style="padding-top: 1px;">
        <h4 style="padding: 20px 0">关于你自己</h4>
        <div id="editor" style="height: auto !important;">
            <p>请 <b>编辑你自己的关于</b> 介绍</p>
        </div>
    </div>
@endsection

@section('footer')
    <script src="/resources/lib/wangEditor-3.1.1/release/wangEditor.js"></script>
    <script>
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        $(function() {
            var v = new Vue({
                el: '.container',
                data: {
                    id: '{!! isset($article) ? $article->id : '' !!}',
                    title: '关于自己',
                    content: this.content,
                    description: '关于自己',
                    process_parent_id: '{!! isset($pid) ? $pid : '' !!}',
                    process_id: '{!! isset($id) ? $id : '' !!}',
                },
                mounted () {
                    var E = window.wangEditor;
                    var editor = new E('#editor');
                    // 自定义菜单配置
                    editor.customConfig.menus = [
                        'head',  // 标题
                        'bold',  // 粗体
                        'fontSize',  // 字号
                        'fontName',  // 字体
                        'italic',  // 斜体
                        'underline',  // 下划线
                        'strikeThrough',  // 删除线
                        'foreColor',  // 文字颜色
                        'backColor',  // 背景颜色
                        'link',  // 插入链接
                        'list',  // 列表
                        'justify',  // 对齐方式
                        'quote',  // 引用
                        'emoticon',  // 表情
                        // 'image',  // 插入图片
                        'table',  // 表格
                        'video',  // 插入视频
                        'code',  // 插入代码
                        'undo',  // 撤销
                        'redo'  // 重复
                    ];
                    // 或者 var editor = new E( document.getElementById('editor') )
                    editor.create();

                },
                methods: {
                    clickToSubmit () {
                        this.content = ue.getAllHtml();
                        this.$http.post('/book/add/', {
                            title: this.title,
                            content: this.content,
                            description: this.description,
                            is_about: 1,
                            id: this.id
                        }).then(function(response) {
                            var data = response.body;
                            if (data.code === 0) {
                                window.location.href = '/about/' + data.data
                            } else {
                                layer.msg('操作失败', {icon: 5});
                            }
                        })
                    }
                }
            })
        })
    </script>
@endsection
