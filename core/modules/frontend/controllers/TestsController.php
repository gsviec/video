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
use Phanbook\Models\Tags;
use Phanbook\Models\Posts;
use Phanbook\Models\ModelBase;

use Phanbook\Tools\ShortId;
use Phanbook\Utils\DateTime;

/**
 * Class HelpController
 *
 * @package Phosphorum\Controllers
 */
class TestsController extends ControllerBase
{

    public function mathAction()
    {

        d(ShortId::decode('BZ9RNV'));
    }
    public function sessionAction()
    {



        echo $this->session-> getLifetime();


        var_dump($_SESSION);
        var_dump($_COOKIE);
        $key = $this->crypt->decrypt($_COOKIE['oauth_token']);
        var_dump($key);
        $data = $this->session->read($key);

        $data = explode('auth|', $data);
        $item = unserialize($data[1]);
        var_dump($item);
        if (isset($item['id'])) {


        }

        return false;
        $hello = [
            'login' =>[

                'id' => 1,
                'type' => 'password'
            ]
        ];
        d($this->session->write('var', serialize($hello)));

    }
    public function videoAction()
    {
        $videoPath = ROOT_DIR . 'content/uploads/videos/157ee77f1b2bb1.mp4';
        d(\Phanbook\Utils\Ffmpeg::getDuration($videoPath));
    }
    public function uploadAction()
    {
        $s3 = new \Phanbook\Amazon\Upload;
        $s3->run(ROOT_DIR . 'content/uploads/README.md');
    }
    public function youtubeAction()
    {
        $url = 'https://www.googleapis.com/youtube/v3/videos?';
        $url = $url . 'id=8fmzq-8z1bA&key=AIzaSyDw2qKJiRMhCLifNi0PT60_MCXYhfUzPi0&';
        $url = $url . 'part=snippet,contentDetails,statistics,status';
        $data = json_decode($this->get_data($url), true);
        $tags = $data['items'][0]['snippet']['tags'];
        d($tags, false);
     d(implode(',', $tags));

    }
    public function timeAction()

    {
        d( DateTime::durationByDateInterval('PT3H45M39S'));
    }
    public function onConstruct()
    {
        if (APPLICATION_ENV == 'production') {
            return $this->response->redirect('/');
        }
        $this->view->disable();
    }
    /* gets the data from a URL */
    public function get_data($url) {

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    public function queueAction()
    {
        $job = ['id' => 123, 'name' => 'duythien'];

        //$job = ['id' => 111, 'name' => 'nhitran'];
        $this->queue->put($job);
    }
    public function infoAction()
    {
        phpinfo();
    }
    public function dirAction()
    {
        d(VIDEO_DIR);
    }
    public function historyAction()
    {

        $this->cookies->set('historyId', $historyId, time() + 3600*24*7);
    }
}
