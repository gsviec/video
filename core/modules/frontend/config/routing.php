<?php
/**
 * Phanbook : Delightfully simple forum software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */

$router->setDefaults([
    'module'     => 'frontend',
    'controller' => 'posts',
    'action'     => 'index'
]);
$router->removeExtraSlashes(true);

$router->add('/:controller/:action/:params', [
    'controller' => 1,
    'action' => 2,
    'params' => 3,
]);
$router->add('/:controller[/]?', [
    'controller' => 1,
]);
$router->add('/:controller/:int/{slug}', [
    'controller' => 1,
    'id' => 2,
    'slug' => 3,
    'action' => 'view'
]);
$router->add('/categories/{slug}', [
    'controller' => 'categories',
    'slug' => 1,
    'action' => 'view'
]);
$router->add('/posts/:int/{slug}', [
    'id'        => 1,
    'slug'      => 2,
    'action'    => 'view'
]);


$router->add('/upload', [
    'controller' => 'posts',
    'action' => 'new'
]);
$router->add('/watch', [
    'controller' => 'posts',
    'action' => 'view'
]);

$router->add('/channels/{slug}', [
    'controller' => 'channels',
    'action' => 'view'
])->beforeMatch(function ($uri, $route) {
    $uris = ['/channels/save'];
    if (in_array($uri, $uris)) {
        return false;
    }
    if ('/' == $uri) {
        return false;
    }
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
        return false;
    }
    return true;
});
$router->add('/playlist/{slug}', [
    'controller' => 'playlist',
    'action' => 'view'
])->beforeMatch(function ($uri, $route) {
    $uris = ['/playlist/save', '/playlist/new'];
    if (in_array($uri, $uris)) {
        return false;
    }
    if ('/' == $uri) {
        return false;
    }
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
        return false;
    }
    return true;
});
$router->add('/language/{code}', [
    'controller' => 'language',
    'action' => 'index'
]);
$router->add('/pages/{router}', [
    'controller' => 'pages',
    'action' => 'index'
]);

