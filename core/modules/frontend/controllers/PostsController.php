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
use Phanbook\Models\Channels;
use Phanbook\Models\Playlist;
use Phanbook\Utils\DateTime;
use Phanbook\Utils\Slug;
use Phanbook\Utils\Editor;
use Phanbook\Models\Posts;
use Phanbook\Models\Vote;
use Phanbook\Models\Karma;
use Phanbook\Models\Users;
use Phanbook\Models\ModelBase;
use Phanbook\Models\PostsViews;
use Phanbook\Models\PostsHistory;
use Phanbook\Frontend\Forms\ReplyForm;
use Phanbook\Frontend\Forms\CommentForm;
use Phanbook\Frontend\Forms\PostsForm;
use Phanbook\Tools\ShortId;
/**
 * Class QuestionsController.
 */
class PostsController extends ControllerBase
{

    /**
     * Default it will get all posts
     */
    public function indexAction()
    {
        $posts = new Posts();
        list($page, $perPage, $offset) = $this->getPerPageAndOffset();
        $posts->setOffset($offset);
        $this->view->setVars([
            'page'           => $page,
            'perPage'        => $perPage,
            'newVideos'      => $posts->getNewVideos(),
            'wpVideos'       => $posts->getWordpressVideos(),
            'phpVideos'      => $posts->getPhpVideos(),
            'gitVideos'      => $posts->getGitVideos(),
            'htmlVideos'     => $posts->getHtmlVideos(),
            'toolVideos'     => $posts->getToolVideos(),
            'jsVideos'       => $posts->getJavaScriptVideos(),
            'devopsVideos'   => $posts->getDevopsVideos(),
            'featureVideos'  => $posts->getFeatureVideos(),
            'phalconVideos'  => $posts->getPhalconVideos(),
            'playlist'       => Playlist::getPopular()
        ]);

    }

    /**
     * Method editAction.
     */
    public function editAction($id)
    {
        $param = $this->dispatcher->getParams();

        if (!isset($id)) {
            $id = $param[0];
        }

        if (!$object = Posts::findFirstById($id)) {
            $this->flashSession->error(t('Posts doesn\'t exist.'));
            return $this->currentRedirect();
        }

        if (!$this->authorize($object)) {
            $this->flashSession->error(t('You do not have permission to edit this page'));
            return $this->currentRedirect();
        }

        $this->loaderAssetsJqueryUpload();
        $form = new PostsForm($object);

        $this->view->setVars([

            'object' => $object,
            'form' => $form,
            'url'=> $this->getUrlVideo($object->id)
        ]);
    }
    public function updateAction()
    {
        $id = $this->request->getPost('id');
        if (!$object = Posts::findFirstById($id)) {
            $this->flashSession->error(t('Posts doesn\'t exist.'));
            return $this->currentRedirect();
        }
        $object->setEditedAt(time());
        $form = new PostsForm($object);
        //save data
        if ($this->request->isPost()) {
            $form->bind($_POST, $object);
            if (!$form->isValid()) {
                foreach ($form->getMessages() as $m) {
                    $this->flashSession->error($m->getMessage());
                }
                return $this->redirectKeepValue($id);
            }
            if (!$object->save()) {
                foreach ($object->getMessages() as $m) {
                    $this->flashSession->error($m->getMessage());
                }
                return $this->redirectKeepValue($id);
            }
            $this->flashSession->success(t('Update data was success'));
            return $this->response->redirect($this->router->getControllerName() . '/edit/' . $id);
        }
    }
    /**
     * Save data after submit a video via ajax
     * @return \Phalcon\Http\ResponseInterface
     */
    public function saveAction()
    {
        //  Is not $_POST
        if (!$this->request->isPost()) {
            return $this->response->redirect($this->router->getControllerName());
        }
        $this->view->disable();

        if ($this->request->isAjax()) {
            $title = isset($_POST['filename']) ? $_POST['filename'] : 'Your filename video';
            $object = new Posts;
            $object->setTitle($title);
            $object->setUsersId($this->auth->getUserId());
            $object->setType(Posts::POST_VIDEO);
            $object->setSlug(uniqid(true));
            $object->setCategoryId(1);

            if ($this->request->hasFiles()) {
                foreach ($this->request->getUploadedFiles() as $file) {
                    $extension = $file->getExtension();
                    if (!$this->videoCheck($extension)) {
                        return $this->respondWithError(t('The format video not correct'), 404);
                    }
                    $uniqid = uniqid(true);
                    $videoFilename = $uniqid . '.' . $extension;
                    if (!$file->moveTo(public_path('uploads/videos/' . $videoFilename))) {
                        return $this->respondWithError('Not found tmp', 404);
                    }
                    $object->setVideoFilename($videoFilename);
                    $arr = ['id' => $uniqid, 'videoFilename' => $videoFilename];
                    //Put to jobs
                    $this->queue->enqueue('upload_video', "Phanbook\\Queue\\UploadVideo", $arr, true);
                }
            }

            if (!$object->save()) {
                $m = $object->getMessages();
                echo $this->respondWithError($m[0]->getMessage(), 404);
                return 0;
            }
            echo $this->renderUploadForm($object);
            return 1;
        }
    }

