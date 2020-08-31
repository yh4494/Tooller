<?php

namespace App\Http\Controllers\Modal;

use App\Http\Controllers\BasicController;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModalController extends BasicController
{
    public function category(Request $request)
    {
        $list = Category::where([['pid', '=', 0]])->get();
        return view('home.modal.add-category', [
            'category' => $list
        ]);
    }

    public function mark(Request $request)
    {
        $currentCategoryId = $request->get('currentCategoryId');
        return view('home.modal.add-mark', [
            'currentCategoryId' => $currentCategoryId
        ]);
    }

    public function process(Request $request)
    {
        return view('home.modal.add-process', [
            'pid' => $request->get('pid')
        ]);
    }
}
