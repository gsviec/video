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
namespace Phanbook\Backend\Controllers;

use Phanbook\Controllers\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\Paginator\Adapter\NativeArray as Paginator;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;


/**
 * Class ControllerBase
 *
 * @package Phanbook\Backend\Controllers
 */
class ControllerBase extends Controller
{
    /**
     * @var array
     */
    private $securedRoutes = [
        ['controller' => 'admin'],
        ['controller' => 'template'],
        ['controller' => 'posts'],
        ['controller' => 'settings'],
        ['controller' => 'pages'],
        ['controller' => 'users'],
        ['controller' => 'tags'],
        ['controller' => 'dashboard'],
        ['controller' => 'update'],
        ['controller' => 'tests'],
        ['controller' => 'media'],
        ['controller' => 'themes']

    ];

    /**
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        if ($this->auth->isAdmin() && $this->isSecuredRoute($dispatcher)) {
            return true;
        }
        header('Location:/oauth/login');
        exit;
    }



    public function initialize()
    {
        $this->view->currentOrder = $this->currentOrder;
        $this->loadDefaultAssets();
        $this->view->menuStruct = $this->menuStruct;
        $this->view->constants = (object) get_defined_constants(true)["user"];
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
            ->addCss('//fonts.googleapis.com/css?family=Open+Sans', false)
            ->addCss('css/bootstrap.min.css')
            ->addCss('css/font-awesome.min.css')
            ->addCss('css/animate.css')
            ->addCss('backend/css/app.css')
            ->addCss('backend/css/app-custom.css');
        $this->assets
            ->addJs('js/jquery.js')
            ->addJs('js/jquery-ui.js')
            ->addJs('js/bootstrap.js')
            ->addJs('js/growl/jquery.growl.js')
            ->addJs('js/chosen/chosen.jquery.min.js')
            ->addJs('backend/js/jquery.taginput.src.js')
            ->addJs('backend/js/app.js')
            ->addJs('backend/js/app.plugin-custom.js');
    }

    /**
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    private function isSecuredRoute(Dispatcher $dispatcher)
    {
        foreach ($this->securedRoutes as $route) {
            if ($route['controller'] == $dispatcher->getControllerName()) {
                return true;
            }
        }

        return false;
    }
}
