@extends("modal")

@section('header')
    <style type="text/css">
        .input-select {
            width: 500px;
            height: auto;
            margin: 0 auto;
            margin-top: 100px;
        }
    </style>
@endsection

@section('content')
    <div id="content-login" v-cloak>
        <div class="input-select" v-if="!isReg">
            <h5 style="margin-bottom: 20px;">登录Tooller</h5>
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">账号</label>
                    <input type="text" class="form-control" v-model="formData.name" placeholder="请输入账号">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">密码</label>
                    <input type="password" class="form-control" v-model="formData.password" id="exampleInputPassword1" placeholder="密码">
                </div>
                <button type="button" class="btn btn-primary" @click="clickToShowReg(false)">登录</button>
                <button type="button" class="btn btn-default" @click="clickToShowReg(true)">注册</button>
            </form>
        </div>
        <div class="input-select" v-if="isReg" v-cloak>
            <h5 style="margin-bottom: 20px;">注册Tooller</h5>
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">账号</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="请输入账号">
                    {{--                <small id="emailHelp" class="form-text text-muted">请输入账号</small>--}}
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">邮箱</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="请输入账号">
                    {{--                <small id="emailHelp" class="form-text text-muted">请输入账号</small>--}}
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">密码</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="密码">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">确认密码</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="密码">
                </div>
                <button type="button" class="btn btn-primary" @click="clickToShowReg(false)">登录</button>
                <button type="button" class="btn btn-default" @click="clickToShowReg(true)">注册</button>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        new Vue({
            el: '#content-login',
            data: {
                isReg: false,
                formData: {
                    name: '',
                    password: '',
                    confirmPassword: '',
                    email: ''
                }
            },
            mounted() {
            },
            methods: {
                clickToShowReg: function(e) {
                    this.isReg = e;
                    // this.formData = { name: '', password: '', confirmPassword: '', email: '' };
                    if (!this.isReg) { // 登录
                        if (this.isEmpty(this.formData.name) || this.isEmpty(this.formData.password)) {
                            layer.msg('请填写账号密码', {icon: 5});
                            return;
                        }

                        this.$http.post('/login', this.formData).then(function(data) {
                            var res = data.body;
                            if (res.code !== 0)
                                layer.msg('登录失败，请检查账号密码', {icon: 5});
                            else
                                window.location.href = '/'
                        })
                    }
                },
                isEmpty (some) {
                    if (some === null || some === undefined || some == '') {
                        return true;
                    }
                    return false;
                }
            }
        })
    </script>
@endsection



