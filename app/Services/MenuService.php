<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Services;

use Lavary\Menu\Builder;
use Lavary\Menu\Menu;

/**
 * Class MenuService
 * @package App\Services
 */
class MenuService
{
    /**
     * @var Menu
     */
    protected $menu;

    /**
     * AdminMenuService constructor.
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return Menu
     */
    public function getMenu()
    {
        $routeName = \Route::currentRouteName();

        return $this->menu->make('menu', function (Builder $menu) use ($routeName) {
            $menu->add(trans('menu.home'), [
                'route' => 'home', 'id' => 1
            ]);
//            $menu->add(trans('menu.pic'), [
//                'route' => 'home', 'id' => 2
//            ]);
            $menu->add(trans('menu.message'), [
                'route' => 'message.index', 'id' => 3
            ]);
            $menu->add(trans('menu.changelog'), [
                'route' => 'changelog.index', 'id' => 4
            ]);

            $home = $menu->find(1);
            if (str_contains($routeName, 'home')) {
                $home->attr('class', 'am-active');
            }

            $message = $menu->find(3);
            if (str_contains($routeName, 'message')) {
                $message->attr('class', 'am-active');
            }

            $changelog = $menu->find(4);
            if (str_contains($routeName, 'changelog')) {
                $changelog->attr('class', 'am-active');
            }
        });
    }
}
