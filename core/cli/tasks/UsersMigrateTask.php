<?php
namespace Phanbook\Cli\Tasks;

use Phalcon\CLI\Task;
use Phanbook\Tools\Cli\Output;
use Phanbook\Models\UsersMigrate;


class UsersMigrateTask extends Task
{
    public function indexAction()
    {
        Output::stdout('Initialize search the  posts Indexer');

        $u = new UsersMigrate();
        $u->migreateUsers();

        Output::stdout('Indexer successfully');
    }
}
