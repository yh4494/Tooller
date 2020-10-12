@extends('layout')

@section('header')
    <style>
        .child-done {
            background: #C5DEB2 !important;
        }
        .sprint {
            display: flex;
            flex-direction: row;
            margin-bottom: 20px;
        }
        .sprint .element {
            width: auto;
            flex: 1;
            box-shadow: #f3f3f3 2px 2px 2px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sprint .element {
            margin-right: 20px;
            border-left: none;
            border-top: none;
        }
        .sprint .element:last-child {
            margin-right: 0px;
        }
        .sprint .element .element-child {

        }
        .sprint .element p {
            padding: 15px 10px 15px 10px;
            border-bottom: 1px solid #f3f3f3;
            border-left: 4px solid orange;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            box-shadow: #f3f3f3 2px 2px 2px;
            border-top: 1px solid #f3f3f3;
            width: 345.67px;
            background: #fff;
            cursor: pointer;
        }
        #cart1 p {
            border-left: 4px solid green;
        }

        #cart2 p {
            border-left: 4px solid #ccc;
        }
        #cart p {
            border-left: 4px solid orangered;
        }
        .sprint .element p:first-child {
            padding-top: 15px;
        }
        .title-flex {
            flex: 1;
            padding-left: 10px;
            height: 30px;
            font-weight: bold;
        }
        .title-flex:first-child {
            padding-left: 0;
        }
    </style>
    <link rel="stylesheet" href="/resources/lib/css/jquery-ui-git.css" rel="external nofollow" >
@endsection

