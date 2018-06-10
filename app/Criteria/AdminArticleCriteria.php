<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Criteria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AdminArticleCriteria
 * @package App\Criteria
 */
class AdminArticleCriteria implements CriteriaInterface
{
    protected $title;

    protected $description;

    protected $from;

    protected $to;

    protected $tags;

    /**
     * AdminArticleCriteria constructor.
     * @param $title
     * @param $description
     * @param $from
     * @param $to
     * @param $tags
     */
    public function __construct($title, $description, $from, $to, $tags)
    {
        $this->title = $title;
        $this->description = $description;
        $this->from = $from;
        $this->to = $to;
        $this->tags = $tags;
    }

    /**
     * @param  Model $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (!empty($this->title)) {
            $model = $model->where('title', 'like', '%' . $this->title . '%');
        }

        if (!empty($this->description)) {
            $model = $model->where('description', 'like', '%' . $this->description . '%');
        }

        if (!empty($this->from)) {
            $model = $model->where('created_at', '>', $this->from . ' 00:00:00');
        }

        if (!empty($this->to)) {
            $model = $model->where('created_at', '<', $this->to . ' 24:00:00');
        }

        if (!empty($this->tags)) {
            $model = $model->whereHas('tags', function ($query) {
                /**
                 * @var Builder $query
                 */
                $model = $query->whereIn('id', explode(',', $this->tags));
            });
        }

        return $model;
    }
}
