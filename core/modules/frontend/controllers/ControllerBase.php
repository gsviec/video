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

use Phanbook\Controllers\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo;
use Phanbook\Models\Playlist;
use Phanbook\Models\Vote;
use Phanbook\Models\Users;
use Phanbook\Models\Karma;
use Phanbook\Models\Tags;
use Phanbook\Models\Posts;
use Phanbook\Models\Comment;
use Phanbook\Models\PostsReply;
use Phanbook\Frontend\Forms\CommentForm;
use Phanbook\Models\ModelBase;
use Phanbook\Tools\ShortId;
use Phanbook\Models\ActivityNotifications;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Phalcon\Paginator\Adapter\NativeArray  as PaginatorNativeArray;

/**
 * Class ControllerBase
 *
 * @package Phanbook\Controllers
 */
class ControllerBase extends Controller
{

    /**
     * @var array
     */
    private $unsecuredRoutes = [];

    /**
     * @var bool
     */
    protected $jsonResponse = false;

    /**
     * @var array
     */
    public $jsonMessages = [];

    /**
     * @var string
     */
    public $currentOrder = null;

    /**
     * @var int
     */
    public $numberPage = 1;

    /**
     * @var int
     */
    public $perPage = 8;

    protected $statusCode = 200;

    /**
     * Check if we need to throw a json respone. For ajax calls.
     *
     * @return bool
     */
    public function isJsonResponse()
    {
        return $this->jsonResponse;
    }

    /**
     * Set a flag in order to know if we need to throw a json response.
     *
     * @return $this
     */
    public function setJsonResponse()
    {
        $this->jsonResponse = true;

        return $this;
    }

    /**
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $this->loadDefaultAssets();

        // @todo something
        if ($this->auth->hasRememberMe() && !$this->request->isPost()) {
            $this->auth->loginWithRememberMe();

            //Need return when have session
        }
        $this->getSessionFromRedis();
    }

    /**
     * loadDefaultAssets function.
     *
     * @access private
     * @return void
     */
    private function loadDefaultAssets()
    {
        if (APPLICATION_ENV == ENV_PRODUCTION ) {
            $this->assets
                ->addCss('https://fonts.googleapis.com/css?family=Hind:400,300,500,600,700', false)
                ->addCss('/css/all.min.css?v=2')
            ;
            $this->assets
                ->addJs('https://content.jwplatform.com/libraries/zVSdRWQd.js', false)
                ->addJs('/js/all.min.js?v=2', false)
            ;
        } else {

            $this->assets
                ->addCss('https://fonts.googleapis.com/css?family=Hind:400,300,500,600,700', false)
                ->addCss('/css/bootstrap.min.css', false)
                ->addCss('/css/font-awesome.min.css', false)
                ->addCss('/css/font-circle-video.css', false)
                ->addCss('/css/app.css', false)
                //->addCss('css/login.css')
            ;
            $this->assets
                ->addJs('/js/jquery.js', false)
                ->addJs('/js/bootstrap.js', false)
                ->addJs('https://content.jwplatform.com/libraries/zVSdRWQd.js', false)
                ->addJs('/js/notify.js', false)
                ->addJs('/js/app.function.js', false)
                ->addJs('/js/app.js', false)
            ;
        }
    }

