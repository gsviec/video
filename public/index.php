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

use Phalcon\Mvc\Application;

ini_set('memory_limit', '-1');

require dirname(dirname(__FILE__)) . '/bootstrap/autoloader.php';

try {
    /**
     * Include services
     */
    require ROOT_DIR . '/core/config/services.php';

    $modules = require ROOT_DIR . '/core/config/modules.php';

    require_once ROOT_DIR . '/core/config/routing.php';

    if (APPLICATION_ENV == 'local') {
        error_reporting(E_ALL);
        ini_set('error_reporting', 1);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 0);
        ini_set('log_errors', 0);
    }

    /**
     * Handle the request
     */
    $application = new Application();

    /**
     * Assign the DI
     */
    $application->setDI($di);

    /**
     * Include modules
     */

    $application->registerModules($modules);

    /**
     * Sets the event manager
     */
    $application->setEventsManager($eventsManager);

    echo $application->handle()->getContent();
} catch (Exception $e) {
    $logger = $di->get('logger');
    $logger->error($e->getMessage());
    $logger->error($e->getTraceAsString());

    if (APPLICATION_ENV == 'local') {
        d(get_class($e) . ': ' . $e->getMessage(), false);
        d($e->getTraceAsString());
    }

    $response = $di->get('response');
    $response->redirect('error-reporting');
    $response->send();
}
