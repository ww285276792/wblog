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
 * Class AdminRoleCriteria
 * @package App\Criteria
 */
class AdminRoleCriteria implements CriteriaInterface
{
    protected $name;

    protected $display_name;

    protected $type;

    /**
     * AdminRoleCriteria constructor.
     * @param $name
     * @param $display_name
     * @param $type
     */
    public function __construct($name, $display_name, $type)
    {
        $this->name = $name;
        $this->display_name = $display_name;
        $this->type = $type;
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

        if (!empty($this->display_name)) {
            $model = $model->where('display_name', 'like', '%' . $this->display_name . '%');
        }

        if (!empty($this->type)) {
            $model = $model->where('type', $this->type);
        }

        return $model;
    }
}
