<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Web;

use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use App\Repositories\Eloquent\BannerRepositoryEloquent;
use App\Repositories\Eloquent\SiteRepositoryEloquent;
use App\Repositories\Eloquent\TagRepositoryEloquent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers\Web
 */
class HomeController extends BaseController
{
    /**
     * @var BannerRepositoryEloquent
     */
    protected $bannerRepositoryEloquent;

    /**
     * @var ArticleRepositoryEloquent
     */
    protected $articleRepositoryEloquent;

    /**
     * @var SiteRepositoryEloquent
     */
    protected $siteRepositoryEloquent;

    /**
     * HomeController constructor.
     * @param Request $request
     * @param BannerRepositoryEloquent $bannerRepositoryEloquent
     * @param ArticleRepositoryEloquent $articleRepositoryEloquent
     * @param SiteRepositoryEloquent $siteRepositoryEloquent
     */
    public function __construct(
        Request $request,
        BannerRepositoryEloquent $bannerRepositoryEloquent,
        ArticleRepositoryEloquent $articleRepositoryEloquent,
        SiteRepositoryEloquent $siteRepositoryEloquent
    )
    {
        parent::__construct($request);

        $this->bannerRepositoryEloquent = $bannerRepositoryEloquent;
        $this->articleRepositoryEloquent = $articleRepositoryEloquent;
        $this->siteRepositoryEloquent = $siteRepositoryEloquent;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $banners = $this->bannerRepositoryEloquent->getVisibleBanners();
        $articles = $this->articleRepositoryEloquent->getArticles();
        $site = $this->siteRepositoryEloquent->with(['image'])->first();

        return view('web.home.index', compact('banners', 'articles', 'site'));
    }
}
