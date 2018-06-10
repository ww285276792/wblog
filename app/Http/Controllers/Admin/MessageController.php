<?php
/**
 * User: wangwei
 * Date: 2018/4/18
 */

namespace App\Http\Controllers\Admin;

use App\Criteria\AdminMessageCriteria;
use App\Repositories\Eloquent\MessageRepositoryEloquent;
use Illuminate\Http\Request;

/**
 * Class MessageController
 * @package App\Http\Controllers\Admin
 */
class MessageController extends BaseController
{
    /**
     * @var MessageRepositoryEloquent
     */
    protected $messageRepositoryEloquent;

    /**
     * MessageController constructor.
     * @param MessageRepositoryEloquent $messageRepositoryEloquent
     */
    public function __construct(
        MessageRepositoryEloquent $messageRepositoryEloquent
    )
    {
        parent::__construct();

        $this->messageRepositoryEloquent = $messageRepositoryEloquent;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : null;

        $messages = $this->messageRepositoryEloquent
            ->with(['user'])
            ->pushCriteria(new AdminMessageCriteria($request->get('name')))
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return view('admin.message.index', compact('messages'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->messageRepositoryEloquent->delete($id);

        return redirect(route('admin_message.index'))->with('success', trans('common.delete_success'));
    }
}
