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
        .operator-line {
            width: 1080px;
            height: 36px;
        }

        .pagination>li>a, .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            line-height: 1.42857143;
            text-decoration: none;
            color: #666666;
            background-color: #fff;
            border: 1px solid #ddd;
            margin-left: -1px;
        }
        .pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus {
            z-index: 2;
            color: #fff;
            background-color: #343A40;
            border-color: #343A40;
            cursor: default;
        }
    </style>
@endsection

@section('content')
    <div class="container" style="padding-bottom: 20px; position: relative" v-cloak>
        <div id="list-content">
            <div style="padding-top: 15px"></div>
            <div class="list-allens" style="padding-bottom: 20px; background: #f3f3f3;">
                <ul class="list-of-categoriess">
                    <li class="animate__animated animate__fadeIn"
                        style="overflow: hidden; min-height: 50px; height: auto !important; padding-right: 10px;
                         padding-bottom: 10px;
                         padding-top: 10px;" v-for="item in listLinks">
                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                        <span style="color: #6699CC; font-weight: bold;"> 【@{{ item.name }}】</span>
                    </li>
                </ul>
            </div>
        </div>
        <div style="padding-top: 15px"></div>
        <div class="operator-line">
            <ul id="paginator" style="position: center " class="pagination"></ul>
        </div>

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
                    $('#paginator').jqPaginator({
                        totalPages:  1,
                        visiblePages: 4,
                        currentPage: 1,
                        onPageChange: function (num, type) {

                        }
                    });
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
