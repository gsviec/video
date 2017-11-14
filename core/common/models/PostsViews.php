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
namespace Phanbook\Models;

use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Phalcon\DI\FactoryDefault;

class PostsViews extends ModelBase
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $postsId;

    /**
     *
     * @var string
     */
    protected $ipaddress;

    /**
     * @var int
     */
    protected $usersId;

    /**
     * @var int
     */
    protected $createdAt;


    /**
     * Method to set the value of field id
     *
     * @param  integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field postsId
     *
     * @param  integer $postsId
     * @return $this
     */
    public function setPostsId($postsId)
    {
        $this->postsId = $postsId;

        return $this;
    }

    /**
     * Method to set the value of field ipaddress
     *
     * @param  string $ipaddress
     * @return $this
     */
    public function setIpaddress($ipaddress)
    {
        $this->ipaddress = $ipaddress;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field postsId
     *
     * @return integer
     */
    public function getPostsId()
    {
        return $this->postsId;
    }

    /**
     * Returns the value of field ipaddress
     *
     * @return string
     */
    public function getIpaddress()
    {
        return $this->ipaddress;
    }

    /**
     * @param int $usersId
     */
    public function setUsersId($usersId)
    {
        $this->usersId = $usersId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUsersId()
    {
        return $this->usersId;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * Initialize method for model.
     */
    public function getSource()
    {
        return 'postsViews';
    }
    public function initialize()
    {
        parent::initialize();
        $this->belongsTo('postsId', __NAMESPACE__ .'\Posts', 'id', ['alias' => 'posts']);

    }
    public function clearCache()
    {
        if ($this->id) {
            $viewCache = $this->getDI()->getViewCache();
            $viewCache->delete('post-' . $this->posts_id);
        }
    }
    public static function getPaginateHistoryVideo($item)
    {
        $di = FactoryDefault::getDefault();
        $userId = $di->getAuth()->getUserId();
        if (!isset($userId)) {
            return false;
        }
        $sql = [
            'columns' => 'a.*',
            'model' => 'Posts',
            'joins' => [
                [
                    'type' => 'join',
                    'model' => 'PostsViews',
                    'on' => 'pv.postsId = a.id',
                    'alias' => 'pv'
                ]
            ],
            'orderBy' => 'pv.createdAt',
            'where' => "pv.usersId = {$userId}"
        ];
        $builder = self::modelQuery($sql);

        $paginator = new PaginatorQueryBuilder(
            [
                "builder"  => $builder,
                "limit" => $item[1],
                "page"  => $item[0],
            ]
        );
        return $paginator->getPaginate();
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'postsId' => 'postsId',
            'usersId' => 'usersId',
            'ipaddress' => 'ipaddress',
            'createdAt' => 'createdAt'
        ];
    }
}
