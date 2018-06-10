<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Web;

use App\Repositories\Eloquent\SiteRepositoryEloquent;
use Illuminate\Http\Request;

/**
 * Class AboutMeController
 * @package App\Http\Controllers\Web
 */
class AboutMeController extends BaseController
{
    /**
     * @var SiteRepositoryEloquent
     */
    protected $siteRepositoryEloquent;

    /**
     * AboutMeController constructor.
     * @param Request $request
     * @param SiteRepositoryEloquent $siteRepositoryEloquent
     */
    public function __construct(
        Request $request,
        SiteRepositoryEloquent $siteRepositoryEloquent
    )
    {
        parent::__construct($request);

        $this->siteRepositoryEloquent = $siteRepositoryEloquent;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $site = $this->siteRepositoryEloquent->with(['image'])->first();

        return view('web.about.index', compact('site'));
    }
}
