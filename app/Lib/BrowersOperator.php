<?php


namespace App\Lib;


use App\Lib\Operator\CommonOperator;
use App\Model\Article;
use Illuminate\Support\Facades\Log;

/**
 * 浏览量计数
 *
 * Class BrowersOperator
 * @package App\Lib
 */
class BrowersOperator implements CommonOperator
{
    public function execute($data)
    {
        if (!$data) {
            Log::info('更新浏览量失败');
            return false;
        }

        $article = Article::find($data);
        if (!$article) {
            Log::info('更新浏览量失败' . $data);
            return false;
        }

        $article->browers_num = $article->browers_num + 1;
        $article->save();
        return true;
    }
}
