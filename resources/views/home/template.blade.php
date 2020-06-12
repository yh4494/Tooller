@extends('layout')

@section('header')
    <style>
        .operate button{
            margin-right: 10px;
        }
        .table-list {
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    <ul class="nav nav-tabs table-list">
        <li class="nav-item">
            <a class="nav-link @if(isset($route) && $route == 'template_index') active @endif" href="/template">列表</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(isset($route) && $route == 'template_edit') active @endif" href="/template/edit">编辑</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(isset($route) && $route == 'template_create') active @endif" href="/template/create">添加</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(isset($route) && $route == 'template_order') active @endif" href="/template/assign-order">收单</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(isset($route) && $route == 'template_basic') active @endif" href="/template/basic">基础</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(isset($route) && $route == 'template_count') active @endif" href="/template/count">统计</a>
        </li>
    </ul>
    @yield('template')
@endsection

@section('footer')
    <script type="text/javascript" charset="utf-8" src="/resources/lib/utf8-php/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/resources/lib/utf8-php/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/resources/lib/utf8-php/lang/zh-cn/zh-cn.js"></script>
    @yield('script')
    <script>
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');
    </script>
@endsection