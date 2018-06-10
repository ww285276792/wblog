<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CommentRepository
 * @package App\Repositories\Contracts
 */
interface CommentRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getCommentCount();
}
