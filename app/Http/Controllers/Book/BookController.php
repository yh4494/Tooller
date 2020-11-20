<?php


namespace App\Http\Controllers\Book;


use App\Http\Controllers\BasicController;
use App\Lib\JsonTooller;
use App\Model\Book;

class BookController extends BasicController
{
    public function index()
    {
        $books = Book::where([['user_id', '=', $this->user->id]])->get();
        $tempArr = [];
        foreach ($books as $item) {
            if (empty($item->mark)) {
                $item->mark = '未定义';
            }
            $tempArr[$item->mark][] = $item;
        }
        return JsonTooller::data(0, '返回成功', $tempArr);
    }
}
