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
namespace Phanbook\Utils;

use Phanbook\Models\Tags;
use Phanbook\Models\PostsTags;

class Google
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getYoutubeApiUrl($filename)
    {
        $url = 'https://www.googleapis.com/youtube/v3/videos?id=';
        $url = $url . $filename. '&key=' . $this->config->google->apiKey;
        $url = $url . '&part=snippet,contentDetails,statistics,status';
        return $url;
    }

}
