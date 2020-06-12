@extends('layout')

@section('header')

@endsection

@section('content')
    <div class="rel-title"># 时间戳</div>
    <div style="width: 100%; height: 50px; margin-bottom: 15px; overflow: hidden; border: 1px solid #ccc; color: #666666; font-size: 25px; text-align: center; line-height: 50px;">
        @{{time}}
    </div>

    <div class="row">
        <div class="col">
            <input type="text" class="form-control" placeholder="请输入时间">
        </div>
        <div class="col">
            <select class="form-control">
                <option value="1">时间戳转时间</option>
            </select>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="输出时间">
        </div>
    </div>
    <div style="padding: 15px 0 15px 0; font-size: 18px; color: #666666;"># Json transfer or Xml transfer</div>
    <div style="width:50%; border: 1px solid #666666; height: 600px; float: right;"></div>
    <textarea style="width:50%; border: 1px solid #666666; height: 600px; float: left;"></textarea>
@endsection

@section('footer')
    <script>
        var v = new Vue({
            el  : '.container',
            data:{
                time: ''
            },
            mounted: function() {
                var some = setInterval(function () {
                    var date = new Date ();
                    v.time = date.getFullYear() + "年" + (date.getMonth() + 1) + "月" + date.getDay() + "日" + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds() + " " + date.getTime();
                }, 1000);
            }
        })
    </script>
@endsection