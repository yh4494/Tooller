@extends("modal")

@section('header')
    <style type="text/css">
        .input-select {
            width: 500px;
            height: auto;
            margin: 0 auto;
            margin-top: 100px;
        }
        * {
            color: #fff;
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
                <a href="javascript:void(0)" style="float: right; margin-top: 18px;"  @click="clickToShowReg(true)">注册</a>
            </form>
        </div>
        <div class="input-select" v-if="isReg" v-cloak>
            <h5 style="margin-bottom: 20px;">注册Tooller</h5>
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">账号</label>
                    <input type="email" v-model="formData.name" class="form-control" placeholder="请输入账号">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">邮箱</label>
                    <input type="email" v-model="formData.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="请输入账号">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">密码</label>
                    <input type="password" v-model="formData.password" class="form-control"  placeholder="请输入密码">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">邀请码</label>
                    <input type="email" v-model="formData.invitationCode" class="form-control" placeholder="请输入邀请码">
                </div>
                <button type="button" class="btn btn-default" @click="clickToRegister(true)">注册</button>
                <a href="javascript:void(0)" style="float: right; margin-top: 18px;" @click="clickToJumpLogin(false)">登录</a>
            </form>
        </div>
    </div>
    @if(env('SHOW_DA_BACKGROUND') == 'TRUE')
        <main style="position: absolute; z-index: -10000">
            <div class="content content--canvas">
                {{--                <h2 class="content__title">Helloweba</h2>--}}
            </div>
        </main>

        <script src="/resources/lib/cool-background/js/noise.min.js"></script>
        <script src="/resources/lib/cool-background/js/util.js"></script>
        <script src="/resources/lib/cool-background/js/coalesce.js"></script>
        <script>
            {setTimeout(() => document.body.classList.add('render'), 60);}
        </script>
    @endif
@endsection

@section('footer')
    <script>
        $(function() {
            document.documentElement.className="js";var supportsCssVars=function(){var e,t=document.createElement("style");return t.innerHTML="root: { --tmp-var: bold; }",document.head.appendChild(t),e=!!(window.CSS&&window.CSS.supports&&window.CSS.supports("font-weight","var(--tmp-var)")),t.parentNode.removeChild(t),e};supportsCssVars()||alert("Please view this demo in a modern browser that supports CSS Variables.");
        })
        new Vue({
            el: '#content-login',
            data: {
                isReg: false,
                formData: {
                    name: '',
                    password: '',
                    confirmPassword: '',
                    email: '',
                    invitationCode: ''
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
                clickToJumpLogin (e) {
                    this.isReg = e;
                },
                clickToRegister () {
                    this.$http.post('/register', this.formData).then(function(data) {
                        var res = data.body;
                        if (res.code !== 0)
                            layer.msg(res.msg, {icon: 5});
                        else {
                            this.isReg = false;
                        }

                    })
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



