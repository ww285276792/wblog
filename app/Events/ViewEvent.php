<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ViewEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $model;

    /**
     * ViewEvent constructor.
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
}
