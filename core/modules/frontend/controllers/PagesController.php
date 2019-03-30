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
namespace Phanbook\Frontend\Controllers;

/**
 * Class RouterController
 * This class to router page
 *
 * @package Phanbook\Frontend\Controllers
 */
class PagesController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
        $this->assets->addJs('js/live-chat.js');
    }
    /**
     * indexAction function.
     */
    public function indexAction()
    {
        $router = $this->dispatcher->getParam('router');

        if (empty($router)) {
            $router = 'index';
        }
        $this->view->isGoto = false;
        return $this->view->pick('pages/' . $router);
    }
    public function serviceAction()
    {
        if ($this->request->isPost()) {
            $name   = $this->request->get('name') . ' ' . $this->request->get('surename');
            $email  = $this->request->get('email');
            $content = $this->request->get('content');
            $params = [
                'name'    => $name,
                'content' => $content,
                'email'   => $email
            ];

            $this->mail->send('fcduythien@gmail.com', 'contact', $params);
            $this->flashSession->success(t('Thank you for subscribing to our newsletter'));
            return $this->currentRedirect();
        }
        $this->view->isGoto = false;
        return $this->view->pick('pages/service');
    }
}
