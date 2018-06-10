<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Criteria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ArticleCriteria
 * @package App\Criteria
 */
class ArticleCriteria implements CriteriaInterface
{
    protected $keyword;

    protected $tag;

    /**
     * ArticleCriteria constructor.
     * @param $keyword
     * @param $tag
     */
    public function __construct($keyword, $tag)
    {
        $this->keyword = $keyword;
        $this->tag = $tag;
    }

    /**
     * @param Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (!empty($this->keyword)) {
            $model = $model->where('title', 'like', '%' . $this->keyword . '%');
        }

        if (!empty($this->tag)) {
            $model = $model->whereHas('tags', function ($query) {
                /**
                 * @var Builder $query
                 */
                $query->where('name', '=', $this->tag);
            });
        }

        return $model;
    }
}
