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
use Phanbook\Models\Posts;
use Phanbook\Models\ModelBase;

/**
 * Class SearchController
 */
class CategoriesController extends ControllerBase
{
    public function indexAction()
    {
        $this->setPerPage(29);

        $sql = ['model' => 'Categories', 'joins' => []];
        $categories = $this->paginator($sql);
        $pagination = $categories->getPaginate();
        $this->view->setVars([
            'categories' => $pagination->items,
            'currentPage' => $pagination->current,
            'totalPages' => $pagination->total_pages,
        ]);
    }
    public function viewAction()
    {
        $slug = $this->dispatcher->getParam('slug');
        $categories = Categories::findFirstBySlug($slug);
        if (!$categories) {
            $this->flashSession->notice(t('The category was not found'));
            return $this->indexRedirect();
        }
        $status = Posts::STATUS_ACTIVE;
        $postWhere = "a.deleted = 0 AND a.status = '{$status}' AND a.type = 'video'";
        $sql = [
            'model' => 'Posts',

            'joins' => [
                [
                    'type' => 'join',
                    'model' => 'Categories',
                    'on' => 'a.categoryId = c.id',
                    'alias' => 'c'
                ]
            ],
            'where' => "c.id = {$categories->id} AND {$postWhere}"
        ];
        $this->setPerPage(22);
        $cats = $this->paginator($sql);
        $pagination = $cats->getPaginate();

        $this->view->setVars([
            'name'   => $categories->getName(),
            'videos' => $pagination->items,
            'currentPage' => $pagination->current,
            'totalPages' => $pagination->total_pages,
            'isGoto' => true
        ]);
    }

}
