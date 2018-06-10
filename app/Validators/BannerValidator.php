<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class BannerValidator
 * @package App\Validators
 */
class BannerValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'visible' => 'required|integer',
            'sort' => 'required|integer',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'visible' => 'required|integer',
            'sort' => 'required|integer',
        ],
    ];
}
