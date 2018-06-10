<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Validators;

use Illuminate\Contracts\Validation\Factory;
use \Prettus\Validator\LaravelValidator;

/**
 * Class CommentValidator
 * @package App\Validators
 */
class CommentValidator extends LaravelValidator
{
    protected $rules = [
        'content' => 'required|string',
    ];

    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        self::setMessages([
            'content.required' => trans('article.validator.content_required'),
            'content.string' => trans('article.validator.content_string'),
        ]);
    }
}
