@extends('layout')

@section('header')
    <link rel="stylesheet" href="/resources/lib/time-line/css/style.css">
@endsection

@section('content')
    <div class="container">
        <div class="container-allens-time" style="margin-left: 50px;padding-bottom: 20px">
            <ul>
                @foreach($data as $key => $item)
                <li>
                    <span></span>
                    @foreach($item as $i => $s)
                    <div>
                        <div class="title" @if(!$s->process_name) style="display: none" @endif>任务：{{ $s->process_name }}</div>
                        <div class="info">文章：<a href="/book/show/{{ $s->article_id  }}">{{ $s->article_name }}</a></div>
{{--                        <div class="type">Prensetation</div>--}}
                        <hr @if(count($item) == $i + 1) style="display: none" @endif>
                    </div>
                    <span class="number">
                        <span>{{ $key }}</span>
                        <span></span>
                    </span>
                    @endforeach
                </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection
