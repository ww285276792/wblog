<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MessageRepository
 * @package App\Repositories\Contracts
 */
interface MessageRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getMessageCount();

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestMessages($limit);
}
