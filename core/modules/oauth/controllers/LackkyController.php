<?php
/**
 * Phanbook : Delightfully simple forum and Q&A software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://phanbook.com Phanbook Project
 * @since   1.0.0
 * @author  Phanbook <hello@phanbook.com>
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
namespace Phanbook\Oauth\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Class LogoutController
 *
 * @package Phanbook\Oauth\Controllers
 */
class LackkyController extends ControllerBase
{

    /**
     * logoutAction
     *
     * @return void
     */
    public function indexAction()
    {
        // Destroy the whole session
        $this->auth->remove();
        $this->view->disable();
        $this->response->redirect();
    }
    public function loginAction()
    {
        $url = 'https://lackky.com/login';
        if (APPLICATION_ENV == ENV_LOCAL) {
            $url = 'http://dev.lackky.com/login';
        }
        return $this->response->redirect($url);
    }
    public function signupAction()
    {
        $url = 'https://lackky.com/signup';

        if (APPLICATION_ENV == ENV_LOCAL) {
            $url = 'http://dev.lackky.com/signup';
        }
        return $this->response->redirect($url);
    }
}
