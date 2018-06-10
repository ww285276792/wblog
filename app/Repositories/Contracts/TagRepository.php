<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TagRepository
 * @package App\Repositories\Contracts
 */
interface TagRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getTags();
}
