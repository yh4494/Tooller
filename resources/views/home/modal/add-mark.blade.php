@extends('modal')

@section('header')

@endsection

@section('content')
    <div class="container" style="padding: 40px 20px;">
        <form>
            <h3>创建分类</h3>
            <hr>
            <div class="form-group">
                <label for="exampleInputPassword1">标题</label>
                <input type="text" class="form-control" v-model="name" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">地址</label>
                <input type="text" class="form-control" v-model="address" id="exampleInputPassword1">
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
                currentCategoryId: '{!! $currentCategoryId !!}',
                name: '',
                address: ''
            },
            methods: {
                clickToSubmit () {
                    var url = ('/api/mark/save?categoryId=' + this.currentCategoryId + '&name=' + this.name + '&address=' + this.address)
                    this.$http.get(url).then(function (response) {
                        var data = response.body;
                        if (data.code !== 0) {
                            layer.msg(data.msg, {icon: 5});
                        }
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    })
                }
            }
        })
    </script>
@endsection
