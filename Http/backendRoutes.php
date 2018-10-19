<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/redirect'], function (Router $router) {
    $router->bind('redirect', function ($id) {
        return app('Modules\Redirect\Repositories\RedirectRepository')->find($id);
    });
    $router->get('redirects', [
        'as' => 'admin.redirect.redirect.index',
        'uses' => 'RedirectController@index',
        'middleware' => 'can:redirect.redirects.index'
    ]);
    $router->get('redirects/create', [
        'as' => 'admin.redirect.redirect.create',
        'uses' => 'RedirectController@create',
        'middleware' => 'can:redirect.redirects.create'
    ]);
    $router->post('redirects', [
        'as' => 'admin.redirect.redirect.store',
        'uses' => 'RedirectController@store',
        'middleware' => 'can:redirect.redirects.create'
    ]);
    $router->get('redirects/{redirect}/edit', [
        'as' => 'admin.redirect.redirect.edit',
        'uses' => 'RedirectController@edit',
        'middleware' => 'can:redirect.redirects.edit'
    ]);
    $router->put('redirects/{redirect}', [
        'as' => 'admin.redirect.redirect.update',
        'uses' => 'RedirectController@update',
        'middleware' => 'can:redirect.redirects.edit'
    ]);
    $router->delete('redirects/{redirect}', [
        'as' => 'admin.redirect.redirect.destroy',
        'uses' => 'RedirectController@destroy',
        'middleware' => 'can:redirect.redirects.destroy'
    ]);
// append

});
