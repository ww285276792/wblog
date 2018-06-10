<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class BaseController
 * @package App\Http\Controllers\Web
 */
class BaseController extends Controller
{
    /**
     * BaseController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        if ($request->get('lang')) {
            app()->setLocale($request->get('lang'));
        }

        app()->setLocale(config('app.locale'));
    }
}
