<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\BasicController;

class TimeToolController extends BasicController
{
    /**
     * 时间工具
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home.tool.time', ['route' => 'tool']);
    }

    /**
     * 加密工具
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function crypt()
    {
        return view('home.tool.crypt', ['route' => 'tool']);
    }
}
