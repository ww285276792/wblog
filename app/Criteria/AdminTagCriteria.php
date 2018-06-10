<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Criteria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AdminTagCriteria
 * @package App\Criteria
 */
class AdminTagCriteria implements CriteriaInterface
{
    protected $name;

    /**
     * AdminTagCriteria constructor.
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
            $model = $model->where('name', 'like', '%' . $this->name . '%');
        }

        return $model;
    }
}
