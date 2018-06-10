<?php
/**
 * User: wangwei
 * Date: 2018/4/18
 */

namespace App\Validators;

use \Prettus\Validator\LaravelValidator;

/**
 * Class ChangelogValidator
 * @package App\Validators
 */
class ChangelogValidator extends LaravelValidator
{
    protected $rules = [
        'version' => 'required|string',
        'date' => 'required|string',
        'content' => 'required|string',
    ];
}
