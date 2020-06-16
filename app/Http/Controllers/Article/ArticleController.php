<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\BasicController;
use App\Lib\JsonTooller;
use App\Model\Article;
use App\Model\Collect;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends BasicController
{
    public function index()
    {
        return view('home.book.book', ['route' => 'book']);
    }

    /**
     * 文章列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function article(Request $request)
    {
        $where = [];
        if ($request->get('type')) {
            switch ($request->get('type')) {
                case 'public':
                    array_push($where, ['is_public', '=', 1]);
                    array_push($where, ['user_id', '!=', $this->user->id]);
                    $articles = Article::where($where)->orderBy('create_at', 'desc')->get();
                    break;
                case 'collect':
                    $articles = Article::select('article.*')
                        ->leftjoin('collect', 'article.id', 'collect.collect_id')
                        ->where([['collect.type', '=', '1'], ['collect.user_id', '=', $this->userId]])
                        ->get();
                    break;
            }
        } else {
            array_push($where, ['user_id', '=', $this->user->id]);
            $articles = Article::where($where)->orderBy('create_at', 'desc')->get();
        }
        return view('home.book.book-list', [
            'route'    => 'article',
            'articles' => $articles,
            'showWay'  => false,
            'type'     => $request->get('type')
        ]);
    }

    /**
     * 添加笔记
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addNote(Request $request)
    {
        $article = null;
        if ($request->get('id') && !$request->get('is_article')) $article = Article::where('process_id', $request->get('id'))->first();
        else $article = Article::where('id', $request->get('id'))->first();

        if ($article) $article->content = str_replace('\n', '', $article->content);

        $request->get('read') == 'true' ? $showView = 'home.book.show_article' : $showView = 'home.book.add_article';
        return view($showView,  [
            'route'   => 'process',
            'pid'     => $request->get('pid'),
            'id'      => $request->get('id'),
            'article' => $article,
            'read'    => $request->get('read') ?? false,
            'isModal' => $request->get('is_modal') ?? false,
            'isArticle' => $request->get('is_article') ?? false,
            'self'    => $article->user_id == $this->userId
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

        if ($request->get('id') && ($request->get('is_article') == 'false' || !$request->get('is_article'))) {
            $article = Article::where('process_id', $request->get('id'))->first();
        } else {
            $article = Article::where('id', $request->get('id'))->first();
        }
        if (!$article) $article = new Article();

        $article->title              = $request->get('title');
        $article->content            = $request->get('content');
        $article->description        = $request->get('description');
        $article->process_parent_id  = $request->get('pid');
        $article->user_id            = $request->session()->get('user_id');
        $article->is_public          = $request->get('isPublic');
        $article->parent_category_id = $request->get('categoryParent');
        $article->child_category_id  = $request->get('categoryChildId');

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
        $collect = Collect::where([['type', '=', 1], ['user_id', '=', $this->userId], ['collect_id', '=', $articleId]])->first();
        if (!$collect) {
            $collect = new Collect();
            $collect->type = 1;
            $collect->collect_id = $articleId;
            $collect->save();
        } else {
            $collect->delete();
        }

        return JsonTooller::success();
    }

}
