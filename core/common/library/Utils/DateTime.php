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

class DateTime
{
    public static function durationByDateInterval($dateInterval)
    {
        $date = new \DateInterval($dateInterval);
        return $date->h . ':' . $date->i . ':' . $date->s;
    }
}
