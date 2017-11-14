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
namespace Phanbook\Queue;

use Phanbook\Models\Posts;
use Phanbook\Utils\Ffmpeg;

class UploadVideo extends Resque
{

    /**
     * Run a job
     *
     */
    public function perform()
    {
        $params = $this->args;
        if (!is_array($params)) {
            throw new \Exception('The parameter needs to be a array');
        }
        $id = $params['id'];
        if (!isset($id)) {
            $this->logger->error('The id video was not found!');
            return false;
        }
        $filename = $params['videoFilename'];
        if (!isset($filename)) {
            $this->logger->error('A filename was not found!');
            return false;
        }

        $path = public_path('uploads/videos/' . $filename);
        if (!file_exists($path)) {
            $this->logger->error('Video not found in folder uploads/videos');
            return false;
        }
        $duration  = Ffmpeg::getDuration($path);
        $thumbnail = Ffmpeg::getThumbnail($path, $id);
        $post = Posts::findFirstByVideoFilename($filename);
        $post->setDuration($duration);
        $post->setThumbnail($thumbnail);

        if (!$post->save()) {
            $this->logger->error('Add a post was not success!' . $post->getMessages() . __LINE__);
            return false;
        }

        $key  = 'video/' . $filename;
        if ($this->storage->upload($path, $key)) {
            unlink($path);
        }
        return true;
    }
}
