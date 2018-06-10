<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Http\Controllers;

use Mews\Captcha\Facades\Captcha;

/**
 * Class CaptchaController
 * @package App\Http\Controllers
 */
class CaptchaController extends Controller
{
    /**
     * @return string
     */
    public function getPath()
    {
        return Captcha::src();
    }
}
