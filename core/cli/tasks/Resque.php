<?php
/**
 * Nines : PharmaScout software
 *
 * Licensed under The GNU License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @link    http://5nines.co.za Nines Project
 * @since   1.0.0
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 */
namespace Phanbook\Cli\Tasks;

use Phalcon\CLI\Task;

class Resque extends Task
{

    public function onConstruct()
    {
        $resque = $this->config->resque;
        foreach ($resque as $key => $value) {
            putenv(sprintf('%s=%s', $key, $value));
        }
    }
}
