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
 * Class AdminUserValidator
 * @package App\Validators
 */
class AdminUserValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string',
            'email' => 'required|email|unique:admin_users,email',
            'password' => 'required|string|min:6|confirmed',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ],
    ];

    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        self::setMessages([
            'name.required' => trans('admin_user.validator.name_required'),
            'name.string' => trans('admin_user.validator.name_string'),
        ]);
    }
}
