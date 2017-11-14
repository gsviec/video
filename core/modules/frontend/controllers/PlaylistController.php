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
use Phanbook\Models\Playlist;
use Phanbook\Models\PostsPlaylist;
use Phanbook\Models\WatchLater;

/**
 * Class PlaylistController
 */
class PlaylistController extends ControllerBase
{
    public function indexAction()
    {
        $this->setPerPage(29);

        $sql = ['model' => 'Playlist', 'joins' => []];
        $categories = $this->paginator($sql);
        $pagination = $categories->getPaginate();
        $this->view->setVars([
            'playlist'    => $pagination->items,
            'currentPage' => $pagination->current,
            'totalPages'  => $pagination->total_pages,
            'postsPlaylist' => new PostsPlaylist()
        ]);
    }
    public function newAction()
    {
        $this->view->disable();
        if (!$this->request->isPost()) {
            return $this->indexRedirect();
        }
        //@TODO at the moment only admin add new playlist
        if (!$this->auth->isAdmin()) {
            $this->flashSession->notice('Your do not have permission add new playlist.');
            return $this->currentRedirect();
        }
        $data = $this->request->getPost();
        if (!isset($data['title'])) {
            return $this->indexRedirect();
        }
        $playlist = new Playlist();
        $playlist->setTitle($data['title']);
        $playlist->setContent($data['content']);
        if (!$playlist->save()) {
            $this->saveLoger($playlist->getMessages());
            $this->flashSession->error($playlist->getMessages()[0]);
            return $this->currentRedirect();
        }
        $this->flashSession->success('Your data has been saved.');
        return $this->currentRedirect();
    }

    public function saveAction()
    {
        $this->view->disable();
        $data = $this->request->getPost();
        if (!PostsPlaylist::addData($data)) {
            echo $this->respondWithError('Data was not success', 404);
            return 0;
        }
        echo $this->respondWithSuccess('OK');
    }

    public function viewAction()
    {
        $slug = $this->dispatcher->getParam('slug');
        $playlist = Playlist::findFirstBySlug($slug);

        if (!$playlist) {
            $this->flashSession->notice(t('The Playlist was not found'));
            return $this->indexRedirect();
        }

        $this->view->setVars([
            'isGoto'   => false,
            'isSeries' => true,
            'playlist' => $playlist,
            'playlistVideo' => Playlist::getPlayListVideoBySlug($slug)
        ]);
    }
}
