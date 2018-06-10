<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Validators;

use \Prettus\Validator\LaravelValidator;

/**
 * Class AdminResetPasswordValidator
 * @package App\Validators
 */
class AdminResetPasswordValidator extends LaravelValidator
{
    protected $rules = [
        'old_password' => 'required|string',
        'new_password' => 'required|string|min:6|confirmed',
    ];
}
