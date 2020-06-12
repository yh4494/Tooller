<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\BasicController;
use Illuminate\Http\Request;

class HomeController extends BasicController
{

    public function index ()
    {
        return view('index', ['route' => 'home']);
    }

    /**
     * 模板编辑页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function template () {
        return view('home.template.template_index', ['route' => 'template_index']);
    }

    /**
     * 模板编辑
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('home.template.template_edit', ['route' => 'template_edit']);
    }

    /**
     * 创建模板
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('home.template.template_create', ['route' => 'template_create']);
    }

    /**
     * 收单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignOrder()
    {
        return view('home.order.assign_order', ['route' => 'template_order']);
    }

    /**
     * 开发工具
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function development()
    {
        return view('home.development.development_json', ['route' => 'development']);
    }

    public function login(Request $request)
    {
        return view('home.login.login');
    }
}
