<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Class ErrorController
 * @package App\Http\Controllers\Admin
 */
class ErrorController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unauthorized()
    {
        return view('error.401');
    }
}