    public function saveLinkAction()
    {
        $link = $this->request->getPost('link');
        $url = explode('?v=', $link);
        $videoFilename = $url[1];
        $data = $this->getDataFromUrl($this->phanbook->google()->getYoutubeApiUrl($videoFilename));

        if (!is_array($data)) {
            $this->flashSession->notice('Url youtube no accepted!');
            return $this->currentRedirect();
        }
        $snippet = $data['items'][0]['snippet'];
        $tags    = $snippet['tags'];
        $contentDetails = $data['items'][0]['contentDetails'];
        $post = new Posts();
        $post->setTitle($snippet['title']);
        $post->setVideoFilename($videoFilename);
        $post->setTechOrder(Posts::VIDEO_YOUTUBE);
        //@Default categories
        $post->setCategoryId(120);
        $post->setContent($snippet['description']);
        $post->setThumbnail($snippet['thumbnails']['medium']['url']);
        $post->setDuration(DateTime::durationByDateInterval($contentDetails['duration']));
        if (is_array($tags)) {
            $post->setTags(implode(',', $tags));
        }
        //if isset($data[])
        if (!$post->save()) {
            foreach ($post->getMessages() as $m) {
                $this->flashSession->error($m->getMessage());
            }
            return $this->currentRedirect();
        }
        $this->flashSession->success('Data was add successfully');
        return $this->response->redirect($this->router->getControllerName() . '/edit/' . $post->id);
    }


    protected function renderUploadForm($object)
    {
        $url = $this->config->application->publicUrl .
            '/watch?v=' .ShortId::encode($object->id)
        ;
        $params = ['object' => $object , 'form' => new PostsForm($object), 'url' => $url, 'flag' => true];
        $html =
        $this->view->getRender(
            'posts',
            'item-detail',
            $params, function($view) {
                $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
            }
        );
        return $html;
    }

    /**
     * Delete spam posts
     */
    public function deleteAction($id)
    {
    }

    /**
     * Add new tips or questions.
     */
    public function newAction()
    {
        if (!$this->auth->getAuth()) {
            $this->flashSession->notice(t('You need to login before uploads'));
            return $this->indexRedirect();
        }
        //@TODO remove
        if (!$this->auth->isAdmin()) {
            return $this->indexRedirect();
        }
        $this->loaderAssetsJqueryUpload();
        $this->view->pick('posts/item');
    }
    /**
     * Displays a post and its comments
     *
     * @param $id
     * @param $slug
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function viewAction()
    {
        $parameters = $this->getParameter();
        $encode = $parameters['v'];
        $userId = $this->auth->getAuth()['id'];
        $ipAddress = $this->request->getClientAddress();
        if (empty($encode)) {
            return $this->indexRedirect();
        }
        $id = ShortId::decode($encode);
        if (!$post = Posts::findFirstById($id)) {
            $this->flashSession->error(t('Posts doesn\'t exist.'));
            return $this->indexRedirect();
        }
        if ($post->getDeleted()) {
            $this->flashSession->error('The Post is deleted');
            return $this->indexRedirect();
        }
        if (!$post->isPublish()) {
            $this->flashSession->error('The Post have not publish');
            return $this->indexRedirect();
        }
        //@TODO add redis
        $params = array(
            'postsId = ?0 AND ipaddress = ?1',
            'bind' => array($id, $ipAddress)
        );
        $viewed = PostsViews::count($params);
        //A view is stored by ipAddress
        if (!$viewed) {
            //Increase the number of views in the post
            $post->setNumberViews($post->getNumberViews() + 1);
            if ($post->getUsersId() != $userId) {
                $post->user->increaseKarma(Karma::VISIT_ON_MY_POST);
                if ($userId > 0) {
                    $user = Users::findFirstById($userId);
                    if ($user) {
                        if ($user->getModerator() == 'Y') {
                            $user->increaseKarma(Karma::MODERATE_VISIT_POST);
                        } else {
                            $user->increaseKarma(Karma::VISIT_POST);
                        }
                        //send log to server
                        if (!$user->save()) {
                            $this->saveLoger($user->getMessages());
                        }
                    }
                }
            }
            if (!$post->save()) {
                $this->saveLoger($post->getMessages());
            }
            $postView = new PostsViews();
            $postView->setPostsId($id);
            $postView->setIpaddress($ipAddress);
            $postView->setUsersId($userId);
            if (!$postView->save()) {
                $this->saveLoger($postView->getMessages());
            }
        }

        $vote = $post->getVotes($id, Vote::OBJECT_POSTS);
        $comments = $post->getCommentWithVotes($id);
        list($nextVideo, $total) = $post->getPostRelated($post);

        //Display video for play list
        if (isset($parameters['list'])) {
            $this->view->listVideo = Playlist::getPlayListVideoBySlug($parameters['list']);
            $this->view->listName = $parameters['list'];
        }

        $this->view->setVars([
            'id' => $id,
            'class' => 'single-video',
            'form'  => new CommentForm(),
            'post'  => $post,
            'vote'  => $vote,
            'total' => $total,
            'disqus' => $this->getConfigDisqus(),
            'techOrder' => $post->getTechOrderAndType(),
            'comments' => $comments,
            'nextVideo' => $nextVideo,
            'recommendVideo' => $post->getNewVideos(),
            'url'=> $this->getUrlVideo($id),
            'author' => $post->user->getFullName()
        ]);

    }

    /**
     * @return mixed
     */
    protected function getConfigDisqus()
    {
        $data = [];
        $disqus = $this->config->disqus->toArray();
        $user = $this->auth->getUser();
        if ($user) {
            $data = [
                "id" => $user->getId(),
                "username" => $user->getFullName(),
                "email" => $user->getEmail(),
                //"avatar" => $user['avatar']['url']
            ];
        }

        $message = base64_encode(json_encode($data));
        $timestamp = time();
        $hmac = $this->phanbook->hmacsha1($message . ' ' . $timestamp, $disqus['keySecret']);
        $disqus['remoteAuthS3'] = $message . ' ' . $hmac . ' '. $timestamp;

        return $disqus;
    }
}
