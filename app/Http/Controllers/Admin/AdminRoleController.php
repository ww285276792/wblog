<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin;

use App\Criteria\AdminRoleCriteria;
use App\Models\Role;
use App\Repositories\Eloquent\PermissionRepositoryEloquent;
use App\Repositories\Eloquent\RoleRepositoryEloquent;
use App\Validators\AdminRoleValidator;
use App\Validators\AdminUserValidator;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class AdminRoleController
 * @package App\Http\Controllers\Admin
 */
class AdminRoleController extends BaseController
{
    /**
     * @var RoleRepositoryEloquent
     */
    protected $roleRepositoryEloquent;

    /**
     * @var AdminUserValidator
     */
    protected $adminRoleValidator;

    /**
     * @var PermissionRepositoryEloquent
     */
    protected $permissionRepositoryEloquent;

    protected $roleType = 'backend';

    /**
     * AdminRoleController constructor.
     * @param RoleRepositoryEloquent $roleRepositoryEloquent
     * @param AdminRoleValidator $adminRoleValidator
     * @param PermissionRepositoryEloquent $permissionRepositoryEloquent
     */
    public function __construct(
        RoleRepositoryEloquent $roleRepositoryEloquent,
        AdminRoleValidator $adminRoleValidator,
        PermissionRepositoryEloquent $permissionRepositoryEloquent
    )
    {
        parent::__construct();

        $this->roleRepositoryEloquent = $roleRepositoryEloquent;
        $this->adminRoleValidator = $adminRoleValidator;
        $this->permissionRepositoryEloquent = $permissionRepositoryEloquent;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ? $request->get('limit') : null;

        $roles = $this->roleRepositoryEloquent
            ->pushCriteria(new AdminRoleCriteria(
                $request->get('name'),
                $request->get('display_name'),
                $this->roleType
            ))
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return view('admin.admin_role.index', compact('roles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = $this->permissionRepositoryEloquent->findWhere([
            'type' => $this->roleType
        ]);

        return view('admin.admin_role.create', compact('permissions'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $this->adminRoleValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $role = $this->roleRepositoryEloquent->create([
                'name' => $request->input('name'),
                'display_name' => $request->input('display_name'),
                'description' => $request->input('description'),
                'type' => $this->roleType,
            ]);

            if (is_array($request->input('permission'))) {
                /**
                 * @var $role Role
                 */
                $role = $this->roleRepositoryEloquent->find($role->id);
                $role->attachPermissions($request->input('permission'));
            }

            return redirect(route('admin_user_role.index'))->with('success', trans('common.create_success'));
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
        $role = $this->roleRepositoryEloquent->find($id);

        $permissions = $this->permissionRepositoryEloquent->findWhere([
            'type' => $this->roleType
        ]);

        $perms = array_column($role->permissions->toArray(), 'id');

        return view('admin.admin_role.edit', compact('role', 'permissions', 'perms'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->adminRoleValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $this->roleRepositoryEloquent->update($request->all(), $id);
            /**
             * @var Role $role
             */
            $role = $this->roleRepositoryEloquent->find($id);
            $role->permissions()->sync($request->get('permission'));

            return redirect(route('admin_user_role.index'))->with('success', trans('common.update_success'));
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
        $this->roleRepositoryEloquent->delete($id);

        return redirect(route('admin_user_role.index'))->with('success', trans('common.delete_success'));
    }
}
