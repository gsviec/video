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

use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;

class Comment extends ModelBase
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
    protected $userId;

    /**
     *
     * @var integer
     */
    protected $objectId;

    /**
     *
     * @var string
     */
    protected $object;

    /**
     *
     * @var string
     */
    protected $content;

    /**
     *
     * @var integer
     */
    protected $createdAt;

    /**
     *
     * @var integer
     */
    protected $modifiedAt;

    /**
     * @var int
     */
    protected $deleted;

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
     * Method to set the value of field userId
     *
     * @param  integer $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Method to set the value of field objectId
     *
     * @param  integer $objectId
     * @return $this
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Method to set the value of field object
     *
     * @param  string $object
     * @return $this
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Method to set the value of field content
     *
     * @param  string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Method to set the value of field createdAt
     *
     * @param  integer $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Method to set the value of field modifiedAt
     *
     * @param  integer $modifiedAt
     * @return $this
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

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
     * Returns the value of field userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Returns the value of field objectId
     *
     * @return integer
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Returns the value of field object
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Returns the value of field content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the value of field createdAt
     *
     * @return integer
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Returns the value of field modifiedAt
     *
     * @return integer
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param int $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'object',
            new InclusionIn(
                [
                    'message' => t('Invalid object type.'),
                    'domain'  => array_flip(self::getObjectsWithLabels())
                ]
            )
        );

        return $this->validate($validator);
    }
    /**
     * Implement hook Phalcon
     */
    public function beforeValidation()
    {

        $this->createdAt  = time();
        if (empty($this->deleted)) {
            $this->deleted = 0;
        }
    }
    public static function getObjectsWithLabels()
    {
        return [
            self::OBJECT_POSTS  => t('Posts'),
            self::OBJECT_POSTS_REPLIES => t('Posts Reply')
        ];
    }
    /**
     * To checking isset class, it use in function setActivityNotifications of ContrllerBase
     *
     * @return boolean
     */
    public function isComment()
    {
        return true;
    }
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->belongsTo('userId', __NAMESPACE__ . '\Users', 'id', ['alias' => 'user']);
    }
    public function getRepliesComment()
    {
        $obj = Comment::find("objectId = " . $this->id);
//        if ($obj->getFirst()) {
//            var_dump($obj->toArray());
//        }
        return $obj;
    }

    /**
     * @return int
     */
    public function getNegative()
    {
        if (!$vote = $this->getVote()) {
            return 0;
        }
        return $this->setHumanViewNumber($vote['negative']);

    }

    /**
     * @return int
     */
    public function getPositive()
    {

        if (!$vote = $this->getVote()) {
            return 0;
        }
        return $this->setHumanViewNumber($vote['positive']);
    }

    public function getVote()
    {
        $vote = Vote::findFirstByObjectId($this->id);
        if ($vote) {
            return $vote->toArray();
        }
        return false;
    }
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'userId' => 'userId',
            'objectId' => 'objectId',
            'object' => 'object',
            'content' => 'content',
            'createdAt' => 'createdAt',
            'modifiedAt' => 'modifiedAt',
            'deleted' => 'deleted'
        );
    }
}
