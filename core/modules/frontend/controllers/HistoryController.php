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
use Phanbook\Models\PostsViews;
use Phanbook\Models\WatchLater;

/**
 * Class PlaylistController
 */
class HistoryController extends ControllerBase
{
    public function indexAction()
    {
        $this->setPerPage(20);
        $paginate = PostsViews::getPaginateHistoryVideo($this->getPerPageAndOffset());
        if (!$paginate) {
            $this->flashSession->notice(AUTHORIZE);
            return $this->indexRedirect();
        }
        $this->view->setVars([
            'videos' => $paginate->items,
            'totalPages' => $paginate->total_pages,
            'currentPage' => $paginate->current
        ]);

    }
}
