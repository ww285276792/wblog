<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Listeners;

use App\Events\ViewEvent;
use Illuminate\Database\Eloquent\Model;

class ViewListener
{
    /**
     * @param ViewEvent $viewEvent
     */
    public function handle(ViewEvent $viewEvent)
    {
        /**
         * @var Model $model
         */
        $model = $viewEvent->model;

        $model->update([
            'view_account' => $model->view_account + 1
        ]);
    }
}
