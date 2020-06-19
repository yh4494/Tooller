<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Allens Tooller</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/resources/lib/css/common.css">
    <meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/resources/lib/font-awesome-4.7.0/css/font-awesome.css">
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
    <link rel="stylesheet" type="text/css" href="/resources/lib/webuploader-0.1.5/css/webuploader.css" />
    <link rel="stylesheet" type="text/css" href="/resources/lib/webuploader-0.1.5/examples/image-upload/style.css" />
</head>
<body id="app">
    <div style="position: absolute; height: 56px; width: 100%; background: #343a40;"></div>
    <div class="container" v-cloak>
        @include('nav')
        <div id="wrapper" style="display: none">
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
            <div class="btn-group btn-group-toggle" style="margin-top: 15px;" data-toggle="buttons">
                <label class="btn btn-secondary active">
                    <input type="radio" name="options" id="option1" checked> 全部
                </label>
                <label class="btn btn-secondary">
                    <input type="radio" class="plus-allens" name="options" id="option1" checked> <i style="margin-top: 4px; color: #fff" class="fa fa-plus" aria-hidden="true"></i>
                </label>
            </div>
            <div class="book-content" style="margin-top: 15px;">
                <div class="card" :style="'width: 250px; margin-bottom: 10px;' + (item.hidden ? '' : 'box-shadow: #ccc 2px 2px 2px;')" v-for="item in mainData">
                    <img :src="!item.hidden ? '/resources/assets/images/random00' + item.id % 6 + '.jpeg' : ''" v-show="!item.hidden" style="cursor: pointer" @click="clickToShowBook(item.pdf_url)" class="card-img-top" alt="...">
                    <div class="card-body" v-show="!item.hidden">
                        <h5 class="card-title">@{{item.book_name}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/resources/lib/js/vue.min.js"></script>
<script type="text/javascript" src="/resources/lib/webuploader-0.1.5/examples/image-upload/jquery.js"></script>
<script type="text/javascript" src="/resources/lib/webuploader-0.1.5/dist/webuploader.js"></script>
<script type="text/javascript" src="/resources/lib/webuploader-0.1.5/examples/image-upload/upload.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
<script>
    $(function() {
        var plus = false;
        $('.plus-allens').click(function(e) {
            $('#wrapper').toggle()
        })
    })
</script>
</html>
