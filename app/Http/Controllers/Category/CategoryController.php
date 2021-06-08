<?php


namespace App\Http\Controllers\Category;


use App\Http\Controllers\BasicController;
use App\Lib\JsonTooller;
use App\Model\Article;
use App\Model\Category;
use App\Model\Mark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BasicController
{

    private static $visibleNums = 20;

    private static $pageSizeN   = 20;



    /**
     * 获取所有的文章分类
     */
    public function all(Request $request)
    {
        $categorys = Category::where([['user_', '=', $this->userId], ['pid', '!=', 0]])->get();
        return JsonTooller::data(0, '返回成功', $categorys->toArry());
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

    /**
     * 保存分类
     *
     * @param Request $request
     * @return false|string
     */
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|max:20',
            'desc'        => 'max:100',
            'pid'         => 'required'
        ]);

        if ($validator->fails()) {
            return JsonTooller::paramsFail();
        }

        $category = new Category();
        $category->name = $request->get('name');
        $category->desc = $request->get('desc') ?? '';
        $category->pid  = $request->get('pid');

        $category->save();
        return JsonTooller::success();
    }

    /**
     * 获取所有子分类
     * @param $id
     * @return false|string
     */
    public function child($id)
    {
        $childs = Category::where([['user_id', '=', $this->user->id], ['pid', '=', $id]])->get();
        return JsonTooller::data(0, '成功返回', $childs->toArray());
    }


    /**
     * 文章公共查询
     *
     * @param $columns
     * @param $where
     * @return mixed
     */
    private function commonSearchArticle ($selectType = true, $columns, $where, $page = 1, $pageSize = 10, $type = null) {
        $connection = Article::select($columns)->leftjoin('category', 'article.child_category_id', 'category.id');
        $connection->leftjoin('collect', 'article.id', 'collect.collect_id');
        $connection->where($where);
        if ($selectType) {
            $connection->offset(($page - 1) * $pageSize)->limit($pageSize);
        }

        $connection->orderBy('article.create_at', 'desc');
        if ($selectType) {
            return $connection->get();
        }
        return $connection->count();
    }
}
