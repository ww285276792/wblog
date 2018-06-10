<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserRepository;
use App\User;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
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
    public function getUserCount()
    {
        return $this->all()->count();
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestUsers($limit)
    {
        return $this->scopeQuery(function ($query) use ($limit) {
            /**
             * @var Builder $query
             */
            return $query->limit($limit);
        })->orderBy('created_at', 'desc')->get();
    }
}
