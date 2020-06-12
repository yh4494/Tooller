@extends('layout')

@section('header')

@endsection

@section('content')
    <div class="rel-title"><div></div>MD5 加密</div>
    <div class="row" v-cloak>
        <div>
            <form class="form-inline mb-2">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="inputPassword2" class="sr-only"></label>
                    <input type="text" style="width: 400px;" v-model="md5String" class="form-control" id="inputPassword2" placeholder="请输入md5加密串"/>
                </div>
                <button type="button" @click="clickToTransferMd5" class="btn btn-primary mb-2">转换</button>
            </form>
        </div>

        <br/>
        <div class="mx-sm-3 mb-2" style="clear: both; width: 100%; margin-top: 20px;">
            <div>@{{md5Small}}</div>
            <br/>
            <div>@{{md5Large}}</div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="/resources/lib/js/md5.js"></script>
    <script>
        new Vue({
            el: '.row',
            data: {
                md5String: '',
                md5Small: '',
                md5Large: ''
            },
            mounted () {
            },
            methods: {
                clickToTransferMd5: function() {
                    this.md5Small = hex_md5(this.md5String);
                    this.md5Large = hex_md5(this.md5String).toUpperCase();
                }
            }
        })
    </script>
@endsection