@section('content')
    <div class="container" style="padding-bottom: 20px; zoom: 0;">
        <div class="alert alert-success" v-if="showAlert" role="alert" v-cloak>
            @{{ alertTitle }}
        </div>
        <div style="padding: 15px 0; white-space: nowrap;" id="category" v-cloak>
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary" @click="clickToShowSprint">
                    @if(isset($sprint) && $sprint)
                        <i class="fa fa-tasks" style="color: #fff;" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-th" style="color: #fff;" aria-hidden="true"></i>
                    @endif
                </button>
                @if(isset($sprint) && $sprint)
{{--                    <button type="button" class="btn btn-secondary" @click="clickToShowSprint(0)">--}}
{{--                        未开始--}}
{{--                    </button>--}}
{{--                    <button type="button" class="btn btn-secondary" @click="clickToShowSprint(2)">--}}
{{--                        进行中--}}
{{--                    </button>--}}
{{--                    <button type="button" class="btn btn-secondary" @click="clickToShowSprint(1)">--}}
{{--                        已完成--}}
{{--                    </button>--}}
                @else
                    <button type="button" class="btn btn-secondary" @click="clickToShowHistoryProcess">
                        <i class="fa fa-history" style="color: #fff;" aria-hidden="true"></i>
                    </button>
                    <button type="button" data-toggle="modal" class="btn btn-secondary" @click="showAddProcess()" style="color: #fff;">
                        <i class="fa fa-plus" style="color: #fff;" aria-hidden="true"></i>
                    </button>
                @endif
            </div>
            @if(isset($sprint) && $sprint)

            @else
            <select class="form-control form-control" id="changeCateogry" @change="changeCildCategory" style="max-width: 200px; float: right; background: #6E757C; color: #fff;" >
                <option value="0">全部</option>
                <option v-for="item in mainData" style="color:#fff" :value="item.id" >@{{ item.name }}</option>
            </select>
            @endif
        </div>
        @if(!isset($sprint) || !$sprint)
        <div style="width: 100%;" v-cloak>
            <div  class="animate__animated animate__fadeIn" style="width: 100%; background: #000; margin-bottom: 5px; color: #fff;padding: 10px; border-radius: 8px;">
                今日任务
                <div style="width: 100%; margin-top: 10px; height: 30px; background: #fff; line-height: 30px;padding-left: 5px; box-shadow: #f3f3f3 1px 1px 1px" v-for="i in today" :class="i.status == 1 ? 'child-done' : ''">
                    <i class="fa fa-circle-o"></i>
                    <span>@{{ i.name }}</span>
                    <a v-if="i.status == 0" style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToDoneChildTask(i.pid, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-plus-o" >DONE</i>
                    </a>
                    <a v-if="i.status == 0" style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToShowMind(i.pid, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-sitemap" ></i>
                    </a>
                    <a style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToDeleteChildTask(i.pid, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                    <a v-if="i.status == 1" style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToCancelChildTask(i.pid, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-reply" aria-hidden="true"></i>
                    </a>
                    <a style="float: right; margin: 2px 10px 0 0;" href="javascript:void(0)" @click="clickToAddArticle(i.pid, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <a v-if="i.article !== null" style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToAddArticle(i.pid, i.id, true)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-book" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div v-for="item in listData" :style="item.status == 0 ? 'background: #666666;' : 'background:#99CC33;' " class="animate__animated animate__fadeIn" style="width: 100%; background: #28a745; margin-bottom: 5px; color: #fff;padding: 10px; border-radius: 8px;">
                @{{ item.name }}
                <a href="javascript:void(0)" style="float: right; margin-right: 5px;  color: #fff;" @click="clickToComplete(item.id)">完成</a>
                <a style="float: right; margin-right: 5px; cursor: pointer; color: #fff;" @click="clickToGiveup(item.id)">放弃</a>
                <a style="float: right; margin-right: 5px; cursor: pointer; color: #fff;" @click="showAddProcess(item.id)">子任务</a>

                <div style="width: 100%; margin-top: 10px; height: 30px; background: #fff; line-height: 30px;padding-left: 5px; box-shadow: #f3f3f3 1px 1px 1px" v-for="i in item.child_process" :class="i.status == 1 ? 'child-done' : ''">
                    <i class="fa fa-circle-o"></i>
                    <span>@{{ i.name }}</span>
                    <a v-if="i.status == 0" style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToDoneChildTask(item.id, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-plus-o" >DONE</i>
                    </a>
                    <a v-if="i.status == 0" style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToShowMind(item.id, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-sitemap" ></i>
                    </a>
                    <a style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToDeleteChildTask(item.id, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </a>
                    <a v-if="i.status == 1" style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToCancelChildTask(item.id, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-reply" aria-hidden="true"></i>
                    </a>
                    <a style="float: right; margin: 2px 10px 0 0;" href="javascript:void(0)" @click="clickToAddArticle(item.id, i.id)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <a v-if="i.article !== null" style="float: right; margin: 1px 10px 0 0;" href="javascript:void(0)" @click="clickToAddArticle(item.id, i.id, true)" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <i class="fa fa-book" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
        @else
        <div style="display: flex; flex-direction: row;">
            <div class="title-flex">未开始</div>
            <div class="title-flex" style="margin-left: 15px">进行中</div>
            <div class="title-flex" style="margin-left: 15px">已完成</div>
        </div>
        <div id="sprint-container" class="animate__animated animate__fadeIn" style="width: 100%; height: 100%; overflow: hidden; zoom:0; margin-top: 10px;" v-cloak>
            <div id="catalog" class="sprint" style="height: 99%">
                <div class="aaa element test-5 animate__animated animate__fadeIn" id="cart2" style="width: 400px; max-height: 100%;">
                    @foreach($process[0] as $item)
                        <p class="animate__animated animate__fadeInDown" data-id="{{ $item['id'] }}">{{ $item['name'] }}</p>
                    @endforeach
                </div>

                <div class="aaa element test-5 animate__animated animate__fadeIn" id="cart" style="width: 400px; max-height: 100%;">
                    @foreach($process[2] as $item)
                        <p data-id="{{ $item['id'] }}">{{ $item['name'] }}</p>
                    @endforeach
                </div>

                <div class="aaa element test-5 animate__animated animate__fadeIn" id="cart1" style="width: 400px; max-height: 100%;">
                    @foreach($process[1] as $item)
                    <p class="animate__animated animate__fadeInUp" data-id="{{ $item['id'] }}">{{ $item['name'] }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('footer')
    <script src="/resources/lib/js/jquery-ui.js"></script>
    <script>
        function init () {
            function fun(){
                $(".aaa p").draggable({
                    helper: "clone",
                });
            }
            $(function() {
                fun();
                $(".aaa").droppable({
                    activeClass: "ui-state-default",
                    drop: function(event, ui) {
                        $("<p class='ui-draggable'></p>").text(ui.draggable.text()).appendTo(this);
                        var item = ui.draggable;
                        var id   = item.context.dataset.id;
                        var type = $(this).prop('id');
                        var status;
                        item.remove();

                        switch(type) {
                            case 'cart':
                                status = 2;
                                break;
                            case 'cart1':
                                status = 1;
                                break;
                            case 'cart2':
                                status = 0;
                                break;
                        }

                        $.ajax({
                            url: '/process/change-status?id=' + id + '&status=' + status,
                            method: 'GET',
                            type: 'json',
                            success: function(data) {

                            }
                        })
                        fun();
                    }
                })
                $('#sprint-container').height($(window).height() - 250);
                $(window).resize(function () {
                    $('#sprint-container').height($(window).height() - 250);
                })
            });
        }

        var v = new Vue({
            el  : '.container',
            data: {
                name: '',
                content: '',
                showAlert: false,
                alertTitle: '',
                listData: [],
                mainData: [],
                parentId: 0,
                currentPid: 0,
                history: false,
                sprint: '{!! isset($sprint) && $sprint ? true : false !!}',
                today: []
            },
            methods: {
                showAddProcess (pid = 0) {
                    layer.open({
                        title: '',
                        type: 2,
                        area: ['40%', '400px'],
                        fixed: true, //不固定
                        maxmin: true,
                        content: '/modal/process?pid=' + pid,
                        end: function() {
                            v.requestProcessList();
                            v.requestProcessMain();
                            setTimeout(function () {
                                v.showAlert = false;
                            }, 1500);
                        }
                    });
                },
                clickToAddProcess: function () {
                    $.ajax({
                        url:'/process/add',
                        method: 'POST',
                        type: 'json',
                        data: { name: v.name, content: v.content, pid: this.parentId },
                        success: function(data) {
                            $('#exampleModalCenter').modal('hide')
                            // v.showAlert  = true;
                            // v.alertTitle = "添加process成功";

                            v.requestProcessList();
                            v.requestProcessMain();
                            setTimeout(function () {
                                v.showAlert = false;
                            }, 1500);
                        },
                        error: function () {
                            $('#exampleModalCenter').modal('hide')
                            v.showAlert  = true;
                            v.alertTitle = "添加process失败";
                            setTimeout(function () {
                                v.showAlert = false;
                            }, 1500);
                        }
                    })
                },
                clickToShowSprint () {
                    if (this.sprint) window.location.href = '/process'
                    else window.location.href = '/process?sprint=true'
                },
                clickToDoneChildTask (pid, id) {
                    this.clickToComplete(id)
                },
                clickToShowMind (pid, id) {
                    layer.open({
                        title: '',
                        type: 2,
                        area: ['90%', '90%'],
                        fixed: true, //不固定
                        maxmin: true,
                        content: '/tool/mind?is_modal=true&pid=' + pid + '&id=' + id
                    });
                },
                clickToCancelChildTask (pid, id) {
                    this.$http.get('/process/cancel/' + id).then(function(response) {
                        this.requestProcessList();
                        var data = response.body;
                        if (data.code === 0) {
                            // this.showAlertMethod('取消完成成功');
                            this.requestProcessList(null);
                        } else
                            this.showAlertMethod('取消完成失败');
                    })
                },
                clickToDeleteChildTask (pid, id) {
                    layer.confirm('是否删除该任务？', {
                        btn: ['删除','取消'] //按钮
                    }, function(index){
                        layer.close(index);
                        v.$http.get('/process/delete/' + id).then(function(response) {
                            v.requestProcessList();
                            var data = response.body;
                            if (data.code === 0) {
                                v.requestProcessList(null);
                            }
                        })
                    }, function(){

                    });

                },
                changeCildCategory (e) {
                    console.log(e)
                    console.log($('#changeCateogry').val())
                    this.requestProcessList($('#changeCateogry').val())
                },
                requestProcessList: function (pid) {
                    if (!pid && pid !== 0) pid = this.currentPid;
                    else this.currentPid = pid;
                    this.$http.get('/process/all?pid=' + pid + '&history=' + this.history).then( function(response) {
                        console.log(response.body);
                        this.listData = response.body.data;
                    });
                },
                requestTodayList: function (pid) {
                    this.$http.get('/process/today-task').then( function(response) {
                        this.today = response.body.data;
                    });
                },
                requestProcessMain: function () {
                    this.$http.get('/process/main').then( function(response) {
                        console.log(response.body);
                        this.mainData = response.body.data;
                    });
                },
                clickToGiveup: function (id) {
                    this.$http.get('/process/delete/' + id).then(function(response) {
                        this.requestProcessList();
                        var data = response.body;
                        if (data.code === 0) {
                            // this.showAlertMethod('删除成功');
                            this.requestProcessMain();
                        } else
                            this.showAlertMethod('删除失败');
                    })
                },
                clickToComplete: function (id) {
                    this.$http.get('/process/complete/' + id).then(function(response) {
                        this.requestProcessList();
                        var data = response.body;
                        if (data.code === 0) {
                            this.requestProcessList();
                        } else
                            this.showAlertMethod('完成失败');
                    })
                },
                clickToShowHistoryProcess () {
                    this.history = !this.history;
                    this.requestProcessList();
                },
                clickToAddArticle (pid, id, read = false) {
                    //iframe层-父子操作
                    layer.open({
                        title: '',
                        type: 2,
                        area: ['90%', '90%'],
                        fixed: true, //不固定
                        maxmin: true,
                        content: '/book/add-note?is_modal=true&pid=' + pid + '&id=' + id + '&read=' + read
                    });
                },
                clickToAddChildTask (id) {
                    this.name = '';
                    this.content = '';
                    this.parentId = id;
                },
                showAlertMethod (title) {
                    v.showAlert  = true;
                    v.alertTitle = title;
                    setTimeout(function () {
                        v.showAlert = false;
                    }, 1500);
                }
            },
            mounted: function () {
                this.requestProcessList(null);
                this.requestProcessMain();
                this.requestTodayList()
                init();
            }
        })
</script>
@endsection
