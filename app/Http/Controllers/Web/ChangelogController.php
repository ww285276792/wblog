<?php
/**
 * User: wangwei
 * Date: 2018/4/18
 */

namespace App\Http\Controllers\Web;

use App\Repositories\Eloquent\ChangelogRepositoryEloquent;
use Illuminate\Http\Request;

/**
 * Class ChangelogController
 * @package App\Http\Controllers\Web
 */
class ChangelogController extends BaseController
{
    /**
     * @var ChangelogRepositoryEloquent
     */
    protected $changelogRepositoryEloquent;

    /**
     * ChangelogController constructor.
     * @param Request $request
     * @param ChangelogRepositoryEloquent $changelogRepositoryEloquent
     */
    public function __construct(
        Request $request,
        ChangelogRepositoryEloquent $changelogRepositoryEloquent
    )
    {
        parent::__construct($request);

        $this->changelogRepositoryEloquent = $changelogRepositoryEloquent;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $changelogs = $this->changelogRepositoryEloquent->orderBy('date', 'desc')->all();

        return view('web.changelog.index', compact('changelogs'));
    }
}
