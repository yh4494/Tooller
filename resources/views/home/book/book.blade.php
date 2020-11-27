@extends('layout')

@section('header')
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Allens Tooller - Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/resources/lib/css/common.css">
    <meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/resources/lib/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="/resources/lib/webuploader-0.1.5/css/webuploader.css" />
    <link rel="stylesheet" type="text/css" href="/resources/lib/webuploader-0.1.5/examples/image-upload/style.css" />
    <style type="text/css">
        [v-cloak] {
            display: none;
        }
        .white-a {
            color: #fff;
        }
        a.white-a :hover {
            color: #fff;
        }
        #uploader .queueList {
            margin: 0 !important;
        }
        #filePicker div:nth-child(2){width:100%!important;height:100%!important;}
    </style>
@endsection

@section('content')
    <div class="container" style="background: #fff; padding-bottom: 20px;" v-cloak>
        <div id="wrapper" v-show="showUploader">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">书籍分类</span>
                </div>
                <input type="text" class="form-control" id="markInput" placeholder="请输入书籍的分类，未指定将会置为未定义分类" aria-label="Dollar amount (with dot and two decimal places)">
            </div>
            <!--头部，相册选择和格式选择-->
            <div id="uploader">
                <div class="queueList">
                    <div id="dndArea" class="placeholder">
                        <div id="filePicker"></div>
                        <p>或将文件拖到这里，单次最多可选300张</p>
                    </div>
                </div>
                <div class="statusBar" style="display:none;">
                    <div class="progress">
                        <span class="text">0%</span>
                        <span class="percentage"></span>
                    </div><div class="info"></div>
                    <div class="btns">
                        <div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="btn-group btn-group-toggle" style="padding-top: 15px;" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" name="options" id="option1" checked> 全部
                </label>
                <label class="btn btn-secondary" id="plus-allens" @click="clickToShowUploader">
                    <input type="radio" id="plus-allens" name="options" id="option1" checked> <i style="margin-top: 4px; color: #fff" class="fa fa-plus" aria-hidden="true"></i>
                </label>
            </div>
            <div class="book-content" style="padding-top: 15px;">
                <template v-for="(i, key) in mainData">
                    <div style="width: 100%">
                        <h5 style="border-radius: 5px; font-weight: bold; color: #666666; padding: 10px 0 10px 10px"><i class="fa fa-bookmark" aria-hidden="true"></i>&nbsp;&nbsp;@{{ key }}</h5>
                    </div>
                    <template v-for="item in i">
                        <div class="card" :style="'width: 250px; margin-bottom: 10px;' + (item.hidden ? '' : 'box-shadow: #ccc 2px 2px 2px;')" >
                            <img :src="!item.hidden ? '/resources/assets/images/random00' + item.id % 6 + '.jpeg' : ''" v-show="!item.hidden" style="cursor: pointer" @click="clickToShowBook(item.pdf_url)" class="card-img-top" alt="...">
                            <div class="card-body" v-show="!item.hidden">
                                <h5 class="card-title">@{{item.book_name}}</h5>
                            </div>
                        </div>
                    </template>
                </template>

            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="/resources/lib/js/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
    <script type="text/javascript" src="/resources/lib/webuploader-0.1.5/examples/image-upload/jquery.js"></script>
    <script type="text/javascript" src="/resources/lib/webuploader-0.1.5/dist/webuploader.js"></script>
    <script type="text/javascript" src="/resources/lib/webuploader-0.1.5/examples/image-upload/upload.js"></script>
@endsection
