<?php

//Auth::routes();

Route::group(['namespace' => 'Web'], function ($router) {
    /**
     * @var \Illuminate\Support\Facades\Route $router
     */
    $router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $router->post('login', 'Auth\LoginController@login');
    $router->post('logout', 'Auth\LoginController@logout')->name('logout');
    $router->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    $router->post('register', 'Auth\RegisterController@register');

    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('article', 'ArticleController@index')->name('article.index');
    $router->post('article', 'ArticleController@getArticle')->name('article.list');
    $router->get('article/{id}', 'ArticleController@show')->name('article.show');
    $router->post('article/comment/{id}', 'CommentController@store')->name('comment.store');
    $router->post('comment/{id}', 'CommentController@index')->name('comment.index');
    $router->get('message', 'MessageController@index')->name('message.index');
    $router->post('message', 'MessageController@store')->name('message.store');
    $router->post('message/list', 'MessageController@getMessage')->name('message.list');
    $router->get('changelog', 'ChangelogController@index')->name('changelog.index');
    $router->get('about', 'AboutMeController@index')->name('about.index');

    Route::get('auth/github', 'Auth\AuthController@redirectToProvider')->name('auth.github');
    Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');
});

Route::get('/get_captcha', 'CaptchaController@getPath')->name('get_captcha');
Route::get('/test', 'TestController@index');
