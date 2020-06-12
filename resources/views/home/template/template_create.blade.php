@extends('home.template')

@section('template')
    <form style="margin-top: 20px;" class="formclass">
        <div class="form-group">
            <label for="exampleInputEmail1">主题</label>
            <input type="email" v-model="theme" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="输入主题">
            {{--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>--}}
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">内容</label>
            <script id="editor" v-model="content" type="text/plain" style="width:100%;height:500px;" data-placement="内容"></script>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">备注</label>
            <textarea width="100%" v-model="remark" class="form-control" id="exampleInputPassword1" placeholder="备注"></textarea>
        </div>
    </form>
    <button type="button" class="btn btn-primary">提交</button>
@endsection

@section('script')
    <script>
        var v = new Vue({
            el  : '.formclass',
            data: function () {
                return {
                    theme  : '',
                    content: '',
                    remark : ''
                }
            }
        });
    </script>
@endsection