<?php
/**
 * User: wangwei
 * Date: 2018/4/18
 */

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ChangelogRepository
 * @package App\Repositories\Contracts
 */
interface ChangelogRepository extends RepositoryInterface
{
    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestChangelogs($limit);
}
