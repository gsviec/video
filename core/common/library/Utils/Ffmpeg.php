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

class Ffmpeg
{

    /**
     * @param $videoPath
     * @return string
     */
    public static function getDuration($videoPath)
    {
        $cmd = "ffmpeg -i " . $videoPath . " >> /tmp/ffmpeg 2>&1";
        exec($cmd, $result);
        if (isset($result[17])) {
            preg_match('/Duration: ((\d+):(\d+):(\d+))/s', $result[17], $time);
            //var_dump($time);
            return $time[1];
        }
        return '00:05:00';
    }

    /**
     * @param $videoPath
     * @param $id
     * @return string | null
     */
    public static function getThumbnail($videoPath, $id)
    {
        $filename = $id . '.png';
        $outputPath = public_path('uploads/videos/' . $filename);
        $cmd = "ffmpeg -y -i {$videoPath}  -vframes 1 " . $outputPath;
        exec($cmd, $result);
        if (file_exists($outputPath)) {
            return $outputPath;
        }
        return null;
    }
}
