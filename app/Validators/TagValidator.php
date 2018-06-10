<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TagValidator
 * @package App\Validators
 */
class TagValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|unique:tags,name',
            'color' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string',
            'color' => 'required',
        ],
    ];
}
