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
use Phalcon\Image\Adapter\Imagick;

/**
 * Class UploadImage
 * {code}
 * $this->queue->enqueue('upload_images', "Phanbook\\Queue\\UploadImage", $array, true);
 * {/code}
 * @package Phanbook\Queue
 */
class UploadImage extends Resque
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
        //For use when upload a video
        if (isset($params['videoImage'])) {
            if (!$this->uploadImageVideo($params)) {
                $this->logger->error('Upload image a video was not success!');
                return false;
            }
            return true;
        }
        //For use when upload a avatar user

        if (isset($params['avatarImage'])) {
            if (!$this->uploadImageAvatar($params)) {
                $this->logger->error('Upload image a video was not success!');
                return false;
            }
            return true;
        }

        //Upload
        $this->uploadImageChannel($params);

        return true;
    }

    /**
     * @param $params
     * @return bool
     */
    protected function uploadImageVideo($params)
    {
        $filename = $params['filename'];
        if (!isset($filename)) {
            return false;
        }
        $path = public_path('uploads/videos/' . $filename);
        $image = new Imagick($path);
        $image->resize(400, 400)->crop(270, 169);
        if (!$image->save()) {
            $this->logger->error("Resize channel image not success", 1);
            return false;
        }

        $key  = 'images/video/' . $filename;
        if ($this->storage->upload($path, $key)) {
            unlink($path);
            return true;
        }
        return false;
    }

    /**
     * @param $params
     * @return bool
     */
    protected function uploadImageChannel($params)
    {
        $id = $params['id'];
        if (!isset($id)) {
            $this->logger->error('Adding image '. $id . ' was not successful!');
            return false;
        }
        $path = public_path('uploads/channels/' . $id);
        $image = new Imagick($path);
        $image->resize(200, 200)->crop(176, 157);
        if (!$image->save()) {
            $this->logger->error("Resize channel image not success", 1);
            return false;
        }
        $key  = 'images/profile/' . $id;
        if (!$this->storage->upload($path, $key)) {
            return false;
        }
        unlink($path);
        return true;
    }

    /**
     * @param $params
     * @return bool
     */
    protected function uploadImageAvatar($params)
    {
        $id = $params['id'];
        if (!isset($id)) {
            $this->logger->error('Adding image '. $id . ' was not successful!');
            return false;
        }
        $path = image_path('avatar/' . $id);
        $image = new Imagick($path);
        $image->resize(200, 200)->crop(176, 157);
        if (!$image->save()) {
            $this->logger->error("Resize channel image not success", 1);
            return false;
        }
        $key  = 'images/avatar/' . $id;
        if (!$this->storage->upload($path, $key)) {
            return false;
        }
        unlink($path);
        return true;
    }
}
