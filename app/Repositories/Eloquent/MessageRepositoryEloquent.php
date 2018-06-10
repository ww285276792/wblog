<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Repositories\Eloquent;

use App\Models\Message;
use App\Repositories\Contracts\MessageRepository;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class MessageRepositoryEloquent
 * @package App\Repositories\Eloquent
 */
class MessageRepositoryEloquent extends BaseRepository implements MessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Message::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return mixed
     */
    public function getMessageCount()
    {
        return $this->all()->count();
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getLatestMessages($limit)
    {
        return $this->with(['user'])
            ->scopeQuery(function ($query) use ($limit) {
                /**
                 * @var Builder $query
                 */
                return $query->limit($limit);
            })->orderBy('created_at', 'desc')->get();
    }
}
