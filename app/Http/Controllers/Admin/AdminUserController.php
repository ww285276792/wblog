<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin;

use App\Criteria\AdminUserCriteria;
use App\Models\AdminUser;
use App\Repositories\Eloquent\AdminUserRepositoryEloquent;
use App\Repositories\Eloquent\RoleRepositoryEloquent;
use App\Validators\AdminUserValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class AdminUserController
 * @package App\Http\Controllers\Admin
 */
class AdminUserController extends BaseController
{
    /**
     * @var AdminUserRepositoryEloquent
     */
    protected $adminUserRepositoryEloquent;

    /**
     * @var AdminUserValidator
     */
    protected $adminUserValidator;

    /**
     * @var RoleRepositoryEloquent
     */
    protected $roleRepositoryEloquent;

    protected $roleType = 'backend';

    /**
     * AdminUserController constructor.
     * @param AdminUserRepositoryEloquent $adminUserRepositoryEloquent
     * @param AdminUserValidator $adminUserValidator
     * @param RoleRepositoryEloquent $roleRepositoryEloquent
     */
    public function __construct(
        AdminUserRepositoryEloquent $adminUserRepositoryEloquent,
        AdminUserValidator $adminUserValidator,
        RoleRepositoryEloquent $roleRepositoryEloquent
    )
    {
        parent::__construct();

        $this->adminUserRepositoryEloquent = $adminUserRepositoryEloquent;
        $this->adminUserValidator = $adminUserValidator;
        $this->roleRepositoryEloquent = $roleRepositoryEloquent;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : null;

        $users = $this->adminUserRepositoryEloquent
            ->pushCriteria(new AdminUserCriteria(
                $request->get('name'),
                $request->get('email'),
                $request->get('role_id')
            ))
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        $roles = $this->roleRepositoryEloquent->findWhere([
            'type' => $this->roleType
        ]);

        return view('admin.admin_user.index', compact('users', 'roles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = $this->roleRepositoryEloquent->findWhere([
            'type' => $this->roleType
        ]);

        return view('admin.admin_user.create', compact('roles'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $this->adminUserValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $user = $this->adminUserRepositoryEloquent->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            $role = $this->roleRepositoryEloquent->find($request->get('role_id'));
            $user->attachRole($role);

            return redirect(route('admin_user.index'))->with('success', trans('common.create_success'));
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
        $user = $this->adminUserRepositoryEloquent->find($id);

        $roles = $this->roleRepositoryEloquent->findWhere([
            'type' => $this->roleType
        ]);

        return view('admin.admin_user.edit', compact('user', 'roles'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->adminUserValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $user = $this->adminUserRepositoryEloquent->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ], $id);

            $user->detachRole($user->roles()->first());
            $role = $this->roleRepositoryEloquent->find($request->input('role_id'));
            $user->attachRole($role);

            return redirect(route('admin_user.index'))->with('success', trans('common.update_success'));
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
        /**
         * @var $user AdminUser
         */
        $user = $this->adminUserRepositoryEloquent->find($id);

        if ($user->hasRole('superadministrator')) {
            return redirect()->back()->with('error', trans('admin_user.not_delete_superadmin'));
        }

        if ($user->id == auth()->guard('admin')->user()->id) {
            return redirect()->back()->with('error', trans('admin_user.not_delete_self'));
        }

        $this->adminUserRepositoryEloquent->delete($id);

        return redirect(route('admin_user.index'))->with('success', trans('common.delete_success'));
    }
}
