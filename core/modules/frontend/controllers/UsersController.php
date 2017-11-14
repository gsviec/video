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

use Phanbook\Models\Users;
use Phanbook\Models\Posts;
use Phanbook\Models\ModelBase;
use Phanbook\Models\PostsReply;
use Phanbook\Frontend\Forms\UserForm;
use Phanbook\Frontend\Forms\UserSettingForm;
use Phanbook\Frontend\Forms\ChangePasswordForm;

/**
 * Class UsersController
 */
class UsersController extends ControllerBase
{

    /**
     * @var int
     */
    public $perPage = 12;

    public function initialize()
    {
        parent::initialize();
    }

    public function detailAction($user)
    {
        if (!$user = Users::findFirstByUsername($user)) {
            $this->flashSession->error(t('The User dosen\'t exits'));
            return $this->indexRedirect();
        }
        $tab     = $this->request->getQuery('tab');
        $page    = isset($_GET['page']) ? (int)$_GET['page'] : $this->numberPage;
        $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : $this->perPage;
        $where  = '';
        if ($tab == "answers") {
            $join = [
                'type'  => 'join',
                'model' => 'PostsReply',
                'on'    => 'r.postsId = p.id',
                'alias' => 'r'

            ];
            list($itemBuilder, $totalBuilder) =
                ModelBase::prepareQueriesPosts($join, $where, $this->perPage);
                $itemBuilder->groupBy(array('p.id'));
        } else {
            list($itemBuilder, $totalBuilder) =
                ModelBase::prepareQueriesPosts('', $where, $this->perPage);
        }
        $params =[];
        switch ($tab) {
            case 'questions':
                $this->tag->setTitle('Questions');
                $questionConditions = 'p.type = "questions"';
                $itemBuilder->where($questionConditions);
                break;
            case 'answers':
                $this->tag->setTitle('My Answers');
                $answersConditions = 'r.usersId = ?0';
                $itemBuilder->where($answersConditions);
                //$totalBuilder->where($answersConditions);
                break;
            default:
                $this->tag->setTitle('All Questions');
                break;
        }
        $conditions = 'p.deleted = 0 and p.usersId = ?0';
        if ($tab == 'answers') {
            $conditions = 'p.deleted = 0';
        }
        $itemBuilder->andWhere($conditions);
        $totalBuilder->andWhere($conditions);
        $params = array($user->getId());
        //get all reply
        $parametersNumberReply = [
            'group' => 'postsId',
            'usersId = ?0',
            'bind' => [$user->getId()],
        ];

        $paramQuestions = [
            'usersId = ?0 and type = "questions" and deleted = 0',
            'bind' => [$user->getId()]
        ];
        $totalPosts = $totalBuilder->getQuery()->setUniqueRow(true)->execute($params);
        $totalPages = ceil($totalPosts->count / $perPage);
        $offset     = ($page - 1) * $perPage + 1;
        if ($page > 1) {
            $itemBuilder->offset($offset);
        }
        $this->view->setVars(
            [
                'user'              => $user,
                'posts'             => $itemBuilder->getQuery()->execute($params),
                'totalQuestions'    => Posts::count($paramQuestions),
                'totalReply'        => PostsReply::find($parametersNumberReply)->count(),
                'tab'               => $tab,
                'totalPages'        => $totalPages,
                'currentPage'       => $page
            ]
        );
    }