    protected function loaderAssetsJqueryUpload()
    {
        $this->assets
            ->addCss('/css/jquery-upload/jquery.fileupload.css', false)
            ->addCss('/css/jquery-upload/jquery.fileupload-ui.css', false)
        ;
        $this->assets
            ->addJs('/js/jquery.ui.widget.js', false)
            ->addJs('/js/jquery-upload//jquery.iframe-transport.js', false)
            ->addJs('/js/jquery-upload/jquery.fileupload.js', false)
        ;
    }
    /**
     * After execute route event
     *
     * @param Dispatcher $dispatcher
     */
    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        if ($this->request->isAjax() && $this->isJsonResponse()) {
            $this->view->disable();
            $this->response->setContentType('application/json', 'UTF-8');

            $data = $dispatcher->getReturnedValue();
            if (is_array($data)) {
                $this->response->setJsonContent($data);
            }
            echo $this->response->getContent();
        }
    }

    public function initialize()
    {

        $this->view->setVars([
            'name'          => $this->config->application->name,
            'gAnalytic'     => $this->config->google->analytic,
            'facebookApp'   => $this->config->facebook->clientId,
            'canonical'     => $this->config->application->publicUrl,
            'class'         => 'default',
            'action'        => $this->router->getActionName(),
            'controller'    => $this->router->getControllerName(),
            'isGoto'        => true,
            'baseUri'       => '/',
            'publicUrl'     => $this->config->application->publicUrl,
            'currentUri'    => $this->getCurrentUri(),
            'playlist'      => Playlist::getPlaylist()
        ]);
    }


    /**
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    private function isUnsecuredRoute(Dispatcher $dispatcher)
    {
        foreach ($this->unsecuredRoutes as $route) {
            if ($route['controller'] == $dispatcher->getControllerName()
                && $route['action'] == $dispatcher->getActionName()
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set a flash message with messages from objects
     *
     * @param $object
     */
    public function displayModelErrors($object)
    {
        if (is_object($object) && method_exists($object, 'getMessages')) {
            foreach ($object->getMessages() as $message) {
                $this->flashSession->error($message);
            }
        } else {
            $this->flashSession->error(t('No object found. No errors.'));
        }
    }


    public function toggleAction($id)
    {
        $this->view->disable();
        if ($this->toggleObject($id)) {
            $this->flashSession->success(t('Entry status changed successfully'));
        } else {
            $this->flashSession->error(t('An error occurred on changing entry status'));
        }

        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }

    /**
     * Method to toggle objects
     *
     * @return mixed
     */
    private function toggleObject($id, $method = 'status')
    {
        $class = 'Phanbook\Models\\' . ucfirst($this->router->getControllerName());

        if (!class_exists($class)) {
            return false;
        }

        $id     = $this->filter->sanitize($id, ['int']);
        $object = $class::findFirstById($id);

        if (!is_object($object)) {
            return false;
        }
        $setter = 'set' . ucfirst($method);
        $getter = 'get' . ucfirst($method);

        if (!method_exists($object, $getter) || !method_exists($object, $setter)) {
            return false;
        }

        $value = $object->$getter() == 0 ? 1 : 0;
        $object->$setter($value);

        return $object->save();
    }

    /**
     * Method to delete objects
     *
     * @return mixed
     */
    private function delete($id, $model = null)
    {
        $this->view->disable();

        if (empty($model)) {
            $class = 'Phanbook\Models\\' . ucfirst($this->router->getControllerName());
        }

        if (!class_exists($class)) {
            return false;
        }

        if (is_array($id)) {
            $ids    = array_map(
                function ($key) {
                    return (int)$key;
                },
                $id
            );
            $object = $class::find('id IN (' . implode(',', $ids) . ')');
        } else {
            $id     = $this->filter->sanitize($id, ['int']);
            $object = $class::findFirstById($id);
        }
        if (!$object) {
            $this->flashSession->error(t('Entry was not found'));

            return $this->response->redirect($this->request->getHTTPReferer(), true);
        }

        if (!$object->delete()) {
            foreach ($object->getMessages() as $message) {
                $this->flashSession->error($message->getMessage());
            }
        } else {
            $this->flashSession->success(t('Entry was successfully deleted'));
        }

        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }

    public function deleteAction($id)
    {
        $this->view->disable();

        return $this->delete($id);
    }

    /**
     * Method for voting a task
     *
     * @return mixed
     */
    public function voteAction()
    {
        $this->view->disable();
        if (!$this->request->isPost()) {
            return $this->response->redirect($this->router->getControllerName());
        }

        $way = 'positive';
        if ($this->request->getPost('way') == 'negative') {
            $way = 'negative';
        }
        $objectId = $this->request->getPost('objectId');
        $object   = $this->request->getPost('object');
        $user     = Users::findFirstById($this->auth->getAuth()['id']);

        if (!$user) {
            echo $this->respondWithError(t("You need login before vote this"), 403);
            return 0;
        }
        $this->db->begin();
        if ($object == Vote::OBJECT_POSTS) {
            if (!$post = Posts::findFirstById($objectId)) {
                echo $this->respondWithError('NOT_EXITS', 404);
                return 0;
            }
            $this->setPointPost($way, $user, $post);

            //Adding notification when you have receive vote on the post,
            //and not for now for post replies
            if ($user->getId() != $post->getUsersId()) {
                $this->setActivityNotifications($user, $post);
            }
        }
        if ($object == Vote::OBJECT_POSTS_REPLIES) {
            if (!$postReply = PostsReply::findFirstById($objectId)) {
                echo $this->respondWithError('NOT_EXITS', 404);
                return 0;
            }
            //Set karam Voting someone else's post (positive or negative) on posts reply
            $this->setPointReply($way, $user, $postReply);
        }
        $vote = Vote::vote($objectId, $object, $way);
        if (!$vote) {
            $this->db->rollback();
            echo $this->respondWithError('Vote have a problem', 404);
            return 0;
        }

        //checking the user have already voted this post yet
        if (is_string($vote)) {
            $this->db->rollback();
            echo $this->respondWithError($vote, 404);
            return 0;
        }
        $this->db->commit();
        $vote = (new Vote)->getVotes($objectId, $object)->toArray();
        echo $this->respondWithArray([
            'sum' => $vote['positive'] - $vote['negative'],
            'positive' => $vote['positive'],
            'negative' => $vote['negative']
        ]);
        return 1;
    }
    /**
     * Comments are temporary "Post-It" notes left on a question or answer.
     * They can be up-voted (but not down-voted) and flagged, but do not generate reputation.
     * There's no revision history, and when they are deleted they're gone for good.
     *
     * @return mixed
     */
    public function commentAction()
    {
        $this->view->disable();

        if (!$this->request->isPost()) {
            return $this->response->redirect($this->router->getControllerName());
        }
        $user = Users::findFirstById($this->auth->getAuth()['id']);

        if (!$user) {
            $this->flashSession->error(t('You need to login first'));
            return $this->currentRedirect();
        }
        if ($user->getVote() < 9) {
            $this->flashSession->error(t('You must have 10 points to add comment'));
            return $this->currentRedirect();
        }
        $object = new Comment();
        $form   = new CommentForm($object);
        $form->bind($_POST, $object);

        if (!$form->isValid($this->request->getPost())) {
            foreach ($form->getMessages() as $message) {
                $this->flashSession->error($message->getMessage());
            }
        } else {
            if (!$object->save()) {
                $this->displayModelErrors($object);
            }
        }
        return $this->currentRedirect();
    }

    /**
     * Attempt to determine the real file type of a file.
     *
     * @param string $extension Extension (eg 'jpg')
     *
     * @return boolean
     */
    public function imageCheck($extension)
    {
        $allowedTypes = [
            'image/gif',
            'image/jpg',
            'image/png',
            'image/bmp',
            'image/jpeg'
        ];

        return in_array($extension, $allowedTypes);
    }
    public function videoCheck($extension)
    {
        $allowedTypes = [
            'mp4',
            'flv'
        ];

        return in_array($extension, $allowedTypes);
    }
    public function indexRedirect()
    {
        return $this->response->redirect();
    }
    public function currentRedirect()
    {
        if ($url = $this->cookies->get('urlCurrent')->getValue()) {
            $this->cookies->delete('urlCurrent');
            return $this->response->redirect($url);
        }
        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }
    /**
     * Set karam Voting someone else's post (positive or negative) on posts reply
     *
     * @param string $way       [description]
     * @param object $user      Phanbook\Models\Users
     * @param object $postReply Phanbook\Models\PostsReply
     */
    public function setPointReply($way, $user, $postReply)
    {
        if ($postReply->getUsersId() != $user->getId()) {
            if ($way == 'positive') {
                if ($postReply->post->getUsersId() != $user->getId()) {
                    $karamCount = intval(abs($user->getKarma() - $postReply->user->getKarma()) / 1000);
                    $points = Karma::VOTE_UP_ON_MY_REPLY_ON_MY_POST + $karamCount;
                } else {
                    $points = (Karma::VOTE_UP_ON_MY_REPLY + intval(abs($user->getKarma() - $postReply->user->getKarma()) / 1000));
                }
                $postReply->user->increaseKarma($points);
                $user->increaseKarma(Karma::VOTE_UP_ON_SOMEONE_ELSE_REPLY);
            } else {
                if ($postReply->post->getUsersId() != $user->getId()) {
                    $karamCount = intval(abs($user->getKarma() - $postReply->user->getKarma()) / 1000);
                    $points = Karma::VOTE_DOWN_ON_MY_REPLY_ON_MY_POST + $karamCount;
                } else {
                    $points = (Karma::VOTE_DOWN_ON_MY_REPLY + intval(abs($user->getKarma() - $postReply->user->getKarma()) / 1000));
                }
                $postReply->user->decreaseKarma($points);
                $user->decreaseKarma(Karma::VOTE_DOWN_ON_SOMEONE_ELSE_REPLY);
            }
        }
        if ($postReply->save()) {
            //decrease vote when user up or down post
            $user->setVote($user->getVote() - 1);
            if (!$user->save()) {
                foreach ($user->getMessages() as $message) {
                    $this->jsonMessages['messages'][] = [
                        'type'  => 'error',
                        'message' => $message->getMessage()
                    ];
                    return $this->jsonMessages;
                }
            }
        } else {
            error_log('todo setPointReply');
        }
    }
    /**
     * Set karam Voting someone else's post (positive or negative) on posts
     *
     * @param string $way  positive or negative
     * @param object $user Phanbook\Models\Users
     * @param object $post Phanbook\Models\Posts
     */
    public function setPointPost($way, $user, $post)
    {
        if ($post->getUsersId() != $user->getId()) {
            if ($way == 'positive') {
                $post->user->increaseKarma(Karma::SOMEONE_DID_VOTE_MY_POST);
                $user->increaseKarma(Karma::VOTE_ON_SOMEONE_ELSE_POST);
            } else {
                $post->user->decreaseKarma(Karma::SOMEONE_DID_VOTE_MY_POST);
                $user->increaseKarma(Karma::VOTE_ON_SOMEONE_ELSE_POST);
            }
        }
        if ($post->save()) {
            $user->setVote($user->getVote() - 1);
            if (!$user->save()) {
                foreach ($user->getMessages() as $message) {
                    $this->jsonMessages['messages'][] = [
                        'type'  => 'error',
                        'message' => $message->getMessage()
                    ];
                    return $this->jsonMessages;
                }
            }
        } else {
            $this->saveLoger('todo setPointReply');
        }
    }
    /**
     * These is it will save ActivityNotifications when the user have comment,
     * vote, etc to post or post reply, which just display for user
     *
     * @param  object $user   this is session user Phanbook\Models\Users
     * @param  object $object Phanbook\Models\{Posts, PostsReply...}
     * @return mixed
     */
    public function setActivityNotifications($user, $object)
    {
        $activity = new ActivityNotifications();
        //set user recive a notification when it have a post comment or reply
        $activity->setUsersOriginId($user->getId());

        //If is posts, it will use when user vote post
        if (method_exists($object, '_isPost')) {
            $activity->setUsersId($object->getUsersId());
            $activity->setPostsId($object->getId());
            $activity->setPostsReplyId(null);
            $activity->setType(ActivityNotifications::TYPE_POSTS);
        }
        if (method_exists($object, 'isComment')) {
            //@todo
        }

        if (method_exists($object, 'isReply')) {
            $activity->setUsersId($object->post->getUsersId());
            $activity->setPostsId($object->post->getId());
            $activity->setPostsReplyId($object->getId());
            $activity->setType(ActivityNotifications::TYPE_REPLY);
        }

        if (!$activity->save()) {
            $this->saveLoger('Save fail, I am on here' . __LINE__);
        }
    }
    /**
     * The function sending log for nginx or apache, it will to analytic later
     *
     * @param $e
     */
    public function saveLoger($e)
    {

        $logger = $this->logger;
        if (is_object($e)) {
            $logger->error($e[0]->getMessage());
        }
        if (is_array($e)) {
            foreach ($e as $message) {
                $logger->error($message->getMessage());
            }
        }
        if (is_string($e)) {
            $logger->error($e);
        }
    }
    /**
     * Transfer values from the controller to views
     *
     * @param array $parmas
     */
    public function setViewVariable($parmas)
    {
        foreach ($parmas as $key => $value) {
            $this->view->setVar($key, $value);
        }
    }
    public function currentController()
    {
        return $this->response->redirect($this->router->getControllerName());
    }
    /**
     * @param $id
     */
    public function redirectKeepValue($id = null)
    {
        //Keep current value form
        if (!is_null($id)) {
            return $this->dispatcher->forward([
                'controller' => $this->router->getControllerName(),
                'action' => 'edit',
                'params' => [$id, serialize($_POST)]

            ]);
        }
        return $this->dispatcher->forward(
            ['controller' => $this->router->getControllerName(), 'action' => 'new']
        );
    }
    public function authorize($object)
    {
        if ($this->auth->isAdmin()) {
            return true;
        }
        $id = $this->auth->getUserId();
        return $id == $object->usersId;
    }
    /**
     * @param $message
     * @param $errorCode
     * @return JsonResponse
     */
    public function respondWithError($message, $errorCode)
    {
        return $this->respondWithArray([
            'error' => [
                'code' => $errorCode,
                'http_code' => $this->statusCode,
                'message' => $message,
            ]
        ]);
    }
    public function respondWithSuccess($message = 'ok')
    {
        return $this->respondWithArray(
            [
                'success' => [
                    'message' => $message,
                ]
            ]
        );
    }

    protected function respondWithArray(array $data)
    {
        return json_encode($data);
    }
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    protected function getUrlVideo($id)
    {
        return $this->config->application->publicUrl .
        'watch?v=' .ShortId::encode($id);
    }

    /* gets the data from a URL */
    public function getDataFromUrl($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
    }

    /**
     * @param $page
     */
    public function setPerPage($page)
    {
        $this->perPage = $page;
        return $this;
    }
    public function getCurrentUri()
    {
        $controller = $this->router->getControllerName();
        if ( 'posts' === $controller) {
            return 'posts?';
        }
        $query = $this->request->getQuery();
        unset($query['_url']);
        if (isset($query['page'])) {
            unset($query['page']);
        }
        if (in_array($controller, ['channels', 'categories'])) {
            $slug = $this->dispatcher->getParam('slug');
            $controller .= '/' . $slug;
        }
        return $controller . '?'. http_build_query($query) . '&';
    }

    protected function getSessionFromRedis()
    {
        if (is_null($this->auth->getAuth()) && isset($_COOKIE['oauth_token'])) {
            $key = $this->crypt->decrypt($_COOKIE['oauth_token']);
            $data = $this->session->read($key);
            $data = explode('auth|', $data);

            if (isset($data[1])) {
                $item = unserialize($data[1]);
                //d($item);
                if (is_array($item)) {
                    $this->auth->setSession($item);
                }
            }
        }
    }
}
