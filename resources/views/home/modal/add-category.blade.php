@extends('modal')

@section('header')

@endsection

@section('content')
    <div class="container" style="padding: 40px 20px;">
        <form>
            <h3>创建分类</h3>
            <hr>
            <div class="form-group">
                <label for="exampleInputEmail1">顶级分类</label>
                <select class="custom-select" v-model="categoryParent">
                    @foreach($category as $key => $item)
                        <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                    @endforeach
                </select>
                <small id="emailHelp" class="form-text text-muted">必须选择一个顶级分类</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">分类名称</label>
                <input type="text" class="form-control" v-model="categoryName" id="exampleInputPassword1">
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
                categoryParent: '{{ $category[0]['id'] }}',
                categoryMain: [],
                categoryName: ''
            },
            methods: {
                clickToSubmit () {
                    this.$http.post('/api/category/save', {
                        name: this.categoryName,
                        desc: '',
                        pid: this.categoryParent
                    }).then(function(response) {
                        this.categoryMain = response.body.data;
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    });
                }
            }
        })
    </script>
@endsection
