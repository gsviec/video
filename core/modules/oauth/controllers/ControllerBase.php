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
use Phanbook\Models\Users;
use Phanbook\Models\Karma;

/**
 * Class TestsController
 *
 * @package Phanbook\Frontend\Controllers
 */
class ControllerBase extends Controller
{

    public function initialize()
    {
        $this->loadDefaultAssets();
        $this->view->setVars([
            'name'          => $this->config->application->name,
            'publicUrl'     => $this->config->application->publicUrl
        ]);

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
    /**
     * @param string $uid       to checking condition when authentication again
     * @param object $user      here is oauth
     * @param object $toekn     here it is token get by oauth
     * @param object $object    here is it is find in database
     * @param string $nameOauth there are google, github, facebook...
     *
     * @return mixed
     */
    public function commonOauthSave($uid, $user, $token, $object, $nameOauth)
    {

        if (!$object) {
            $object = new Users();
            //setTokenGithub or setTokenGoogle
            $uuidName  = 'setUuid' . $nameOauth;
            $tokenName = 'setToken'. $nameOauth;
            $object->$tokenName($token->getToken());
            $object->setTokenType(Users::TOKEN_TYPE);
            //$object->setUid($uid);
            $object->$uuidName($uid);
            $object->setEmail($user->getEmail());
            $object->setName($user->getName());
            //@ Todo later, it perfect if we do haven't delete in database
            $username = 'users' . (Users::count() + 1);
            $object->setUsername($username);
            if (empty($user->getEmail())) {
                $object->setEmail($username .'+@phalconbook.com');
            }
            $object->setStatus(Users::STATUS_ACTIVE);
            $object->increaseKarma(Karma::LOGIN);

            if (!$object->save()) {
                $this->displayModelErrors($object);
                return $this->indexRedirect();
            }
        }
        //Update session id
        session_regenerate_id(true);



        //Store the user data in session
        $this->auth->setSession($object);

        //Store the user data in cookies
        $this->auth->setRememberEnvironment($object);

        //Dispaly notification when user login
        $this->notification($object);

        return $this->currentRedirect();
    }
    public function currentRedirect()
    {
        if (isset($_GET['redirect'])) {
            return $this->response->redirect($_GET['redirect']);
        }
        if ($this->cookies->has('HTTPBACK')) {
            $url   = $this->cookies->get('HTTPBACK');
            $clone = clone $url;
            $url->delete();

            return $this->response->redirect(unserialize($clone->getValue()));
        }
        return $this->response->redirect($this->request->getHTTPReferer(), true);
    }
    public function indexRedirect()
    {
        return $this->response->redirect('oauth/login');
    }
    /**
     * loadDefaultAssets function.
     *
     * @access private
     * @return void
     */
    private function loadDefaultAssets()
    {
        $this->assets
            ->addCss('https://fonts.googleapis.com/css?family=Hind:400,300,500,600,700', false)
            ->addCss('css/bootstrap.min.css')
            ->addCss('css/font-awesome.min.css')
            ->addCss('css/font-circle-video.css')
            ->addCss('css/app.css')
            //->addCss('css/login.css')
        ;
        $this->assets
            ->addJs('js/jquery.js')
            ->addJs('js/bootstrap.js')
            ->addJs('js/app.function.js')
            ->addJs('js/app.js')
        ;
    }
}
