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
 * Class AdminUserCriteria
 * @package App\Criteria
 */
class AdminUserCriteria implements CriteriaInterface
{
    protected $name;

    protected $email;

    protected $roleId;

    /**
     * AdminUserCriteria constructor.
     * @param $name
     * @param $email
     * @param $roleId
     */
    public function __construct($name, $email, $roleId)
    {
        $this->name = $name;
        $this->email = $email;
        $this->roleId = $roleId;
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

        if (!empty($this->email)) {
            $model = $model->where('email', 'like', '%' . $this->email . '%');
        }

        if (!empty($this->roleId)) {
            $model = $model->whereHas('roles', function ($query) {
                /**
                 * @var Builder $query
                 */
                $query->where('id', '=', $this->roleId);
            });
        }

        return $model;
    }
}
