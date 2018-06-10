<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin\Report;

use App\Criteria\AdminUserReportCriteria;
use App\Http\Controllers\Admin\BaseController;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin\Report
 */
class UserController extends BaseController
{
    /**
     * @var UserRepositoryEloquent
     */
    protected $userRepositoryEloquent;

    /**
     * UserController constructor.
     * @param UserRepositoryEloquent $userRepositoryEloquent
     */
    public function __construct(
        UserRepositoryEloquent $userRepositoryEloquent
    )
    {
        parent::__construct();

        $this->userRepositoryEloquent = $userRepositoryEloquent;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $this->userRepositoryEloquent
            ->pushCriteria(new AdminUserReportCriteria(
                $request->get('created_at_from'),
                $request->get('created_at_to')
            ))
            ->scopeQuery(function ($query) {
                /**
                 * @var Builder $query
                 */
                return $query
                    ->groupBy(DB::raw("FROM_UNIXTIME(UNIX_TIMESTAMP(created_at),'%Y-%m-%d')"))
                    ->orderBy('date');
            })
            ->get([
                DB::raw('count(*) as total'),
                DB::raw("FROM_UNIXTIME(UNIX_TIMESTAMP(created_at),'%Y-%m-%d') as date")
            ]);

        $totalData = array_pluck($data, 'total');
        $total = json_encode($totalData);
        $date = json_encode(array_pluck($data, 'date'));
        $title = trans('report.user.register_user_count').'（'.array_sum($totalData).'）';

        return view('admin.report.user.index', compact(
            'title', 'total', 'date'
        ));
    }
}
