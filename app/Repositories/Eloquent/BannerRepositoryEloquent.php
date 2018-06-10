<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Eloquent;

use App\Criteria\BannerCriteria;
use App\Models\Banner;
use App\Repositories\Contracts\BannerRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class BannerRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class BannerRepositoryEloquent extends BaseRepository implements BannerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Banner::class;
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
    public function getVisibleBanners()
    {
        return $this->with(['image'])
            ->pushCriteria(new BannerCriteria())
            ->orderBy('sort', 'asc')
            ->all();
    }
}
