<?php

namespace App\Http\Controllers\BookMark;

use App\Http\Controllers\BasicController;
use App\Lib\JsonTooller;
use App\Model\Article;
use App\Model\Category;
use App\Model\Mark;
use Illuminate\Http\Request;

class BookMarkController extends BasicController
{
    public function index()
    {
        header('Access-Control-Allow-Origin:*');
        $categorys = Category::where([['user_id', '=', $this->userId], ['pid', '!=', 0]])->get();
        return view('home.book-mark.book-mark', [
            'route'    => 'book-mark',
            'category' => $categorys ?? []
        ]);
    }

    /**
     * 获取连接
     *
     * @param Request $request
     * @return false|string
     */
    public function gainLinks(Request $request)
    {
        $categoryId = $request->get('categoryId');
        $links = Mark::where([['category_id', '=', $categoryId ?? 0]])->get();
        $article = Article::select('id', 'title as name')->where([['user_id', '=', $this->userId], ['child_category_id', '=', $categoryId]])->get();
        foreach ($article as & $item) {
            $item->address = '/book/show/' . $item->id;
        }
        return JsonTooller::successData(array_merge($links ? $links->toArray() : [], $article->toArray()));
    }

    /**
     * 保存连接
     *
     * @param Request $request
     * @return false|string
     */
    public function saveLink(Request $request)
    {
        $name    = $request->get('name');
        $address = $request->get('address');

        if (!$name || !$address) {
            return JsonTooller::paramsFail();
        }

        $link = new Mark();
        $link->name        = $name;
        $link->address     = $address;
        $link->user_id     = $this->userId;
        $link->category_id = $request->get('categoryId') ?? 0;
        $link->save();
        return JsonTooller::success();
    }
}
