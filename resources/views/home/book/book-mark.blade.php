@extends('modal')


@section('header')
@endsection

@section('content')
    <a href="{!! $url !!}" target="__blank"><div style="width: 50px; height: 50px; text-align: center; line-height: 50px; border-radius: 25px; font-size: 20px; position: fixed; top: 20px; left: 20px; background: #ccc; z-index: 20000">
        <i class="fa fa-send"></i>
    </div></a>
    <iframe src="{!! $url !!}" style="position: fixed; width: 100%; height: 100%" frameborder="0"></iframe>
@endsection

@section('script')
@endsection
