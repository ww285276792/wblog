<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin;

use App\Criteria\AdminTagCriteria;
use App\Repositories\Eloquent\TagRepositoryEloquent;
use App\Validators\TagValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class TagController
 * @package App\Http\Controllers\Admin
 */
class TagController extends BaseController
{
    /**
     * @var TagRepositoryEloquent
     */
    protected $tagRepositoryEloquent;

    /**
     * @var TagValidator
     */
    protected $tagValidator;

    /**
     * TagController constructor.
     * @param TagRepositoryEloquent $tagRepositoryEloquent
     * @param TagValidator $tagValidator
     */
    public function __construct(
        TagRepositoryEloquent $tagRepositoryEloquent,
        TagValidator $tagValidator
    )
    {
        parent::__construct();

        $this->tagRepositoryEloquent = $tagRepositoryEloquent;
        $this->tagValidator = $tagValidator;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : null;

        $tags = $this->tagRepositoryEloquent
            ->pushCriteria(new AdminTagCriteria($request->get('name')))
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return view('admin.tag.index', compact('tags'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $this->tagValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $this->tagRepositoryEloquent->create($request->all());

            return redirect(route('admin_tag.index'))->with('success', trans('common.create_success'));
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tag = $this->tagRepositoryEloquent->find($id);

        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->tagValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $this->tagRepositoryEloquent->update($request->all(), $id);

            return redirect(route('admin_tag.index'))->with('success', trans('common.update_success'));
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->tagRepositoryEloquent->delete($id);

        return redirect(route('admin_tag.index'))->with('success', trans('common.delete_success'));
    }
}
