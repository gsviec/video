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
namespace Phanbook\Frontend\Controllers;

use Phalcon\Mvc\View;
use Phanbook\Models\Comment;
use Phanbook\Models\Posts;
use Phanbook\Models\Users;
use Phanbook\Models\Karma;
use Phanbook\Models\PostsReply;
use Phanbook\Models\PostsBounties;
use Phanbook\Frontend\Forms\ReplyForm;
use Phanbook\Models\PostsReplyHistory;

/**
 * Class CommentController.
 */
class CommentController extends ControllerBase
{

    /**
     * The answer a question
     * @return mixed
     */
    public function indexAction()
    {
        $this->view->disable();
        $user = $this->auth->getUser();
        if (!$user) {
            echo $this->respondWithError(AUTHORIZE, 404);
            return 0;
        }
        if ($this->request->isAjax()) {
            $postId = $this->request->getPost('id');
            $content = $this->request->getPost('content', 'trim');
            $object  = $this->request->getPost('object');
            if (str_word_count($content) < 3) {
                echo $this->respondWithError(t('You comment must be at least 5 word'), 404);
                return 0;
            }
            $post = Posts::findFirstById($postId);

            if (!$post) {
                echo $this->respondWithError('The post have not exits!', 404);
                return 0;
            }
            //Only update the number of replies if the user that commented isn't the same that posted
            if ($user->getId() != $post->getUsersId()) {
                $post->setNumberReply($post->getNumberReply() + 1);
                $post->user->increaseKarma(Karma::SOMEONE_REPLIED_TO_MY_POST);
                $user->increaseKarma(Karma::REPLY_ON_SOMEONE_ELSE_POST);

                if (!$post->save() || !$user->save()) {
                    $this->logger->error('Save fail answerAction. I am on here ' . __LINE__);
                }
            }
            $comment = new Comment();
            $comment->setObjectId($postId);
            $comment->setContent($content);
            $comment->setUserId($user->getId());
            $comment->setObject($object);
            if (!$comment->save()) {
                $m = $comment->getMessages();
                echo $this->respondWithError($m[0]->getMessage(), 404);
                return 0;
            }
            $class = null;
            if ($object == Comment::OBJECT_POSTS_REPLIES) {
                $class = '-reply';
            }
            $parameter = ['comment' => $comment, 'class' => $class];
            $html =
                $this->view->getRender(
                    'partials',
                    'comment',
                    $parameter, function($view) {
                    $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
                }
                );
            echo $html;
            return 1;
        }
    }

    /**
     * Delete spam posts
     */
    public function deleteAction($id)
    {
        $auth = $this->auth->getAuth();
        if (!$auth) {
            $this->flashSession->error('You must be logged first');
            return $this->indexRedirect();
        }
        $parameters = [
            "id = ?0 AND (usersId = ?1 OR 'Y' = ?2 OR 'Y' = ?3)",
            "bind" => [$id, $auth['id'], $auth['moderator'], $auth['admin']]
        ];
        if (!$object = PostsReply::findFirst($parameters)) {
            $this->flashSession->error(t('Post doesn\'t exist.'));

            return $this->indexRedirect();
        }
        if (!$object->delete()) {
            $this->saveLoger($object->getMessages());
        }
        $this->flashSession->success(t('Data was successfully deleted'));
        return $this->currentRedirect();
    }

    public function editAnswerAction($id)
    {
        $auth = $this->auth->getAuth();
        $postReply = PostsReply::findFirstById($id);
        if (!$auth) {
            $this->flashSession->error(t('You must be logged in first to post answer'));
            return $this->currentRedirect();
        }
        if (!$this->auth->isTrustModeration() && $auth['id'] != $postReply->getUsersId()) {
            $this->flashSession->error(t('You don\'t have permission'));
            return $this->currentRedirect();
        }
        if (!$postReply) {
            $this->flashSession->error(t('The posts replies not exist!'));
            return $this->currentRedirect();
        }
        if ($this->request->isPost()) {
            //save history  postreplies table, it just for admin or moderator
            if ($this->auth->isTrustModeration() && $auth['id'] != $postReply->getUsersId()) {
                $postReplyHistory = new PostsReplyHistory;
                $postReplyHistory->setContent($this->request->getPost('content'));
                $postReplyHistory->setPostsReplyId($id);
                $postReplyHistory->setUsersId($auth['id']);
                if (!$postReplyHistory->save()) {
                    $this->saveLoger($postReplyHistory->getMessages());
                }
            }
            //Update replies post
            $postReply->setContent($this->request->getPost('content'));
            if (!$postReply->save()) {
                $this->saveLoger($postReply->getMessages());
            }
            $this->flashSession->success(t('Data was successfully saved'));
            return $this->response->redirect($this->request->getHTTPReferer());
        }
        $this->view->hotPosts   = Posts::getHotPosts();
        $this->view->form       = new ReplyForm($postReply);
        $this->view->firstTime  = null;
        $this->view->type       = 'postReply';
        $this->tag->setTitle(t('Edit answer'));
        return $this->view->pick('edit');
    }
}
