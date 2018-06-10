<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Validators;

use \Prettus\Validator\LaravelValidator;

/**
 * Class ArticleValidator
 * @package App\Validators
 */
class ArticleValidator extends LaravelValidator
{
    protected $rules = [
        'title' => 'required|string',
        'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        'description' => 'required|string',
        'content' => 'required|string',
        'url' => 'nullable|url',
        'tag' => 'array',
    ];
}
