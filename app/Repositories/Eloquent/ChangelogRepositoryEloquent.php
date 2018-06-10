<?php
/**
 * User: wangwei
 * Date: 2018/4/18
 */

namespace App\Repositories\Eloquent;

use App\Models\Changelog;
use App\Repositories\Contracts\ChangelogRepository;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class ChangelogRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class ChangelogRepositoryEloquent extends BaseRepository implements ChangelogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Changelog::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestChangelogs($limit)
    {
        return $this->scopeQuery(function ($query) use ($limit) {
            /**
             * @var Builder $query
             */
            return $query->limit($limit);
        })->orderBy('created_at', 'desc')->get();
    }
}
