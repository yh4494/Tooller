@extends('layout')

@section('header')
    <style>

    </style>
@endsection

@section('content')
    <div class="book-content container">
        <div class="btn-group btn-group-toggle" style="margin: 15px 0;" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="options" id="option1" checked> 全部
            </label>
            <label class="btn btn-secondary" @click="clickToPlusArticle()">
                <input type="radio" name="options" id="option1" checked> <i style="margin-top: 4px; color: #fff" class="fa fa-plus" aria-hidden="true"></i>
            </label>
        </div>
        <a href="/resources/lib/pdf/web/viewer.html?file=/resources/assets/book/程序员必读之软件架构.pdf" target="_blank">
            <div class="book-item"></div>
        </a>

    </div>


@endsection

@section('footer')
    <script>
        var vue = new Vue({
            el: '.container',
            methods: {
                clickToPlusArticle: function(e) {
                    //iframe层-父子操作
                    layer.open({
                        title: '',
                        type: 2,
                        area: ['90%', '90%'],
                        fixed: true, //不固定
                        maxmin: true,
                        content: '/book/add-note?pid=' + pid + '&id=' + id + '&read=' + read
                    });
                }
            }
        })
    </script>
@endsection
