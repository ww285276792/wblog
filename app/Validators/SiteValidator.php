<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Validators;

use \Prettus\Validator\LaravelValidator;

/**
 * Class SiteValidator
 * @package App\Validators
 */
class SiteValidator extends LaravelValidator
{
    protected $rules = [
        'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        'author' => 'required|string',
        'author_description' => 'required|string',
        'site_description' => 'required|string',
        'is_comment' => 'required|integer',
        'is_message' => 'required|integer',
    ];
}
