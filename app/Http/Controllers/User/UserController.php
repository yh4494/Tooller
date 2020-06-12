<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BasicController;
use App\Lib\JsonTooller;
use App\Model\Article;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class UserController extends BasicController
{
    /**
     * 登录
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:255',
            'password'    => 'required'
        ]);

        if ($validator->fails()) {
            return JsonTooller::paramsFail();
        }

        $user = User::where(['name' => $request->get('name')])->first();
        if ($user->password == md5($request->get('password'))) { // 登录成功
            $request->session()->put('user_id', $user->id);
            Cache::put($user->id, json_encode($user), 60 * 24 * 7);
            return JsonTooller::success();
        }

        return JsonTooller::commonError();
    }

    /**
     * 注册接口
     */
    public function register()
    {

    }

    /**
     * 退出登录
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $request->session()->remove('user_id');
        return redirect('/login');
    }

    /**
     * 关于界面
     *
     * @param Request $request
     */
    public function about(Request $request)
    {
        $article = Article::where([['is_about', '=', 1], ['user_id', '=', $request->session()->get('user_id')]])->first();
        return view('home.about.about', [
            'route'   => 'about',
            'article' => $article,
            'edit'    => $article && !$request->get('edit') ? false : true
        ]);
    }

    /**
     * 关于界面
     *
     * @param Request $request
     */
    public function aboutShow(Request $request, $id)
    {
        $article = Article::where([['is_about', '=', 1], ['user_id', '=', $request->session()->get('user_id')]])->first();
        return view('home.about.about', [
            'route'   => 'about',
            'article' => $article,
            'edit'    => false
        ]);
    }

    public function timeLine(Request $request)
    {
        return view('home.time-line.time-line', ['route' => 'time-line']);
    }
}
