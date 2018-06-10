<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Validators;

use Illuminate\Contracts\Validation\Factory;
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class AdminRoleValidator
 * @package App\Validators
 */
class AdminRoleValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required|string',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string',
            'display_name' => 'required|string',
            'description' => 'required|string',
        ],
    ];

    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        self::setMessages([
            'name.required' => trans('admin_role.validator.name_required'),
            'name.string' => trans('admin_role.validator.name_string'),
            'display_name.required' => trans('admin_role.validator.display_name_required'),
            'display_name.string' => trans('admin_role.validator.display_name_string'),
            'name.unique' => trans('admin_role.validator.name_unique'),
        ]);
    }
}
