<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepository;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ArticleRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class ArticleRepositoryEloquent extends BaseRepository implements ArticleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Article::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->with(['image', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getArticle($id)
    {
        return $this->with(['image', 'tags'])
            ->withCount(['comments'])
            ->find($id);
    }

    /**
     * @return mixed
     */
    public function getArticleCount()
    {
        return $this->all()->count();
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestArticles($limit)
    {
        return $this->withCount(['comments'])
            ->scopeQuery(function ($query) use ($limit) {
                /**
                 * @var Builder $query
                 */
                return $query->limit($limit);
            })->orderBy('created_at', 'desc')->get();
    }
}
