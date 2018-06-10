<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin;

use App\Criteria\AdminCommentCriteria;
use App\Repositories\Eloquent\CommentRepositoryEloquent;
use Illuminate\Http\Request;

/**
 * Class CommentController
 * @package App\Http\Controllers\Admin
 */
class CommentController extends BaseController
{
    /**
     * @var CommentRepositoryEloquent
     */
    protected $commentRepositoryEloquent;

    /**
     * CommentController constructor.
     * @param CommentRepositoryEloquent $commentRepositoryEloquent
     */
    public function __construct(
        CommentRepositoryEloquent $commentRepositoryEloquent
    )
    {
        parent::__construct();

        $this->commentRepositoryEloquent = $commentRepositoryEloquent;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : null;

        $comments = $this->commentRepositoryEloquent
            ->with(['user', 'article'])
            ->pushCriteria(new AdminCommentCriteria($request->get('name')))
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return view('admin.comment.index', compact('comments'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->commentRepositoryEloquent->delete($id);

        return redirect(route('admin_article_comment.index'))->with('success', trans('common.delete_success'));
    }
}
