<?php
namespace Phanbook\Cli\Tasks;

use Phalcon\CLI\Task;
use Phanbook\Seeder\ChannelsSeeder;
use Phanbook\Tools\Cli\Output;
use Phanbook\Seeder\PostsSeeder;
use Phanbook\Search\Posts as PostsSearch;


class ChannelsTask extends Task
{
    public function indexAction()
    {
        Output::stdout('Initialize search the  posts Indexer');

        Output::stdout('Indexer successfully');
    }
    public function seederAction()
    {
        if (!$this->config->application->debug) {
            Output::stdout('This is live site so we don\'t need seeder data!');
            return false;
        }
        ChannelsSeeder::run();
    }
}
