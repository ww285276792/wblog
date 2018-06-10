<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Web;

use App\Repositories\Eloquent\MessageRepositoryEloquent;
use App\Repositories\Eloquent\SiteRepositoryEloquent;
use App\Validators\MessageValidator;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class MessageController
 * @package App\Http\Controllers\Web
 */
class MessageController extends BaseController
{
    /**
     * @var MessageRepositoryEloquent
     */
    protected $messageRepositoryEloquent;

    /**
     * @var MessageValidator
     */
    protected $messageValidator;

    /**
     * @var SiteRepositoryEloquent
     */
    protected $siteRepositoryEloquent;

    /**
     * MessageController constructor.
     * @param Request $request
     * @param MessageRepositoryEloquent $messageRepositoryEloquent
     * @param MessageValidator $messageValidator
     * @param SiteRepositoryEloquent $siteRepositoryEloquent
     */
    public function __construct(
        Request $request,
        MessageRepositoryEloquent $messageRepositoryEloquent,
        MessageValidator $messageValidator,
        SiteRepositoryEloquent $siteRepositoryEloquent
    )
    {
        parent::__construct($request);

        $this->messageRepositoryEloquent = $messageRepositoryEloquent;
        $this->messageValidator = $messageValidator;
        $this->siteRepositoryEloquent = $siteRepositoryEloquent;

        $this->middleware('auth')->only('store');
        $this->middleware('request.throttle:60,60')->only('store');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $message = $this->siteRepositoryEloquent->first(['is_message'])->is_message;

        return view('web.message.index', compact('message'));
    }

    /**
     * @return JsonResponse
     */
    public function getMessage()
    {
        $messages = $this->messageRepositoryEloquent
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
            ->orderBy('created_at', 'desc')
            ->paginate(10, [
                'id', 'user_id', 'content', 'created_at'
            ]);

        return response()->json([
            'data' => $messages,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $isMessage = $this->siteRepositoryEloquent->first(['is_message'])->is_message;

            if ($isMessage != 1) {
                return response()->json(trans('message.message_closed'), 405);
            }

            $data = $request->all();
            $data['user_id'] = $request->user('web')->id;
            $this->messageValidator->with($data)->passesOrFail();

            $this->messageRepositoryEloquent->create($data);

            return response()->json([
                'code' => 1,
                'message' => trans('message.create_message_success'),
            ]);
        } catch (ValidatorException $e) {
            return response()->json([
                'code' => 0,
                'message' => $e->getMessageBag()
            ]);
        }
    }
}
