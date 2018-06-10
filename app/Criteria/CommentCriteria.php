<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Criteria;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CommentCriteria
 * @package App\Criteria
 */
class CommentCriteria implements CriteriaInterface
{
    protected $articleId;

    /**
     * CommentCriteria constructor.
     * @param $articleId
     */
    public function __construct($articleId)
    {
        $this->articleId = $articleId;
    }

    /**
     * @param  Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (!empty($this->articleId)) {
            $model = $model->where('article_id', $this->articleId);
        }

        return $model;
    }
}
