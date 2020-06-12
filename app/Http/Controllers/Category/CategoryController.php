<?php


namespace App\Http\Controllers\Category;


use App\Http\Controllers\BasicController;
use App\Lib\JsonTooller;
use App\Model\Category;
use Illuminate\Http\Request;

class CategoryController extends BasicController
{
    /**
     * 获取所有的文章分类
     */
    public function all(Request $request)
    {

    }

    /**
     * 获取pid为0的分类
     *
     * @param Request $request
     * @return false|string
     */
    public function main(Request $request)
    {
        $list = Category::where([['pid', '=', 0]])->get();
        return JsonTooller::data(0, '返回成功', array_reverse($list->toArray()));
    }
}
