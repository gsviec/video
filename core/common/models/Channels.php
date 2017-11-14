<?php

namespace Phanbook\Models;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phanbook\Tools\ZFunction;
use Phanbook\Models\Subscribe;

class Channels extends ModelBase
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $uniqid;

    /**
     *
     * @var integer
     */
    public $usersId;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $slug;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $imageFilename = 'channel-avatar.png';


    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'channels';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Channels[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Channels
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function validation()
    {

        $validator = new Validation();


        $validator->add(
            ['slug'],
            new UniquenessValidator([
                'model' => $this,
                'message' => 'Another user with same channels already exists'
            ])
        );

        return $this->validate($validator);
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getSubscribe()
    {
        $parameters = [
            'usersId = ?0',
            'bind' => array($this->usersId)
        ];
        return number_format(Subscribe::count($parameters));
    }

    /**
     * @return string
     */
    public function getHumanNumberVideo()
    {
        $number = 2000;
        if ($number > 1000000) {
            return round($number / 1000000, 1) . 'k';
        } else {
            return number_format($number);
        }
    }
    public function initialize()
    {
        $this->hasOne('usersId', __NAMESPACE__ . '\Users', 'id', ['alias' => 'user']);
    }

    /**
     * @param int $usersId
     */
    public function setUsersId(int $usersId)
    {
        $this->usersId = $usersId;
    }

    /**
     * @return int
     */
    public function getUsersId(): int
    {
        return $this->usersId;
    }

    public static function findByIdOrUid($string)
    {
        $c = Channels::query()
            ->where('id = :string:')
            ->orWhere('uniqid = :string:')
            ->bind(['string' => $string])
            ->limit(1)
            ->execute();

        if ($c->valid()) {
            return $c->getFirst();
        }

        return false;
    }

    /**
     * @param $item
     * @return \stdclass
     */
    public function getPaginateVideo($item)
    {
        //Check a user have a post before get video
        if (!$this->user) {
            return false;
        }
        $paginator = new PaginatorModel(
            [
                "data"  => $this->user->posts,
                "limit" => $item[1],
                "page"  => $item[0],
            ]
        );
        return $paginator->getPaginate();
    }

    public static function getPopular()
    {
        return Channels::find(['limit' => 6]);
    }

    public function getImageFilename()
    {
        if (empty($this->imageFilename)) {

            return 'channel-avatar.png';
        }
        return $this->imageFilename;
    }
    public function setImageFilename($imageFilename)
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }
    /**
     * @return string
     */
    public function getThumbnail($with = 176, $h = 157)
    {

        return 'images/channels/' . $this->getImageFilename() .'?w=' . $with .'&h=' .$h;
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
            'uniqid' => 'uniqid',
            'usersId' => 'usersId',
            'name' => 'name',
            'slug' => 'slug',
            'description' => 'description',
            'imageFilename' => 'imageFilename'
        );
    }

}
