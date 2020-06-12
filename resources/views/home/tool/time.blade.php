@extends('layout')

@section('header')

@endsection

@section('content')
    <div class="rel-title"><div></div> 当前时间</div>
    <div style="width: 100%; height: 50px; overflow: hidden; border: 1px solid #ccc; color: #666666; font-size: 25px; text-align: center; line-height: 50px;">
        @{{time}}
    </div>

    <div class="rel-title"><div></div>时间转换</div>
    <div class="row">
        <div class="col">
            <input type="text" v-model="inputTransferTime" class="form-control" placeholder="请输入需要转换的时间戳">
        </div>
        <div class="col-2" style="line-height: 40px; text-align: center">
            时间戳 >> 时间
        </div>
        <div class="col">
            <input type="text" v-model="outputTransferTime" class="form-control" placeholder="output">
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <input type="text" v-model="inputTransferTime" class="form-control" placeholder="请输入需要转换的日期: 格式 2019-02-11 00:08:29">
        </div>
        <div class="col-2" style="line-height: 40px; text-align: center">
            时间 >> 时间戳
        </div>
        <div class="col">
            <input type="text" v-model="outputTransferTime" class="form-control" placeholder="output">
        </div>
    </div>

    <div class="row">

    </div>
@endsection

@section('footer')
    <script src="/resources/lib/js/time-transfer.js"></script>
    <script>
        var week   = '';
        switch (new Date().getDay()) {
            case 0: week = '星期日'; break;
            case 1: week = '星期一'; break;
            case 2: week = '星期二'; break;
            case 3: week = '星期三'; break;
            case 4: week = '星期四'; break;
            case 5: week = '星期五'; break;
            case 6: week = '星期六'; break;
        }

        var v = new Vue({
            el  : '.container',
            data:{
                time: '',
                inputTransferTime: '',
                outputTransferTime: ''
            },
            watch: {
                inputTransferTime : function (newV, oldV) {
                    var date;
                    if (isNaN(parseInt(newV))) {
                       return;
                    }
                    date = new Date(parseInt(newV));
                    v.outputTransferTime = formatTime(date);
                }
            },
            mounted: function() {
                var some = setInterval(function () {
                    var date = new Date ();
                    v.time = date.getFullYear() + "年" + (date.getMonth() + 1) + "月" + date.getDate() + "日" + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds() + " " + week + " " + date.getTime();
                }, 1000);
            }
        })
    </script>
@endsection