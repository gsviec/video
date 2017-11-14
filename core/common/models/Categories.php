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

use Phanbook\Models\Posts;

/**
 * Class Categories
 * @package Phanbook\Models
 */
class Categories extends ModelBase
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @var string
     */
    protected $slug;

    /**
     *
     * @var integer
     */
    protected $numberPosts;

    /**
     *
     * @var string
     */
    protected $noBounty;

    /**
     *
     * @var string
     */
    protected $noDigest;

    /**
     * @var string
     */
    protected $imageFilename;

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
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Method to set the value of field slug
     *
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Method to set the value of field numberPosts
     *
     * @param integer $numberPosts
     * @return $this
     */
    public function setNumberPosts($numberPosts)
    {
        $this->numberPosts = $numberPosts;

        return $this;
    }

    /**
     * Method to set the value of field noBounty
     *
     * @param string $noBounty
     * @return $this
     */
    public function setNoBounty($noBounty)
    {
        $this->noBounty = $noBounty;

        return $this;
    }

    /**
     * Method to set the value of field noDigest
     *
     * @param string $noDigest
     * @return $this
     */
    public function setNoDigest($noDigest)
    {
        $this->noDigest = $noDigest;

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
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Returns the value of field slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Returns the value of field numberPosts
     *
     * @return integer
     */
    public function getNumberPosts()
    {
        return $this->numberPosts;
    }

    /**
     * Returns the value of field noBounty
     *
     * @return string
     */
    public function getNoBounty()
    {
        return $this->noBounty;
    }

    /**
     * Returns the value of field noDigest
     *
     * @return string
     */
    public function getNoDigest()
    {
        return $this->noDigest;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'categories';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categories[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categories
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function getImageFilename()
    {
        if (empty($this->imageFilename)) {

            return 'category-avatar.png';
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

        return 'images/categories/' . $this->getImageFilename() .'?w=' . $with .'&h=' .$h;
    }

    /**
     * @return string
     */
    public function getHumanNumberVideo()
    {
        $number = $this->numberPosts;
        if ($number > 1000000) {
            return round($number / 1000000, 1) . 'k';
        } else {
            return number_format($number);
        }
    }

    /**
     * @param $id
     * @return bool|\Phalcon\Mvc\Model\ResultsetInterface
     */
    public function getVideoById($id)
    {
        $posts = new Posts();
        $posts->setLimit(20);
        return $posts->getVideoByCategory($id);
    }

    /**
     * @param $id
     */
    public function getTotalVideoById($id)
    {

        $posts = new Posts();
        $posts->setLimit(20);
        $count = $posts->countVideoByCategory($id);
        $totalPages = ceil($count / $this->limit) ;

        return $totalPages;
    }

    public function updateNumberPosts()
    {
        $cats = Categories::find()->toArray();

        foreach ($cats as $key => $cat) {
            $numberCat = Posts::count("categoryId = {$cat['id']}");

            $object = Categories::findFirstById($cat['id']);
            $object->setNumberPosts($numberCat);
            if (!$object->save()) {
                $this->saveLoger($object->getMessages());
                return false;
            }
        }
        return true;
    }
}
