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

$router->add('/oauth/:controller', [
    'module' => 'oauth',
    'controller' => 1,
]);
$router->add('/oauth/:controller/:int', [
    'module' => 'oauth',
    'controller' => 1,
    'id' => 2,
]);
$router->add('/oauth/:controller/:action/:params', [
    'module' => 'oauth',
    'controller' => 1,
    'action' => 2,
    'params' => 3,
]);

$router->add('/oauth/github/access_token', [
    'module'     => 'oauth',
    'controller' => 'login',
    'action'     => 'tokenGithub'
]);
$router->add('/oauth/google/access_token', [
    'module'     => 'oauth',
    'controller' => 'login',
    'action'     => 'tokenGoogle'
]);
$router->add('/oauth/facebook/access_token', [
    'module'     => 'oauth',
    'controller' => 'login',
    'action'     => 'tokenFacebook'
]);
$router->add('/oauth/resetpassword', [
    'module'     => 'oauth',
    'controller' => 'register',
    'action'     => 'resetpassword'
]);
 $router->add('/login', [
     'module'     => 'oauth',
     'controller' => 'login',
     'action'     => 'index'
 ]);
 $router->add('/signup', [
     'module'     => 'oauth',
     'controller' => 'register',
     'action'     => 'signup'
 ]);
$router->add('/logout', [
    'module'     => 'oauth',
    'controller' => 'logout',
    'action'     => 'index'
]);
$router->add('/forgotpassword', [
    'module'     => 'oauth',
    'controller' => 'register',
    'action'     => 'forgotpassword'
]);
$router->add('/oauth/google', [
    'module'     => 'oauth',
    'controller' => 'login',
    'action'     => 'google'
]);

$router->add('/oauth/facebook', [
    'module'     => 'oauth',
    'controller' => 'login',
    'action'     => 'facebook'
]);
