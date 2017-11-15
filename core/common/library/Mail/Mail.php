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
namespace Phanbook\Mail;

use Phalcon\Mvc\User\Component;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Validator\Email as Email;

require_once ROOT_DIR . '/vendor/autoload.php';

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mail extends Component
{
    protected $transport;


    private function getTemplate($key, $params)
    {

        //Set views layout
        $this->view->setViewsDir(app_path('core/views/'));
        $render = $this->view->getRender(
            rtrim($this->config->mail->templatesDir, '/'),
            $key,
            $params,
            function ($view) {
                $view->setRenderLevel(View::LEVEL_LAYOUT);
            }
        );

        if (!empty($render)) {
            return $render;
        }
        //When use template for cli
        return $this->view->getContent();
    }

    /**
     * Send email
     *
     * @param $to - email to send
     * @param $templateKey - a unique key of the template
     * @param array $params - array with params for template. If $params['subject'] not set we get subject from database;
     *
     * @return int
     */
    public function send($to, $templateKey, $params = [])
    {
        $body = $this->getTemplate($templateKey, $params);
        if (!$body) {
            d('You need to create templates email in database');
            return false;
        }

        if (!isset($params['subject'])) {
            $subject = $this->config->application->name;
        } else {
            $subject = $params['subject'];
        }
        $mail = $this->config->mail;
        // Create the message
        $message = new Swift_Message($subject);
        $message
            ->setTo($to)
            ->setFrom([$mail->fromEmail => $mail->fromName])
            ->setBody($body, 'text/html');
        if (!$this->transport) {
            $transport = new Swift_SmtpTransport($mail->smtp->server, $mail->smtp->port);
            $transport->setUsername($mail->smtp->username);
            $transport->setPassword($mail->smtp->password);
            $this->transport = $transport;
        }

        $mailer = new Swift_Mailer($this->transport);
        return $mailer->send($message);
    }

    /**
     * Send a test email
     *
     * @param $to
     *
     * @return int
     */
    public function sendTest($to)
    {
        return $this->send($to, 'test');
    }
    /**
     * Send a test email
     *
     * @param $to
     *
     * @return int
     */
    public function getToMailTest($to)
    {
        return $to;
    }
    public function renderTest()
    {

        return $this->getTemplate('test', []);
    }
}
