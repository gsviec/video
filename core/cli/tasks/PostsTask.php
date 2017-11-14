<?php
namespace Phanbook\Cli\Tasks;

use Phalcon\CLI\Task;
use Phanbook\Tools\Cli\Output;
use Phanbook\Seeder\PostsSeeder;
use Phanbook\Search\Posts as PostsSearch;


class PostsTask extends Task
{
    public function indexAction()
    {
        Output::stdout('Initialize search the  posts Indexer');

        $search = new PostsSearch();
        $search->indexAll();

        Output::stdout('Indexer successfully');
    }
    public function seederAction()
    {
        if (!$this->config->application->debug) {
            Output::stdout('This is live site so we don\'t need seeder data!');
            return false;
        }
        PostsSeeder::run();
    }
}
