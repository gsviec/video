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
use Phanbook\Models\Posts;
use Phanbook\Search\Posts as PostsSearch;


/**
 * Class SearchController
 */
class SearchController extends ControllerBase
{
    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface|View
     */
    public function indexAction()
    {
        $q = $this->request->getQuery('q', 'string');
        $page    = $this->request->getQuery('page') ? : 1;
        $perPage = $this->request->getQuery('limit') ? : $this->perPage;
        $offset  = ($page > 1) ? ($page - 1) * $perPage + 1 : 0;

        $indexer = new PostsSearch();
        list($posts, $totalPost) = $indexer->search(['title' => $q, 'content' => $q], $perPage, $offset, true);

        if (!count($posts)) {
            list($posts, $totalPost) = $indexer->search(['title' => $q], $perPage, $offset, true);

            if (!count($posts)) {
                //Use mysql query to search
            }
            if (!count($posts)) {
                $this->flashSession->notice('There are no search results');
                return $this->response->redirect();
            }
        }

        $this->view->setVars(
            [
                'q' => $q,
                'posts'         => $posts,
                'totalPages'    => $totalPost,
                'currentPage'   => $page,
                'currentUri'    => $this->getCurrentUri()
            ]
        );
    }
    /**
     * Finds related posts
     */
    public function showRelatedAction()
    {
        $this->view->disable();
        if ($this->request->isAjax()) {
            $post = Posts::findFirstById($this->request->getPost('id'));
            if ($post) {
                $posts = Posts::postRelated($post);
                if (count($posts) > 0) {
                    $params = ['posts' => $posts];
                    echo $this->view->getRender(
                        'partials',
                        'list-posts',
                        $params,
                        function ($view) {
                            $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
                        }
                    );
                }

            }
        }
    }
}
