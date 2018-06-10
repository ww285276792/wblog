<?php
/**
 * User: wangwei
 * Date: 2018/4/15
 */

namespace App\Services;

use Lavary\Menu\Builder;
use Lavary\Menu\Menu;

/**
 * Class AdminMenuService
 * @package App\Services
 */
class AdminMenuService
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

        return $this->menu->make('adminMenu', function (Builder $menu) use ($routeName) {
            $this->setConsoleMenu($menu, $routeName);
            $this->setArticleMenu($menu, $routeName);
            $this->setTagMenu($menu, $routeName);
            $this->setMessageMenu($menu, $routeName);
            $this->setChangelogMenu($menu, $routeName);
            $this->setAdminUserMenu($menu, $routeName);
            $this->setSiteMenu($menu, $routeName);
        });
    }

    /**
     * 控制台
     *
     * @param $menu
     * @param $routeName
     */
    public function setConsoleMenu(Builder $menu, $routeName)
    {
        $menu
            ->add('<span>' . trans('admin_menu.dash') . '</span>', [
                'route' => 'admin.dash', 'id' => 1
            ])
            ->prepend('<i class="fa fa-dashboard"></i>');
        $dash = $menu->find(1);

        if (str_contains($routeName, 'admin.dash')) {
            $dash->attr('class', 'open');
        }
    }

    /**
     * 标签管理
     *
     * @param Builder $menu
     * @param $routeName
     */
    public function setTagMenu(Builder $menu, $routeName)
    {
        $menu
            ->add('<span>' . trans('admin_menu.manage_tag') . '</span>', [
                'class' => 'menu-accordion', 'id' => 2
            ])
            ->prepend('<i class="fa fa-tag"></i>');
        $tag = $menu->find(2);

        $tag->add(trans('admin_menu.tag'), [
            'route' => 'admin_tag.index',
            'id' => 21
        ]);
        $taglevel1 = $menu->find(21);

        if (str_contains($routeName, 'admin_tag')) {
            $tag->attr('class', 'open menu-accordion');
            $taglevel1->active();
        }
    }

    /**
     * 文章管理
     *
     * @param Builder $menu
     * @param $routeName
     */
    public function setArticleMenu(Builder $menu, $routeName)
    {
        $menu
            ->add('<span>' . trans('admin_menu.manage_article') . '</span>', [
                'class' => 'menu-accordion', 'id' => 4
            ])
            ->prepend('<i class="fa fa-book"></i>');
        $tag = $menu->find(4);

        $tag->add(trans('admin_menu.article'), [
            'route' => 'admin_article.index',
            'id' => 41
        ]);
        $taglevel1 = $menu->find(41);

        if (str_contains($routeName, 'admin_article') && !str_contains($routeName, 'admin_article_comment')) {
            $tag->attr('class', 'open menu-accordion');
            $taglevel1->active();
        }

        $tag->add(trans('admin_menu.comment'), [
            'route' => 'admin_article_comment.index',
            'id' => 42
        ]);
        $taglevel2 = $menu->find(42);

        if (str_contains($routeName, 'admin_article_comment')) {
            $tag->attr('class', 'open menu-accordion');
            $taglevel2->active();
        }
    }

    /**
     * 管理员
     *
     * @param Builder $menu
     * @param $routeName
     */
    public function setAdminUserMenu(Builder $menu, $routeName)
    {
        $menu
            ->add('<span>' . trans('admin_menu.admin_user') . '</span>', [
                'class' => 'menu-accordion', 'id' => 3
            ])
            ->prepend('<i class="fa fa-user"></i>');
        $adminUser = $menu->find(3);

        $adminUser->add(trans('admin_menu.admin_user'), [
            'route' => 'admin_user.index',
            'id' => 31
        ]);
        $adminUserlevel1 = $menu->find(31);
        if (
            str_contains($routeName, 'admin_user') && !str_contains($routeName, 'admin_user_role')
        ) {
            $adminUser->attr('class', 'open menu-accordion');
            $adminUserlevel1->active();
        }

        $adminUser->add(trans('admin_menu.admin_user_role'), [
            'route' => 'admin_user_role.index',
            'id' => 32
        ]);
        $adminUserlevel2 = $menu->find(32);
        if (str_contains($routeName, 'admin_user_role')) {
            $adminUser->attr('class', 'open menu-accordion');
            $adminUserlevel2->active();
        }
    }

    /**
     * 网站管理
     *
     * @param Builder $menu
     * @param $routeName
     */
    public function setSiteMenu(Builder $menu, $routeName)
    {
        $menu
            ->add('<span>' . trans('admin_menu.site') . '</span>', [
                'class' => 'menu-accordion', 'id' => 5
            ])
            ->prepend('<i class="fa fa-wrench"></i>');
        $banner = $menu->find(5);

        $banner->add(trans('admin_menu.banner'), [
            'route' => 'admin_setting_banner.index',
            'id' => 51
        ])->prepend('<i class="icon dashboard"></i>');
        $banner1 = $menu->find(51);
        if (
        str_contains($routeName, 'admin_setting_banner')
        ) {
            $banner->attr('class', 'open menu-accordion');
            $banner1->active();
        }

        $banner->add(trans('admin_menu.site_info'), [
            'route' => 'admin_setting_site.edit',
            'id' => 52
        ]);
        $banner2 = $menu->find(52);
        if (
        str_contains($routeName, 'admin_setting_site')
        ) {
            $banner->attr('class', 'open menu-accordion');
            $banner2->active();
        }
    }

    /**
     * 更新日志管理
     *
     * @param Builder $menu
     * @param $routeName
     */
    public function setChangelogMenu(Builder $menu, $routeName)
    {
        $menu
            ->add('<span>' . trans('admin_menu.manage_changelog') . '</span>', [
                'class' => 'menu-accordion', 'id' => 6
            ])
            ->prepend('<i class="fa fa-bookmark"></i>');
        $changelog = $menu->find(6);

        $changelog->add(trans('admin_menu.changelog'), [
            'route' => 'admin_changelog.index',
            'id' => 61
        ]);
        $changelog1 = $menu->find(61);

        if (str_contains($routeName, 'admin_changelog')) {
            $changelog->attr('class', 'open menu-accordion');
            $changelog1->active();
        }
    }

    /**
     * 留言管理
     *
     * @param Builder $menu
     * @param $routeName
     */
    public function setMessageMenu(Builder $menu, $routeName)
    {
        $menu
            ->add('<span>' . trans('admin_menu.manage_message') . '</span>', [
                'class' => 'menu-accordion', 'id' => 7
            ])
            ->prepend('<i class="fa fa-envelope"></i>');
        $message = $menu->find(7);

        $message->add(trans('admin_menu.message'), [
            'route' => 'admin_message.index',
            'id' => 71
        ]);
        $message1 = $menu->find(71);

        if (str_contains($routeName, 'admin_message')) {
            $message->attr('class', 'open menu-accordion');
            $message1->active();
        }
    }
}
