<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Models;

use Laratrust\Models\LaratrustRole;

/**
 * Class Role
 * @package App\Models
 */
class Role extends LaratrustRole
{
    protected $fillable = [
        'name', 'display_name', 'description', 'type',
    ];
}
