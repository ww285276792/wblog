<?php
/**
 * User: wangwei
 * Date: 2018/4/18
 */

namespace App\Http\Controllers\Admin;

use App\Criteria\AdminChangelogCriteria;
use App\Repositories\Eloquent\ChangelogRepositoryEloquent;
use App\Validators\ChangelogValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ChangelogController
 * @package App\Http\Controllers\Admin
 */
class ChangelogController extends BaseController
{
    /**
     * @var ChangelogRepositoryEloquent
     */
    protected $changelogRepositoryEloquent;

    /**
     * @var ChangelogValidator
     */
    protected $changelogValidator;

    /**
     * ChangelogController constructor.
     * @param ChangelogRepositoryEloquent $changelogRepositoryEloquent
     * @param ChangelogValidator $changelogValidator
     */
    public function __construct(
        ChangelogRepositoryEloquent $changelogRepositoryEloquent,
        ChangelogValidator $changelogValidator
    )
    {
        parent::__construct();

        $this->changelogRepositoryEloquent = $changelogRepositoryEloquent;
        $this->changelogValidator = $changelogValidator;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : null;

        $changelogs = $this->changelogRepositoryEloquent
            ->pushCriteria(new AdminChangelogCriteria($request->get('version')))
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return view('admin.changelog.index', compact('changelogs'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.changelog.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $this->changelogValidator->with($request->all())->passesOrFail();

            $this->changelogRepositoryEloquent->create($request->all());

            return redirect(route('admin_changelog.index'))->with('success', trans('common.create_success'));

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
        $changelog = $this->changelogRepositoryEloquent->find($id);

        return view('admin.changelog.edit', compact('changelog'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->changelogValidator->with($request->all())->passesOrFail();

            $this->changelogRepositoryEloquent->update($request->all(), $id);

            return redirect(route('admin_changelog.index'))->with('success', trans('common.update_success'));
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
        $this->changelogRepositoryEloquent->delete($id);

        return redirect(route('admin_changelog.index'))->with('success', trans('common.delete_success'));
    }
}
