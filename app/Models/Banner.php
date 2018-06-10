<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Banner
 * @package App\Models
 */
class Banner extends Authenticatable
{
    use Notifiable, LogsActivity;

    protected static $logName = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id', 'visible', 'sort'
    ];

    /**
     * Tag constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        self::$logName = trans('banner.manage');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo('App\Models\Image');
    }
}
