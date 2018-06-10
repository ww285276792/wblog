<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BannerRepository
 * @package App\Repositories\Contracts
 */
interface BannerRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getVisibleBanners();
}
