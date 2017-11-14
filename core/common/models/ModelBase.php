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

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
use Phanbook\Tools\ZFunction;
use Phanbook\Models\Behavior\Blameable as ModelBlameable;
/**
 * Class ModelBase
 * It is common model basics for Mysql
 *
 * @package Phanbook\Models
 */
class ModelBase extends Model
{

    const OBJECT_POSTS       = 'posts';
    const OBJECT_COMMENTS    = 'comments';
    const OBJECT_POSTS_REPLIES = 'postsReplies';

    /**
     *'1' - A published post or page
     *'2' - post is pending review
     *'draft'   - a post in draft status
     *'future'  - a post to publish in the future
     *'private' - not visible to users who are not logged in
     *'trash'   - post is in trash bin.
     */
    const STATUS_ACTIVE   = 'active';
    const STATUS_PENDING  = 'pending';
    const STATUS_PRIVATE  = 'private';
    const STATUS_DISABLED = 'disable';
    const STATUS_INACTIVE = 'inactive';

    /**
     *
     * @var integer
     */
    protected $createdAt;

    /**
     * @var int
     */
    protected $limit = 8;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @param int $limit
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * Toggle object status. 0 or 1
     *
     * @param $id     - id of object to toggle
     * @param string  $method - column name for toggleing - status by default
     */
    public function toggleObject($id, $column = 'status')
    {

    }

    public static function getBuilder()
    {
        $di = FactoryDefault::getDefault();

        return $di->get('modelsManager')->createBuilder();
    }

    public static function getConnection()
    {
        $di = FactoryDefault::getDefault();

        return $di->get('db');
    }

    /**
     * Generic method for deleting one or more rows based on primary key id and classname
     *
     * @param $ids   - array|int with object id
     * @param null                             $model - full class name. if null get classname automaticaly
     *
     * @return bool|void
     */
    public function deleteObject($ids, $model = null)
    {

    }
    /**
     * @param $objectId
     * @param $object
     *
     * @return mixed
     */
    public function getVotes($objectId, $object)
    {
        $sql = "SELECT COALESCE(SUM(positive),0) AS positive, COALESCE(SUM(negative),0) AS negative
            FROM  vote WHERE objectId = ? AND object = ?
        ";
        $comment = new Vote();
        $params = [$objectId, $object];
        $pdoResult  = $comment->getReadConnection()->query($sql, $params);
        return (new Resultset(null, $comment, $pdoResult))->getFirst();
    }

