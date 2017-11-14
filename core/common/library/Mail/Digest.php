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

use Phalcon\Di\Injectable;

use Phanbook\Models\Posts;
use Phanbook\Models\Subscribe;
use Phanbook\Models\Users;

/**
 * Digest
 *
 * Sends a weekly digest to subscribed users
 */
class Digest extends Injectable
{
    protected $transport;

    protected $mailer;

    /**
     * Sends the digest
     */
    public function send($preview = 'test')
    {
        $users = [];
        foreach (Users::find() as $user) {
            $toMail= $user->getEmail();
            if ($toMail && strpos($user->email, '@phalconbook') === false) {
                $users[trim($toMail)] = $user->getFullName();
            }
        }
        $subscribes = [];
        foreach (Subscribe::find() as $sub) {
            $subscribes[trim($sub->getEmail())] = $sub->getName() ?? '';
        }
        $total = array_unique(array_merge($users, $subscribes));
        $sitename = '[ '. $this->config->application->name . ' Blog ]';


        $subject = 'Bản tin trên ' . $sitename . date('d/m/y');

        if ($preview != 'send') {
             echo "Send test email";
             $params = [
                 'fullName'  => 'Thien Tran',
                 'email'     => 'fcduythien@gmail.com',
                 'name'      => $sitename,
                 'subject'   => $subject
             ];
             if (!$this->mail->send('fcduythien@gmail.com', 'senddigest', $params)) {
                 var_dump('send disgest email false');
             }
            exit(1);
        }

        foreach ($total as $email => $name) {
            try {
                 $params = [
                     'fullName'  => $name,
                     'email'     => $email,
                     'name'      => $sitename,
                     'subject'   => $subject
                 ];

                 if (!$this->mail->send($email, 'senddigest', $params)) {
                     var_dump('send disgest email false');
                 }
            } catch (\Exception $e) {
                echo $e->getMessage(), PHP_EOL;
            }
        }
    }

    public function getData()
    {
        $lastWeek = new \DateTime();
        $lastWeek->modify('-1 week');
        $parameters = [
            'createdAt >= ?0 AND deleted != 1',
            'bind'  => [$lastWeek->getTimestamp()],
            'order' => 'numberViews',
            'limit' => 10
        ];
        $url   = $this->config->application->publicUrl;
        $posts = [];
        foreach (Posts::find($parameters) as $post) {
            $user = $post->user;
            if ($user == false) {
                continue;
            }
            $title   = $post->getTitle();
            $content = substr($this->markdown->text($post->getContent()), 0, 200);
            $link = $url . '/posts/' . $post->getId() . '/' . $post->getSlug();
            $posts[] = [
                'link'      => $link,
                'title'     => $title,
                'content'   => strip_tags($content)
            ];
        }
        return $posts;
    }
}
