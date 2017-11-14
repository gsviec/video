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
use Phanbook\Models\Categories;
use Phanbook\Models\WatchLater;

/**
 * Class SearchController
 */
class WatchLaterController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->disable();
        $userId = $this->auth->getUserId();
        if (!$this->request->isAjax()) {
            return $this->indexRedirect();
        }
        if (!isset($userId)) {
            echo $this->respondWithError(AUTHORIZE, 404);
            return 0;
        }
        if ($this->request->isPost()) {
            $id = $this->request->getPost('id');
            $watch = new WatchLater();
            $watch->setPostId($id);
            $watch->setUserId($userId);
            $watch->setStatus(WatchLater::STATUS_ACTIVE);
            $watch->setCreatedAt(time());
            if (!$watch->save()) {
                echo $this->respondWithError($watch->getMessages()[0]->getMessage(), 403);
                return 0;
            }
            echo $this->respondWithSuccess('Add watch later success!');
            return 1;
        }
    }
}
