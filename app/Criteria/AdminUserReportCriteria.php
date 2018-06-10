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
 * Class AdminUserReportCriteria
 * @package App\Criteria
 */
class AdminUserReportCriteria implements CriteriaInterface
{
    protected $from;

    protected $to;

    /**
     * AdminUserReportCriteria constructor.
     * @param $from
     * @param $to
     */
    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param  Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (!empty($this->from)) {
            $model = $model->where('created_at', '>=', $this->from . ' 00:00:00');
        }

        if (!empty($this->to)) {
            $model = $model->where('created_at', '<=', $this->to . ' 24:00:00');
        }

        return $model;
    }
}