    /**
     * @param bool $id this is id post or comment id
     * @return Resultset
     */
    public function getCommentWithVotes($id = false)
    {
        $sql = 'SELECT c.*, u.email,
            (SELECT COALESCE(SUM(v.positive),0) FROM  vote v  WHERE c.id = v.objectId AND v.object = ?) AS positive,
            (SELECT COALESCE(SUM(v.negative),0) FROM  vote v  WHERE c.id = v.objectId AND v.object = ?) AS negative
            FROM comment as c
            LEFT JOIN users u ON u.id = c.userId
            WHERE c.objectId= ? AND c.deleted = 0
            GROUP BY c.id
            ORDER BY c.id DESC';

        $comment = new Comment();
        $params = [self::OBJECT_POSTS, self::OBJECT_POSTS, ($id ? $id : $this->getId())];
        $pdoResult  = $comment->getReadConnection()->query($sql, $params);
        return (new Resultset(null, $comment, $pdoResult));
    }
    /**
     * @param $obJectid
     * @param $object
     *
     * @return mixed
     */
    public function getComments($objectString)
    {

    }
    /**
     * Set Notify users that always want notifications via Queueing jobs
     *
     * @param integer $userId      user want notification
     * @param integer $postId      [description]
     * @param integer $postReplyId [description]
     * @param string  $type        Such as Comment, reply...
     *
     * @return integet|bool
     */
    public function setNotification($userId, $postId, $postReplyId, $type)
    {
        $notification = new Notifications();
        $notification->setUsersId($userId);
        $notification->setPostsId($postId);
        $notification->setPostsReplyId($postReplyId);
        $notification->setType($type);

        if (!$notification->save()) {
            $messages = $notification->getMessages();
            error_log('setNotification error' . __LINE__. $messages[0]);
            return false;
        }
        return $notification->getId();
    }
    /**
     * Set Notify users that always want notifications just display notification on website
     * @param integer $userId       user want notification
     * @param integer $postId       [description]
     * @param integer $postReplyId  [description]
     * @param string  $type         such as Comment, reply...
     * @param integer $userOriginId the usesr id post question
     */
    public function setActivityNotifications($userId, $postId, $postReplyId, $userOriginId, $type)
    {
        $activity = new ActivityNotifications();
        $activity->setUsersId($userId);
        $activity->setPostsId($postId);
        ;
        $activity->setPostsReplyId($postReplyId);
        $activity->setUsersOriginId($userOriginId);
        $activity->setType($type);
        $activity->save();
    }
    /**
     * The function sending log for nginx or apache, it will to analytic later
     *
     * @param $e
     */
    public function saveLoger($e)
    {

        $logger = $this->getDI()->getLogger();
        if (is_object($e)) {
            $logger->error($e[0]->getMessage());
        }
        if (is_array($e)) {
            foreach ($e as $message) {
                $logger->error($message->getMessage());
            }
        }
        if (is_string($e)) {
            $logger->error($e);
        }
    }
    /**
     * Get data via method Query Builder Phalcon
     * {code}
     * $sql =[
     *  'model' => 'Phanbook\Models\Posts'
     *  'columns' => ['a.id', 'a.title']
     *  'joins' => [
     *      [
     *          'type' => 'join'
     *          'model' => 'Phanbook\Models\PostsReply'
     *          'on' => 'a.id = pr.postsId'
     *          'alias' => 'pr'
     *      ]
     *      [
     *          //like above
     *      ]
     *   ],
     *   'where' => ''
     * ];
     * {/code}
     *
     * {code}
     * $sql = [
     *      'model' => 'Phanbook\Models\Tags',
     *      'joins' => []
     *
     *  ];
     * {/code}
     *
     * @param  array
     * @return Phalcon\Mvc\Model\Query\BuilderInterface
     */
    public static function modelQuery($query)
    {
        $builder = self::getBuilder();
        $modelNamespace = __NAMESPACE__ . '\\' ;
        if (!empty($query['model'])) {
            $builder->from(['a' => $modelNamespace . $query['model']]);
        }

        if (!empty($query['columns'])) {
            $builder->columns($query['columns']);
        }
        foreach ($query['joins'] as $join) {
            if (in_array($join['type'], ['innerJoin', 'leftJoin', 'rightJoin', 'join'])) {
                $type = (string) $join['type'];
                $builder->$type($modelNamespace . $join['model'], $join['on'], $join['alias']);
            }
        }
        if (!empty($query['groupBy'])) {
            $builder->groupBy($query['groupBy']);
        }
        if (!empty($query['orderBy'])) {
            $builder->orderBy($query['orderBy']);
        }
        if (!isset($query['bindWhere'])) {
            $query['bindWhere'] = [];
        }
        if (!empty($query['where'])) {
            $builder->where($query['where'], $query['bindWhere']);
        }
        if (!empty($query['limit'])) {
            $builder->limit($query['limit']);
        }
        return $builder;
    }

    /**
     * @param $query
     * @return array
     */
    public static function getItemAndTotal($query)
    {
        $itemBuilder = self::modelQuery($query);
        $item = $itemBuilder->getQuery()->execute();
        $totalBuilder = clone $itemBuilder;

        $totalBuilder
            ->columns('COUNT(*) AS count');
        $total = $totalBuilder->getQuery()->setUniqueRow(true)->execute();

        return array($item, $total->count);
    }
    /**
     * Hook Phalcon PHP
     */
    public function initialize()
    {
        //$this->addBehavior(new ModelBlameable());
        $this->keepSnapshots(true);
    }
    /**
     * @return bool|string
     */
    public function getHumanCreatedAt()
    {
        return ZFunction::getHumanDate($this->createdAt);
    }
    public function setHumanViewNumber($number)
    {
        if ($number > 1000000) {
            return round($number / 1000000, 1) . 'k';
        } else {
            return number_format($number);
        }
    }
}
