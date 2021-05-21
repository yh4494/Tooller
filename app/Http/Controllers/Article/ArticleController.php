<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\BasicController;
use App\Lib\JsonTooller;
use App\Lib\Operator\AbstractOperatorFactory;
use App\Model\Article;
use App\Model\Category;
use App\Model\Collect;
use App\Model\Mark;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArticleController extends BasicController
{
    private static $visibleNums = 20;

    private static $pageSizeN   = 20;

    public function index()
    {
        return view('home.book.book', ['route' => 'book']);
    }

    /**
     * 推荐文章
     *
     * @param Request $request
     * @return false|string
     */
    public function goodArticles(Request $request)
    {
        $count     = Mark::select('id')->count();
        $randomNum = Cache::get('RANMDOM_NUM');
        $seeds     = random_int(1, intval($count / 10));
        while($randomNum == $seeds) {
            $seeds = random_int(1, intval($count / 10));
        }
        Cache::put('RANMDOM_NUM', $seeds, 1);
        $marks = Mark::select('*')->with('category')->offset($seeds * 10)->limit(10)->get();
        return JsonTooller::successData($marks->toArray());
    }

    /**
     * 文章列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article(Request $request)
    {
        $where     = [];
        $isCollect = false;
        $total     = 0;
        $columns   = ['article.id', 'article.title', 'article.child_category_id', 'article.description', 'article.create_at', 'category.name as categoryName', 'is_markdown'];
        $pCategory = Category::where([['pid', '=', 0]])->get();
        $categorys = Category::where([['user_id', '=', $this->userId], ['pid', '!=', 0]])->get();
        if ($request->get('category')) {
            array_push($where, ['child_category_id', '=', $request->get('category')]);
        }

        if ($request->get('pCategory')) {
            array_push($where, ['parent_category_id', '=', $request->get('pCategory')]);
        }

        // 模糊查询
        if ($request->get('searchValue')) {
            $lowerSearchStr = strtolower($request->get('searchValue'));
            array_push($where, [DB::raw('lower(t_article.title)'), 'like', "%{$lowerSearchStr}%"]);
        }

        $page      = $request->get('page') ?? 1;
        $pageSize  = $request->get('pageSize') ?? env('ARTICLE_PAGE_NUMS', self::$pageSizeN);

        if ($request->get('type')) {
            switch ($request->get('type')) {
                case 'public':
                    array_push($where, ['article.is_public', '=', 1]);
                    array_push($where, ['article.user_id', '!=', $this->user->id]);
                    $articles = $this->commonSearchArticle(true, $columns, $where, $page, $pageSize);
                    break;
                case 'collect':
                    $where = [['collect.type', '=', '1'], ['collect.user_id', '=', $this->userId]];
                    array_push($where, ['article.is_public', '=', 1]);
                    if ($request->get('category')) {
                        array_push($where, ['child_category_id', '=', $request->get('category')]);
                    }
                    $articles  = $this->commonSearchArticle(true, $columns, $where, $page, $pageSize, 'collect');
                    $isCollect = true;
                    break;
                case 'collection':
                    break;
            }
        } else {
            if (isset($this->user)) array_push($where, ['article.user_id', '=', $this->user->id]);
            else array_push($where, ['article.is_public', '=', 1]);
            $articles = $this->commonSearchArticle(true, $columns, $where, $page, $pageSize);
        }

        if ($request->get('type') !== 'collection') $total = $this->commonSearchArticle(false, $columns, $where, $pageSize, $isCollect);
        $vsi   = $total % $pageSize == 0 ? $total / $pageSize : $total / $pageSize + 1;
        return view('home.book.book-list', [
            'route'    => 'article',
            'articles' => $articles ?? [],
            'showWay'  => false,
            'type'     => $request->get('type'),
            'category' => $categorys,
            'currentCategory' => $request->get('category') ?? 0,
            'page'     => $page,
            'pageSize' => $pageSize,
            'total'    => $total ?? 0,
            'visible'  => $vsi,
            'visibleN' => static::$visibleNums,
            'searchV'  => $request->get('searchValue') ?? '',
            'pCategory' => $pCategory,
            'currentParentCategory' => $request->get('pCategory') ?? -1
        ]);
    }

    /**
     * mark详情
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function markDetail (Request $request) {
        $url = $request->get('url');
        return view('home.book.book-mark', [
            'url' => $url
        ]);
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

    /**
     * 添加笔记
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addNote(Request $request)
    {
        $article = null;
        if ($request->get('id') && !$request->get('is_article')){
            $article = Article::where('process_id', $request->get('id'))->first();
        } else {
            $article = Article::where('id', $request->get('id'))->first();
        }

        if ($article) {
            $user = User::find($article->user_id);
            $article->user = $user;
            $article->content = str_replace('\n', '', $article->content);
        }

        $request->get('read') == 'true' ? $showView = 'home.book.show_article' : $showView = 'home.book.add_article';
        return view($showView,  [
            'route'   => 'process',
            'pid'     => $request->get('pid'),
            'id'      => $request->get('id'),
            'article' => $article,
            'read'    => $request->get('read') ?? false,
            'isModal' => $request->get('is_modal') ?? false,
            'isArticle' => $request->get('is_article') ?? false,
            'self'    => isset($article) ? $article->user_id == $this->userId : true
        ]);
    }

    /**
     * 添加笔记
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addNoteUeditor(Request $request)
    {
        $article = null;
        if ($request->get('id') && !$request->get('is_article')){
            $article = Article::where('process_id', $request->get('id'))->first();
        } else {
            $article = Article::where('id', $request->get('id'))->first();
        }

        if ($article) {
            $user = User::find($article->user_id);
            $article->user = $user;
            $article->content = str_replace('\n', '', $article->content);
        }

        $request->get('read') == 'true' ? $showView = 'home.book.show_article' : $showView = 'home.book.add_article_ueditor';
        return view($showView,  [
            'route'   => 'process',
            'pid'     => $request->get('pid'),
            'id'      => $request->get('id'),
            'article' => $article,
            'read'    => $request->get('read') ?? false,
            'isModal' => $request->get('is_modal') ?? false,
            'isArticle' => $request->get('is_article') ?? false,
            'self'    => isset($article) ? $article->user_id == $this->userId : true
        ]);
    }

    /**
     * 展示文章
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $article = Article::where('id', $id)->first();
        if ($article) $article->content = str_replace('\n', '', $article->content);
        $collect = Collect::where([['type', '=', 1], ['user_id', '=', $this->userId], ['collect_id', '=', $article->id]])->first();
        $user = User::find($article->user_id);
        $article->user = $user;
        if ($collect) {
            $article->collect = true;
        }

        if ($article->is_public == 0 && $this->userId != $article->user_id) {
            return redirect('/article');
        }

        AbstractOperatorFactory::getFactory(AbstractOperatorFactory::BROWERS_OPRATOR)->execute($article->id);
        return view('home.book.show_article',  [
            'route'   => 'article',
            'id'      => $id,
            'article' => $article,
            'self'    => $this->userId == $article->user_id
        ]);
    }

    /**
     * 添加note
     *
     * @param Request $request
     * @return false|string
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
            'content'     => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return JsonTooller::paramsFail();
        }

        if (!$this->userId) {
            return JsonTooller::unLogin();
        }

        if ($request->get('id') && ($request->get('is_article') == 'false' || !$request->get('is_article'))) {
            $article = Article::where('process_id', $request->get('id'))->first();
        } else {
            $article = Article::where('id', $request->get('id'))->first();
        }
        if (!$article) $article = new Article();

        $article->title              = $request->get('title');
        $article->content            = $request->get('content');
        $article->markdown           = $request->get('markdown');
        $article->description        = $request->get('description');
        $article->process_parent_id  = $request->get('pid');
        $article->user_id            = $request->session()->get('user_id');
        $article->is_public          = $request->get('isPublic');
        $article->parent_category_id = $request->get('categoryParent');
        $article->child_category_id  = $request->get('categoryChildId');
        $article->is_markdown        = $request->get('is_markdown') && $request->get('is_markdown') == 1 ? 1 : 0;

        if ($request->has('is_about')) {
            $article->is_about = $request->get('is_about') ?? 0;
        }

        if (($request->get('is_article') == 'false' || !$request->get('is_article'))) {
            $article->process_id  = $request->get('id');
        }

        if ($article->save()) {
            return JsonTooller::data(0, '返回成功', $article->id);
        }

        return JsonTooller::commonError();
    }

    /**
     * 删除文章
     *
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        Article::find($id)->delete();
        return JsonTooller::success();
    }

    /**
     * 收藏文章
     *
     * @param Request $request
     * @return false|string
     */
    public function collect(Request $request)
    {
        if (!$this->userId) {
            return JsonTooller::unLogin();
        }

        $articleId = $request->get('articleId');
        $isDelete = false;
        $collect = Collect::where([['type', '=', $request->get('type')], ['user_id', '=', $this->userId], ['collect_id', '=', $articleId]])->first();
        if (!$collect) {
            $collect = new Collect();
            $collect->type = $request->get('type');
            $collect->collect_id = $articleId;
            $collect->save();
        } else {
            $collect->delete();
            $isDelete = true;
        }

        $article = Article::find($articleId);
        switch ($collect->type) {
            case 1:
                if ($isDelete) {
                    if ($article->collect_num != 0) $article->collect_num -= $article->collect_num;
                } else {
                    $article->collect_num = $article->collect_num + 1;
                }
                break;
            case 3:
                if ($isDelete) {
                    if ($article->support_num != 0) $article->support_num -= $article->support_num;
                } else {
                    $article->support_num = $article->support_num + 1;
                }
                break;
        }
        $article->save();

        return JsonTooller::success();
    }

}
