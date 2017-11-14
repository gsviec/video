<?php
namespace Phanbook\Search;

use Phalcon\Mvc\User\Component;
use Elasticsearch\ClientBuilder as Client;
use Phanbook\Models\Posts as ModelPosts;

class Posts extends Component
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
        $config = $this->config;
        if (isset($config->elasticsearch->index)) {
            $this->index = $config->elasticsearch->index;
        }
        if (isset($config->elasticsearch->typeSearch)) {
            $this->typeSearch  = $config->elasticsearch->typeSearch;
        }

    }
    /**
     * Search documents in ElasticSearch by the specified criteria
     *
     * @param array   $fields
     * @param int     $limit
     * @param boolean $returnPosts
     */
    public function search(array $fields, $limit = 10, $from = 0, $returnPosts = false)
    {
        return PostsMysql::search($fields, $limit);

        $total   = 0;
        $results = [];
        $searchParams['index'] = $this->index;
        $searchParams['type']  = $this->typeSearch;

        try {
            $client = Client::create()->build();
            $searchParams['body']['fields'] = ['id', 'karma'];
            $searchParams['body']['query']['bool']['must'] = $this->parserField($fields);
            $searchParams['body']['from'] = (int) $from;
            $searchParams['body']['size'] = (int) $limit;
            //d(json_encode($searchParams, JSON_PRETTY_PRINT), false);
            $queryResponse = $client->search($searchParams);
            //d($queryResponse);
            if (is_array($queryResponse['hits'])) {
                $total = $queryResponse['hits']['total'];
                foreach ($queryResponse['hits']['hits'] as $hit) {
                    $post = ModelPosts::findFirstById($hit['fields']['id'][0]);
                    if ($post) {
                        if (!$returnPosts) {
                            $results[] = [
                                'id' => $post->Id(),
                                'title' => $post->getTitle(),
                                'created' => $post->getHumanCreatedAt()
                            ];
                        } else {
                            $results[] = $post;
                        }
                    }
                }
            }
            krsort($results);
            return array(array_values($results), $total);
        } catch (\Exception $e) {
            if (APPLICATION_ENV == 'local') {
                //d($e);
            }
            return array($results, $total);
        }
    }
    public function parserField($fields)
    {
        if (count($fields) == 1) {
            reset($fields);
            return  $this->setQueryString(key($fields), current($fields));
        } else {
            $query = [];
            $rangeStack = ['q', 'star', 'priceMin', 'priceMax', 'startDate', 'endDate'];
            foreach ($fields as $field => $value) {
                if ($field == 'q') {
                    $query[] = $this->setQueryString($field, $value);
                }
                //https://www.elastic.co/guide/en/elasticsearch/reference/1.4/query-dsl-terms-query.html
                if ($field == 'star') {
                    $query[] = array('terms' => [$field => $value]);
                }
                if ($field == 'priceMin') {
                    $query[] = $this->setRange('price', ['gte' => $value]);
                }
                if ($field == 'priceMax') {
                    $query[] = $this->setRange('price', ['lte' => $value]);
                }
                if ($field == 'startDate') {
                    $query[] = $this->setRange($field, ['gte' => $value]);
                }
                if ($field == 'endDate') {
                    $query[] = $this->setRange($field, ['lte' => $value]);
                }
                if (!in_array($field, $rangeStack)) {
                    //http://stackoverflow.com/questions/28001632/filter-items-which-array-contains-any-of-given-values
                    if (is_array($value)){
                        foreach ($value as $item) {
                            $query[] = array('term' => array($field => $item));
                        }
                    } else{
                        $query[] = array('term' => array($field => $value));
                    }
                }
            }
        }
        return $query;
    }

    /**
     * Index a single document
     *
     * @param ModelPosts $post
     */
    protected function doIndexSearch(ModelPosts $post)
    {
        $client = Client::create()->build();
        $karma  = $post->getNumberViews() + 0 + $post->getNumberReply();
        if ($karma > 0) {
            $id     = $post->getId();
            $params = [];

            $params['body']  = [
                'id'        => $id,
                'karma'     => $karma,
                'title'     => $post->getTitle(),
                'content'   => $post->getContent(),
                'tags'      => $post->getTags(),
                'category'  => $post->getCategoryId()
            ];
            $params['index'] = $this->index;
            $params['type']  = $this->typeSearch;
            $params['id']    = 'post-' . $post->getId();
            $ret = $client->index($params);
            var_dump($ret);
        }
    }

    /**
     * @return array
     */
    public function searchCommon()
    {
        $client = Client::create()->build();

        $searchParams['index'] = $this->index;
        $searchParams['type']  = $this->typeSearch;

        $searchParams['body']['common']['body']['fields'] = array('id', 'karma');
        $searchParams['body']['common']['body']['query'] = "nelly the elephant not as a cartoon";
        $searchParams['body']['common']['body']["cutoff_frequency"] = 0.001;

        return $client->search($searchParams);
    }

    /**
     * Puts a post in the search server
     *
     * @param Posts $post
     */
    public function index($post)
    {
        $this->_doIndex($post);
    }


    /**
     * @param $key
     * @param array $params
     * @return array
     */
    protected function setRange($key, array $params)
    {
        if (isset($params['gte'])) {
            $range = ['gte' => $params['gte']];
        }
        if (isset($params['lte'])) {
            $range = ['lte' => $params['lte']];
        }
        if (isset($params['gte']) && isset($params['lte'])) {
            $range = ['gte' => $params['gte'], 'lte' => $params['lte']];
        }

        return ['range' =>array($key => $range)];
    }
    /**
     * @param $key
     * @param $value
     * @return array
     */
    protected function setQueryString($key, $value)
    {
        $params = ['fields' => [$key], 'query' => $value];
        return ['query_string' => $params];
    }
    /**
     * Indexes all posts in the forum in ES
     */
    public function indexAll()
    {

        try {
            $client = Client::create()->build();
            $deleteParams['index'] = $this->index;
            $client->indices()->delete($deleteParams);
        } catch (\Exception $e) {
            // the index does not exist yet
        }
        $posts = new ModelPosts();
        if(!$posts = $posts->getAllVideo()) {
            d('We dont have any posts');
            return 0;
        }
        foreach ($posts as $post) {
            $this->doIndexSearch($post);
        }
    }
}

//2833/20
//floor adjust flavor divert width loyal vague together provide trend dinosaur picture
