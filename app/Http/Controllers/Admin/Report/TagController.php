<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Admin\BaseController;
use App\Repositories\Eloquent\TagRepositoryEloquent;

/**
 * Class TagController
 * @package App\Http\Controllers\Admin\Report
 */
class TagController extends BaseController
{
    /**
     * @var TagRepositoryEloquent
     */
    protected $tagRepositoryEloquent;

    /**
     * TagController constructor.
     * @param TagRepositoryEloquent $tagRepositoryEloquent
     */
    public function __construct(
        TagRepositoryEloquent $tagRepositoryEloquent
    )
    {
        parent::__construct();

        $this->tagRepositoryEloquent = $tagRepositoryEloquent;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $title = trans('report.tag.tag_article_count');

        $data = $this->tagRepositoryEloquent
            ->withCount(['articles as value'])
            ->all();

        return view('admin.report.tag.index', compact('data', 'title'));
    }
}
