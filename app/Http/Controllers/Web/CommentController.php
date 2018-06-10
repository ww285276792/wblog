<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Web;

use App\Criteria\CommentCriteria;
use App\Repositories\Eloquent\ArticleRepositoryEloquent;
use App\Repositories\Eloquent\CommentRepositoryEloquent;
use App\Repositories\Eloquent\SiteRepositoryEloquent;
use App\Validators\CommentValidator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CommentController
 * @package App\Http\Controllers\Web
 */
class CommentController extends BaseController
{
    /**
     * @var ArticleRepositoryEloquent
     */
    protected $articleRepositoryEloquent;

    /**
     * @var CommentRepositoryEloquent
     */
    protected $commentRepositoryEloquent;

    /**
     * @var CommentValidator
     */
    protected $commentValidator;

    /**
     * @var SiteRepositoryEloquent
     */
    protected $siteRepositoryEloquent;

    /**
     * CommentController constructor.
     * @param Request $request
     * @param ArticleRepositoryEloquent $articleRepositoryEloquent
     * @param CommentRepositoryEloquent $commentRepositoryEloquent
     * @param CommentValidator $commentValidator
     * @param SiteRepositoryEloquent $siteRepositoryEloquent
     */
    public function __construct(
        Request $request,
        ArticleRepositoryEloquent $articleRepositoryEloquent,
        CommentRepositoryEloquent $commentRepositoryEloquent,
        CommentValidator $commentValidator,
        SiteRepositoryEloquent $siteRepositoryEloquent
    )
    {
        parent::__construct($request);

        $this->articleRepositoryEloquent = $articleRepositoryEloquent;
        $this->commentRepositoryEloquent = $commentRepositoryEloquent;
        $this->commentValidator = $commentValidator;
        $this->siteRepositoryEloquent = $siteRepositoryEloquent;

        $this->middleware('auth')->only('store');
        $this->middleware('request.throttle:60,60')->only('store');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function index($id)
    {
        $comments = $this->commentRepositoryEloquent
            ->with([
                'user' => function ($query) {
                    $a = "/static/images/user.png";
                    /**
                     * @var Builder $query
                     */
                    $query->select(['id', 'name',
                        DB::raw("CASE WHEN avatar is null THEN '" . $a . "' ELSE avatar END as avatar")
                    ]);
                },
            ])
            ->pushCriteria(new CommentCriteria($id))
            ->orderBy('created_at', 'desc')
            ->paginate(10, [
                'id', 'user_id', 'content', 'created_at'
            ]);

        return response()->json([
            'data' => $comments,
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function store(Request $request, $id)
    {
        try {
            $isComment = $this->siteRepositoryEloquent->first(['is_comment'])->is_comment;

            if ($isComment != 1) {
                return response()->json(trans('article.comment_closed'), 405);
            }

            $data = $request->all();
            $data['user_id'] = $request->user('web')->id;
            $data['article_id'] = $id;
            $this->commentValidator->with($data)->passesOrFail();
            $this->commentRepositoryEloquent->create($data);

            return response()->json([
                'code' => 1,
                'message' => trans('article.create_comment_success'),
            ]);
        } catch (ValidatorException $e) {
            return response()->json([
                'code' => 0,
                'message' => $e->getMessageBag()
            ]);
        }
    }
}
