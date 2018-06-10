<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Web;

use App\Criteria\ArticleCriteria;
use App\Events\ViewEvent;
use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use App\Repositories\Eloquent\SiteRepositoryEloquent;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

/**
 * Class ArticleController
 * @package App\Http\Controllers\Web
 */
class ArticleController extends BaseController
{
    /**
     * @var ArticleRepositoryEloquent
     */
    protected $articleRepositoryEloquent;

    /**
     * @var SiteRepositoryEloquent
     */
    protected $siteRepositoryEloquent;

    /**
     * ArticleController constructor.
     * @param Request $request
     * @param ArticleRepositoryEloquent $articleRepositoryEloquent
     * @param SiteRepositoryEloquent $siteRepositoryEloquent
     */
    public function __construct(
        Request $request,
        ArticleRepositoryEloquent $articleRepositoryEloquent,
        SiteRepositoryEloquent $siteRepositoryEloquent
    )
    {
        parent::__construct($request);

        $this->articleRepositoryEloquent = $articleRepositoryEloquent;
        $this->siteRepositoryEloquent = $siteRepositoryEloquent;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $tag = $request->get('tag');

        return view('web.article.index', compact('keyword', 'tag'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $article = $this->articleRepositoryEloquent->getArticle($id);
        $comment = $this->siteRepositoryEloquent->first(['is_comment'])->is_comment;

        event(new ViewEvent($article));

        return view('web.article.show', compact('article', 'comment'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArticle(Request $request)
    {
        $articles = $this->articleRepositoryEloquent
            ->pushCriteria(new ArticleCriteria(
                $request->get('keyword'),
                $request->get('tag')
            ))
            ->with([
                'image' => function ($query) {
                    $a = "/images/default.png";
                    /**
                     * @var Builder $query
                     */
                    $query->select(['id', 'path']);
                },
                'tags' => function ($query) {
                    /**
                     * @var Builder $query
                     */
                    $query->select(['id', 'name', 'color']);
                },
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(15, [
                'id', 'image_id', 'title', 'description', 'created_at'
            ]);

        return response()->json([
            'data' => $articles,
        ]);
    }
}
