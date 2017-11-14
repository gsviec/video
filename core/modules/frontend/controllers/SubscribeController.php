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

use Phanbook\Models\Posts;
use Phanbook\Models\Subscribe;
use Phanbook\Models\PostsSubscribers;

/**
 * Class SubcribeController
 */
class SubscribeController extends ControllerBase
{
    /**
     * Subscribe to a post to receive e-mail notifications
     *
     * @return mixed
     */
    public function indexAction()
    {
        $this->view->disable();
        $this->setJsonResponse();

        if (!$this->request->isPost()) {
            return false;
        }

        //Find the post by Id
        $post = Posts::findFirstById($this->request->getPost('objectId'));
        if (!$post) {
            $this->jsonMessages['messages'][] = [
                'type'    => 'error',
                'content' => 'The Post does not exist'
            ];
            return $this->jsonMessages;
        }

        /**
        * Sometime We need to get object User login, so I do check user like below
        * By the way, you can checking session
        *
        * {code} Users::findFirstById($this->auth->getAuth()['id'] {/code}
        */
        $userId = $this->auth->getAuth()['id'];
        if (!$userId) {
            $this->jsonMessages['messages'][] = [
                'type'    => 'error',
                'content' => 'You must log in first to subscribe post'
            ];
            return $this->jsonMessages;
        }
        $subscription = PostsSubscribers::findFirst(
            [
            'postsId = ?0 AND usersId = ?1',
            'bind' => [$post->getId(), $userId]
            ]
        );
        if (!$subscription) {
            $subscription = new PostsSubscribers();
            $subscription->setPostsId($post->getId());
            $subscription->setUsersId($userId);
            if (!$subscription->save()) {
                foreach ($subscription->getMessages() as $message) {
                    $this->logger->error('Subscribe save false '. $message . __LINE__ .'and'. __CLASS__);
                }
                return false;
            }
            $this->jsonMessages['messages'][] = [
                'type'    => 'info',
                'content' => 'You have just subscribe post',
                'flag'    => 1
            ];
            return $this->jsonMessages;
        } else {
            //unsubsribe posts
            if (!$subscription->delete()) {
                foreach ($subscription->getMessages() as $message) {
                    $this->logger->error('Unsubscribe delete false '. $message . __LINE__ .'and'. __CLASS__);
                }
                return false;
            }
            $this->jsonMessages['messages'][] = [
                'type'    => 'info',
                'content' => 'You have just unsubscribe post'
            ];
            return $this->jsonMessages;
        }
    }
    /**
     * Get the weekly newsletter!
     * @todo   implement
     * @return mixed
     */
    public function weeklyAction()
    {
        if (!$this->request->isPost()) {
            return false;
        }
        $this->view->disable();

        $email = $this->request->getPost('email');
        if (!$email) {
            echo $this->respondWithError('Please input your Email', 404);
            return 0;

        }
        $subscribe = Subscribe::findFirstByEmail($email);
        if (!$subscribe) {
            $subscribe = new Subscribe();
            $subscribe->setEmail($email);
        }
        $fullName = null;
        if (isset($_POST['name'])) {
            $subscribe->setName($_POST['name']);
            $fullName = $_POST['name'];
        }
        $subscribe->setStatus('Y');

        if (!$subscribe->save()) {
            foreach ($subscribe->getMessages() as $message) {
                $this->logger->error($message);
            }
            echo $this->respondWithError('Data was not success', 404);
            return 0;
        }
        $name   = $this->config->application->name;
        $link   = ($this->request->isSecure()
                ? 'https://' : 'http://') . $this->request->getHttpHost();
        $params = [
            'link'    => $link,
            'unLink'  => $link . '/subscribe/remove?email=' . urlencode($this->crypt->encryptBase64(trim($email))),
            'name'    => $name,
            'subject' => t('Thank you for subscribing to our newsletter') . ' ' . $name,
            'fullName'=> $fullName
        ];
        $this->mail->send($email, 'subscribe', $params);
        $this->cookies->set('hide_subscribe', true, time() + 86400*365);


        if ($this->request->isAjax()) {
            //Ajax send from blog wordpress
            if (isset($_POST['Box'])) {
                echo $this->respondWithArray(['status' => '200', 'html' =>t('Thank you for subscribing to our newsletter') ]);
                return 1;
            }
            echo $this->respondWithSuccess(t('Thank you for subscribing to our newsletter'));
            return 1;
        }

        $this->flashSession->success(t('Thank you for subscribing to our newsletter'));

        return $this->currentRedirect();

    }
    public function removeAction()
    {
        $email = $this->request->get('email');
        $email = $this->crypt->decryptBase64(urldecode($email));

        $subscribe = Subscribe::findFirstByEmail($email);
        if (!$subscribe) {
            $this->flashSession->error(t('The email have not exits!'));
            return $this->indexRedirect();
        }
        $subscribe->setStatus('N');

        if (!$subscribe->save()) {
            foreach ($subscribe->getMessages() as $message) {
                $this->flashSession->error($message);
                return $this->indexRedirect();
            }
        }
        $this->flashSession->success(t('Unsubscribe Successful'));
        return $this->indexRedirect();
    }
}
