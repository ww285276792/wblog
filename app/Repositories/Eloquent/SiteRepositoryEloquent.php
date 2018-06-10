<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Eloquent;

use App\Models\Site;
use App\Repositories\Contracts\SiteRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class SiteRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class SiteRepositoryEloquent extends BaseRepository implements SiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Site::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