    public function indexAction()
    {

        $sql = [
            'model' => 'Users',
            'joins' => []

        ];
        //Create a Model paginator
        $data = $this->paginator($sql);
        $this->view->setVars(
            [
                'paginator' => $data->getPaginate(),
                'tab'  => 'users',
            ]
        );
        $this->tag->setTitle(t('List all users'));
        $this->assets->addCss('core/assets/css/user.css');
    }

    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function profileAction()
    {
        $object = Users::findFirstById($this->auth->getAuth()['id']);

        if (!$object) {
            $this->flashSession->error(t('Hack attempt!!!'));

            return $this->response->redirect('/');
        }
        $form = new UserForm($object);

        if ($this->request->isPost()) {
            $form->bind($_POST, $object);
            if (!$form->isValid()) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message->getMessage());
                }
            } else {

                if (!$object->save()) {
                    foreach ($object->getMessages() as $message) {
                        $this->flashSession->error($message->getMessage());
                    }
                } else {
                    $this->flashSession->success(t('Data was successfully saved'));
                    $this->refreshAuthSession($object->toArray());
                    return $this->response->redirect($this->router->getControllerName() . '/profile');
                }
            }
        }
        $this->view->form   = $form;
        $this->view->object = $object;
    }
    private function refreshAuthSession($array)
    {
        $auth = $this->auth->getAuth();
        $auth = array_merge($auth, $array);

        return $this->session->set('auth', $auth);
    }

    /**
     * @return bool
     */
    public function changepasswordAction()
    {
        $form = new ChangePasswordForm();
        $object = Users::findFirstById($this->auth->getAuth()['id']);

        $this->view->form = $form;

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message->getMessage());
                }
            } else {
                if ($object && $object->getStatus() == $object::STATUS_ACTIVE) {
                    $newPass = $this->security->hash($this->request->getPost('passwd_new_confirm'));
                    $object->setPasswd($newPass);
                    if (!$object->save()) {
                        $this->displayModelErrors($object);
                    } else {
                        $this->flashSession->success(t('Hooray! Your password was successfully changed.'));
                        return $this->response->redirect($this->router->getControllerName() . '/changepassword');
                    }
                } elseif ($object && $object->getStatus() != Users::STATUS_ACTIVE) {
                    $this->flashSession->error(t('User status is: ') . $object->getStatusesWithLabels()[$object->getStatus()] . '. You can\'t change your password.');
                } else {
                    $this->flashSession->error(t('User doesn\'t exist !'));
                }
            }
        }

        return true;
    }

    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function settingAction()
    {
        $object = Users::findFirstById($this->auth->getAuth()['id']);
        if (!$object) {
            $this->flashSession->error(t('Hack attempt!!!'));
            return $this->response->redirect();
        }
        $form = new UserSettingForm($object);
        $form->bind($_POST, $object);
        if ($this->request->isPost()) {
            if (!$form->isValid()) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message->getMessage());
                }
            } else {
                $object->setDigest($this->request->getPost('digest'));
                if (!$object->save()) {
                    foreach ($object->getMessages() as $message) {
                        $this->flashSession->error($message->getMessage());
                    }
                } else {
                    $this->flashSession->success(t('Data was successfully saved'));
                    $this->refreshAuthSession($object->toArray());
                    return $this->response->redirect($this->router->getControllerName() . '/setting');
                }
            }
        }
        $this->tag->setTitle(t('Edit profile'));
        $this->view->form   = $form;
        $this->view->object = $object;
    }

    public function avatarAction()
    {
        $user = $this->auth->getUser();

        if (!isset($user)) {
            return $this->indexRedirect();
        }

        //Update avatar to amazon
        if ($this->request->isPost()) {
            if ($this->request->hasFiles()) {
                foreach ($this->request->getUploadedFiles() as $file) {
                    if (!$this->imageCheck($file->getRealType())) {
                        $this->flashSession->error(t('You format image not correct'));
                    }
                    $id = $user->id . '.png';
                    //Move to temp location
                    $r = $file->moveTo(image_path('avatar/' . $id));
                    //Put to jobs
                    $this->queue->enqueue(
                        'upload_images_avatar',
                        "Phanbook\\Queue\\UploadImage",
                        ['id' => $id, 'avatarImage' => true],
                        true
                    );
                }
                $this->flashSession->success(t('You was updated data success'));
            }
        }
        $this->view->avatar = $user->getAvatar();
        $this->view->action = 'user-avatar';
    }
}
