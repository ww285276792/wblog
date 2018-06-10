<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository
 * @package App\Repositories\Contracts
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getUserCount();

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestUsers($limit);
}
