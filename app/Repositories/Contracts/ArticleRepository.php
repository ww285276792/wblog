<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ArticleRepository
 * @package App\Repositories\Contracts
 */
interface ArticleRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getArticles();

    /**
     * @param $id
     * @return mixed
     */
    public function getArticle($id);

    /**
     * @return mixed
     */
    public function getArticleCount();

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestArticles($limit);
}
