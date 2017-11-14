<?php
namespace Phanbook\Search;

use Phalcon\Mvc\User\Component;
use Elasticsearch\ClientBuilder as Client;
use Phanbook\Models\Posts as ModelPosts;

class PostsMysql extends Component
{
    /**
     * Index a document
     * @var string
     */
    protected $index = 'lackky';

    /**
     * Type a document
     * @var string
     */
    protected $typeSearch = 'posts';

    public function __construct()
    {


    }
    public static function search($field, $limit)
    {
        $obj = [];
        if (isset($_GET['q'])) {
            $q   = htmlentities($field['title']);
            $obj = ModelPosts::find([
                "conditions" => "title LIKE '%$q%'",
                "limit" => $limit
            ]);

            return [$obj, 1];
        }
        return [$obj, 0];
    }

}

//2833/20
//floor adjust flavor divert width loyal vague together provide trend dinosaur picture
