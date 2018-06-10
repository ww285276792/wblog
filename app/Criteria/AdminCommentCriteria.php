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
 * Class AdminCommentCriteria
 * @package App\Criteria
 */
class AdminCommentCriteria implements CriteriaInterface
{
    protected $name;

    /**
     * AdminCommentCriteria constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param  Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (!empty($this->name)) {
            $model = $model->whereHas('user', function ($query) {
                /**
                 * @var Builder $query
                 */
                $model = $query->where('name', 'like', '%' . $this->name . '%');
            });
        }

        return $model;
    }
}
