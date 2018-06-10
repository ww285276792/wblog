<?php
/**
 * User: wangwei
 * Date: 2018/4/18
 */

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Changelog
 * @package App\Models
 */
class Changelog extends Authenticatable
{
    use Notifiable, LogsActivity;

    protected static $logName = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version', 'date', 'content'
    ];

    /**
     * Tag constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        self::$logName = trans('changelog.manage');
    }
}
