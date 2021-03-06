@extends('modal')

@section('header')

@endsection

@section('content')
    <div class="container" style="padding: 40px 20px;">
        <form>
            <h3>创建任务</h3>
            <hr>
            <div class="form-group">
                <label for="exampleInputEmail1">任务名称</label>
                <input type="text" class="form-control" v-model="name">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">任务描述</label>
                <textarea type="text" class="form-control" v-model="content"></textarea>
            </div>
            <button type="button" @click="clickToSubmit" class="btn btn-primary">提交</button>
        </form>
    </div>
@endsection

@section('footer')
    <script>
        new Vue({
            el: '.container',
            data: {
                name: '',
                content: '',
                parentId: '{!! $pid !!}'
            },
            methods: {
                clickToSubmit () {
                    this.$http.post('/process/add', { name: this.name, content: this.content, pid: this.parentId }).then(function (response) {
                        var data = response.data;
                        if (data.code !== 0) {
                            layer.msg(data.msg, {icon: 5});
                        } else {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        }
                    })
                }
            }
        })
    </script>
@endsection
