@extends('layout')

@section('header')
    <meta charset="UTF-8" />
    <title>js便笺</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: #222222;
        }

        .note-container {
            position: absolute;
            width: 300px;
            height: 400px;
            background-color: #f3f3f3;
            box-shadow: 0 3px 20px rgba(0,0,0,.25);
            border-radius: 5px;
            overflow: hidden;
        }

        .note-title {
            position: relative;
            width: 100%;
            color: #fff;
            background-color: #6e6e6e;
            user-select: none;
            cursor: default;
        }

        .note-title h6 {
            margin: 0;
            padding-left: 15px;
            font-size: 16px;
            font-weight: 700;
            height: 40px;
            color: #fff;
            line-height: 40px;
        }

        .note-title .btn-close {
            position: absolute;
            height: 40px;
            width: 40px;
            line-height: 40px;
            right: 0;
            top: 0;
            color: #000;
            text-align: center;
            text-decoration: none;
        }

        .note-title .btn-close:hover {
            background-color: #ccc;
            color: #fff;
        }

        .note-content {
            height: 320px;
            padding: 10px;
            overflow-y: auto;
            outline: none;
        }

        .note-footer {
            height: 40px;
            line-height: 40px;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: -o-flex;
            display: flex;
        }

        .note-footer .btn-new, .btn-finish,
        .note-footer .btn-remove {
            flex: 1;
            width: 40px;
            height: 40px;
            color: #333;
            text-align: center;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            outline: none;
            border: none;
            background-color: #ccc;
        }

        .note-footer .btn-new:hover,
        .note-footer .btn-remove:hover {
            opacity: 0.7;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div
        style="width: 40px; height: 40px; cursor: pointer; position:absolute; left: 15px; top: 80px; background: #ccc; font-size: 18px; text-align: center; line-height: 40px;border-radius: 20px"
        @click="clickToShowSprint"
    >
        <i class="fa fa-tasks" style="color: #fff;" aria-hidden="true"></i>
    </div>
    <div
        style="width: 40px; height: 40px; cursor: pointer; position:absolute; left: 15px; top: 130px; background: #ccc; font-size: 18px; text-align: center; line-height: 40px;border-radius: 20px"
        @click="clickToAddSprint"
    >
        <i class="fa fa-plus" style="color: #fff;" aria-hidden="true"></i>
    </div>
    <div
        style="width: 40px; height: 40px; cursor: pointer; position:absolute; left: 15px; top: 180px; background: #ccc; font-size: 18px; text-align: center; line-height: 40px;border-radius: 20px"
        @click="clickToRefresh"
    >
        <i class="fa fa-refresh" style="color: #fff;" aria-hidden="true"></i>
    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="/resources/lib/tag/app.js"></script>
@endsection
