<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

/**
 * Class Permission
 * @package App\Models
 */
class Permission extends LaratrustPermission
{
    protected $fillable = [
        'name', 'display_name', 'description',
    ];
}
