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
 * Class AdminChangelogCriteria
 * @package App\Criteria
 */
class AdminChangelogCriteria implements CriteriaInterface
{
    protected $version;

    /**
     * AdminChangelogCriteria constructor.
     * @param $version
     */
    public function __construct($version)
    {
        $this->version = $version;
    }

    /**
     * @param  Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (!empty($this->version)) {
            $model = $model->where('version', 'like', '%' . $this->version . '%');
        }

        return $model;
    }
}
