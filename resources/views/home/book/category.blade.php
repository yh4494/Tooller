@extends('layout')
@section('header')
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        .btn-light {
            background: #606A71;
            color: #fff;
        }

        .filter-option-inner-inner {
            color: #fff;
        }

        .dropdown-item.active, .dropdown-item:active {
            background: #f3f3f3;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="container" style="padding-bottom: 20px; position: relative" v-cloak>
        <div id="list-content">
            <div class="list-allens" style="padding-bottom: 20px; background: #f3f3f3;">
                <li class="animate__animated animate__fadeIn"
                    style="list-style: none; padding-top: 10px; padding-left: 10px;" v-for="item in listLinks">
                    <div style="float: right; padding-right: 20px">
                        <span style="color: #ccc; font-weight: bold; text-align: right">【@{{ item.name }}】</span>
                    </div>
                </li>
            </div>
        </div>
        <div>11112222</div>
    </div>
@endsection


@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="/resources/lib/jqPaginator-2.0.2/jq-paginator.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var vue = new Vue({
                el: '.container',
                data: {
                    listLinks: []
                },
                mounted() {
                    this.getMarkList();
                },
                methods: {

                    getMarkList() {
                        this.$http.get('/api/mark/markPage').then(function (data) {
                            this.listLinks = data.body.data
                            console.log(this.listLinks)
                        })
                    }


                }
            })
        })
    </script>


@endsection
