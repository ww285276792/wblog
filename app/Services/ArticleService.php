<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Services;

use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use Illuminate\Database\Query\Builder;

/**
 * Class ArticleService
 * @package App\Services
 */
class ArticleService
{
    /**
     * @var ArticleRepositoryEloquent
     */
    protected $articleRepositoryEloquent;

    /**
     * ArticleService constructor.
     * @param ArticleRepositoryEloquent $articleRepositoryEloquent
     */
    public function __construct(
        ArticleRepositoryEloquent $articleRepositoryEloquent
    )
    {
        $this->articleRepositoryEloquent = $articleRepositoryEloquent;
    }

    /**
     * @return mixed
     */
    public function getMostCountArticles()
    {
        return $this->articleRepositoryEloquent
            ->scopeQuery(function ($query) {
                /**
                 * @var Builder $query
                 */
                return $query->limit(5)->orderBy('created_at', 'desc');
            })
            ->orderBy('view_account', 'desc')
            ->all();
    }
}
