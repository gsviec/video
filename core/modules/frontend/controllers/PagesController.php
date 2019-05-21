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
        $this->view->setVar('isGoto', false);
        return $this->view->pick('pages/' . $router);
    }
    public function serviceAction()
    {
        if ($this->request->isPost()) {
            if (!$this->checkCaptcha()) {
                $this->flashSession->error(t('prove your humanity'));
                return $this->currentRedirect();
            }
            $name   = $this->request->get('name') . ' ' . $this->request->get('surename');
            $email  = $this->request->get('email');
            $content = $this->request->get('content');
            $params = [
                'name'    => $name,
                'content' => $content,
                'email'   => $email
            ];

            //$this->mail->send('fcduythien@gmail.com', 'contact', $params);
            $this->flashSession->success(t('Thank you for subscribing to our newsletter'));
            return $this->currentRedirect();
        }
        $siteKey = isset($this->config->reCaptcha->siteKey) ? $this->config->reCaptcha->siteKey : '';
        $this->view->setVar('siteKey', $siteKey);
        $this->view->setVar('isGoto', false);
        return $this->view->pick('pages/service');
    }

    /**
     * Validation Google captcha
     *
     * @return boolean
     */
    protected function checkCaptcha()
    {
        $secret = $this->config->reCaptcha->secretKey;
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        
        if (!isset($recaptchaResponse) || !isset($secret)) {
            return false;
        }
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
        $resp = $recaptcha->verify($recaptchaResponse, $_SERVER['REMOTE_ADDR']);
        if (!$resp->isSuccess()) {
            return false;
        }
        return true;
    }
}
