<?php
namespace Phanbook\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phanbook\Utils\Slug;

class Playlist extends ModelBase
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
    protected $usersId;

    /**
     *
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $slug;

    /**
     *
     * @var string
     */
    protected $content;

    /**
     * @var string | null
     */
    protected $imageFilename;

    /**
     *
     * @var integer
     */
    protected $createdAt;

    /**
     *
     * @var string
     */
    protected $status;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field usersId
     *
     * @param integer $usersId
     * @return $this
     */
    public function setUsersId($usersId)
    {
        $this->usersId = $usersId;

        return $this;
    }

    /**
     * Method to set the value of field title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Method to set the value of field content
     *
     * @param string $content
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
     * @param integer $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

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
     * Returns the value of field usersId
     *
     * @return integer
     */
    public function getUsersId()
    {
        return $this->usersId;
    }

    /**
     * Returns the value of field title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * Returns the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'playlist';
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param null|string $imageFilename
     */
    public function setImageFilename($imageFilename)
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getImageFilename()
    {
        if (empty($this->imageFilename)) {

            return 'playlist.png';
        }
        return $this->imageFilename;
    }
    /**
     * @return string
     */
    public function getThumbnail($with = 176, $h = 157)
    {

        return 'images/playlist/' . $this->getImageFilename() .'?w=' . $with .'&h=' .$h;
    }
    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Playlist[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Playlist
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * @param $slug
     * @param int $limit
     * @return mixed
     */
    public static function getPlayListVideoBySlug($slug, $limit = 30)
    {
        $builder = self::getBuilder();
        $builder
            ->columns(['p.*'])
            ->from(['p' => __NAMESPACE__ . '\Posts'])
            ->innerJoin(__NAMESPACE__ . '\PostsPlaylist', 'p.id = pl.postId', 'pl')
            ->innerJoin(__NAMESPACE__ . '\Playlist', 'l.id = pl.playlistId', 'l')
            ->where('l.slug = :slug:', ['slug' => $slug])
            ->orderBy('pl.createdAt ASC')
            ->limit($limit)
        ;
        $result = $builder->getQuery()->execute();

        return $result;
    }

    public function beforeValidation()
    {
        $userId = $this->getDI()->getAuth()->getUserId();
        if (!$userId) {
            return false;
        }
        $this->slug      = Slug::generate($this->title);
        $this->status    = self::STATUS_ACTIVE;
        $this->usersId   = $userId;
        $this->createdAt = time();
    }

    /**
     * Validations and business logic
     */
    public function validation()
    {

        $validator = new Validation();
        $validator->add(
            'slug',
            new UniquenessValidator([
                'model' => $this,
                'message' => 'Another user with same playlist already exists'
            ])
        );
        return $this->validate($validator);
    }
    public static function getPlaylist()
    {
        $di = new self();
        $userId = $di->getDI()->getAuth()->getUserId();
        $builder = self::getBuilder();
        $builder
            ->columns(['p.*'])
            ->from(['p' => __NAMESPACE__ . '\Playlist'])
            ->where('p.usersId = :id: AND p.status = :status:', ['status' => self::STATUS_ACTIVE, 'id' => $userId])
            ->limit(10)
        ;
        $result = $builder->getQuery()->execute();

        return $result;
    }

    public static function getPopular()
    {
        return Playlist::find(['limit' => 6]);
    }

    /**
     * Independent Column Mapping.
     * Keys are the real names in the table and the values their names in the application
     *
     * @return array
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'usersId' => 'usersId',
            'title' => 'title',
            'slug' => 'slug',
            'content' => 'content',
            'imageFilename' => 'imageFilename',
            'createdAt' => 'createdAt',
            'status' => 'status'
        );
    }

}
