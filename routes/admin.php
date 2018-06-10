<?php

$router->group(['prefix' => 'admin', 'namespace' => 'Admin'], function ($router) {
    /**
     * @var \Illuminate\Support\Facades\Route $router
     */
    $router->get('dash', 'DashboardController@index')->name('admin.dash');
    $router->get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    $router->post('login', 'Auth\LoginController@login');
    $router->post('logout', 'Auth\LoginController@logout')->name('admin.logout');
    $router->get('password/reset', 'Auth\ResetPasswordController@showResetForm');
    $router->post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin_password.reset');

//    标签
    $router->resource('admin_tag', 'TagController');
//    管理员
    $router->resource('admin_user', 'AdminUserController');
//    后端角色
    $router->resource('admin_user_role', 'AdminRoleController');
//    文章
    $router->resource('admin_article', 'ArticleController');
//    评论
    $router->get('admin_article_comment', 'CommentController@index')->name('admin_article_comment.index');
    $router->delete('admin_article_comment/{id}', 'CommentController@destroy')->name('admin_article_comment.destroy');
//    banner
    $router->resource('admin_setting_banner', 'BannerController');
//    站点设置
    $router->get('admin_setting_site/edit', 'SiteController@edit')->name('admin_setting_site.edit');
    $router->put('admin_setting_site/{id}', 'SiteController@update')->name('admin_setting_site.update');
//    更新日志
    $router->resource('admin_changelog', 'ChangelogController');
//    留言
    $router->get('admin_message', 'MessageController@index')->name('admin_message.index');
    $router->delete('admin_message/{id}', 'MessageController@destroy')->name('admin_message.destroy');
//    统计
    $router->get('admin_report_user', 'Report\UserController@index')->name('admin_report_user.index');
    $router->get('admin_report_tag', 'Report\TagController@index')->name('admin_report_tag.index');

//    没有权限
    $router->get('unauthorized', 'ErrorController@unauthorized')->name('admin.unauthorized');
});
