<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Services;

use App\Repositories\Eloquent\SiteRepositoryEloquent;

/**
 * Class SiteService
 * @package App\Services
 */
class SiteService
{
    /**
     * @var SiteRepositoryEloquent
     */
    protected $siteRepositoryEloquent;

    /**
     * SiteService constructor.
     * @param SiteRepositoryEloquent $siteRepositoryEloquent
     */
    public function __construct(SiteRepositoryEloquent $siteRepositoryEloquent)
    {
        $this->siteRepositoryEloquent = $siteRepositoryEloquent;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->siteRepositoryEloquent->with(['image'])->first();
    }
}
